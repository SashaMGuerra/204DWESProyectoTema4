<?php

/**
 * Configuración base de datos de 1&1 (explotación)
 */
require_once '../config/configDBPDO.php'; // Fichero de configuración de la base de datos.

/**
 * Creación de las tablas.
 */
$sInstrucciones = <<<QUERY
    /* Uso de la base de datos */
    USE dbs4868794;

    /* Creación de las tablas */
    CREATE TABLE IF NOT EXISTS Departamento(
        codDepartamento VARCHAR(3) PRIMARY KEY,
        descDepartamento VARCHAR(255) NOT NULL,
        fechaBaja DATE NULL,
        volumenNegocio FLOAT NULL
    ) engine=innodb;
QUERY;

try {
    // Conexión con la base de datos.
    $oDB = new PDO(HOST, USER, PASSWORD);

    // Mostrado de las excepciones.
    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejecución de la creación de las tablas.
    $oDB->exec($sInstrucciones);
    
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





