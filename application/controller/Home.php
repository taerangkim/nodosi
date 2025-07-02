<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class Home extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    private $CommModel;

    public function __construct() {

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
        $url = '';
        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
        $this->CommModel = $this->loadModel('CommModel');
    }
    public function index()
    {
        $this->ComCode = $this->CommModel->GetComCode();
        $this->dao->queryOption=[
            'col' =>'TB.*, TA.AdminName, TMB.NickName',
            'table' => 'Tbl_Board as TB',
            'join' =>[
                'inner join Tbl_Member as TMB on TB.MemIdx = TMB.MemIdx',
                'inner join Tbl_Admin as TA on TMB.MemIdx = TA.MemIdx'
            ],
            'where' => [
                'TB.ComCode' => ['=', '2001', 'and'],
                'TB.IsDel' => ['=', 'N', ''],
            ],
            'limit' => '0,10 ',
            'order' => 'Bidx desc',

        ];
        $notic = $this->dao->ExecuteFill();

        $this->dao->queryOption=[
            'col' =>'TB.*, TA.AdminName, TMB.NickName',
            'table' => 'Tbl_Board as TB',
            'join' =>[
                'inner join Tbl_Member as TMB on TB.MemIdx = TMB.MemIdx',
                'inner join Tbl_Admin as TA on TMB.MemIdx = TA.MemIdx'
            ],
            'where' => 'TB.ComCode=\'2003\' and TB.IsDel=\'N\' and TB.RegDate> DATE_ADD(NOW(), INTERVAL -3 DAY)',
            'order' => 'Bidx desc',
        ];

        $stock = $this->dao->ExecuteFill();

        $order = array();
        $orderProduct = array();

        if (isset($_SESSION['MemIdx']))
        {
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
            $order = $this->dao->ExecuteFill();

            if(count($order) > 0)
            {
                $this->dao->queryOption=[
                    'col' => '*',
                    'table' => 'Tbl_OrderProduct',
                    'where' => [
                        'OIdx' => ["=", $order[0]['OIdx'], '']
                    ],
                    'order' => "OPIdx desc",

                ];
                $orderProduct = $this->dao->ExecuteFill();
            }
        }

        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.MemIdx',
                    'TM.NickName',
                    'TB.title',
                    'TB.RegDate',
                    'TB.Content',
                    'TB.Count',
                    'ifnull ((SELECT ImageName FROM Tbl_Board_R_Img AS BRI 
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx 
                        WHERE BIdx = TB.BIdx ORDER BY TI.ImgIdx asc LIMIT 0,1  ), \'\') as ImageName',
                    'ifnull ((SELECT path FROM Tbl_Board_R_Img AS BRI 
                        INNER JOIN Tbl_Image AS TI ON BRI.ImgIdx = TI.ImgIdx
                        WHERE BIdx = TB.BIdx Order BY TI.ImgIdx asc LIMIT 0,1), \'\') as path'
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => [
                'INNER JOIN Tbl_Member AS TM ON TB.MemIdx = TM.MemIdx',
            ],
            'where' =>
                [
                    'TB.ComCode' => ['=', '2002', ''],
                ],
            'order' => 'RegDate desc',
            'limit' => '0, 12'
        ];
        $review = $this->dao->ExecuteFill();

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            //echo $this->blade->run('home.indexNotic',[]);

            echo $this->blade->run('home.index',[
//            echo $this->blade->run('home.cons',[
                'util' => $this->util,
                'notic' => $notic,
                'order' => $order,
                'orderProduct' => $orderProduct,
                'comcode' => $this->ComCode,
                'stock' => $stock,
                'review' => $review,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function test()
    {
        echo date("Y-m-d H:i:s")."<br/>";
        echo date("H")."<br/>";
        echo $this->blade->run('_templates.test');
    }


}