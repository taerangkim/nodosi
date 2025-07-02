<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class ajax extends Controller
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

    }
    public function ajaxSetAuth()
    {
        $callNum = $this->util->urlParam('callNum','');
        $rand_num = rand(000000,999999);
        $callNum = str_replace("-", "", $callNum);
        $this->dao->queryOption = [
            'table' => 'Tbl_Wait_Authnum',
            'val' =>[
                'AuthNum' => $rand_num,
                'AuthTel' => $callNum,
                'Flag' => 0,
            ]
        ];
        $this->dao->ExecuteInsert();
        $title = "대기 등록을 위한 인증 번호";
        $msg = "한길 통상 상품 구매를 위한 대기 등록 인증 번호 입니다.\n";
        $msg .= "[" . $rand_num  . "] 를 입력하여 주시기 바랍니다.\n";
        $msg .= "감사합니다\n";
        $message = new \system\message\message();
        $message->sendMMSMessage($title, $msg, '^'.$callNum);
        $resultArray = [
            'result' => 'ok'
        ];
        $json_result = json_encode($resultArray, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }
    public function ajaxBoardRead()
    {
        $bidx = $this->util->urlParam('bidx','');
        $this->dao->queryOption=[
            'col' => '*',
            'table' => 'Tbl_Board',
            'where' =>[
                'Bidx' => ['=', $bidx, '']
            ]
        ];
        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }


}