<?php
$from = 'Y:\\Documentos\MT\17655-01-T01';
$to = '17655-01-T01';

//Abro el directorio que voy a leer
$dir = opendir($from);

//Recorro el directorio para leer los archivos que tiene
while(($file = readdir($dir)) !== false){
    //Leo todos los archivos excepto . y ..
    if(strpos($file, '.') !== 0){
        //Copio el archivo manteniendo el mismo nombre en la nueva carpeta
        copy($from.'/'.$file, $to.'/'.$file);
    }
}
?>