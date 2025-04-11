<?php
	include("../conexionli.php");

    $outp = "";
    $link=Conectarse();
    
    $tables = array();
    $result = $link->query('SHOW TABLES');
    while($row = mysqli_fetch_row($result)) 
    {
        $tables[] = $row[0]; 
    }
    foreach($tables as $table){
        //echo $table.'<br>';
        $rs = $link->query('SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($rs);
        $info_campo = mysqli_fetch_fields($rs);
        echo '<h1>Tabla: '.$table.'</h1><br><br>';

        $SQL = "SELECT * FROM $table";
        $bd=$link->query($SQL);
        while($rs = mysqli_fetch_array($bd)){
            foreach ($info_campo as $valor) {
                echo $valor->name .' = '. $rs[$valor->name].'<br>';
            }
        }    
/*
        foreach ($info_campo as $valor) {
            echo $valor->name.'<br>';
        }
        echo '<br><br>';
*/        
        //echo 'Tabla '.$table.' Campos '.$num_fields.'<br>';
    }
    $link->close();

    $SQL = "SELECT * FROM clientes Order By Cliente Asc";
    $bd=$link->query($SQL);
    while($rs = mysqli_fetch_array($bd)){ 
        //echo $rs[1].'<br>';
        if ($outp != "") {$outp .= ",";}
        $outp.= '{"RutCli":"'.				    $rs["RutCli"].					    '",';
        $outp.= '"Cliente":"'.				    trim($rs["Cliente"]). 				    '",';
        $outp.= '"Giro":"'.				        trim($rs["Giro"]). 				        '",';
        $outp.= '"HES":"'.				        $rs["HES"]. 				        '",';
        $outp.= '"Direccion":"'.				trim($rs["Direccion"]). 				    '",';
        $outp.= '"Clasificacion":"'. 		    $rs["Clasificacion"]. 				'"}';
    }
    $outp ='{"records":['.$outp.']}';
    $link->close();

    $json_string = $outp;
    $file = 'json/clientes.json';
    file_put_contents($file, $json_string);


    $data = file_get_contents("json/clientes.json");
    $products = json_decode($data, true);

    //$RutCli     = $products['RutCli'];
    //$Cliente    = $products['Cliente'];

    echo ($data);
/*
    foreach ($products as $cliente) {
        echo '<pre>';
        print_r($cliente);
        echo '</pre>';
        //echo $cliente[$i]['RutCli'].'<br>';
    }
*/ 
?>