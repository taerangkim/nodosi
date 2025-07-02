<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class stock extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    private $CommModel;
    public $pageingSize;
    private $allowed_Ext;


    public function __construct() {


        $this->views = $_SERVER['DOCUMENT_ROOT'] . '/application/views';
        $this->compiledFolder = $_SERVER['DOCUMENT_ROOT'] . '/compiled';

        $this->blade = new BladeOne($this->views , $this->compiledFolder , BladeOne::MODE_SLOW);
        $this->dao = new \system\dao\dao();
        $this->RowsCount = 0;
        $this->pageingSize = 10;
        $conn = $this->dao->open();
        if ($conn)
        {
            //echo "Connected!<br>";
        }else
        {

        }
        $url = '';
        $this->util = new \system\util\util();
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
        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.title',
                    'DATE_FORMAT(TB.RegDate, \'%Y-%m-%d\') as RegDate'
                ],
            'table' => 'Tbl_Board AS TB',
            'where' =>
            [
                'TB.ComCode' => ['=', '2003', ''],
            ],
            'order' => 'TB.RegDate desc',

        ];
        $boardresult = $this->dao->ExecuteFill();
        $replyResult = array();

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('stock.index',[
                'boardresult' => $boardresult,
                'replyResult' => $replyResult,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function stockLoad()
    {
        $this->ComCode = $this->CommModel->GetComCode();
        $this->dao->queryOption = [
            'col' =>
                [
                    'TB.BIdx',
                    'TB.title',
                    'DATE_FORMAT(TB.RegDate, \'%Y-%m-%d\') as RegDate',
                ],
            'table' => 'Tbl_Board AS TB',
            'join' => [
                'INNER JOIN Tbl_Member AS TM ON TB.MemIdx = TM.MemIdx',
                'left JOIN Tbl_BoardImage AS TBI ON TB.BIdx = TBI.BIdx',
            ],
            'where' =>
                [
                    'TB.ComCode' => ['=', '2003', ''],
                ],
            'limit' => '0, 20',
            'order' => 'TB.RegDate desc',
        ];
        //echo $this->dao->getQuery();
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
//        $boardresult = $this->dao->ExecuteFill();
//        $replyResult = array();
//
//        try {
//            echo $this->blade->run('_templates.header');
//            echo $this->blade->run('_templates.gnb_order',[
//                'urlparams' =>  $this->urlparams,
//            ]);
//            echo $this->blade->run('stock.index',[
//                'boardresult' => $boardresult,
//                'replyResult' => $replyResult,
//            ]);
//            echo $this->blade->run('_templates.footer');
//        } catch (Exception $e) {
//            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
//        }
    }
}