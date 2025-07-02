<?php
namespace system\message;

class message
{
    private $blade;
    private $views;
    private $compiledFolder;
    private $dao;
    private $util;
    public $urlparams;
    public $WaitMessage = "YYMMDD 한길 통상 판매장 대기 번호는 N 번입니다.\n 판매장에서 대기번호 호출시 판매장으로 이동하여 주시기 바랍니다.\n 즐거운 쇼핑 되시길 바랍니다. 감사합니다.";
    public $SaleMessage = "YYMMDD 한길통상 거래 내역\nPRODUCT\n할인 : DCPRICE 원\n결제금액 : PRICE 원\n\n 이용해주셔서 감사합니다.\n 거래 명세 인터넷으로 확인하기 URL";

    public function __construct()
    {
        $this->dao = new \system\dao\dao();
        $this->dao->dbName = "mcs";
        $this->RowsCount = 0;
        $this->pageingSize = 20;
        $conn = $this->dao->open();
        if ($conn) {
            //echo "Connected!<br>";
        } else {
        }
        $this->util = new \system\util\util();
        $url = '';
        if (isset($_GET['url'])) {
            $url = ltrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
        }
        $this->urlparams = explode('/', $url);
    }

    public function makeSortUrl($url)
    {
        /*
        $client_id = "YOUR_CLIENT_ID"; // 네이버 개발자센터에서 발급받은 CLIENT ID
        $client_secret = "YOUR_CLIENT_SECRET";// 네이버 개발자센터에서 발급받은 CLIENT SECRET
        $encText = urlencode("https://developers.naver.com/docs/utils/shortenurl");
        $postvars = "url=".$encText;
        //$url = "https://openapi.naver.com/v1/util/shorturl";
        //$is_post = true;
        $url = "https://openapi.naver.com/v1/util/shorturl?url=". $url ;
        $is_post = false;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
        $headers = array();
        $headers[] = "X-Naver-Client-Id: ".$client_id;
        $headers[] = "X-Naver-Client-Secret: ".$client_secret;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo "status_code:".$status_code."<br>";
        curl_close ($ch);
        if($status_code == 200) {
            echo $response;
        } else {
            echo "Error 내용:".$response;
        }
        */
    }

    public function sendSmSMessage($title, $msg, $DEST_INFO)
    {
        $this->dao->queryOption = [
            'table' => 'SDK_SMS_SEND',
            'val' => [
                'USER_ID' => 'nodosi',
                'SCHEDULE_TYPE' => '0',
                'SUBJECT' => $title,
                'NOW_DATE' => date("YmdHis"),
                'SEND_DATE' => date("YmdHis"),
                'CALLBACK' => '0222547093',
                'DEST_COUNT' => '0',
                'DEST_INFO' => $DEST_INFO,
                'SMS_MSG' => $msg,
            ]
        ];
        $this->dao->ExecuteInsert();
    }

    public function sendMMSMessage($title, $msg, $DEST_INFO)
    {
        $this->dao->queryOption = [
            'table' => 'SDK_MMS_SEND',
            'val' => [
                'USER_ID' => 'nodosi',
                'SCHEDULE_TYPE' => '0',
                'SUBJECT' => $title,
                'NOW_DATE' => date("YmdHis"),
                'SEND_DATE' => date("YmdHis"),
                'CALLBACK' => '0222547093',
                'DEST_COUNT' => '0',
                'DEST_INFO' => $DEST_INFO,
                'MMS_MSG' => $msg,
            ]
        ];
        $this->dao->ExecuteInsert();
    }

}