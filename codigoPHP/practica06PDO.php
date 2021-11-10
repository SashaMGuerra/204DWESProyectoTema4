<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 08/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-6 PDO</title>
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
             * Fecha de creación: 08/10/2021
             * Fecha de última modificación: 08/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Carga de registros en Departamento desde un array utilizando
             * una consulta preparada.
             */

            //Librería de validación.
            include '../core/210322ValidacionFormularios.php';

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

            // Array con los departamentos a insertar.
            $aDepartamentos = [
                ["codDepartamento" => 'AIR', "descDepartamento" => 'Departamento Aire', 'volumenNegocio' => 0.57],
                ["codDepartamento" => 'AVA', "descDepartamento" => 'Departamento Agua', 'volumenNegocio' => 57.98],
                ["codDepartamento" => 'TIE', "descDepartamento" => 'Departamento Tierra', 'volumenNegocio' => 57]
            ];

            try {
                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Consulta preparada.
                $oConsulta = $oDB->prepare(<<<QUERY
                        INSERT INTO Departamento
                        VALUES (:codDep, :descDep, null, :volNeg);
                QUERY);

                // Comienzo de la transacción.
                $oDB->beginTransaction();

                /*
                 * Ejecución de la consulta preparada por cada departamento.
                 */
                foreach ($aDepartamentos as $aDepartamento) {
                    /*
                     * Modificación de los parámetros por cada departamento.
                     */
                    $aParametros = [
                        ':codDep' => $aDepartamento['codDepartamento'],
                        ':descDep' => $aDepartamento['descDepartamento'],
                        ':volNeg' => $aDepartamento['volumenNegocio']
                    ];

                    $oConsulta->execute($aParametros);
                }

                echo 'Se han realizado los registros';

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
