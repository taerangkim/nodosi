<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');
include_once $_SERVER['DOCUMENT_ROOT']. "/vendor/phpqrcode/qrlib.php";

class order extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    private $CommModel;

    public function __construct()
    {

        if (!isset($_SESSION['MemIdx'])) {
            header('Location: /login?ret=order');
            exit;
        }

        $this->views = $_SERVER['DOCUMENT_ROOT'] . '/application/views';
        $this->compiledFolder = $_SERVER['DOCUMENT_ROOT'] . '/compiled';

        $this->blade = new BladeOne($this->views, $this->compiledFolder, BladeOne::MODE_SLOW);
        $this->dao = new \system\dao\dao();
        $this->RowsCount = 0;
        $this->pageingSize = 20;
        $conn = $this->dao->open();
        if ($conn) {
            //echo "Connected!<br>";
        } else {

        }
        $this->util = new \system\util\util();

        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
        $this->CommModel = $this->loadModel('CommModel');
    }
    //예약 홈
    public function index()
    {
        $this->ComCode = $this->CommModel->GetComCode();
        $this->dao->queryOption = [
            'col' =>
                [
                    'O.OIdx',
                    'O.Title',
                    "Replace(O.OrderMemo, chr(13),'<BR>') as Content",
                    'O.RegDate',
                    'O.MemIdx',
                    'O.ReceiptDate',
                    'CC.ComName as ReceiptCodeName'
                ],
            'table' => 'Tbl_Order AS O',
            'join' => 'INNER JOIN Tbl_ComCode AS CC ON O.ReceiptCode = CC.ComCode',
            'where' =>
                [
                    'MemIdx' => ['=', $_SESSION['MemIdx'], 'and'],
                    'isDel' => ['=', 'N', '']
                ],
            'order' => 'O.Oidx desc',

        ];
        //echo $this->dao->getQuery();
        $result = $this->dao->ExecuteFill();
        $replyResult = array();
        $orderProduct = array();
        if(count($result) > 0)
        {
            //print_r($result);
            foreach ($result as $item) {
                $this->dao->queryOption=[
                    'col' => '*',
                    'table' => 'Tbl_OrderProduct',
                    'where' => [
                        'OIdx' => ["=", $item['OIdx'], '']
                    ],
                    'order' => "OPIdx desc",

                ];
                //echo $this->dao->getQuery();
                $resulttemp = $this->dao->ExecuteFill();
                $orderProduct = array_merge($orderProduct, $resulttemp);
            }
        }


        foreach ($result as $item) {
            $bIdx = $item["OIdx"];
            //echo $item['BIdx'] . "<BR>";
            $this->dao->queryOption = [
                'col' => [
                    'BRIdx',
                    'TOR.OIdx',
                    'TOR.RegDate',
                    'M.MemIdx',
                    'M.NickName',
                    "Replace(Contents, chr(13),'<p>') as Contents",
                ],
                'table' => 'Tbl_Order_Reply AS TOR',
                'join' => 'INNER JOIN Tbl_Member AS M ON TOR.MemIdx = M.MemIdx',
                'where' => [
                    'OIdx' => ['=', $bIdx, 'and'],
                    'isDel' => ['=', 'N', '']
                ]
            ];
            $resulttemp = $this->dao->ExecuteFill();
            $replyResult = array_merge($replyResult, $resulttemp);
        }

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('order.orderlist', [
                'result' => $result,
                'comcode' => $this->ComCode,
                'util' => $this->util,
                'replyResult' => $replyResult,
                'orderProduct' => $orderProduct
            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function orderfrm()
    {
        $reservmode = $this->util->urlParam('reservmode', 'ins');
        $bidx = $this->util->urlParam('reservbidx', '');

        $result = array();
        $this->dao->queryOption = [
            'col' => [
                'Distinct CC.ComCode',
                'CC.ComValue',
                'CC.ComName',
                'FRO.IsSale'
            ],
            'table' => 'Tbl_ComCode AS CC',
            'join' => [
                'LEFT join Tbl_Fish_R_ProductType AS FR ON CC.ComCode = FR.FishCode',
                'LEFT JOIN Tbl_Fish_R_OrgCode AS FRO ON FR.FRPROIdx = FRO.FRPROIdx'
            ],
            'where' => [
                'CC.ComGroup' => ['=', '1000', 'and'],
                'CC.ComCode mod 1000' => ['>', '0', 'and'],
                'FRO.IsSale' => ['=', 'Y', ''],
            ],
            'order' => 'CC.ComValue asc',
        ];
        $fishlist = $this->dao->ExecuteFill();

        $this->dao->queryOption = [
            'col' => [
                'CC.ComCode',
                'CC.ComValue',
                'CC.ComName'

            ],
            'table' => 'Tbl_ComCode AS CC',

            'where' => [
                'CC.ComGroup' => ['=', '3300', 'and'],
                'CC.ComCode mod 1000' => ['>', '0', 'and'],
                'CC.isUse' => ['=', 'Y', ''],
            ],
        ];
        $array_3300 = $this->dao->ExecuteFill();
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('order.orderfrm', [
                'fishlist' => $fishlist,
                'array_3300' => $array_3300,
                'contentResult' => $result,
                'reservmode' => $reservmode,
                'nowdate' => date("Y,m,d,H,i,s"),
            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function orderdelproc()
    {
        $OIdx = $this->util->urlParam('orderidx', '');

        $this->dao->queryOption = [
            'col' => 'BankIdx AS BankIdx ',
            'table' => 'Tbl_Order',
            'where' => [
                'OIdx' => ['=', $OIdx, '']
            ]
        ];
        $Bidx = $this->dao->ExecuteScalar();
        if ($Bidx > 0)
        {
            $this->dao->queryOption=[
                'table' => 'Tbl_Bank',
                'val' => [
                    'admincheck' => 'N',
                ],
                'where' => [
                    'Bidx' => ['=', $Bidx, '']
                ]
            ];
            $this->dao->ExecuteUpdate();
        }



        $this->dao->queryOption=[
            'table' => 'Tbl_Order',
            'val' => [
                'IsDel' => 'Y',
                'BankIdx' => '0'
            ],
            'where' => [
                'OIdx' => ['=', $OIdx, '']
            ]
        ];
        $this->dao->ExecuteUpdate();
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '삭제되었습니다.',
                'location' => '/order',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function orderproc()
    {
        $title = $this->util->urlParam('title', '');
        $kgcode = $this->util->urlParam('kgcode', '');
        $receiptcode = $this->util->urlParam('receiptcode', '');
        $receiptdate = $this->util->urlParam('receiptdate', '');
        $receipttime = $this->util->urlParam('receipttime', '3401');
        $telnum = $this->util->urlParam('telnum', '');
        $orderlisjosn = $this->util->urlParam('orderlistjson', '');
        $contents = $this->util->urlParam('contents', '');
        $ReceiptName = $this->util->urlParam('ReceiptName', '');
        $DepositorName = $this->util->urlParam('DepositorName', '');

        $json_result = json_decode($orderlisjosn);

        $randomNum = mt_rand(1, 1000);


        str_pad($randomNum, "4", "0", STR_PAD_LEFT);
        $now = DateTime::createFromFormat('U.u', microtime(true));
        $orderno = $now->format("YmdHisu") . $randomNum;

        $this->dao->queryOption = [
            'table' => 'Tbl_Order',
            'val' => [
                'OrderNo' => $orderno,
                'MemIdx' => $_SESSION['MemIdx'],
                'Title' => $title,
                'OrderMemo' => $contents,
                'TelNum' => $telnum,
                'ReceiptCode' => $receiptcode,
                'ReceiptTime' => $receipttime,
                'ReceiptDate' => $receiptdate,
                'DepositorName' => $DepositorName,
                'ReceiptName' => $ReceiptName,
                'CPIdx' => '1000'
            ]
        ];
        $oIdx = $this->dao->ExecuteInsetLastId();
        if ($_SESSION['MemIdx'] == '2981')
        {
            $this->sendOrderSMS($oIdx);
        }
        foreach ($json_result as $item) {
            $prodtypecodeArray = explode( '_', $item->prodtypecode );
            $origincodeArray = explode( '_', $item->orgcode );
            $this->dao->queryOption =[
                'table' => 'Tbl_OrderProduct',
                'val' =>
                [
                    'OIdx' => $oIdx,
                    'FishCode' => $item->fishcode,
                    'ProdCode' => $prodtypecodeArray[1],
                    'OriginCode' => $origincodeArray[1],
                    'KgCode' => $item->kgcode,
                ]

            ];


            $this->dao->ExecuteInsert();


        }
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '예약이 등록되었습니다.',
                'location' => '/order',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }


    }
    public function orderfaq()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('order.orderfaq', [

            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function orderreplyproc()
    {
        $OIdx = $this->util->urlParam('Oidx', '');
        $replyContent = $this->util->urlParam('replyContent', '');
        $this->dao->queryOption = [
            'col' => 'ifnull(max(OrderNum), 1) + 1 AS OrderNum ',
            'table' => 'Tbl_Order_Reply',
            'where' => [
                'OIdx' => ['=', $OIdx, '']
            ]
        ];
        $OrderNum = $this->dao->ExecuteFill();
        $this->dao->queryOption = [
            'table' => 'Tbl_Order_Reply',
            'val' => [
                'OIdx' => $OIdx,
                'MemIdx' => $_SESSION['MemIdx'],
                'Contents' => $replyContent,
                'OrderNum' => $OrderNum[0]['OrderNum']
            ]
        ];
        $this->dao->ExecuteInsert();
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '댓글이 등록되었습니다.',
                'location' => '/order',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }

    public function ajaxLoadFishOrg()
    {
        $FRPROIdx = $this->util->urlParam('FRPROIdx', '');
        $this->dao->queryOption = [
            'col' => [
                'FRPROIDX',
                'OrgCode',
                'ComName',
                'FORGIdx'
            ],
            'table' => 'Tbl_Fish_R_OrgCode  AS FRO',
            'join' => 'INNER JOIN Tbl_ComCode AS CC ON FRO.OrgCode = CC.ComCode',
            'where' => [
                'FRO.FRPROIdx' => ["=", $FRPROIdx, 'and'],
                'FRO.IsSale' => ['=', 'Y', 'and'],
                'FRO.IsDel' => ['=', 'N', 'and'],
                'CC.IsUse' => ['=', 'Y', '']
            ]
        ];
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        //echo $this->dao->getQuery();
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }
    public function ajaxLoadFishKg()
    {
        $FORGIdx = $this->util->urlParam('FORGIdx', '');
        $this->dao->queryOption =
            [
                'col' => [
                    'CC.ComCode',
                    'CC.Comvalue',
                    'CC.ComName',
                    'FRS.StartSaleTime',
                    'FRS.EndSaleTime',
                    'ifnull(FRN.Notic, \'\') as Notic'
                ],
                'table' => 'Tbl_Fish_R_KgCodes AS FRK',
                'join' =>
                    [
                        'INNER JOIN Tbl_ComCode AS CC ON FRK.KgCode = CC.ComCode',
                        'LEFT JOIN Tbl_Fish_R_SaleCode AS FRS ON FRK.FRPROIdx = FRS.FRPROIdx AND FRK.FORGIdx = FRS.FORGIdx AND FRS.IsDel=\'N\'',
                        'LEFT JOIN Tbl_Fish_R_Notic AS FRN ON FRN.FRPROIdx = FRS.FRPROIdx AND FRN.FORGIdx = FRS.FORGIdx AND FRN.IsDel=\'N\'',
                    ],
                'where' =>
                    [
                        'FRK.FORGIdx' => ['=', $FORGIdx, 'and'],
                        'FRK.IsDel' => ['=', 'N', 'and'],
                        'FRK.IsSale' => ['=', 'Y', ''],
                    ],
            ];

        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);

        //echo $this->dao->getQuery();
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;

    }
    public function ajaxLoadFishProd()
    {
        $fishcode = $this->util->urlParam('fishcode', '');
        $this->dao->queryOption = [
            'col' => [
                'FRPT.FRPROIdx',
                'CC.ComName',
                'CC.ComCode'
            ],
            'table' => 'Tbl_Fish_R_ProductType AS FRPT',
            'join' => 'INNER JOIN Tbl_ComCode AS CC ON FRPT.ProdCode = CC.ComCode',
            'where' => [
                'FishCode' => ["=", $fishcode, 'and'],
                'IsUse' => ['=', 'Y', '']
            ]
        ];
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        //echo $this->dao->getQuery();
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }

    public function urlParamNullCheck($param, $msg, $gotourl)
    {
        if ($param == '') {
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => $msg,
                    'location' => $gotourl,
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }
    }

    public function orderQR()
    {
        $Oidx = $this->util->urlParam('OIdx', '');
        $this->dao->queryOption=[
            'col' =>
                'OP.*',
            'table' => 'Tbl_OrderProduct as OP',
            'join' =>
            [
                'INNER JOIN Tbl_ComCode AS C1 ON OP.FishCode = C1.ComCode',
                'INNER JOIN Tbl_ComCode AS C2 ON OP.ProdCode = C2.ComCode',
                'INNER JOIN Tbl_ComCode AS C3 ON OP.OriginCode = C3.ComCode',
                'INNER JOIN Tbl_ComCode AS C4 ON OP.KgCode = C4.ComCode',
            ],
            'where' => [
                'OIdx' => ["=", $Oidx, '']
            ],
            'order' => "OPIdx desc",
        ];
        //echo $this->dao->getQuery();
        $OrderProduct = $this->dao->ExecuteFill();
        $json_OrderProduct = json_encode($OrderProduct, JSON_UNESCAPED_UNICODE);

//        print_r($OrderProduct);
//        echo '<BR>';
//        print_r($json_OrderProduct);
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('order.OrderQR', [
                'json_OrderProduct' => $json_OrderProduct,
            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }

    }

    public function makeTestQr()
    {
        //value: "[{&quot;OPIdx&quot;:&quot;59&quot;,&quot;OIdx&quot;:&quot;98&quot;,&quot;FishCode&quot;:&quot;1001&quot;,&quot;ProdCode&quot;:&quot;1101&quot;,&quot;OriginCode&quot;:&quot;1203&quot;,&quot;KgCode&quot;:&quot;100015&quot;,&quot;ReceiptStatus&quot;:&quot;N&quot;}]",
        $qrContents =  "[{&quot;OIdx&quot;:&quot;98&quot;}]";
        //$qrContents = "hangil_001";
        $filePath = sha1($qrContents) . ".png";
        if (!file_exists($filePath)) {
            $ecc = 'H'; // L, M, Q, H, This parameter specifies the error correction capability of QR.
            $pixel_Size = 10; // This specifies the pixel size of QR.
            $frame_Size = 10; // level 1-10
            QRcode::png($qrContents, $filePath, $ecc, $pixel_Size, $frame_Size);
            echo "파일이 정상적으로 생성되었습니다.";
            echo "<hr/>";
        } else {
            echo "파일이 이미 생성되어 있습니다.\n파일을 지우고 다시 실행해 보세요.";
            echo "<hr/>";
        }

        echo "저장된 파일명 : " . $filePath;
        echo "<hr/>";
        echo "<center><img src='/" . $filePath . "'/></center>";
    }
    public function sendOrderSMS($oidx)
    {
        $this->dao->queryOption = [
            'col' =>[
                "DATE_FORMAT(DATE_ADD(ReceiptDate, INTERVAL -1 DAY), '%Y년%m월%d일') AS ReceiptDate1",
                'ReceiptDate' ,
                'ReceiptDate' ,
                'TelNum',
                "DATE_FORMAT(ReceiptDate,'%Y년%m월%d일') AS  ReceiptDate"
            ],
            'table' => 'Tbl_Order',
            'where' =>
                [
                    'OIdx' =>['=', $oidx,'']
                ]
        ];

        $Result = $this->dao->ExecuteFill();
        $title = "노도시 예약금 입금 안내 문자";
        $msg = "안녕하세요 (주)노도시 입니다.\n" . $Result[0]['ReceiptDate'] . " 예약 구매 품목 예약금 입금 안내 입니다.\n";
        $msg .= "수령 전일 " . $Result[0]['ReceiptDate1'] . " 자정 까지 입금을 부탁드리겠습니다..\n";
        $msg .= '예약금 확인이 안될시 예약 자동 취소 됨을 알려드립니다.\n';
        $msg .= "입금 계좌는 수협 1010-2118-1674 (주)노도시 입니다\n";
        $msg .= "예약금은 50,000 원입니다.\n";
        $msg .= "감사합니다\n";

        $message = new \system\message\message();

        //echo $msg;

        $message->sendMMSMessage($title, $msg, '^' . $Result[0]['TelNum'] );
    }
}