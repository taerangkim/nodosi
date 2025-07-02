<?php

spl_autoload_register(function ($class){
    if ($class == "BladeOne")
    {
        require_once($_SERVER['DOCUMENT_ROOT']. '/lib/BladeOne.php');
    }else if ($class == "phpoffice\phpspreadsheet\src\PhpSpreadsheet\Helper\Sample")
    {
      $class = str_replace('\\', '/', $class);
        require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/'.$class.'.php');
    }else if ($class == "PhpOffice\phpspreadsheet\src\PhpSpreadsheet\IOFactory")
    {
      $class = str_replace('\\', '/', $class);
        require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/'.$class.'.php');
    }else if ($class == "PhpOffice\phpspreadsheet\src\PhpSpreadsheet\Spreadsheet")
    {
      $class = str_replace('\\', '/', $class);
        require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/'.$class.'.php');
    }else if($class == 'Mpdf\mPDF')
    {
        echo 'aaa';
        $class = str_replace('\\', '/', $class);
        require_once($_SERVER['DOCUMENT_ROOT']. '/vendor/'.$class.'.php');
    }else
    {
        $class = str_replace('\\', '/', $class);
        require_once __DIR__ . '/../'.$class.'.php';
    }

});
?>

