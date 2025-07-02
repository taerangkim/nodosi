<?php
namespace system\util;

class util
{      // User 클래스 선언
    public  $initBlock = 10;
    public  $initPahe = 10;

    public function __construct() {
    }

    public  function urlParam($paramName, $defaultReturn)
    {
        if (isset($_GET[$paramName]))
        {
            return $_GET[$paramName];
        }else if(isset($_POST[$paramName]))
        {
            return $_POST[$paramName];
        }else

        {
            return $defaultReturn;
        }
    }
    public  function PagingNav($intTotalPage, $nowPage)
    {

        $total_block = ceil ($intTotalPage / $this->initBlock);
        $block = ceil ($nowPage / $this->initBlock);
        $first_page = (($block - 1) * $this->initBlock) + 1;
        $last_page = min ($intTotalPage, $block * $this->initBlock);

        $prev_page = $nowPage - 1;
        $next_page = $nowPage + 1;

        $prev_block = $block - 1;
        $next_block = $block + 1;
        $prev_block_page = $prev_block * $this->initBlock;
        $next_block_page = $next_block * $this->initBlock - ($this->initBlock - 1);


        $result = [
            'total_block'=> $total_block,
            'block'=> $block,
            'first_page'=>$first_page,
            'last_page'=>$last_page,
            'prev_page'=>$prev_page,
            'next_page'=>$next_page,
            'prev_block'=>$prev_block,
            'next_block'=>$next_block,
            'prev_block_page'=>$prev_block_page,
            'next_block_page' =>$next_block_page,
            'intTotalPage' => $intTotalPage
        ];
        return $result;


    }
    function fn_logSave($log){ //로그내용 인자
        $logPathDir = $_SERVER['DOCUMENT_ROOT'] . "/_log";  //로그위치 지정


        $filePath = $logPathDir."/".date("Y")."/".date("n");
        $folderName1 = date("Y"); //폴더 1 년도 생성
        $folderName2 = date("n"); //폴더 2 월 생성

        if(!is_dir($logPathDir."/".$folderName1)){
            mkdir($logPathDir."/".$folderName1, 0777);
        }

        if(!is_dir($logPathDir."/".$folderName1."/".$folderName2)){
            mkdir(($logPathDir."/".$folderName1."/".$folderName2), 0777);
        }

        $log_file = fopen($logPathDir."/".$folderName1."/".$folderName2."/".date("Ymd").".txt", "a");
        fwrite($log_file, $log."\r\n");
        fclose($log_file);
    }
    function get_time() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    function  curl($url, $data)
    {
        if ($data != '')
        {
            $url =  $url . "?" . http_build_query($data, "&","&");
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);

        if (isset($error_msg)) {
            // TODO - Handle cURL error accordingly
            echo "$url CURL ERROR  => " . $http_status;
            return  '';
        }else
        {
            echo "<BR>" . $url . " : result =>" . $http_status . "<BR>\n";

            return $response;
        }


    }
    /*
     *
    */
    function rowsearch($row, $colname, $search)
    {
        if ($search != '') {
            return array_search($search, array_column($row, $colname));
        }
        else
        {
            return '';
        }
    }
    /*
     *
     */
    function rowcount($row , $colname, $search)
    {
        $searchRow = array_column($row, $colname);
        $count = 0;
        foreach ($searchRow as $item) {
            if($item == $search) $count++;
        }
        return $count;
    }
    /*
     *
     */
    function debugPrint($msg, $mode)
    {
        if ($mode=='echo')
        {
            echo "<BR>" . $msg . "<br>";
        }
    }
    /*
     * 파일 용량 변환
     */
    function file_size($size) {
        $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        if ($size == 0) {
            return('n/a');
        } else {
            return (round($size/pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
        }
    }
    function file_perms($fullFilename)
    {
        $perms = fileperms($fullFilename);
        $info  = '';
        $info .= (($perms & 0x0100) ? 'r' : '-');
        $info .= (($perms & 0x0080) ? 'w' : '-');
        $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
        $info .= (($perms & 0x0020) ? 'r' : '-');
        $info .= (($perms & 0x0010) ? 'w' : '-');
        $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) :  (($perms & 0x0400) ? 'S' : '-'));
        $info .= (($perms & 0x0004) ? 'r' : '-');
        $info .= (($perms & 0x0002) ? 'w' : '-');
        $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));
        return $info;
    }

    function array_search($array, $key, $value)
    {

        $results = array();
        $this->array_search_r($array, $key, $value, $results);
        return $results;
    }

    function array_search_r($array, $key, $value, &$results)
    {
        if (!is_array($array)) {
            return;
        }

        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $this->array_search_r($subarray, $key, $value, $results);
        }
    }

};
?>