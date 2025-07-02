<?php
set_time_limit(0);
header('Content-Encoding: none');

use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');


class salereport extends Controller
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
        $sno = $this->util->urlParam('sno', '');
        $telnum = $this->util->urlParam('telnum', '');
        $wait = $this->util->urlParam('wait', '');

        $this->dao->queryOption = [
            'col' =>
                [
                    'right(NoMemCallNum, 4) as TelNum',
                    'right(NoMemCallNum, 6) as DispTelNum',
                    'NoMemCallNum',
                ],
            'table' => 'Tbl_Wait as S',
            'where' =>[
                'WaitIdx' => ['=', $wait,''],
            ],
        ];


        $telResult = $this->dao->ExecuteFill();
        if($telResult[0]['TelNum'] != $telnum)
        {
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '입력하신 전화번호로 거래된 거래가 없습니다.',
                    'location' => '/',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }
        $this->dao->queryOption=[
            'col' => ' B.BizName',
            'table' => 'Tbl_BizTel  AS bt',
            'join' =>[
                'INNER JOIN Tbl_BizInfo AS B ON bt.BIdx = B.BIdx',
            ],
            'where' =>[
                "REPLACE(bt.TelNum, '-', '')" => ['=', $telResult[0]['NoMemCallNum'],''],
            ],
        ];
        $bizResult = $this->dao->ExecuteFill();
        if (count($bizResult) > 0)
        {
            $ordererName = $bizResult[0]['BizName'];
        }else
        {
            $ordererName = "**" . $telResult[0]['DispTelNum'];
        }
        $this->dao->queryOption = [
            'col' => [
                'S.*',
                'CC1.ComName as PayType',
                "IFNULL(M.NickName, '현장판매') as MemNick",
                "CASE WHEN O.OIdx > 0 THEN 50000 ELSE '0' END as ResevePrice ",
            ],
            'table' => 'Tbl_Sale as S',
            'join' =>[
                'INNER JOIN Tbl_ComCode AS CC1 ON S.PayType = CC1.ComCode',
                'LEFT JOIN Tbl_Member AS M on S.MemIdx = M.MemIdx',
                "LEFT join Tbl_Order as O on S.ReseveOidx = O.OIdx and O.CalculationCheck='Y'"
            ],
            'where' =>[
                'SaleNo' => ['=', $sno,''],
            ],
        ];
        $mainResult = $this->dao->ExecuteFill();
        if (count($mainResult) > 0)
        {
            $this->dao->queryOption = [
                'col' => [
                    'SP.*',
                    'CC.ComName AS FishName',
                    'CC1.ComName AS ProdName',
                    'CC2.ComName AS OrgName',
                ],
                'table' => 'Tbl_SaleProduct AS SP',
                'join' => [
                    'INNER JOIN Tbl_ComCode AS CC ON SP.FishCode = CC.ComCode',
                    'INNER JOIN Tbl_ComCode AS CC1 ON SP.ProdCode = CC1.ComCode',
                    'INNER JOIN Tbl_ComCode AS CC2 ON SP.OriginCode = CC2.ComCode',
                ],
                'where' => [
                    'SIdx' => ['=', $mainResult[0]['SIdx'], ''],
                ],
            ];
            $subResult = $this->dao->ExecuteFill();
            //print_r($subResult);

            try {
                echo $this->blade->run('order.salereport', [
                    'mainResult' => $mainResult,
                    'subResult' => $subResult,
                    'orderName' => $ordererName,
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
    public function makepdf()
    {

        $spreadsheet = new Spreadsheet();

        //$mpdf = new mPDF();


    }
}