<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 11/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-8 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <header>
            <h1>Importación a la tabla Departamento.</h1>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 11/10/2021
             * Fecha de última modificación: 11/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Toma datos de departamento.xml y los añade a la tabla Departamento
             * (importar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

            /**
             * Recogida de los datos de la tabla Departamento.
             */
            try {
                $sSentencia = <<<QUERY
                        INSERT INTO Departamento
                        VALUES (:codDep, :descDep, :fechaBaja, :volNeg);
                QUERY;
                
                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                // Consulta preparada.
                $oConsulta = $oDB->prepare($sSentencia);
                
                // Comienzo de la transacción.
                $oDB->beginTransaction();
                
                /*
                 * Creación del lector, que formatee la salida con indentación y espacios.
                 */
                $oDoc = new DOMDocument();
                $oDoc -> formatOutput = true;
                
                // Carga del archivo.
                $oDoc->load('../tmp/tablaDepartamento.xml');
                
                $nodeDepartamento = $oDoc->getElementsByTagName('departamento');
                
                foreach ($nodeDepartamento as $departamento) {
                    $codDep = $departamento->getElementsByTagName('codDepartamento')->item(0)->nodeValue;
                    $descDep = $departamento->getElementsByTagName('descDepartamento')->item(0)->nodeValue;
                    /*
                     * Fecha baja puede tener valor null. Cuando lo carga del archivo,
                     * lo hace como una cadena vacía.
                     * Comprueba si es una cadena vacía, y si lo es, indica que
                     * es null.
                     */
                    $fechaBaja = ($departamento->getElementsByTagName('fechaBaja')->item(0)->nodeValue)==''?null:$fechaBaja;
                    $volNeg = $departamento->getElementsByTagName('volumenNegocio')->item(0)->nodeValue;
                   
                    $oConsulta->bindParam(':codDep', $codDep);
                    $oConsulta->bindParam(':descDep', $descDep);
                    $oConsulta->bindParam(':fechaBaja', $fechaBaja);
                    $oConsulta->bindParam(':volNeg', $volNeg);
                    
                    // Ejecución del select.
                    $oConsulta->execute();
                }

                /*
                 * Si todo ha salido bien, commitea cambios.
                 */
                $oDB->commit();
                
                echo '<div>Se han introducido los datos con éxito.</div>';
                
            } catch (PDOException $exception) {
                /*
                 * Si se han dado errores, hace rollback.
                 */
                $oDB->rollBack();
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
