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
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
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
         * Fecha de modificación: 10/11/2021
         * 
         * Mostrado del contenido de la tabla Departamento.
         */
        
        // Constantes para la conexión con la base de datos.
        require_once '../config/configDBPDO.php';
        
        try{
            // Establecimiento de la conexión.
            $oDB = new PDO(HOST, USER, PASSWORD);
            
            // Mostrado de las excepciones.
            $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            /* 
             * Consulta preparada de selección de todo el contenido de la tabla.
             * Cambiado del modo de fetch 
             */
            $sConsulta = 'SELECT * FROM Departamento';
            
            /*
             * Establecimiento del valor del tipo de cursor a CURSOR_SCROLL
             * para obtener un cursor desplazable.
             */
            $oResultadoConsulta = $oDB->prepare($sConsulta);
            
            /*
             * Ejecución de la consulta preparada.
             */
            $oResultadoConsulta->execute();

            // Mostrado del número de filas devueltas por el query.
            echo '<div>La tabla Departamentos tiene '.$oResultadoConsulta->rowCount().' registros.</div>';

            /*
             * Mostrado de la información devuelta por el query mediante fetch,
             * dándole como parámetro el estilo de fetch de objeto.
             */
            echo '<h2>Mediante fetch</h2>';
            $oDepartamento = $oResultadoConsulta->fetch(PDO::FETCH_OBJ);
            echo '<table>';
            columnsNameRow($oResultadoConsulta);
            while($oDepartamento){
                echo '<tr>';
                foreach ($oDepartamento as $valor) {
                    echo "<td>$valor</td>";
                }
                echo '</tr>';
                $oDepartamento = $oResultadoConsulta->fetch(pdo::FETCH_OBJ);
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
            $oDepartamento = $oResultadoConsulta->fetchObject();
            echo '<table>';
            columnsNameRow($oResultadoConsulta);
            while($oDepartamento){
                echo '<tr>';
                foreach ($oDepartamento as $valor) {
                    echo "<td>$valor</td>";
                }
                echo '</tr>';
                $oDepartamento = $oResultadoConsulta->fetchObject();
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
            $oDepartamento = $oResultadoConsulta->fetchAll(PDO::FETCH_OBJ);
            echo '<table>';
            columnsNameRow($oResultadoConsulta);
            foreach ($oDepartamento as $aFila) {
                echo '<tr>';
                foreach ($aFila as $valor) {
                    echo "<td>$valor</td>";
                }
                echo '</tr>';
                }
            echo '</table>';
        }
        
        /*
         * Captura de excepciones.
         */ 
        catch(PDOException $exception){
            /*
             * Mostrado del código de error y su mensaje.
             */
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
            echo '</ul>';
        }
        
        /*
         * Cierre de la conexión.
         */
        finally {
            unset($oDB);
        }
        
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
        </main>
        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
