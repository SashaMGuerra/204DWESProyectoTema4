/* Creación de la base de datos */
CREATE DATABASE IF NOT EXISTS DAW204DBDepartamentos;

USE DAW204DBDepartamentos;

/* Creación de las tablas */
CREATE TABLE IF NOT EXISTS Departamento(
    codDepartamento VARCHAR(3) PRIMARY KEY,
    descDepartamento VARCHAR(255) NOT NULL,
    fechaBaja DATE NULL,
    volumenNegocio FLOAT NULL
) engine=innodb;

/* Creación del usuario */
CREATE USER IF NOT EXISTS 'usuarioDAW204DBDepartamentos'@'%' IDENTIFIED BY 'P@ssw0rd';
GRANT ALL ON DAW204DBDepartamentos.* TO 'usuarioDAW204DBDepartamentos'@'%';