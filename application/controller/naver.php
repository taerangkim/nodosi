<?php
set_time_limit(0);
header('Content-Encoding: none');
use eftec\bladeone\BladeOne;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');

class naver extends Controller
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

//        if ($_SESSION['naver_state'] != $_GET['state'])
//        {
//            // 오류가 발생하였습니다. 잘못된 경로로 접근 하신것 같습니다.
//        }
        $naver_Client_ID = 'mQoed7yuPkYlWGUC2sEt';
        $NAVER_CLIENT_SECRET = 'JEgnnEOUGi';

        $naver_Callback_url =  'http://dev.nodosi.co.kr/naver/oauth';

        $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$naver_Client_ID."&client_secret=".$NAVER_CLIENT_SECRET."&redirect_uri=".urlencode($naver_Callback_url)."&code=".$_GET['code']."&state=".$_GET['state']; // 토큰값 가져오기

        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $naver_curl);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if($status_code == 200)
        {
            $responseArr = json_decode($response, true);

            $_SESSION['naver_access_token'] = $responseArr['access_token'];
            $_SESSION['naver_refresh_token'] = $responseArr['refresh_token']; // 토큰값으로 네이버 회원정보 가져오기

            $me_headers = array(
                'Content-Type: application/json',
                sprintf('Authorization: Bearer %s',
                $responseArr['access_token'])
            );
            $me_is_post = false;
            $me_ch = curl_init();
            curl_setopt($me_ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
            curl_setopt($me_ch, CURLOPT_POST, $me_is_post);
            curl_setopt($me_ch, CURLOPT_HTTPHEADER, $me_headers);
            curl_setopt($me_ch, CURLOPT_RETURNTRANSFER, true);
            $me_response = curl_exec ($me_ch);
            $me_status_code = curl_getinfo($me_ch, CURLINFO_HTTP_CODE);
            curl_close ($me_ch);
            $me_responseArr = json_decode($me_response, true);
            if ($me_responseArr['response']['id'])
            {
                $mb_uid = 'naver_'.$me_responseArr['response']['id'];
                $this->dao->queryOption = [
                    'col' => [
                        'MemId',
                        'MemIdx',
                        'NickName',
                    ],
                    'table' => 'Tbl_Member',
                    'where' => [
                        'MemId' => ["=", $mb_uid , '']
                    ]
                ];
                $memResult = $this->dao->ExecuteFill();

                if (count($memResult) == 0) {
                    $mb_nickname = $me_responseArr['response']['nickname']; // 닉네임
                    $mb_email = $me_responseArr['response']['email']; // 이메일

                    $this->dao->queryOption = [
                        'table' => 'Tbl_Member',
                        'val' => [
                            'MemId' => $mb_uid,
                            'NickName' => $mb_nickname,
                            'SNS' => 'naver',
                            'Email' => $mb_email
                        ]
                    ];
                    $memIdx = $this->dao->ExecuteInsetLastId();
                    $_SESSION['NickName'] = $mb_nickname;
                    $_SESSION['MemId'] = $mb_uid;
                    $_SESSION['MemIdx'] = $memIdx;
                    //echo '가입';
                }
                else {
                    $_SESSION['NickName'] = $memResult[0]['NickName'];;
                    $_SESSION['MemId'] = $memResult[0]['MemId'];
                    $_SESSION['MemIdx'] = $memResult[0]['MemIdx'];
                    //echo '이미 가입';
                }
                header('Location: /reserv');
                exit;


            } else {
                // 회원정보를 가져오지 못했습니다.
            }
        }
        else
        { // 토큰값을 가져오지 못했습니다.
        }




//
//            $naver_curl = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".NAVER_CLIENT_ID."&client_secret=".NAVER_CLIENT_SECRET."&redirect_uri=".urlencode(NAVER_CALLBACK_URL)."&code=".$_GET['code']."&state=".$_GET['state'];
//
//            출처: https://blog.yesyo.com/entry/네아로-네이버-아이디로-로그인-PHP-연동 [MintState WebLog]
//
//
//            $naver_Secret = 'JEgnnEOUGi';
//
//
//        $admin_key = "d1aa8fe0fc2e2df3f7a655a7a5d7802c"; //APP 키 발급 정보에 보면 ADMIN 키도 함께 있다.
//        if(isset($_SESSION['access_token']))
//        {
//            $access_token =$_SESSION['access_token'];
//        }else {
//            $code = $_GET["code"]; //발급받은 code 값
//            $app_key = "aaad8c367fcbf41179e77a3a4b74843f";
//            $redirect_uri = "http://dev.nodosi.co.kr/kakao/oauth";
//            $api_url = "https://kauth.kakao.com/oauth/token";
//            $params = sprintf( 'grant_type=authorization_code&client_id=%s&redirect_uri=%s&code=%s', $app_key, $redirect_uri, $code);
//            $opts = array(
//                CURLOPT_URL => $api_url,
//                CURLOPT_SSL_VERIFYPEER => false,
//                CURLOPT_POST => true,
//                CURLOPT_POSTFIELDS => $params,
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_HEADER => false );
//            $ch = curl_init();
//            curl_setopt_array($ch, $opts);
//            $result = curl_exec($ch);
//            curl_close($ch);
//            $resultDecode = json_decode($result, true);
//
//            $access_token = $resultDecode["access_token"];
//            $_SESSION['access_token'] = $resultDecode["access_token"];
//        }
//        //echo "access_token=>" . $_SESSION['access_token'];
//
//        $app_url= "https://kapi.kakao.com/v2/user/me";
//        $opts = array(
//            CURLOPT_URL => $app_url,
//            CURLOPT_SSL_VERIFYPEER => false,
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => false,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_HTTPHEADER => array( "Authorization: Bearer " . $access_token )
//        );
//        $ch = curl_init();
//        curl_setopt_array($ch, $opts);
//        $result = curl_exec($ch);
//        curl_close($ch);
//        $result = json_decode($result, true);
//        $this->dao->queryOption = [
//            'col' => [
//                'MemId',
//                'MemIdx',
//                'NickName',
//            ],
//            'table' => 'Tbl_Member',
//            'where' => [
//                'MemId' => ["=", 'kakao' . $result['id'] , '']
//            ]
//        ];
//        $memResult = $this->dao->ExecuteFill();
//        if (count($memResult) == 0)
//        {
//            if ($result['id'] != '' && $result['kakao_account']['profile']['nickname'] != '' && $result['kakao_account']['email'] != '')
//            {
//                $this->dao->queryOption = [
//                    'table' => 'Tbl_Member',
//                    'val' => [
//                        'MemId' => 'kakao' . $result['id'],
//                        'NickName' => $result['kakao_account']['profile']['nickname'],
//                        'SNS' => 'kakao',
//                        'Email' => $result['kakao_account']['email']
//                    ]
//                ];
//                $memIdx = $this->dao->ExecuteInsetLastId();
//                $_SESSION['NickName'] = $result['kakao_account']['profile']['nickname'];
//                $_SESSION['MemId'] = 'kakao' . $result['id'];
//                $_SESSION['MemIdx'] = $memIdx;
//            }else
//            {
//            }
//        }else
//        {
//            $_SESSION['NickName'] = $memResult[0]['NickName'];;
//            $_SESSION['MemId'] = $memResult[0]['MemId'];
//            $_SESSION['MemIdx'] = $memResult[0]['MemIdx'];
//        }
//        header('Location: /reserv');
//        exit;
    }
}

//"{"msg":"no authentication key!","code":-401}"
//is_email_valid  kakao 계정 주인이 이메일 인증을 정상적으로 진행한 경우 true 아닌경우 false
//"has_email":true,"email_needs_agreement":false,"is_email_valid":true,"is_email_verified":true,"email":"cadcom4817@gmail.com"}}"
//string(715) "{"id":1571779037,"connected_at":"2020-12-23T11:00:11Z",
//    "properties":{
//        "nickname":"김승일",
//        "profile_image":"http://k.kakaocdn.net/dn/ntUgg/btqGpz3wSR0/lkCUmfGdqRs39VMaaykIUk/img_640x640.jpg",
//        "thumbnail_image":"http://k.kakaocdn.net/dn/ntUgg/btqGpz3wSR0/lkCUmfGdqRs39VMaaykIUk/img_110x110.jpg"
//    },
//    "kakao_account":{
//        "profile_needs_agreement":false,
//        "profile":{
//          "nickname":"김승일",
//          "thumbnail_image_url":"http://k.kakaocdn.net/dn/ntUgg/btqGpz3wSR0/lkCUmfGdqRs39VMaaykIUk/img_110x110.jpg",
//          "profile_image_url":"http://k.kakaocdn.net/dn/ntUgg/btqGpz3wSR0/lkCUmfGdqRs39VMaaykIUk/img_640x640.jpg"
//          },
//       "has_email":true,
//       "email_needs_agreement":false,
//       "is_email_valid":true,
//       "is_email_verified":true,
//       "email":"cadcom4817@gmail.com"
//   }
//}" 1571779037