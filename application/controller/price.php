<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class price extends Controller
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;

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
        $url = '';
        $this->util = new \system\util\util();
        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
    }
    public function index()
    {
        $this->dao->queryOption= [
            'col' => 'Distinct RegDatm',
            'table' => 'Tbl_Fish_R_MarkPrice',
            'order' => 'RegDatm Desc',
            'limit' => '0, 20'
        ];
        $result = $this->dao->ExecuteFill();
        $this->dao->queryOption = [
            'col' =>[
                'FORMAT(TFRM.MarketPrice, 0) as MarketPrice',
                'CC.ComName as FishName',
                'CC.ComCode as FishCode ',
                'CC1.ComName as ProdName',
                'FRPO.FRPROIdx as ProdCode',
                'DD.ComName as OrgName',
                'FRPO.FORGIdx as OrgCode',
                'EE.ComName as KgName',
                'EE.ComCode as KgCode',
            ],
            'table' => 'Tbl_Fish_R_MarkPrice as TFRM',
            'join' =>[
                'INNER JOIN Tbl_Fish_R_ProductType AS FRP ON TFRM.FRPROIdx = FRP.FRPROIdx',
                'INNER JOIN Tbl_ComCode AS CC ON FRP.FishCode = CC.ComCode',
                'INNER JOIN Tbl_ComCode AS CC1 ON FRP.ProdCode = CC1.ComCode',
                'INNER JOIN Tbl_Fish_R_OrgCode AS FRPO ON TFRM.FORGIdx = FRPO.FORGIdx',
                'INNER JOIN Tbl_ComCode AS DD ON FRPO.OrgCode = DD.ComCode',
                'INNER JOIN Tbl_ComCode AS EE ON TFRM.KgCode = EE.ComCode'
            ],
            'where' =>[
                'RegDatm' => ['=', date("Y-m-d", time()), 'and'],
                'TFRM.IsDel' => ['=', 'N', '']

            ],
            'order' => 'FishName asc, ProdName asc, OrgName asc, KgName asc',
        ];
        $todayPrice = $this->dao->ExecuteFill();
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('price.index',[
                'result' => $result,
                'todayPrice' => $todayPrice,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function loadPriceDate()
    {
        $date = $this->util->urlParam('date', '');

        $this->dao->queryOption = [
            'col' =>[
                'FORMAT(TFRM.MarketPrice, 0) as MarketPrice',
                'CC.ComName as FishName',
                'CC.ComCode as FishCode ',
                'CC1.ComName as ProdName',
                'FRPO.FRPROIdx as ProdCode',
                'DD.ComName as OrgName',
                'FRPO.FORGIdx as OrgCode',
                'EE.ComName as KgName',
                'EE.ComCode as KgCode',
            ],
            'table' => 'Tbl_Fish_R_MarkPrice as TFRM',
            'join' =>[
                'INNER JOIN Tbl_Fish_R_ProductType AS FRP ON TFRM.FRPROIdx = FRP.FRPROIdx',
                'INNER JOIN Tbl_ComCode AS CC ON FRP.FishCode = CC.ComCode',
                'INNER JOIN Tbl_ComCode AS CC1 ON FRP.ProdCode = CC1.ComCode',
                'INNER JOIN Tbl_Fish_R_OrgCode AS FRPO ON TFRM.FORGIdx = FRPO.FORGIdx',
                'INNER JOIN Tbl_ComCode AS DD ON FRPO.OrgCode = DD.ComCode',
                'INNER JOIN Tbl_ComCode AS EE ON TFRM.KgCode = EE.ComCode'
            ],
            'where' =>[
                'RegDatm' => ['=', $date, 'and'],
                'TFRM.IsDel' => ['=', 'N', '']
            ],
            'order' => 'FishName asc, ProdName asc, OrgName asc, KgName asc',
        ];

        $result = $this->dao->ExecuteFill();
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }
    public function loadPriceData()
    {
        $prodCode = $this->util->urlParam('prodCode', '52');
        $orgCode = $this->util->urlParam('orgCode', '159');
        $kgCode = $this->util->urlParam('kgCode','100018');

        $day = date("Y-m-d", time());
        $queryArray =[];
        for ($i=0; $i < 7; $i++)
        {
            $CheckDate = date("Y-m-d", strtotime($day." -".$i." day"));
            $this->dao->queryOption =[
                'col' =>
                [
                    '*',
                    'IFNULL((SELECT MarketPrice FROM Tbl_Fish_R_MarkPrice AS FRM WHERE 
                        FRPROIDX=' . $prodCode .' AND 
                        FORGIdx=' . $orgCode . ' AND 
                        KgCode=' . $kgCode . ' AND 
                        IsDel=\'N\' AND FRM.RegDatm=MST.RegDatm), 0) AS Price'

                ],
                'table' => '(SELECT \'' . $CheckDate . '\' AS RegDatm FROM DUAL) as MST',
            ];
            $queryArray[] = $this->dao->queryOption;

            //echo $this->dao->getQuery();
            //echo $CheckDate . "<BR>";
        }
        $result = $this->dao->ExecuteUnion($queryArray);
        sort($result);
        $json_result = json_encode($result, JSON_UNESCAPED_UNICODE);
        header('Content-Type: application/json; charset=utf-8');
        echo $json_result;
    }


}