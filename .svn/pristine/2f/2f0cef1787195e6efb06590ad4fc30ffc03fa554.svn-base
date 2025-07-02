<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class kakao extends Controller
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

    }
    public function oauth()

    {
        $hostname=$_SERVER["HTTP_HOST"];
        $admin_key = "d1aa8fe0fc2e2df3f7a655a7a5d7802c"; //APP 키 발급 정보에 보면 ADMIN 키도 함께 있다.
        if(isset($_SESSION['access_token']))
        {
            $access_token =$_SESSION['access_token'];
        }else {
            $code = $_GET["code"]; //발급받은 code 값
            $state = $_GET['state'];
            $app_key = "aaad8c367fcbf41179e77a3a4b74843f";
            $redirect_uri = "https://" . $hostname . "/kakao/oauth";
            $api_url = "https://kauth.kakao.com/oauth/token";
            $params = sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', $app_key, $redirect_uri, $code);
            $opts = array(
                CURLOPT_URL => $api_url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $params,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false );
            $ch = curl_init();
            curl_setopt_array($ch, $opts);
            $result = curl_exec($ch);
            curl_close($ch);

            $this->util->fn_logSave($result);
            $resultDecode = json_decode($result, true);

            $access_token = $resultDecode["access_token"];
            $_SESSION['access_token'] = $resultDecode["access_token"];
        }

        //echo "access_token=>" . $_SESSION['access_token'];

        $app_url= "https://kapi.kakao.com/v2/user/me";
        $opts = array(
            CURLOPT_URL => $app_url,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token )
        );
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $result = curl_exec($ch);
        curl_close($ch);

        $result = $this->removeEmoji($result);

        $this->util->fn_logSave($result);

        $result = json_decode($result, true, 512,JSON_UNESCAPED_UNICODE);
        $this->dao->queryOption = [
            'col' => [
                'MemId',
                'MemIdx',
                'NickName',
                'Email',
                'IsBiz',
            ],
            'table' => 'Tbl_Member',
            'where' => [
                'MemId' => ["=", 'kakao' . $result['id'] , '']
            ]
        ];
        $memResult = $this->dao->ExecuteFill();
        if (count($memResult) == 0)
        {
            if ($result['id'] != '' && $result['kakao_account']['email'] != '')
            {
                $this->dao->queryOption = [
                    'table' => 'Tbl_Member',
                    'val' => [
                        'MemId' => 'kakao' . $result['id'],
                        'NickName' => '',
                        'SNS' => 'kakao',
                        'Email' => $result['kakao_account']['email']
                    ]
                ];
                $memIdx = $this->dao->ExecuteInsetLastId();
                $_SESSION['NickName'] = '';
                $_SESSION['MemId'] = 'kakao' . $result['id'];
                $_SESSION['MemIdx'] = $memIdx;
                $_SESSION['IsBiz'] = '0';
                header('Location: /my');
                exit;

            }else
            {
            }
        }else
        {
            $_SESSION['NickName'] = $memResult[0]['NickName'];;
            $_SESSION['MemId'] = $memResult[0]['MemId'];
            $_SESSION['MemIdx'] = $memResult[0]['MemIdx'];
            $_SESSION['IsBiz'] = $memResult[0]['IsBiz'];
            if($state == 'order')
            {
                header('Location: /order');
            }else if($state == 'review')
            {
                header('Location: /review');
            }else
            {
                header('Location: /');
            }

            exit;
        }

        try {
            echo $this->blade->run('_templates.alertRedirect', [
                'msg' => '가입정보가 없습니다.\n한길통상 온라인팀에 문의 하시기 바랍니다.',
                'location' => '/',
            ]);
        } catch (Exception $e) {
            echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
        }
    }
    function unlink()
    {
        if(isset($_SESSION['access_token']))
        {
            $access_token = $_SESSION['access_token'];
            $UNLINK_API_URL = "https://kapi.kakao.com/v1/user/unlink";
            $opts = array(
                CURLOPT_URL => $UNLINK_API_URL,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSLVERSION => 1,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token )
            );
            $curlSession = curl_init();
            curl_setopt_array($curlSession, $opts);
            $accessUnlinkJson = curl_exec($curlSession);
            curl_close($curlSession);
            $unlink_responseArr = json_decode($accessUnlinkJson, true);

            $this->dao->queryOption = [
                'table' => 'Tbl_Member',
                'where' => [
                    'MemIdx' => ['=', $_SESSION['MemIdx'], '']
                ]
            ];
            $this->dao->ExecuteDel();

            unset($_SESSION['NickName']);
            unset($_SESSION['MemId']);
            unset($_SESSION['MemIdx']);
            unset($_SESSION['access_token']);
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '카카오 연결이 해제 되었습니다.\n감사합니다.',
                    'location' => '/',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }

        }else{
            try {
                echo $this->blade->run('_templates.alertRedirect', [
                    'msg' => '로그인 후 이용하여 주시기 바랍니다.',
                    'location' => '/',
                ]);
            } catch (Exception $e) {
                echo "error found " . $e->getMessage() . "<br>" . $e->getTraceAsString();
            }
        }


    }

    function removeEmoji($text) {
        $clean_text = "";
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        // Match Flags
        $regexDingbats = '/[\x{1F1E6}-\x{1F1FF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        // Others
        $regexDingbats = '/[\x{1F910}-\x{1F95E}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        $regexDingbats = '/[\x{1F980}-\x{1F991}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        $regexDingbats = '/[\x{1F9C0}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        $regexDingbats = '/[\x{1F9F9}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }
}