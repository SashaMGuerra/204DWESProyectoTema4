<?php

/* 
 * @author Sasha
 * @version 1.0
 * 
 * Establecimiento y cierre de la conexión con MySQL.
 */

/*
 * Equipo, usuario, contraseña del usuario con que conectarse a la base de datos.
 */
$sHost = '192.168.1.30';
$sUser = 'admindb';
$sPasswd = 'P@ssw0rd';
$sDB = 'prueba';

// Apertura de una nueva conexión a la base de datos.
$oDB = new mysqli();
$oDB ->connect($sHost, $sUser, $sPasswd, $sDB);

// Control de los posibles errores de conexión.
$error = $oDB->connect_errno;

/* Información
print 'Get server info: '.$oDB->get_server_info();
print '<br>stat: '.$oDB->stat();
 * 
 */

/*
$sConsulta = $oDB->stmt_init();
$sConsulta->prepare('insert into tablaprueba values ("ccc", "Letra C", "9")');
$sConsulta->execute();
$sConsulta->close();
 * 
 */

$oResultado = $oDB->query('select * from tablaprueba');
$fetch = $oResultado->fetch_array();
echo '<pre>';
print_r($fetch);
echo '</pre>';

// Cerrado de la conexión.
$oDB->close();