<?php
    $fp = fopen("Resultados.htm", "r");
    $i = 0;
    while(!feof($fp)) {
        $linea = utf8_encode(fgets($fp));  
        //echo strip_tags($linea) . "<br />";
        $ln = trim(strip_tags($linea));
        if($ln != ''){
            //if($ln == 'OTAM Nº:'){
            if($ln > 0){
                $i++;
                echo $i.' = '.$ln.'<br>';
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