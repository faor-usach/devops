<?php
//$data = file_get_contents("http://servidordata/erperp/respaldos/json/clientes.json");
$data = file_get_contents('http://servidordata/erperp/respaldos/json/clientes.json');
$obj = json_decode($data, true);
//$RutCli = $obj->{'RutCli'};
//var_dump($obj);
//$RutCli = $obj->{'RutCli'};
//echo $obj->{'RutCli'};;
/*
$json = '{"foo-bar": "12345"}';

$obj = json_decode($json);
print $obj->{'foo-bar'}; // 12345
*/
 
foreach ($obj as $objeto) {
    //print_r($objeto);
    echo $objeto['RutCli'].' - '.$objeto['Cliente'];
    echo '<br>';
}

?>