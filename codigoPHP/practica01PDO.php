<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 04/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-1 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <style>
            table{
                border: 1px solid gainsboro;
            }
            tr:nth-child(even){
                background-color: gainsboro;
            }
        </style>
    </head>
    <body>
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
            <h1>Atributos de la conexión a la base de datos</h1>
        </header>
        <main>
        <?php
        /**
         * @author Isabel Martínez Guerra
         * Fecha de modificación: 10/11/2021
         * 
         * Conexión a la base de datos con PDO.
         */
        
        // Constantes para la conexión con la base de datos.
        require_once '../config/configDBPDO.php';
        
        echo '<h2>Conexión correcta</h2>';
        
        try{
            /*
             * Array de atributos de la conexión.
             * Se han comentado los atributos no soportados por el driver.
             */
            $aAtributos = array(
                "AUTOCOMMIT", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS", "DRIVER_NAME", "ERRMODE", 
                "ORACLE_NULLS", "PERSISTENT"/*, "PREFETCH" */, "SERVER_INFO", "SERVER_VERSION",
                /*"TIMEOUT"*/
            );

            // Establecimiento de la conexión.
            $oPDO = new PDO(HOST, USER, PASSWORD);
            $oPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recorrido y mostrado de los atributos de la conexión.
            echo '<table>';
            foreach ($aAtributos as $atributo) {
                echo "<tr><td>PDO::ATTR_$atributo: </td>";
                echo '<td>' . $oPDO->getAttribute(constant("PDO::ATTR_$atributo")) . "</td></tr>";
            }
            echo '</table>';  

            
        }catch(PDOException $exception){
            /*
             * Mostrado del código de error y su mensaje.
             */
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
            echo '</ul>';
        }
        finally{
            unset($oPDO);
        }
        
        echo '<h2>Conexión incorrecta</h2>';
        
        try{
            /*
             * Array de atributos de la conexión.
             */
            $aAtributos = array(
                "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
                "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION",
                "TIMEOUT"
            );

            // Establecimiento de la conexión.
            $oPDO = new PDO(HOST, USER, 'abcd');
            $oPDO->setAttribute(PDO_ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Recorrido y mostrado de los atributos de la conexión.
            echo '<table>';
            foreach ($aAtributos as $atributo) {
                echo "<tr><td>PDO::ATTR_$atributo: </td>";
                echo '<td>' . $oPDO->getAttribute(constant("PDO::ATTR_$atributo")) . "</td></tr>";
            }
            echo '</table>';  

            
        }catch(PDOException $exception){
            /*
             * Mostrado del código de error y su mensaje.
             */
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
            echo '</ul>';
        }
        finally{
            unset($oPDO);
        }
        ?>
        </main>
        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
