<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class my extends Controller
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
        $IsBiz = $_SESSION['IsBiz'];
        $NickName = $_SESSION['NickName'];
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('my.index',[
                'urlparams' =>  $this->urlparams,
                'NickName' => $NickName,
                'IsBiz' => $IsBiz,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function fish()
    {

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.fish',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function custom()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.custom',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function review()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.review',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }




    public function deal()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.deal',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function friend()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.friend',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public function blackfriend()
    {
        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('my.blackfriend',[
                'urlparams' =>  $this->urlparams,
            ]);
            echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    public  function nickname()
    {

        try {
            echo $this->blade->run('_templates.header');
            echo $this->blade->run('_templates.gnb_order', [
                'urlparams' => $this->urlparams,
            ]);
            echo $this->blade->run('my.index', [

            ]);
            //echo $this->blade->run('_templates.footer');
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }


    }
    public function setnickname()
    {
        $nick = $this->util->urlParam('nickname', '');
        $this->dao->queryOption=[
            'table' => 'Tbl_Member',
            'val' =>
                [
                    'NickName' => $nick
                ],
            'where' =>[
                'MemIdx' => ['=', $_SESSION['MemIdx'], '']
            ],
        ];
        $_SESSION['NickName'] = $nick;

        $this->dao->ExecuteUpdate();
        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '닉네임이 설정되었습니다.',
                'location' => '/my',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }


    }


}