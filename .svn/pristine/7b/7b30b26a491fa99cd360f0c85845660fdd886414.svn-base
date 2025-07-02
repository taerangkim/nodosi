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

class reserv extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    private  $CommModel;
    private $sheet;


    public function __construct() {

        if ($_SERVER['SERVER_NAME']  == "dev.nodosi.co.kr")
        {
            $_SESSION['NickName']='김승일';
            $_SESSION['MemIdx'] = "1";
        }
        if (!isset($_SESSION['NickName']))
        {
            header('Location: /');
            exit;
        }

        $this->views = $_SERVER['DOCUMENT_ROOT'] . '/application/views';
        $this->compiledFolder = $_SERVER['DOCUMENT_ROOT'] . '/compiled';

        $this->blade = new BladeOne($this->views , $this->compiledFolder , BladeOne::MODE_SLOW);
        $this->dao = new \system\dao\dao();
        $this->RowsCount = 0;
        $this->pageingSize = 20;
        $conn = $this->dao->open();
        if ($conn)
        {
            //echo "Connected!<br>";
        }else
        {

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
        $this->dao->queryOption=[
            'col' =>
                [
                    'TB.BIdx',
                    'TB.Title',
                    "Replace(TB.Content, chr(13),'<p>') as Content",
                    'TB.RegDate',
                    'TB.MemIdx',
                    'TR.FishCode',
                    'TR.KgCode',
                    'TR.ReceiptCode',
                    'TR.OriginCode',
                    'TR.ReceiptTimeCode',
                    'TR.ReceiptDate'
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => 'INNER JOIN Tbl_Reservation AS TR ON TB.BIdx = TR.BIdx',
            'where' =>
            [
                'MemIdx' => ['=', $_SESSION['MemIdx'] , 'and'],
                'isDel' => ['=', 'N', '']
            ],
            'order' => 'BIdx desc',

        ];
        //echo $this->dao->getQuery();
        $result = $this->dao->ExecuteFill();
        $replyResult = array();

        foreach ($result as $item)
        {
            $bIdx = $item["BIdx"];
            //echo $item['BIdx'] . "<BR>";
            $this->dao->queryOption = [
                'col' => [
                    'BIdx',
                    'BRIdx',
                    'BR.RegDate',
                    'M.MemIdx',
                    'M.NickName',
                    "Replace(Contents, chr(13),'<p>') as Contents",
                ],
                'table' => 'Tbl_BoardReply AS BR',
                'join' => 'INNER JOIN Tbl_Member AS M ON BR.MemIdx = M.MemIdx',
                'where' =>[
                    'BIdx' => ['=', $bIdx, 'and'],
                    'isDel' => ['=', 'N', '']

                ]
            ];
            //echo $this->dao->getQuery() . "<BR>";
            $resulttemp = $this->dao->ExecuteFill();
            $replyResult = array_merge($replyResult, $resulttemp);

        }
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_reserv', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('reserv.reservlist', [
                'result' => $result,
                'comcode' => $this->ComCode,
                'util' => $this->util,
                'replyResult' => $replyResult
            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function reservfrm()
    {
        $reservmode = $this->util->urlParam('reservmode', 'ins');
        $bidx = $this->util->urlParam('reservbidx', '');

        $result = array();
/*
        if ($reservmode == 'up')
        {
            $this->dao->queryOption=[
                'col' =>
                    [
                        'TB.BIdx',
                        'TB.Title',
                        'TB.Content',
                        'TB.RegDate',
                        'TB.MemIdx',
                        'TR.FishCode',
                        'TR.KgCode',
                        'TR.ReceiptCode',
                        'TR.OriginCode',
                        'TR.ReceiptTimeCode',
                        'TR.ReceiptDate',
                        'TR.TelNum'

                    ],
                'table' => 'Tbl_Board AS TB',
                'join' => 'INNER JOIN Tbl_Reservation AS TR ON TB.BIdx = TR.BIdx',
                'where' =>
                    [
                        'TB.BIdx' => ['=', $bidx, 'and'],
                        'MemIdx' => ['=', $_SESSION['MemIdx'] , ''],
                    ]
            ];
            $result = $this->dao->ExecuteFill();
        }



        SELECT CC.ComCode, CC.Comvalue, CC.ComName, FRO.IsSale
        FROM Tbl_ComCode AS CC
        LEFT join Tbl_Fish_R_ProductType AS FR ON CC.ComCode = FR.FishCode
        LEFT JOIN Tbl_Fish_R_OrgCode AS FRO ON FR.FRPROIdx = FRO.FRPROIdx
        WHERE 1=1 AND CC.ComGroup='1000' AND CC.ComCode MOD 1000>'0' AND FRO.IsSale='Y'
    */
        $this->dao->queryOption =[
            'col' =>  [
                'CC.ComCode',
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
        ];

        $fishlist = $this->dao->ExecuteFill();

        $this->dao->queryOption =[
            'col' =>  [
                'CC.ComCode',
                'CC.ComValue',
                'CC.ComName'

            ],
            'table' => 'Tbl_ComCode AS CC',

            'where' => [
                'CC.ComGroup' => ['=', '3300', 'and'],
                'CC.ComCode mod 1000' => ['>', '0', '']
            ],
        ];
        $array_3300 = $this->dao->ExecuteFill();
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_reserv', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('reserv.reserv', [
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

    //예약 등록하기
    public function reservc()
    {
        $title = $this->util->urlParam('title', '');
        $fishcode =$this->util->urlParam('fishcode', '');
        $origincode = $this->util->urlParam('orgcode', '');
        $prodtypecode = $this->util->urlParam('prodtypecode', '');

        $kgcode = $this->util->urlParam('kgcode', '');
        $receiptcode = $this->util->urlParam('receiptcode', '');
        $receiptdate = $this->util->urlParam('receiptdate', '');
        $receipttime = $this->util->urlParam('receipttime', '3401');
        $reservmode = $this->util->urlParam('reservmode', 'ins');
        $reservbidx = $this->util->urlParam('reservbidx', '');
        $telnum = $this->util->urlParam('telnum', '');

        if($reservmode == "del")
        {
            $this->dao->queryOption=[
                'table' => 'Tbl_Board',
                'val' => [
                    'isDel' => 'Y'
                ],
                'where' => [
                    'BIdx' => ['=', $reservbidx, 'and'],
                    'MemIdx' => ['=', $_SESSION['MemIdx'], '']
                ]
            ];
            $this->dao->ExecuteUpdate();
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '예약이 취소되었습니다.',
                    'location' => '/reserv',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }else
        {
            $contents = $this->util->urlParam('contents', '');
            $this->urlParamNullCheck($title, '제목을 입력하여 주시기 바랍니다.', '/reserv');
            $this->urlParamNullCheck($fishcode, '어종을 선택하여 주시기 바랍니다.', '/reserv');
            $this->urlParamNullCheck($prodtypecode, '구분을 선택하여 주시기 바랍니다.', '/reserv');
            $this->urlParamNullCheck($origincode, '원산지를 선택하여 주시기 바랍니다.', '/reserv');
            $this->urlParamNullCheck($kgcode, '무게를 선택하여 주시기 바랍니다.', '/reserv');
            $this->urlParamNullCheck($receiptcode, '수령방법을 선택하여 주시기 바랍니다.', '/reserv');
            //$this->urlParamNullCheck($receiptdate, '수령시간을 선택하여 주시기 바랍니다.', '/reserv');
            $origincodeArray = explode( '_', $origincode );
            $prodtypecodeArray = explode( '_', $prodtypecode );


            if ($reservmode == 'ins')
            {
                $this->dao->queryOption=[
                    'table' => 'Tbl_Board',
                    'val' => [
                        'ComCode' => '2001',
                        'MemIdx' => $_SESSION['MemIdx'],
                        'Title' => $title,
                        'Content' => $contents,
                        'CPIdx' => '1000',
                    ]
                ];
                $bIdx = $this->dao->ExecuteInsetLastId();
                $this->dao->queryOption=[
                    'table' => 'Tbl_Reservation',
                    'val' => [
                        'BIdx' => $bIdx,
                        'FishCode' => $fishcode,
                        'KgCode' => $kgcode,
                        'ProdTypeCode' => $prodtypecodeArray[1],
                        'OriginCode' => $origincodeArray[1],

                        'ReceiptCode' => $receiptcode,
                        'ReceiptDate' => $receiptdate,
                        'ReceiptTimeCode' => $receipttime,
                        'TelNum' => $telnum
                    ]
                ];
                echo $this->dao->getInsertQuery();
                $this->dao->ExecuteInsert();
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '예약 되었습니다.',
                        'location' => '/reserv',
                    ]);
                } catch (Exception $e) {
                    echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
            }else if($reservmode == 'up')
            {
                $this->dao->queryOption=[
                    'table' => 'Tbl_Board',
                    'val' => [
                        'Title' => $title,
                        'Content' => $contents,
                    ],
                    'where' => [
                        'BIdx' => ['=', $reservbidx, 'and'],
                        'MemIdx' => ['=', $_SESSION['MemIdx'], '']
                    ]
                ];
                $this->dao->ExecuteUpdate();
                $this->dao->queryOption = [
                    'table' => 'Tbl_Reservation',
                    'val' => [
                        'FishCode' => $fishcode,
                        'KgCode' => $kgcode,
                        'OriginCode' => $origincode,
                        'ReceiptCode' => $receiptcode,
                        'ReceiptDate' => $receiptdate,
                        'ReceiptTimeCode' => $receipttime,
                        'TelNum' => $telnum
                    ],
                    'where' => [
                        'BIdx' => ['=', $reservbidx, ''],
                    ]
                ];
                $this->dao->ExecuteUpdate();
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '예약내용이 수정되었습니다.',
                        'location' => '/reserv',
                    ]);
                } catch (Exception $e) {
                    echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
            }
        }
    }
    /*
     * 댓글 저장
     * param
     *      bidx 글 idx
     *      memidx 사용자 idx
     *      reply 댓글 내용
     *      brdidx 댓글 일련번호
     *      replymode 댓글 처리 모드 ins,up,del
     */
    public function reservrc()
    {
        $bIdx =  $this->util->urlParam('bidx', '');
        $replyContent = $this->util->urlParam('replyContent', '');
        $memIdx = $this->util->urlParam('memidx','1');
        $brIdx = $this->util->urlParam('bridx', '');
        $replymode = $this->util->urlParam('replymode', 'ins');
        if ($replymode=='ins')
        {
            $this->dao->queryOption = [
                'col' => 'ifnull(max(OrderNum), 1) + 1 AS OrderNum ',
                'table' => 'Tbl_BoardReply',
                'where' =>[
                    'Bidx' => ['=', $bIdx, '']
                ]
            ];
            $OrderNum = $this->dao->ExecuteFill();
            $this->dao->queryOption = [
                'table' => 'Tbl_BoardReply',
                'val' => [
                    'BIdx' => $bIdx,
                    'MemIdx' => $_SESSION['MemIdx'],
                    'Contents' => $replyContent,
                    'OrderNum' => $OrderNum[0]['OrderNum']
                ]
            ];


            $this->dao->ExecuteInsert();
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '댓글이 등록되었습니다.',
                    'location' => '/reserv',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }else if($replymode=='up')
        {
            $this->dao->queryOption =
                [
                    'table' => 'Tbl_BoardReply',
                    'val' => [ 'Contents' => $replyContent,],
                    'where' =>  [
                        'BRIdx' => ['=', $brIdx , 'and'],
                        'MemIdx' => ['=', $_SESSION['MemIdx'] , '']
                    ]

                ];
            $this->dao->ExecuteUpdate();
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '댓글이 수정되었습니다.',
                    'location' => '/reserv',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }
        else if($replymode == 'del')
        {
            $this->dao->queryOption =
                [
                    'table' => 'Tbl_BoardReply',
                    'val' => [ 'isDel' => 'Y'],
                    'where' =>  [
                        'BRIdx' => ['=', $brIdx , 'and'],
                        'MemIdx' => ['=', $_SESSION['MemIdx'] , '']
                    ]

                ];
            $this->dao->ExecuteUpdate();
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '댓글이 삭제되었습니다.',
                    'location' => '/reserv',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }


    }
    public function getReply()
    {
        if (!isset($_SERVER['HTTP_X-REQUESTED_WITH']) ||
            ($_SERVER['HTTP_X-REQUESTED_WITH'] !== 'XMLHttpRequest')) {
            echo "잘못된 접근입니다.";
            exit;
        }

    }
    public  function urlParamNullCheck($param, $msg, $gotourl)
    {
        if ($param == '')
        {
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


    public  function ajaxLoadFishOrg()
    {
        $FRPROIdx = $this->util->urlParam('FRPROIdx','');
        $this->dao->queryOption=[
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
                'CC.IsUse' => ['=', 'Y','']
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
        $FORGIdx = $this->util->urlParam('FORGIdx','');
        $this->dao->queryOption =
        [
            'col' => [
                'CC.ComCode',
                'CC.Comvalue',
                'CC.ComName'
            ],
            'table' => 'Tbl_Fish_R_KgCodes AS FRK',
            'join' => 'INNER JOIN Tbl_ComCode AS CC ON FRK.KgCode = CC.ComCode',
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
        $this->dao->queryOption=[
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
    public  function test()
    {
        $qrContents = "00아파트 122동1111 703호";
        $filePath = sha1($qrContents).".png";

        if(!file_exists($filePath)) {
            $ecc = 'H'; // L, M, Q, H, This parameter specifies the error correction capability of QR.
            $pixel_Size = 3; // This specifies the pixel size of QR.
            $frame_Size = 3; // level 1-10
            QRcode::png($qrContents, $filePath, $ecc, $pixel_Size, $frame_Size);
            echo "파일이 정상적으로 생성되었습니다.";
            echo "<hr/>";
        } else {
            echo "파일이 이미 생성되어 있습니다.\n파일을 지우고 다시 실행해 보세요.";
            echo "<hr/>";
        }

        echo "저장된 파일명 : ".$filePath;
        echo "<hr/>";
        echo "<center><img src='/".$filePath."'/></center>";


    }

}