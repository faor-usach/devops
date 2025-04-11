<?php
	include("../conexionli.php");
    $carpetaRespaldo = "json";

    $link=Conectarse();
    $tables = array();
    $result = $link->query('SHOW TABLES');
    while($row = mysqli_fetch_row($result)) 
    {
        $tables[] = $row[0];
    }



    foreach($tables as $table){
        $return = '';
        $result = $link->query('SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $row2 = mysqli_fetch_row($link->query('SHOW CREATE TABLE '.$table));
        $return = 'DELETE FROM '.$table.' WHERE 1';
        $return.= ";Fin\n";
        for ($i = 0; $i < $num_fields; $i++){
            while($row = mysqli_fetch_row($result)){
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++){
                    $row[$j] = ($row[$j]);
                    $Obs = str_replace("'","Â´",$row[$j]);
                    $row[$j] = $Obs;
                    if (isset($row[$j])) { $return.= "'".$row[$j]."'" ; } else { $return.= "''"; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                $return.= ");Fin\n";
            }
        }
        $ficheroRespaldo = $carpetaRespaldo.'/'.$table.'.sql';
        $archivoBackup	= $ficheroRespaldo;
        $handle = fopen($ficheroRespaldo,'w+');
        fwrite($handle,$return);
        fclose($handle);
    }

    $link->close();

?>