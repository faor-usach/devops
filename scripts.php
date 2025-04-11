<?php
$archivo = $_GET['archivo'];
convertir_tablas_a_minusculas($archivo);

function convertir_tablas_a_minusculas($archivo) {
    $archivo_salida = $archivo . '.php'; // Crear un nuevo archivo con los cambios
    $fp = fopen($archivo, 'r');
    $fp_nuevo = fopen($archivo_salida, 'w');

    if (!$fp || !$fp_nuevo) {
        die("Error al abrir los archivos.");
    }

    while (($linea = fgets($fp)) !== false) {
        // Buscar consultas SELECT * FROM
        if (strpos($linea, 'SELECT * FROM') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[3], strtolower($fc[3]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'Select * From') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[3], strtolower($fc[3]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'select * from') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[3], strtolower($fc[3]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'insert into') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'INSERT INTO') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'Insert Into') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'Update') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[1], strtolower($fc[1]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'UPDATE') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[1], strtolower($fc[1]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'Delete From') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'Delete from') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'DELETE FROM') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        if (strpos($linea, 'delete from') !== false) {
            $fc=explode(' ', $linea);
            $bodytag = str_replace($fc[2], strtolower($fc[2]), $linea);
            echo 'origen '.$linea.'<br>';
            echo 'cambio '.$bodytag.'<br>';
            $linea = $bodytag;
        }
        fwrite($fp_nuevo, $linea);
    }
    fclose($fp);
    fclose($fp_nuevo);

    echo "Se ha creado un nuevo archivo: $archivo_salida con las tablas en minúsculas.";

}
function codigo() {
    $fp = fopen($archivo, 'r');
    $fp_nuevo = fopen($archivo_salida, 'w');

    if (!$fp || !$fp_nuevo) {
        die("Error al abrir los archivos.");
    }

    while (($linea = fgets($fp)) !== false) {
        // Buscar consultas SELECT * FROM
        if (preg_match('/^SELECT\s*\*\s+FROM\s+(\w+)/i', $linea, $coincidencias)) {
            echo $linea.'<br>';
            $tabla_original = $coincidencias[1];
            $tabla_minuscula = strtolower($tabla_original);
            $linea = preg_replace('/(\w+)/i', $tabla_minuscula, $linea);
            echo $linea.'<br>';

        }

        fwrite($fp_nuevo, $linea);
    }

    fclose($fp);
    fclose($fp_nuevo);

    echo "Se ha creado un nuevo archivo: $archivo_salida con las tablas en minúsculas.";
}