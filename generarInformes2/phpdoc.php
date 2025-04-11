<?php
header('Content-Type: text/html; charset=utf-8');

require_once '../phpdocx/classes/CreateDocx.php';
include("../conexionli.php");

$docx = new CreateDocx();
 
$docx->setLanguage('es-ES');
$docx->modifyPageLayout('letter'); 

$itemList = array(
    'Line 1',
    'Line 2',
    'Line 3',
    'Line 4',
    'Line 5'
);
$docx->addList($itemList, 1);
$docx->createDocx('output');
?>
	