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
        </style>
    </head>
    <body>
        <h1>Atributos de la conexión a la base de datos</h1>
        
        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Conexión a la base de datos con MySQLi.
         */
        
        // Constantes para la conexión con la base de datos.
        define('CONEXION', 'mysql:host=192.168.3.104;dbname=DAW204DBDepartamentos');
        define('USUARIO', 'usuarioDAW204DBDepartamentos');
        define('PASSWD', 'P@ssw0rd');
        define('DATABASE', 'DAW204DBDepartamentos');
        
        // Establecimiento de la conexión.
        $oDB = new mysqli();
        $oDB->connect(CONEXION, USUARIO, PASSWD, DATABASE);
        
        $oError = $oDB->connect_errno;
        
        var_dump($oDB);
        var_dump($oError);
        
                
        // Array de atributos de la conexión.

        // Recorrido y mostrado de los atributos de la conexión.

        // Cierre de la conexión.
        ?>
    </body>
</html>
