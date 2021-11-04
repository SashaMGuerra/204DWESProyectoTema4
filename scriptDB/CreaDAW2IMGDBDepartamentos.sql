/* Creación de la base de datos */
create database if not exists DAW204DBDepartamentos;

use DAW204DBDepartamentos;

/* Creación de las tablas */
create table if not exists Departamento(
    codDepartamento varchar(3) primary key,
    descDepartamento varchar(255) not null,
    fechaBaja date null,
    volumenNegocio float null
) engine=innodb;

/* Creación del usuario */
create user if not exists 'usuarioDAW204DBDepartamentos'@'%' identified by 'P@ssw0rd';
grant all on DAW204DBDepartamentos.* to 'usuarioDAW204DBDepartamentos'@'%';