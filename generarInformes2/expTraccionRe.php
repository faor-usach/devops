<?php
//****************************************************************************
//Tabla Tracción 
//****************************************************************************

$trProperties = array();
$trProperties[0] = array(	'minHeight' 	=> 500, 
							'tableHeader' 	=> false,
							'font' 			=> 'Arial',
							'fontSize' 		=> 9,
							'vAlign' 			=> 'both',
							//'border'		=> 'double',
						);
$trProperties[0] = array(	'minHeight' 	=> 100, 
							'width'			=> 50000, 
							'vAlign' 			=> 'center',
						);
						
$col_1_1 = array(	'rowspan' 			=> 4, 
					'value' 			=> 'ID ITEM',
					'bold'				=> true,
					'textProperties'	=> array('bold' => true, 'font' => 'Arial', 'fontSize' => 8),
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'height'			=> 5,
				);
$col_1_2 = array( 	'value' 			=> ' ', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_3 = array( 	'value' 			=> 'Carga de', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
				);
$col_1_4 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_5 = array( 	'value' 			=> 'Tensión de', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
				);
$col_1_6 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col_1_7 = array( 	'value' 			=> 'Alarg.', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
				);
$col_1_8 = array( 	'value' 			=> '', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
				
$col_3_2 = array( 	'value' 			=> 'Área', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
					'vAlign' 			=> 'center',
				);
$col_3_3 = array( 	'value' 			=> 'Fluencia', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_3_4 = array( 	'value' 			=> 'Carga', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_3_5 = array( 	'value' 			=> 'Fluencia', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_3_6 = array( 	'value' 			=> 'Tensión', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_3_7 = array( 	'value' 			=> 'Sobre 50', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_3_8 = array( 	'value' 			=> 'Red', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
					'vAlign' 			=> 'center',
				);

/* */
$col_5_2 = array( 	'value' 			=> 'Inicial', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
					'vAlign' 			=> 'center',
				);
$col_5_3 = array( 	'value' 			=> '0,2% Def.', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_5_4 = array( 	'value' 			=> 'Máxima', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_5_5 = array( 	'value' 			=> '0,2 Def.', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_5_6 = array( 	'value' 			=> 'Máxima', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_5_7 = array( 	'value' 			=> 'mm', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_5_8 = array( 	'value' 			=> 'de Área', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
					'vAlign' 			=> 'center',
				);

$col_6_2 = array( 	'value' 			=> 'mm2', 
					'backgroundColor' 	=> 'eeeeee',
					'cellMargin'		=> 100,
					'vAlign' 			=> 'center',
				);
$col_6_3 = array( 	'value' 			=> '(Kgf).', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_6_4 = array( 	'value' 			=> '(Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_6_5 = array( 	'value' 			=> '(MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_6_6 = array( 	'value' 			=> '(MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_6_7 = array( 	'value' 			=> '(%)', 
					'backgroundColor' 	=> 'eeeeee',
					'vAlign' 			=> 'center',
				);
$col_6_8 = array( 	'value' 			=> '(%)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRight'		=> 'double',
					'vAlign' 			=> 'center',
				);
				
				
//$bdReg=$link->query("SELECT * FROM regTraccion Where CodInforme = '".$CodInforme."' and idItem = '".$rowOtam['Otam']."'");
$bdReg=$link->query("SELECT * FROM regTraccion Where idItem = '".$rowOtam['Otam']."'");
if($rowReg=mysqli_fetch_array($bdReg)){
	$Espesor = $rowReg['Espesor'];

	if($Ref == 'CR'){
		$text = [];
		$text[] = array( 'text' => $rowOtam['Otam'], 'bold' => true, 'fontSize'		=> 8 ); 

		$col_2_1 = array(	'value' 			=> $text, // Dato
							'backgroundColor' 	=> 'ffffff',
							'bold'				=> true,
							'borderLeft'		=> 'double',
							'vAlign' 			=> 'center',
						);
						
		$col_2_2 = array( 	'value' 			=>  number_format(($rowReg['aIni']), 2, ',', '.'),
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
						);
		$col_2_3 = array( 	'value' 			=> $rowReg['cFlu'],
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['cMax']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
				
		$col_2_4 = array( 	'value' 			=> number_format(intval($rowReg['cMax']), 0, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['tFlu']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_5 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(($rowReg['tMax']), 3, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_6 = array( 	'value' 			=> $text,
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['aSob']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_7 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['rAre']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$col_2_8 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderRight'		=> 'double',
						);
	}else{
		$text = [];
		$text[] = array( 'text' => $rowOtam['Otam'], 'bold' => true, 'fontSize'		=> 8 ); 

		$col_2_1 = array(	'value' 			=> $text, // Dato
							'bold'				=> true,
							'backgroundColor' 	=> 'ffffff',
							'borderLeft'		=> 'double',
							'vAlign' 			=> 'center',
							'borderBottom'		=> 'double',
						);
		// $col_2_2 = array( 	'value' 			=>   number_format(($rowReg['aIni']), 2, ',', '.'),
		$col_2_2 = array( 	'value' 			=>   $rowReg['aIni'],
							'backgroundColor' 	=> 'ffffff',
							'cellMargin'		=> 100,
							'borderBottom'		=> 'double',
						);
		$col_2_3 = array( 	'value' 			=> $rowReg['cFlu'],
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$col_2_4 = array( 	'value' 			=> number_format(intval($rowReg['cMax']), 0, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['tFlu']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
				
		$col_2_5 = array( 	'value' 			=> number_format(intval($rowReg['tFlu']), 0, ',', '.'), 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		// $text[] = array( 'text' => number_format(($rowReg['tMax']), 3, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
		$text[] = array( 'text' => $rowReg['tMax'], 'bold' => true, 'fontSize'		=> 8 ); 
				
		$col_2_6 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['aSob']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
				
		$col_2_7 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderBottom'		=> 'double',
						);
		$text = [];
		$text[] = array( 'text' => number_format(intval($rowReg['rAre']), 0, ',', '.'), 'bold' => true, 'fontSize'		=> 8 ); 
				
		$col_2_8 = array( 	'value' 			=> $text, 
							'backgroundColor' 	=> 'ffffff',
							'borderRight'		=> 'double',
							'borderBottom'		=> 'double',
						);
	}
}


//set teh global table properties
//$options = array(	'columnWidths' 		=> array(1069,1062,1062,1062,1062,1062,1062,1062), 
$options = array(	'columnWidths' 		=> array(1300,1029,1029,1029,1029,1029,1029,1029), 
					//'borderWidth' 		=> 0,
					'border'			=> 'none',
					'tableAlign' 		=> 'center',
					'vAlign' 			=> 'both',
					//'float' 			=> array('align' 	=> 'center'	),
					//'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503.937007874),
					'tableWidth' 		=> array('type' 	=> 'dxa', 'value' => 8503),
					'textProperties' 	=> array('font' 	=> 'Arial', 'fontSize' => 8, 'textAlign' => 'center'),
				);
				
$values = array(	array($col_1_1, $col_1_2, $col_1_3, $col_1_4, $col_1_5, $col_1_6, $col_1_7, $col_1_8),
					array($col_3_2, $col_3_3, $col_3_4, $col_3_5, $col_3_6, $col_3_7, $col_3_8),
					array($col_5_2, $col_5_3, $col_5_4, $col_5_5, $col_5_6, $col_5_7, $col_5_8),
					array($col_6_2, $col_6_3, $col_6_4, $col_6_5, $col_6_6, $col_6_7, $col_6_8),
					array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8),
				);




$col1_1 = array(	'value' 			=> 'ID ITEM',
					'bold'				=> true,
					'borderLeft'		=> 'double',
					'borderTop'			=> 'double',
					'vAlign' 			=> 'center',
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'width'				=> 100,
				);
$text = [];
$text[] = array( 'text' => 'Área Inicial (mm', 'fontSize'		=> 8 ); 
$text[] = array( 'text' => '2', 'superscript' => true, 'fontSize'		=> 8 ); 
$text[] = array( 'text' => ')', 'fontSize'		=> 8 ); 
				
$col1_2 = array( 	'value' 			=> $text, 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_3 = array( 	'value' 			=> 'Carga de Fluencia 0,2% Def. (Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_4 = array( 	'value' 			=> 'Carga Máxima (Kgf)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_5 = array( 	'value' 			=> 'Tensión de Fluencia 0,2% Def. (MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_6 = array( 	'value' 			=> 'Tensión Máxima (MPa)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_7 = array( 	'value' 			=> 'Alarg. Sobre 50 mm (%)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderRightColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
				);
$col1_8 = array( 	'value' 			=> 'Red de Área (%)', 
					'backgroundColor' 	=> 'eeeeee',
					'borderLeftColor'	=> 'eeeeee',
					'borderTop'			=> 'double',
					'borderRight'		=> 'double',
				);
				
if($Ref == 'CR'){
	$text = [];
	$text[] = array( 'text' => 'Referencia', 'bold' => true, 'fontSize'		=> 8 ); 

	$col_R_1 = array(	'colspan' 			=> 4,
						'value' 			=> $text, // Dato
						'bold'				=> true,
						'backgroundColor' 	=> 'ffffff',
						'borderTop'			=> 'double',
						'borderLeft'		=> 'double',
						'borderBottom'		=> 'double',
						'cellMargin'		=> 100,
					);
	/*
	$col_R_2 = array( 	'value' 			=> '', 
						'cellMargin'		=> 100,
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_3 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_4 = array( 	'value' 			=> '', 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	*/
	$text = [];
	$text[] = array( 'text' => '0', 'bold' => true, 'fontSize'		=> 8 ); 

	$col_R_5 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_6 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_7 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderBottom'		=> 'double',
					);
	$col_R_8 = array( 	'value' 			=> $text, 
						'borderTop'			=> 'double',
						'borderRight'		=> 'double',
						'borderBottom'		=> 'double',
					);
}				
				
if($Ref == 'SR'){
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3, $col1_4, $col1_5, $col1_6, $col1_7, $col1_8),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8),
	);
}else{
	$valuesTr = array(	array($col1_1, $col1_2, $col1_3, $col1_4, $col1_5, $col1_6, $col1_7, $col1_8),
						array($col_2_1, $col_2_2, $col_2_3, $col_2_4, $col_2_5, $col_2_6, $col_2_7, $col_2_8),
						array($col_R_1, $col_R_5, $col_R_6, $col_R_7, $col_R_8),
	);
}				
$docx->addTable($valuesTr, $options, $trProperties);
//$docx->addTable($values, $options);
//$docx->addText($textSpace, $espacioOpcionTablas);

//****************************************************************************
//Tabla Tracción Redonda FIN TABLA
//****************************************************************************
?>