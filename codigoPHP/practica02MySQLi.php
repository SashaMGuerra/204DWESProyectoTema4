<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 04/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-2 MySQLi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            table{
                table-layout: fixed;
                width: 100%;
                max-width: 1000px;
            }
            td, th{
                border: 1px solid gainsboro;
            }
        </style>
    </head>
    <body>
        <h1>Atributos de la conexión a la base de datos</h1>

        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Mostrado del contenido de la tabla Departamento con MySQLi.
         */
        
        // Constantes para la conexión con la base de datos.
        define('CONEXION', '192.168.3.104');
        define('USUARIO', 'usuarioDAW204DBDepartamentos');
        define('PASSWD', 'P@ssw0rd');
        define('DATABASE', 'DAW204DBDepartamentos');


        // Establecimiento de la conexión.
        $oDB = new mysqli();
        $oDB->connect(CONEXION, USUARIO, PASSWD, DATABASE);
        
        /*
         * Mostrado del código de error de la conexión. Si no hay ninguno (está
         * en código 0), muestra que la conexión se ha realizado correctamente.
         */
        $iError = $oDB->connect_errno;
        if($iError!=0){
            echo "<div>Código de error de la última llamada: $iError</div>";
        }
        
        
        /*
         * Query de selección de todo el contenido de la tabla.
         * 
         * Devuelve un mysqli_result
         */
        $sConsulta = 'select * from Departamento';
        $oResultadoConsulta = $oDB->query($sConsulta);
        
        /*
         * Mostrado del número de filas devueltas por el query.
         */
        echo '<div>La tabla Departamentos tiene '.$oResultadoConsulta->num_rows.' registros.</div>';

        /*
         * Mostrado de la información devuelta por el query mediante fetch_all.
         */
        echo '<h2>Mediante fetch_all</h2>';
        $aQuery = $oResultadoConsulta->fetch_all();
        echo '<table>';
        foreach ($aQuery as $aFila) {
            echo '<tr>';
            foreach ($aFila as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>'; 
        }
        echo '</table>';
        
        /*
         * Reselección de la información para repetir el mostrado de información.
         */
        $oResultadoConsulta = $oDB->query($sConsulta);
        
        /*
         * Mostrado de la información devuelta por el query mediante fetch_row.
         */
        echo '<h2>Mediante fetch_row</h2>';
        
        $aQuery = $oResultadoConsulta->fetch_row();
        echo '<table>';
        while($aQuery){
            echo '<tr>';
            foreach ($aQuery as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>';
            $aQuery = $oResultadoConsulta->fetch_row();
        }
        echo '</table>';
        
        /*
         * Reselección de la información para repetir el mostrado de información.
         */
        $oResultadoConsulta = $oDB->query($sConsulta);
        
        // Cierre de la conexión.
        $oDB->close();
        
        
        ?>
    </body>
</html>
