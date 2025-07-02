<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class wait extends Controller
{
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
        $wait = $this->util->urlParam('wait','');

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('wait.index',[
                'wait' => $wait,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }

    public function setSaleNum()
    {
        $receiptNum = $this->util->urlParam('receiptNum','');
        $WaitIdx = $this->util->urlParam('WaitIdx','');

        if($WaitIdx == '' || $receiptNum =='')
        {
            $msg = "비정상적인 접근입니다. 확인 후 다시 시도 하여 주시기 바랍니다.";
            $gotourl = "/";
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => $msg,
                    'location' => $gotourl,
                ]);
                return;
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                return;
            }
        }
        $this->dao->queryOption = [
            'col' => '*',
            'table' => 'Tbl_Wait',
            'where' =>
                [
                    'WaitIdx' => ['=', $WaitIdx,  ''],
                ],
        ];
        $waitArray = $this->dao->ExecuteFill();
        if(count($waitArray) == 0)
        {
            $msg = "해당 대기 번호가 없습니다. ";
            $gotourl = "/";
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => $msg,
                    'location' => $gotourl,
                ]);
                return;
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                return;
            }
        }
        $this->dao->queryOption = [
            'table' => 'Tbl_Wait',
            'val' => [
                'MapNo' => $receiptNum,
            ],
            'where' =>
                [
                    'WaitIdx' => ['=', $WaitIdx,  ''],
                ],
        ];
        $this->dao->ExecuteUpdate();

        $title = "한길통상 수령번호 안내 문자";
        $msg = "안녕하세요 한길통상 입니다.\n대기번호 " . $WaitIdx. "번님의 수령번호는 " . $receiptNum . "번 입니다.\n";
        $msg .= "수령시 수령번호를 확인하시고 수령하시기 바랍니다.\n";
        $msg .= "즐거운 수산물 쇼핑이 되시길 바랍니다.\n 감사합니다.\n";
        $message = new \system\message\message();
        $message->sendMMSMessage($title, $msg, '^' . $waitArray[0]['NoMemCallNum'] );
        $msg = "수령 번호가 등록되었습니다.";
        $gotourl = "/";
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => $msg,
                'location' => $gotourl,
            ]);
            return;
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            return;
        }
    }

}