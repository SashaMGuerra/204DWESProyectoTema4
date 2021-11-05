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
            tr:nth-child(odd){
                background-color: gainsboro;
            }
        </style>
    </head>
    <body>
        <h1>Conexión mediante MySQLi.</h1>

        <?php
        /**
         * @author Isabel Martínez Guerra
         * 
         * Conexión a la base de datos con MySQLi.
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
        else{
            echo "<div>Conexión sin errores.</div>";
        }
        
        /*
         * Mostrado del estadod e la conexión.
         */
        echo '<h2>Estado de la conexión.</h2><table>';
        foreach ($oDB->get_connection_stats() as $sStat => $value) {
            echo "<tr><td>$sStat</td>";
            echo "<td>$value</td></tr>";
        }
        echo '</table>';
        
        
        // Cierre de la conexión.
        $oDB->close();
        
        
        ?>
    </body>
</html>
