<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class transaction extends Controller
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

        $this->dao->queryOption = [
            'col' =>
                'S.SaleNo'
            ,
            'table' => 'Tbl_Wait as W',
            'join' =>[
                'INNER JOIN Tbl_Sale AS S ON W.WaitIdx = S.WaitIdx',
            ],
            'where' =>[
                'W.WaitIdx' => ['=', $wait,''],
            ],
        ];
        $mainResult = $this->dao->ExecuteFill();
        if (count($mainResult) > 0)
        {
            try {
                echo $this->blade->run('order.transaction', [
                    'sno' =>$mainResult[0]['SaleNo'],
                    'wait' => $wait,
            ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }else
        {
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '조회하신 거래 명세표가 없습니다..',
                    'location' => '/',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }
    }

}