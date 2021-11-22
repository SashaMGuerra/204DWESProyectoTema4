<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 12/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-7 PDO JSON</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        
    </head>
    <body>
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
            <h1>Importación a la tabla Departamento.</h1>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 12/10/2021
             * Fecha de última modificación: 12/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Toma datos de tablaDepartamento.json en la carpeta tmp  y los añade a
             * la tabla Departamento (importar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';
            
            $sSentencia = <<<QUERY
                    INSERT INTO Departamento
                    VALUES (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio);
            QUERY;

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
                
                /*
                 * Carga del archivo.
                 */
                $sJsonDepartamentos = file_get_contents('../tmp/tablaDepartamento.json');
                
                // Decodificación del string en JSON a un array de arrays.
                $aDepartamentos = json_decode($sJsonDepartamentos);
                
                // Comienzo de la transacción.
                $oDB->beginTransaction();
                
                /*
                 * Por cada departamento, bind de los parámetros y ejecución
                 * del sql.
                 */
                foreach ($aDepartamentos as $oDepartamento) {
                    $oConsulta->bindParam(':codDepartamento', $oDepartamento->codDepartamento);
                    $oConsulta->bindParam(':descDepartamento', $oDepartamento->descDepartamento);
                    $oConsulta->bindParam(':fechaBaja', $oDepartamento->fechaBaja);
                    $oConsulta->bindParam(':volumenNegocio', $oDepartamento->volumenNegocio);
                    
                    $oConsulta->execute();
                }
                
                //Si la transacción ha ido bien, comitea cambios.
                $oDB->commit();
                
                echo '<div>Se han introducido los datos con éxito.</div>';
                
            } catch (PDOException $exception) {
                //Si la transacción ha fallado, no efectúa ningún cambio.
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
        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
