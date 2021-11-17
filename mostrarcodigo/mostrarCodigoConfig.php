<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 15/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - Mostrar Ficheros de configuración</title>
        <style>
            h2{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php
        /*
         * @author Isabel Martínez Guerra
         * Fecha de creación: 15/11/2021
         * Fecha última modificación: 15/11/2021
         * 
         * Mostrado de los ficheros de configuración de la base de datos.
         */
        
        echo '<h1>Ficheros de configuración de la base de datos.</h1>';
        echo '<h2>PDO</h2>';
        highlight_file('../config/configDBPDO.php');
        
        echo '<h2>MySQLi</h2>';
        highlight_file('../config/configDBMySQLi.php');
        
        ?>
    </body>
</html>
