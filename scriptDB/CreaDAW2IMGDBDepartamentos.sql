/* Creación de la base de datos */
CREATE DATABASE IF NOT EXISTS DB204DWESProyectoTema4;

USE DB204DWESProyectoTema4;

/* Creación de las tablas */
CREATE TABLE IF NOT EXISTS Departamento(
    codDepartamento VARCHAR(3) PRIMARY KEY,
    descDepartamento VARCHAR(255) NOT NULL,
    fechaBaja DATE NULL,
    volumenNegocio FLOAT NULL
) engine=innodb;

/* Creación del usuario */
CREATE USER IF NOT EXISTS 'User204DWESProyectoTema4'@'%' IDENTIFIED BY 'P@ssw0rd';
GRANT ALL ON DB204DWESProyectoTema4.* TO 'User204DWESProyectoTema4'@'%';