<?php
// replace image variables (placeholders) from an existing DOCX. The placeholder has been added to the alt text content

require_once '../../../classes/CreateDocx.php';

$docx = new CreateDocxFromTemplate('../../files/placeholderImage_symbols.docx');
$docx->setTemplateSymbol('${', '}');

$image_1 = array(
	'height' => 3,
	'width' => 3,
	'target' => 'header',
);

$docx->replacePlaceholderImage('HEADERIMG','../../img/logo_header.jpg', $image_1);
$docx->replacePlaceholderImage('LOGO','../../img/imageP3.png');

$docx->createDocx('example_replacePlaceholderImage_4');