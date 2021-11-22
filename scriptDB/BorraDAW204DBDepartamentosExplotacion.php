<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 22/11/2021
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>IMG - Tema 4 - Eliminación DB</title>
    </head>
    <body>
        <h1>Script de eliminación de tablas</h1>
        <?php
        /**
         * Configuración base de datos de 1&1 (explotación)
         */
        require_once '../config/configDBPDO.php'; // Fichero de configuración de la base de datos.

        /**
         * Configuración base de datos de 1&1 (explotación)
         */

        $sInstrucciones = <<<QUERY
            /* Eliminación de la base de datos
            DROP DATABASE dbs4868794;

            Eliminación del usuario 
            DROP USER 'dbu2267525'@'%'; */

            USE dbs4868794;
            DROP TABLE IF EXISTS Departamento;
        QUERY;

        try {
            // Conexión con la base de datos.
            $oDB = new PDO(HOST, USER, PASSWORD);

            // Mostrado de las excepciones.
            $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            
            // Ejecución de la inserción del contenido de las tablas.
            $oDB->exec($sInstrucciones);

            echo '<div>Query realizado.</div>';

        } catch (PDOException $exception) {
            // Mostrado del código de error y su mensaje.
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>' . $exception->getCode() . ' : ' . $exception->getMessage() . '</li>';
            echo '</ul>';
        } finally {
            unset($oDB);
        }

        ?>
    </body>
</html>
