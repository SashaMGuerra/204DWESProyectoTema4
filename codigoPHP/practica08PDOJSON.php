<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 12/11/2021
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
             * Fecha de creación: 12/10/2021
             * Fecha de última modificación: 12/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Toma datos de la tabla Departamento en el directorio tmp y los
             * guarda en tablaDepartamento.json (copia de seguridad/exportar).
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
                 * Recogida de información en un array.
                 */
                $aDepartamentos = [];
                
                $oDepartamento = $oConsulta->fetchObject();
                while ($oDepartamento) {
                    $aDepartamento = [
                        'codDepartamento' => $oDepartamento->codDepartamento,
                        'descDepartamento' => $oDepartamento->descDepartamento,
                        'fechaBaja' => $oDepartamento->fechaBaja,
                        'volumenNegocio' => $oDepartamento->volumenNegocio
                    ];
                    
                    // Añadido del array del departamento al array de departamentos.
                    array_push($aDepartamentos, $aDepartamento);
                    
                    $oDepartamento = $oConsulta->fetchObject();
                }
                
                /**
                 * Formateo a JSON del array con impresión para facilitar la lectura.
                 */
                $sDepartamentosJSON = json_encode($aDepartamentos, JSON_PRETTY_PRINT);
                
                /*
                 * Escritura y guardado del archivo.
                 * 
                 * file_put_contents funciona como la sucesión fopen > fwrite > fclose
                 * Sobreescribe el fichero si ya existía.
                 */
                $iBytes = file_put_contents('../tmp/tablaDepartamento.json', $sDepartamentosJSON);
                
                // Guardado del archivo.
                echo "<div>Se han escrito $iBytes bytes.</div>";
                
                ?>
                <button><a href="practica08PDOdescargarArchivoJSON.php">Descárgame</a></button>
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
