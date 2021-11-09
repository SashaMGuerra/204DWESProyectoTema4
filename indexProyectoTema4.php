<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 02/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - Tema 4</title>
        <link href="webroot/css/common.css" rel="stylesheet" type="text/css"/>
        <link href="webroot/css/indexProyectoTema4.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Proyecto Tema 4</h2>
            <a href="config/configDBPDO.php">Fichero de configuración</a>
        </header>
        <main>
            <table>
                <caption>Prácticas</caption>
                <tr>
                    <th>Enunciados</th>
                    <th colspan="2">PDO</th>
                    <th colspan="2">MySQLi</th>
                </tr>
                <tr>
                    <td>1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</td>
                    <td><a href="codigoPHP/practica01PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo01PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a href="codigoPHP/practica01MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo01MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td>2. Mostrar el contenido de la tabla Departamento y el número de registros.</td>
                    <td><a href="codigoPHP/practica02PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo02PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a href="codigoPHP/practica02MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo02MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td>3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</td>
                    <td><a href="codigoPHP/practica03PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo03PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</td>
                    <td><a href="codigoPHP/practica04PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo04PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5. Página web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</td>
                    <td><a href="codigoPHP/practica05PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo05PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6. Página web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada.</td>
                    <td><a href="codigoPHP/practica06PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a href="mostrarcodigo/mostrarCodigo06PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </main>
        <footer>
            <div>Modificado el 08/1/2021 - Mª Isabel Martínez Guerra</div>
            <div><a href="https://github.com/SashaMGuerra/proyectoTema4"><img id="github" src="webroot/media/img/github_logo_white.png" alt="github logo"/></a></div>
        </footer>
    </body>
</html>
