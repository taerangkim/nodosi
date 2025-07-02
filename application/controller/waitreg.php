<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class waitreg extends Controller
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
            echo $this->blade->run('wait.waitreg',[
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
    public function setwait()
    {
        //이거는 submit 으로 처리를 해야 한다.
        $callNum = $this->util->urlParam('callNum', '');
        $rtype = $this->util->urlParam('rtype', '03');
        $authNum = $this->util->urlParam('authNum', '');

        $callNum = str_replace('-', '', $callNum);

        $this->dao->queryOption="SELECT * from Tbl_Wait_Authnum WHERE 
                                     Flag=0 AND 
                                     AuthTel='". $callNum . "' AND 
                                     AuthNum='" . $authNum . "' AND TIMESTAMPDIFF(MINUTE , RegDate, NOW()) < 3";
        $authResult = $this->dao->ExecuteQuery();

        if (count($authResult) ==  0)
        {
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '인증 번호가 만료되었거나, 인증 번호가 없습니다. 다시 시도하여 주시기 바랍니다.',
                    'location' => '/waitreg',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
            return;
        }
        $this->dao->queryOption="update Tbl_Wait_Authnum set  Flag=1 WHERE 
                                     Flag=0 AND 
                                     AuthTel='". $callNum . "' AND 
                                     AuthNum='" . $authNum . "' AND TIMESTAMPDIFF(MINUTE , RegDate, NOW()) < 3";
        $this->dao->ExecuteUpdateQuery();
        if($rtype == '01')// 업체 전화번호 확인
        {
            $this->dao->queryOption=[
                'col' => 'TelNum',
                'table' => 'Tbl_BizTel',
                'where' => [
                    'TelNum' => ['=', $callNum, '']
                ]
            ];
            $bizTel = $this->dao->ExecuteScalar();
            if ($bizTel != $callNum)
            {
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '요청하신 전화번호로 등록된 업체가 없습니다.\n확인 후 다시 시도하여 주시기 바랍니다.',
                        'location' => '/waitreg',
                    ]);
                } catch (Exception $e) {
                    echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
                return;
            }
        }
        if($rtype == '02') //예약자 전화번호 확인
        {
            $this->dao->queryOption=[
                'col' => 'TelNum',
                'table' => 'Tbl_Order',
                'where' => [
                    'RegDatm' => ['=', date("Ymd"), 'and'],
                    'TelNum' => ['=', $callNum, '']
                ]
            ];
            $revTel = $this->dao->ExecuteScalar();
            if ($revTel != $callNum)
            {
                try {
                    echo $this->blade->run('_templates.alertRedirect', [
                        'msg' => '요청하신 전화번호로 등록된 예약이 없습니다.\n확인 후 다시 시도하여 주시기 바랍니다.',
                        'location' => '/waitreg',
                    ]);
                } catch (Exception $e) {
                    echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
                }
                return;
            }
        }
        $WaitNo = $this->getWaitNo();
        $this->dao->queryOption=[
            'table' =>'Tbl_Wait',
            'val' => [
                'WaitNo' => $WaitNo,
                'MapNo' => $WaitNo,
                'RegDatm' => date("Ymd"),
                'NoMemCallNum' => $callNum,
                'WaitType' => $rtype,
            ]
        ];
        $WaitIdx = $this->dao->ExecuteInsetLastId();
        $message = new \system\message\message();
        $title = date("Y년 m월 d일") . "일 대기자 접수 안내";
        $msg = date("m월 d일") . " 한길통상 판매장 대기 등록이 되었습니다.\n대기 번호는 " . $WaitNo . "번 입니다.\n대기번호 호출 시 판매장으로 오시기 바랍니다.\n감사합니다.\n";
        $DestInfo = "^" . $callNum;

        $message->sendMMSMessage($title, $msg, $DestInfo);

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.alertSendChatRedirect', [
                'msg' => '요청하신 전화번호로 등록되었습니다.',
                'location' => '/',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }

    }
    public function getWaitNo()
    {
        $this->dao->queryOption=[
            'col' => 'ifnull(MAX(WaitNo), 1) + 1 AS WaitNo',
            'table' => 'Tbl_Wait',
            'where' => [
                'RegDatm' => ['=', date("Ymd"), '']
            ]
        ];
        return $this->dao->ExecuteScalar();
    }
}