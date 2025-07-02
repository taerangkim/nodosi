<?php

class HomeModel
{
    private $dao;
    public function __construct() {
        $this->dao = new \system\dao\dao();
        $conn = $this->dao->open();
        
        $this->util = new \system\util\util();
    }
    /*
    public function getCalculateList($option)
    {
        $pageing = $option['page'];
        $pageingsize = $option['pageingSize'];
        $subQuery = $this->makeSubQuery($option, 'list');

        $this->dao->queryOption=[
            'col' => 'OPIdx',
            'table' =>  '(' . $subQuery . ') as MST',
            'where' => 'MST.ROWNUM BETWEEN '. (($pageing-1) * $pageingsize +1) . ' and ' . ($pageing * $pageingsize)
        ];

        $subQuery = $this->dao->getQuery();

        $this->dao->queryOption=[
            'col' => [
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1301) as SOffPrice'
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1302) as SOffPrice2'
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1303) as SOnPrice'
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1304) as SOnPrice2'
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1305) as SOnPrice3'
                ,'(select SUM(SubPrice1) from Tbl_OrderProduct_Sub1 where OPIdx = A.OPIdx and ProdTypeCat2 = 1306) as SOffPrice3'
            ],
            'table' => 'Tbl_ComCode as A',
            'where' =>[
                   ' A.OPIdx ' => ['in', $subQuery , '']
            ],
            'order' => 'A.OPIdx desc','M.CalMDate desc'
        ];
        
        return $this->dao->ExecuteFill();
        

    }
    */
    /*
    public function getCalculateListModelCount($option)
    {
        $subQuery = $this->makeSubQuery($option, 'count');

        $this->dao->queryOption=[
            'col' => 'count(OPIdx) as cnt',
            'table' =>  '(' . $subQuery . ') as MST'
        ];
        //echo $this->dao->getQuery();
        return $this->dao->ExecuteFill();
    }
    */
    /*
    private function makeSubQuery($option, $type)
    {
        $OPIdx = $option['OPIdx'];
        $pageing = $option['page'];
        $pageingsize = $option['pageingSize'];
        $keyword = $option['keyword'];
        $sMDate = $option['sMDate'];
        $eMDate = $option['eMDate'];
        
        
        if ($type=='count'){
        
            $this->dao->queryOption=[
                'col' => 'A.ProdCode',
                'table' => 'Tbl_OrderProduct as A',
                'where' =>[]
            ];
        
        } else {
        
            $this->dao->queryOption=[
                'col' => ['ROW_NUMBER() OVER (order by ProdCode desc) as ROWNUM','A.ProdCode'],
                'table' => 'Tbl_OrderProduct as A',
                'where' =>[]
            ];
        }


        $addWhere = '';
       
        if($keyword = '') $addWhere = "ProdNameCal";
       
        if($addWhere != '')
        {
            if($ProfCIdx != '')
            {
                $addOption = [
                    $addWhere => ['=', $ProdCode, ''],
                ];
            }else
            {
                $addOption = [
                    $addWhere => [' like ', '%' . $keyword . '%', ''],
                ];
            }
            $this->dao->addWhereOption('where', $addOption, '');
        }
        
        if ($sDate1 != '')
        {
           $addOption = [
              'O.LecSDate' => ['>=', $sDate1 , 'and'],
              'O.LecEDate' => ['<=', $eDate1 , ''],
           ];
            
            $this->dao->addWhereOption('where', $addOption, '');
        }
        
        if ($sDate2 != '')
        {
           $addOption = [
              'O1.LecSDate' => ['>=', $sDate2 , 'and'],
              'O1.LecEDate' => ['<=', $eDate2 , ''],
           ];
            
            $this->dao->addWhereOption('where', $addOption, '');
        }
        
        if ($sMDate != '')
        {
           $addOption = [
              'M.CalMDate' => ['>=', $sMDate , 'and'],
              'M.CalMDate ' => ['<=', $eMDate , ''],
           ];
            
            $this->dao->addWhereOption('where', $addOption, '');
        }

        
        $subQuery = $this->dao->getQuery();
        return $subQuery;
    }
    */


    /*
    private function makeSubQuery2($option, $type)
    {
        $CalculateIdx = $option['CalculateIdx'];
        $pageing = $option['page'];
        $pageingsize = $option['pageingSize'];
        $keyword = $option['keyword'];
        $sDate = $option['sDate'];
        $eDate = $option['eDate'];
        
        if ($type=='count'){
        
            $this->dao->queryOption=[
                'col' => 'CalculateIdx',
                'table' => 'Tbl_CalculateAdd as M',
                'where' =>[]
            ];
        
        } else {
        
            $this->dao->queryOption=[
                'col' => ['ROW_NUMBER() OVER (order by CalculateIdx desc) as ROWNUM','CalculateIdx'],
                'table' => 'Tbl_CalculateAdd as M',
                'where' =>[]
            ];
        }


        $addWhere = '';
       
        if($keyword = '') $addWhere = "CalculateIdx";
       
        if($addWhere != '')
        {
            if($CalculateIdx != '')
            {
                $addOption = [
                    $addWhere => ['=', $CalculateIdx, ''],
                ];
            }else
            {
                $addOption = [
                    $addWhere => [' like ', '%' . $keyword . '%', ''],
                ];
            }
            $this->dao->addWhereOption('where', $addOption, '');
        }
        
        if ($sDate != '')
        {
           $addOption = [
              'CalMDate' => ['>=', $sDate , 'and'],
              'CalMDate' => ['<=', $eDate , ''],
           ];
            
            $this->dao->addWhereOption('where', $addOption, '');
        }
        
       
        $subQuery = $this->dao->getQuery();
        return $subQuery;
    }
    */


}