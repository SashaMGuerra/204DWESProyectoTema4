<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 04/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-2 PDO</title>
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
        <h1>Contenido de la tabla Departamento</h1>
        
        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Mostrado del contenido de la tabla Departamento.
         */
        
        // Constantes para la conexión con la base de datos.
        define('CONEXION', 'mysql:host=192.168.3.104;dbname=DAW204DBDepartamentos');
        define('USUARIO', 'usuarioDAW204DBDepartamentos');
        define('PASSWD', 'P@ssw0rd');
        
        // Establecimiento de la conexión.
        $oDB = new PDO(CONEXION, USUARIO, PASSWD);

        /* 
         * Query de selección de todo el contenido de la tabla.
         * 
         * Devuelve un PDOStatement
         */
        $sConsulta = 'select * from Departamento';
        $oResultadoConsulta = $oDB->query($sConsulta);

        // Mostrado del número de filas devueltas por el query.
        echo '<div>La tabla Departamentos tiene '.$oResultadoConsulta->rowCount().' registros.</div>';

        
        /*
         * Mostrado de la información devuelta por el query mediante fetch,
         * dándole como parámetro el estilo de fetch de objeto.
         */
        echo '<h2>Mediante fetch</h2>';
        $aQuery = $oResultadoConsulta->fetch(PDO::FETCH_OBJ);
        echo '<table>';
        columnsNameRow($oResultadoConsulta);
        while($aQuery){
            echo '<tr>';
            foreach ($aQuery as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>';
            $aQuery = $oResultadoConsulta->fetch(pdo::FETCH_OBJ);
        }
        echo '</table>';
        
        /*
         * Reselección de la información para repetir el mostrado de información.
         */
        $oResultadoConsulta = $oDB->query($sConsulta);
        
        
        /*
         * Mostrado de la información devuelta por el query mediante fetchObject
         */
        echo '<h2>Mediante fetchObject</h2>';
        $aQuery = $oResultadoConsulta->fetchObject();
        echo '<table>';
        columnsNameRow($oResultadoConsulta);
        while($aQuery){
            echo '<tr>';
            foreach ($aQuery as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>';
            $aQuery = $oResultadoConsulta->fetchObject();
        }
        echo '</table>';
        
        /*
         * Reselección de la información para repetir el mostrado de información.
         */
        $oResultadoConsulta = $oDB->query($sConsulta);
        
        /*
         * Mostrado de la información devuelta por el query mediante fetchAll,
         * dándole como parámetro el estilo de fetch de objeto.
         */
        echo '<h2>Mediante fetchAll</h2>';
        $aQuery = $oResultadoConsulta->fetchAll(PDO::FETCH_OBJ);
        echo '<table>';
        columnsNameRow($oResultadoConsulta);
        foreach ($aQuery as $aFila) {
            echo '<tr>';
            foreach ($aFila as $valor) {
                echo "<td>$valor</td>";
            }
            echo '</tr>';
            
        }
        
        // Cierre de la conexión.
        unset($oDB);
        
        /**
         * Extrae de una consulta el número de columnas tomadas, y crea una línea
         * de una tabla con una celda para el nombre de cada una.
         * 
         * @param PDOStatement $oResultadoConsulta Sentencia preparada de la
         * que extraer los nombres de las columnas.
         */
        function columnsNameRow($oResultadoConsulta){
            $iNumColumnas = $oResultadoConsulta->columnCount();
            echo '<tr>';
            for($iColumna = 0; $iColumna<$iNumColumnas ;$iColumna++){
                echo "<th>".$oResultadoConsulta->getColumnMeta($iColumna)['name']."</th>";
            }
            echo '</tr>';
        }
        
        ?>
    </body>
</html>
