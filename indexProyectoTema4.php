<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 02/11/2021
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>IMG - Tema 4</title>
        <link href="webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <link href="webroot/css/indexProyectoTema4.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <a target="_blank" class="volver" href="../proyectoDWES/indexProyectoDWES.php">Volver</a>
            <h1>Desarrollo Web en Entorno Servidor</h1>
            <h2>Proyecto Tema 4</h2>
        </header>
        <main>
            <div class="db">
                <h3>Scripts de la base de datos</h3>
                <!-- Explotación 
                <ul>
                    <li><a target="_blank" href="scriptDB/CreaDAW2IMGDBDepartamentosExplotacion.php">Creación</a></li>
                    <li><a target="_blank" href="scriptDB/CargaInicialDAW204DBDepartamentosExplotacion.php">Carga inicial</a></li>
                    <li><a target="_blank" href="scriptDB/BorraDAW204DBDepartamentosExplotacion.php">Eliminación</a></li>
                </ul>
                -->
                <!-- Desarrollo -->
                <a target="_blank" href="mostrarcodigo/mostrarCodigoConfig.php">Ficheros de configuración</a>
            </div>
            <table>
                <tr>
                    <th>Prácticas</th>
                    <th colspan="2">PDO</th>
                    <th colspan="2">MySQLi</th>
                </tr>
                <tr>
                    <td class="enunciado">1. Conexión a la base de datos con la cuenta usuario y tratamiento de errores.</td>
                    <td><a target="_blank" href="codigoPHP/practica01PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo01PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica01MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo01MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">2. Mostrar el contenido de la tabla Departamento y el número de registros.</td>
                    <td><a target="_blank" href="codigoPHP/practica02PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo02PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica02MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo02MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">3. Formulario para añadir un departamento a la tabla Departamento con validación de entrada y control de errores.</td>
                    <td><a target="_blank" href="codigoPHP/practica03PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo03PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica03MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo03MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">4. Formulario de búsqueda de departamentos por descripción (por una parte del campo DescDepartamento, si el usuario no pone nada deben aparecer todos los departamentos).</td>
                    <td><a target="_blank" href="codigoPHP/practica04PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo04PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica04MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo04MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">5. Página web que añade tres registros a nuestra tabla Departamento utilizando tres instrucciones insert y una transacción, de tal forma que se añadan los tres registros o no se añada ninguno.</td>
                    <td><a target="_blank" href="codigoPHP/practica05PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo05PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica05MySQLi.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo05MySQLi.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">6. Página web que cargue registros en la tabla Departamento desde un array departamentosnuevos utilizando una consulta preparada.</td>
                    <td><a target="_blank" href="codigoPHP/practica06PDO.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo06PDO.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th></th>
                    <th colspan="2">XML</th>
                    <th colspan="2">JSON</th>
                </tr>
                <tr>
                    <td class="enunciado" rowspan="4">7. Página web que toma datos (código y descripción) de un fichero xml y los añade a la tabla Departamento de la base de datos (IMPORTAR).</td>
                    <td class="tipo" colspan="4">A tmp</td>
                </tr>
                <tr>
                    <td><a target="_blank" href="codigoPHP/practica07PDOXML.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo07PDOXML.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica07PDOJSON.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo07PDOJSON.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="tipo" colspan="4">Subida de archivo</td>
                </tr>
                <tr>
                    <td><a target="_blank" href="codigoPHP/practica07PDOXMLImport.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo07PDOXMLImport.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica07PDOJSONImport.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo07PDOJSONImport.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">8. Página web que toma datos (código y descripción) de la tabla Departamento y guarda en un fichero departamento.xml (COPIA DE SEGURIDAD/EXPORTAR).</td>
                    <td><a target="_blank" href="codigoPHP/practica08PDOXML.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo08PDOXML.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                    <td><a target="_blank" href="codigoPHP/practica08PDOJSON.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                    <td><a target="_blank" href="mostrarcodigo/mostrarCodigo08PDOJSON.php"><img src="webroot/media/img/doc_icon.png" alt=""/></a></td>
                </tr>
                <tr>
                    <td class="enunciado">9. MtoDepartamentos.</td>
                    <td colspan="4"><a target="_blank" href="../204DWESMtoDepartamentosTema4/index.php"><img src="webroot/media/img/execute-icon.jpg" alt=""/></a></td>
                </tr>
            </table>
        </main>
        
        <?php include_once './codigoPHP/elementoFooter.php'; // Footer ?>
    </body>
</html>
