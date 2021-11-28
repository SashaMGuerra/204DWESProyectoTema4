<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 22/11/2021
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>IMG - Tema 4 - Carga inicial DB</title>
    </head>
    <body>
        <h1>Script de carga inicial de tablas</h1>
        <?php
        /**
         * @author Isabel Martínez Guerra
         * @since 22/11/2021
         * 
         * Fichero de inserción en las tablas del Tema 4.
         */
        
        require_once '../config/configDBPDO.php'; // Fichero de configuración de la base de datos.

        $sInstrucciones = <<<QUERY
            /* Inserción en tablas */
            USE dbs4868794;

            INSERT INTO Departamento VALUES
            ('VEN', 'Ventas', null, 250.51),
            ('COM', 'Compras', null, 200.30),
            ('MAR', 'Marketing', null, 330.33)
        QUERY;

        try {
            // Conexión con la base de datos.
            $oDB = new PDO(HOST, USER, PASSWORD);

            // Mostrado de las excepciones.
            $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Ejecución de la inserción del contenido de las tablas.
            $oDB->exec($sInstrucciones);

            echo '<div>Carga inicial de la tabla realizada con éxito.</div>';
        } catch (PDOException $exception) {
            /*
             * Mostrado del código de error y su mensaje.
             */
            echo '<div>Se han encontrado errores:</div><ul>';
            echo '<li>' . $exception->getCode() . ' : ' . $exception->getMessage() . '</li>';
            echo '</ul>';
        } finally {
            unset($oDB);
        }
        ?>
    </body>
</html>