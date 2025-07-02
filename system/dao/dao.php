<?php
//namespace 규칙은 system/dir
namespace system\dao;
use Exception;
use \PDO;

class dao extends PDO{      // User 클래스 선언
    public $serverName, $connectionOptions;
    public $queryOption;
    public  $conn;
    private $util;
    public $dbName = "main";

    public function __construct() {
        $this->util = new \system\util\util();
    }

    /* open
     * 기본 LMS DB OPEN
     */
    public function open()
    {

        $setting = new \system\config\config();
        try
        {
            if ($this->dbName == "main")
            {
                $this->conn = new PDO( "mysql:host=$setting->lmsServer; dbname=$setting->lmsDBName", "$setting->lmsUid", "$setting->lmsPWD");
                $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }else if($this->dbName == "mcs")
            {
                $this->conn = new PDO( "mysql:host=$setting->mcsServer; dbname=$setting->mcsDBName", "$setting->mcsUid", "$setting->mcsPWD");
                $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }else
            {
                $this->conn = new PDO( "mysql:host=$setting->lmsServer; dbname=$setting->lmsDBName", "$setting->lmsUid", "$setting->lmsPWD");
                $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            }
        }
        catch(Exception $e)
        {
            die( print_r( $e->getMessage() ) );
        }
        return $this->conn;
    }
    public function openOtherDB($set)
    {
        $this->conn = sqlsrv_connect(
            $set->serverName, $set->connectionOptions);
        return $this->conn;
    }
    /*
     * ExecuteQuery
     * 원시쿼리를 이용한 조회
     */
    public function ExecuteQuery()
    {



        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);
        $this->util->fn_logSave($this->queryOption);
        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($this->queryOption);
        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);

        return $Rslt -> fetchAll(PDO::FETCH_ASSOC);
    }

    public function ExecuteUpdateQuery()
    {
        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);
        $this->util->fn_logSave($this->queryOption);
        $start = $this->util->get_time();
        $Rslt = $this-> conn -> prepare($this->queryOption);
        $Rslt -> execute();
        $end = $this->util->get_time();
        $time = $end - $start;
        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";
        $this->util->fn_logSave($msg);
        return;
    }
    /* ExecuteUnion
     * Union Join
     */

    public function ExecuteUnion($OptionArray)
    {
        $querArray = [];
        foreach ($OptionArray as $item)
        {
            $this->queryOption = $item;
            $query = $this->makeSelectQuery();
            $querArray[] = $query;
        }
        $query = implode("  Union ", $querArray);

        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);

        $this->util->fn_logSave($query);
        $query = str_replace("\r\n", "", $query);

        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($query);

        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);

        return $Rslt -> fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * ExecuteUnionAll
     * Union All Join
     */

    public function ExecuteUnionAll($OptionArray)
    {
        $querArray = [];
        foreach ($OptionArray as $item)
        {
            $this->queryOption = $item;
            $query = $this->makeSelectQuery();
            $querArray[] = $query;
        }
        $query = implode("  Union All  ", $querArray);

        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);

        $this->util->fn_logSave($query);
        $query = str_replace("\r\n", "", $query);

        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($query);

        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);

        return $Rslt -> fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * ExecuteFill
     * 여러개의 ROW 가지고 오기
     */

    public function ExecuteFill()
    {
        $query = $this->makeSelectQuery();

        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);

        $this->util->fn_logSave($query);
        $query = str_replace("\r\n", "", $query);

        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($query);

        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);

        return $Rslt -> fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * ExecuteScalar
     * 한개의 Row에서 한개의 컬럼값만 리턴
     */
    public function ExecuteScalar()
    {
        $query = $this->makeSelectQuery();
        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);

        $this->util->fn_logSave($query);
        $query = str_replace("\r\n", "", $query);

        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($query);
        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);

        return $Rslt->fetchColumn(0);
    }
    /*
     * ExecuteDelete
     * 삭제 쿼리
     */
    public function ExecuteDel()
    {
        $query = $this->makeDeleteQuery();
        $msg = "============================================\r\n" . date("Y-m-d H:i:s") . " 쿼리 시작";
        $this->util->fn_logSave($msg);

        $this->util->fn_logSave($query);
        $query = str_replace("\r\n", "", $query);

        $start = $this->util->get_time();

        $Rslt = $this-> conn -> prepare($query);

        $Rslt -> execute();

        $end = $this->util->get_time();

        $time = $end - $start;

        $msg = "Query 실행 시간 " . $time . "\r\n============================================\r\n";

        $this->util->fn_logSave($msg);
    }
    /*
     * ExecuteLastId
     * 등록 후 마지막 증가값 가지고 오기
     */
    public function ExecuteInsetLastId()
    {
        $query = $this->makeInsertQuery();
        try
        {
            $this->util->fn_logSave($query);

            $Rslt = $this-> conn -> prepare($query);
            $Rslt -> execute();
            $query = "SELECT @@IDENTITY";
            $Rslt = $this-> conn -> prepare($query);
            $Rslt -> execute();
            return $Rslt->fetchColumn(0);
        }catch (Exception $e)
        {

            die( print_r( $e->getMessage() ) );
            return;
        }
    }
    /*
     * ExecuteInsert
     * 등록
     */
    public function ExecuteInsert()
    {
        $query = $this->makeInsertQuery();

        try
        {
            $this->util->fn_logSave($query);
            $Rslt = $this-> conn -> prepare($query);
            $Rslt -> execute();
        }catch (Exception $e)
        {

            die( print_r( $e->getMessage() ) );
        }
        return;
    }

    /*
     * ExecuteUpdate
     * 업데이트
     */
    public function ExecuteUpdate()
    {

        $query = $this->makeUpdateQuery();
        try
        {
            $this->util->fn_logSave($query);
            $Rslt = $this-> conn -> prepare($query);
            $Rslt -> execute();

        }catch (Exception $e)
        {
            die( print_r( $e->getMessage() ) );
        }
    }
    private function makeDeleteQuery()
    {
        $option = $this->queryOption;
        $query = "delete \r\n";
        $query .= " \r\n FROM {$option['table']} \r\n";

        if (isset($option['where']))
        {
            $where= "";

            if (is_array($option['where']) && count($option['where']) > 1)
            {

                $query .= " WHERE 1=1 and ";
                if(gettype($option['where']) == 'array')
                {
                    foreach ($option['where'] as $key => $item)
                    {
                        if (is_array($item) && count($item) > 1)
                        {
                            if ($item[0] == 'in')
                            {
                                $where .=  $key .  " in ({$item[1]}) {$item[2]}  \r\n";
                            }
                            else if($item[0] == '()')
                            {
                                $where .= "(" . $item[1] . ") " . $item[2] . " \r\n";
                            }else
                            {
                                $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " \r\n";
                            }
                        }
                    }
                    $query .= $where;
                }else
                {
                    $query .= " and {$option['where']} \r\n";
                }
            }else
            {
                if (gettype($option['where']) == 'array')
                {
                    if(is_array($option['where']) && count($option['where']) > 0)
                    {

                        $query .= " WHERE 1=1 and \r\n";
                        foreach ($option['where'] as $key => $item)
                        {
                            if ($item[0] == 'in')
                            {
                                $where .= $key . "in ({$item[1]}) {$item[2]}";
                            }else if($item[0] == '()')
                            {
                                $where .=  "(" . $item[1] . ") " . $item[2] . " \r\n";
                            }
                            else
                            {
                                $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " \r\n";
                            }
                        }

                        $query .= $where;
                    }else
                    {
                        $query .= " WHERE 1=1 \r\n";
                    }
                }else
                {

                    $query .= " WHERE 1=1 and {$option['where']} \r\n";
                }

            }
        }
        return $query;


    }
    private function makeUpdateQuery()
    {

        $option = $this->queryOption;
        $upval = "";
        if(isset($option['val']))
        {
            foreach ($option['val'] as $key => $item)
            {
                if ($item=='getdate()' or $item=='null')
                {
                    $upval .= $key ."=" . $item . ",";

                }else {
                    $upval .= $key ."='" . $item . "',";
                }
            }
        }
        if (isset($option['sysval']))
        {
            foreach ($option['sysval'] as $key => $item)
            {
                $upval .= $key ."=" . $item . ",";
            }

        }

        $upval = substr($upval,0,-1);
        $where = '';

        if (isset($option["where"]))
        {

            if (gettype($option["where"]) == 'array')

            {
                $where .= ' where 1=1 and ';
                foreach ($option['where'] as $key => $item)
                {
                    if (is_array($item) && count($item) > 1)
                    {
                        if ($item[0] == 'in')
                        {
                            $where .=  $key .  " in ({$item[1]})";
                        }
                        else if($item[0] == '()')
                        {
                            $where .= "(" . $item[1] . ") " . $item[2] . " ";
                        }
                        else if($item[1] == 'null')
                        {
                            $where .= $key . ' is null' . $item[2] . " " ;
                        }
                        else
                        {
                            $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " ";
                        }
                    }

                }
            }else
            {
                $where = "where 1=1 " . $option['where'];
            }

        }

        $query = "update {$option['table']} set {$upval} " . $where;
        return $query;
    }
    private function makeSelectQuery()
    {
        $option = $this->queryOption;

        if (gettype($option) == 'array')
        {
            $query = "SELECT \r\n";
            if (is_array($option['col']) && count($option['col']) > 1)
            {
                $col = '';
                foreach ($option['col'] as $colItem) {
                    $col .= $colItem . ",\r\n";
                }
                $col = substr($col,0,-3);
                $query .= $col;

            }else
            {
                $query .= $option['col'];
            }
            $query .= " \r\n FROM {$option['table']} \r\n";

            if (isset($option['join']))
            {
                if(gettype($option['join']) == 'array')

                {
                    foreach ($option['join'] as $joinItem) {
                        $query .= $joinItem . " \r\n";
                    }
                }else
                {
                    $query .= $option['join'] . " \r\n";
                }

            }


            if (isset($option['where']))
            {
                $where= "";

                if (is_array($option['where']) && count($option['where']) > 1)
                {

                    $query .= " WHERE 1=1 and ";
                    if(gettype($option['where']) == 'array')
                    {
                        foreach ($option['where'] as $key => $item)
                        {
                            if (is_array($item) && count($item) > 1)
                            {
                                if($item[1] == 'null')
                                {
                                    $where .= $key . ' is null ' . $item[2] . " \r\n";
                                }else
                                {
                                    if ($item[0] == 'in')
                                    {
                                        $where .=  $key .  " in ({$item[1]}) {$item[2]}  \r\n";
                                    }
                                    else if($item[0] == '()')
                                    {
                                        $where .= "(" . $item[1] . ") " . $item[2] . " \r\n";
                                    }
                                    else if($item[1] == 'null')
                                    {
                                        $where .= $key . ' is null ' . $item[2] . " \r\n";
                                    }else
                                    {
                                        $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " \r\n";
                                    }
                                }


                            }
                        }
                        $query .= $where;
                    }else
                    {
                        $query .= " and {$option['where']} \r\n";
                    }
                }else
                {
                    if (gettype($option['where']) == 'array')
                    {
                        if(is_array($option['where']) && count($option['where']) > 0)
                        {

                            $query .= " WHERE 1=1 and \r\n";
                            foreach ($option['where'] as $key => $item)
                            {
                                if($item[1] == 'null')
                                {

                                }else
                                {
                                    if ($item[0] == 'in')
                                    {
                                        $where .= $key . "in ({$item[1]}) {$item[2]}";
                                    }else if($item[0] == '()')
                                    {
                                        $where .=  "(" . $item[1] . ") " . $item[2] . " \r\n";
                                    }else if($item[1] == 'null')
                                    {
                                        $where .= $key . ' is null ' . $item[2] . " \r\n";
                                    }
                                    else
                                    {
                                        $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " \r\n";
                                    }
                                }

                            }

                            $query .= $where;
                        }else
                        {
                            $query .= " WHERE 1=1 \r\n";
                        }
                    }else
                    {

                        $query .= " WHERE 1=1 and {$option['where']} \r\n";
                    }

                }
            }
            if (isset($option['where()']))
            {
                if (!isset($option['where'])) $query .= " WHERE 1=1 \r\n";
                $query .= "and (";
                $where = "";
                foreach ($option['where()'] as $key => $item)
                {
                    $where .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " ";
                }
                $query .= $where;

                $query .= ") \r\n";
            }

            if (isset($option['group']))
            {
                if (is_array($option['group']) && count($option['group']) > 1)
                {
                    $group = " group by ";
                    foreach ($option['group'] as $item)
                    {
                        $group .=  $item . ",";
                    }
                    $group = substr($group,0,-1);
                    $query .= $group;
                }else
                {
                    $query .= " group by  {$option['group']} \r\n";
                }
            }

            if (isset($option['order']))
            {
                if (is_array($option['order']) && count($option['order']) > 1)
                {

                    $order = " order by \r\n";
                    foreach ($option['order'] as $item)
                    {
                        $order .=  $item . ",";
                    }
                    $order = substr($order,0,-1);
                    $query .= $order;

                }else
                {
                    $query .= " order by  {$option['order']} \r\n";
                }
            }
            if (isset($option['limit']))
            {
                $query .= " limit {$option['limit']} \r\n";
            }
        }else
        {
            $query = $option;
        }

        return $query;
    }
    private function makeInsertQuery()
    {
        $option = $this->queryOption;
        if (isset($option['col']))
        {
            $query = "insert into {$option['table']} ({$option['col']}) values ({$option['val']})";
        }else
        {
            $col = "";
            $val = "";
            foreach ($option['val'] as $key => $item)
            {
                $col .= $key . ",";

                if (strtolower($item)=='null')
                {
                    $val .= "null,";

                }
                else if($item=='getdate()')
                {
                    $val .= $item . ",";
                }
                else
                {
                    $val .= "'" . $item . "',";
                }
            }
            $col = substr($col,0,-1);
            $val = substr($val,0,-1);
            $query = "insert into {$option['table']} ({$col}) values ({$val})";
        }

        return $query;
    }
    public  function  getQuery()
    {
        $query = $this->makeSelectQuery();
        return $query;
    }
    public function getUnionQuery($OptionArray)
    {
        $querArray = [];
        foreach ($OptionArray as $item)
        {
            $this->queryOption = $item;
            $query = $this->makeSelectQuery();
            $querArray[] = $query;
        }
        $query = implode("  Union ", $querArray);
        return $query;
    }

    public function getUnionAllQuery($OptionArray)
    {
        $querArray = [];
        foreach ($OptionArray as $item)
        {
            $this->queryOption = $item;
            $query = $this->makeSelectQuery();
            $querArray[] = $query;
        }
        $query = implode("  Union All  ", $querArray);
        return $query;
    }
    public function getDeleteQuery()
    {
        $query = $this->makeDeleteQuery();
        return $query;
    }
    public  function getInsertQuery()
    {
        $query = $this->makeInsertQuery();
        return $query;
    }
    public  function getUpdateQuery()
    {
        $query = $this->makeUpdateQuery();
        return $query;
    }
    public function addWhereOption($search, $array, $suffix)
    {

        if($suffix == '') $suffix = 'and';
        if($search=="where()")
        {
            end($this->queryOption['where']);
            $key = key($this->queryOption['where']);
            $this->queryOption['where'][$key][2] = $suffix;
            $addOptionStr = '';
            foreach ($array as $key => $item)
            {
                $addOptionStr .= $key . $item[0] ."'" . $item[1] . "' " . $item[2] . " ";
            }
            $addOption = [
                '()' => ['()', $addOptionStr , ''],
            ];
            $this->queryOption['where'] = array_merge($this->queryOption['where'], $addOption);
        }else
        {
            end($this->queryOption[$search]);
            $key = key($this->queryOption[$search]);
            $this->queryOption[$search][$key][2] = $suffix;
            $this->queryOption[$search] = array_merge($this->queryOption[$search], $array);
        }



    }
    public function addWhereOptionQuery($search, $array)
    {

    }

    public  function addOption($array)
    {
        $this->queryOption = array_merge($this->queryOption, $array);
    }


}
?>