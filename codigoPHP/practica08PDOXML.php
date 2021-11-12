<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 08/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-8 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            a{
                text-decoration: none;
                color: black;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Copia de seguridad / Exportación de la tabla Departamento</h1>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 10/10/2021
             * Fecha de última modificación: 12/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Toma datos de la tabla Departamento en el directorio tmp y los
             * guarda en tablaDepartamento.xml (copia de seguridad/exportar).
             * 
             * Este documento, previamente guardado, puede ser descargado a local.
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

            $sSentencia = 'SELECT * FROM Departamento';
            
            /**
             * Recogida de los datos de la tabla Departamento.
             */
            try {
                
                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta preparada.
                $oConsulta = $oDB->prepare($sSentencia);
                
                // Ejecución del select.
                $oConsulta->execute();
                
                /*
                 * Creación del XML que formatee la salida con indentación y espacios.
                 */
                $oDoc = new DOMDocument();
                $oDoc -> formatOutput = true;
                
                $oElemDepartamentos = $oDoc->createElement("departamentos");
                $nodoDepartamentos = $oDoc->appendChild($oElemDepartamentos);
                
                /*
                 * Recogida de información y escritura del archivo.
                 */
                $oDepartamento = $oConsulta->fetchObject();
                
                while($oDepartamento){
                    // Creación del elemento departamento.
                    $oElemDepartamento = $oDoc->createElement("departamento");
                    $nodoDepartamentos->appendChild($oElemDepartamento);
                    
                    // Creación y añadido de la información sobre el departamento.
                    $oElemCodigo = $oDoc->createElement('codDepartamento', $oDepartamento->codDepartamento);
                    $oElemDepartamento->appendChild($oElemCodigo);
                    
                    $oElemCodigo = $oDoc->createElement('descDepartamento', $oDepartamento->descDepartamento);
                    $oElemDepartamento->appendChild($oElemCodigo);
                    
                    $oElemCodigo = $oDoc->createElement('fechaBaja', $oDepartamento->fechaBaja);
                    $oElemDepartamento->appendChild($oElemCodigo);
                    
                    $oElemCodigo = $oDoc->createElement('volumenNegocio', $oDepartamento->volumenNegocio);
                    $oElemDepartamento->appendChild($oElemCodigo);
                    
                    $oDepartamento = $oConsulta->fetchObject();
                }
                
                // Guardado del archivo.
                echo '<div>Se han escrito '.$oDoc->save('../tmp/tablaDepartamento.xml').' bytes</div>';
                
                ?>
                <button><a href="practica08PDOdescargarArchivoXML.php">Descárgame</a></button>
                <?php
                
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
            
        </main>
    </body>
</html>
