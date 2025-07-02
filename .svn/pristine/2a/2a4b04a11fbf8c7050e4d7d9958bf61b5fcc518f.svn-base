<?php

class CommModel
{
    private $dao;
    public function __construct() {
        $this->dao = new \system\dao\dao();
        $conn = $this->dao->open();
        $this->util = new \system\util\util();
    }
    public  function GetComCode()
    {
        $this->dao->queryOption = [
            'col' => 'ComCode, ComName, ComValue, ComGroup',
            'table' => 'Tbl_ComCode',
            'where' => [
                'isUse' => ['=','Y','and'],
                'IsStatus' => ['=', 'Y','']
            ]
        ];
        return $this->dao->ExecuteFill();
    }

}