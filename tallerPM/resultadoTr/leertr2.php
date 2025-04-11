<?php
    $data_tr_re = [
                    '', 
                    'OTAM', 
                    'Humedad', 
                    'Temperatura', 
                    'Tipo', 
                    'Fecha', 
                    'Diametro', 
                    'Area', 
                    'Módulo, GPa',
                    'Carga de Fluencia, kg',
                    'Carga de UTS, kg',
                    'Tensión de Fluencia, MPa',
                    'Tensión de UTS, MPa',
                    'Alargamiento',
                    'Reducción de área',
                    'Gage Length Inicial, mm',
                    'Gage Length Final, mm',
                    'Diametro final, mm'
                ];
    $data_tr_pl = [
                    '', 
                    'OTAM', 
                    'Humedad', 
                    'Temperatura', 
                    'Tipo',     
                    'Fecha', 
                    'Espesor',
                    'Ancho',
                    'Area', 
                    'Módulo, GPa',
                    'Carga de Fluencia, kg',
                    'Carga de UTS, kg',
                    'Tensión de Fluencia, MPa',
                    'Tensión de UTS, MPa',
                    'Alargamiento',
                    'Gage Length Inicial, mm',
                    'Gage Length Final, mm'
                ];
    $fp = fopen("16784-01-T01/Resultados.htm", "r");
    $i = 0;
    $probeta = 'Re';
    while(!feof($fp)) {
        $linea = utf8_encode(fgets($fp));  
        //echo strip_tags($linea) . "<br />";
        $ln = trim(strip_tags($linea));
        if($ln != ''){
            if(substr_count($ln,'Tracción') > 0 ){
                if(substr_count($ln,'Plana') > 0 ){
                    $probeta = 'Pl';
                }
                $i++;
                echo $i.' = '.$ln.'<br><br>';
            }
            if($ln > 0){
                $i++;
                if($probeta == 'Re'){
                    echo $i.'.- <b>'.$data_tr_re[$i].'</b><br>'.$ln.'<br><br>';
                }else{
                    echo $i.'.- <b>'.$data_tr_pl[$i].'</b><br>'.$ln.'<br><br>';
                }
            }
        }
    }
   
    fclose($fp);


/*
    $texto = file_get_contents("Resultados.htm");
    echo $texto;


    $texto = file_get_contents("Resultados.htm");
    $texto = nl2br($texto);
    echo $texto;
*/

?>