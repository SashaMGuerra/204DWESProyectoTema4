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
        <h1>Atributos de la conexión a la base de datos</h1>

        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Conexión a la base de datos con PDO.
         */
        
        // Constantes para la conexión con la base de datos.
        define('CONEXION', 'mysql:host=192.168.3.104;dbname=DAW204DBDepartamentos');
        define('USUARIO', 'usuarioDAW204DBDepartamentos');
        define('PASSWD', 'P@ssw0rd');
        
        // Establecimiento de la conexión.
        $oPDO = new PDO(CONEXION, USUARIO, PASSWD);

        // Array de atributos de la conexión.
        $aAtributos = array(
            "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
            "ORACLE_NULLS", "PERSISTENT", "PREFETCH", "SERVER_INFO", "SERVER_VERSION",
            "TIMEOUT"
        );

        // Recorrido y mostrado de los atributos de la conexión.
        echo '<table>';
        foreach ($aAtributos as $atributo) {
            echo "<tr><td>PDO::ATTR_$atributo: </td>";
            echo '<td>' . $oPDO->getAttribute(constant("PDO::ATTR_$atributo")) . "</td></tr>";
        }
        echo '</table>';

        // Cierre de la conexión.
        unset($oPDO);
        ?>
    </body>
</html>
