<?php
// Include the PHPWord.php, all other classes were loaded by an autoloader
echo 'Entra';
require_once 'PHPWord.php';
 
$PHPWord = new PHPWord();
 
// New portrait section
$section = $PHPWord->createSection();
 
// Add text elements
$section->addText('Manizales');
$section->addTextBreak(2);
 
$section->addText('Boletin', array('name'=>'Verdana', 'color'=>'006699'));
$section->addTextBreak(2);
 
$PHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));
$section->addText('Volcán nevado del Ruiz', 'rStyle', 'pStyle');
$section->addText('Sismo Sentido.', null, 'pStyle');
 
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
$objWriter->save('Boletin.docx');
 
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=Boletin.docx");
header('Cache-Control: max-age=0');
readfile('Boletin.docx'); 
unlink('Boletin.docx');
?>
