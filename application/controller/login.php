<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class login extends Controller
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
        $this->util = new \system\util\util();

        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
    }
    public function index()
    {
        $hostname=$_SERVER["HTTP_HOST"];

        $ret = $this->util->urlParam('ret','');
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('login.login', [
                'hostname' => $hostname,
                'ret' => $ret,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function logout()
    {
        session_destroy();
        header('Location: /');
    }
}