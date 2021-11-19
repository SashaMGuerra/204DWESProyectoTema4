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
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <link href="../webroot/css/footerDown.css" rel="stylesheet" type="text/css"/>
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
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
            <h1>Contenido de la tabla Departamento</h1>
        </header>
        <main>
        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Mostrado del contenido de la tabla Departamento con MySQLi.
         */
        
        // Constantes para la conexión con la base de datos.
        include '../config/configDBMySQLi.php';


        // Establecimiento de la conexión.
        $oDB = new mysqli();
        $oDB->connect(HOST, USER, PASSWORD, DB);
        
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
        $sConsulta = 'SELECT * FROM Departamento';
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
        </main>
        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
