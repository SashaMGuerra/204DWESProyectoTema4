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
            form{
                width: 100%;
                max-width: 500px;
            }
            table{
                margin: auto;
            }

            span{
                font-size: small;
                color: red;
            }

            .showVariables{
                border-collapse: collapse;
            }
            .showVariables td{
                border: 1px solid gainsboro;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <main>
            <?php
            /*
             * Fecha de creación: 10/10/2021
             * Fecha de última modificación: 10/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Toma datos de la tabla Departamento y los guarda en departamento.xml
             * (copia de seguridad/exportar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

            /**
             * Recogida de los datos de la tabla Departamento.
             */
            try {
                $sSentencia = 'SELECT * FROM Departamento';
                
                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta preparada.
                $oConsulta = $oDB->prepare($sSentencia);

                // Comienzo de la transacción.
                $oDB->beginTransaction();
                
                // Ejecución del select.
                $oConsulta->execute();

                /*
                 * Mientras recoja un departamento, lo añade al xml.
                 */
                $oDepartamento = $oConsulta->fetchObject();
                while($oDepartamento){
                    
                    
                    $oDepartamento = $oConsulta->fetchObject();
                }

                /*
                 * Si todo ha salido bien, commitea cambios.
                 */
                $oDB->commit();
                
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
