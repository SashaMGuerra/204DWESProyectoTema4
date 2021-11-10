<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 08/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-5 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            form{
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
             * Añadido de tres registros a Departamento; deben añadirse los tres
             * o ninguno (transacción).
             */

            //Librería de validación.
            include '../core/210322ValidacionFormularios.php';
            
            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';
            
            /*
             * Definición de constantes para el parámetro "obligatorio"
             */
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);

            /*
             * Inicialización del array de elementos del formulario.
             */
            $aFormulario = [
                'codDepartamento1' => '',
                'descDepartamento1' => '',
                'volumenNegocio1' => '',
                'codDepartamento2' => '',
                'descDepartamento2' => '',
                'volumenNegocio2' => '',
                'codDepartamento3' => '',
                'descDepartamento3' => '',
                'volumenNegocio3' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'codDepartamento1' => '',
                'descDepartamento1' => '',
                'volumenNegocio1' => '',
                'codDepartamento2' => '',
                'descDepartamento2' => '',
                'volumenNegocio2' => '',
                'codDepartamento3' => '',
                'descDepartamento3' => '',
                'volumenNegocio3' => ''
            ];

            /*
             * Confirmación si el formulario ha sido enviado.
             * Si ha sido enviado, valida los campos y registra los errores.
             */
            if (isset($_REQUEST['submit'])) {
                /*
                 * Manejador de errores. Por defecto asume que no hay ningún
                 * error (true). Si encuentra alguno se pone a false.
                 */
                $bEntradaOK = true;
                
                /*
                 * Registro de errores. Valida todos los campos.
                 */
                $aErrores['codDepartamento1'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento1'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento1'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento1'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio1'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio1'], 5000, 0, OBLIGATORIO);
                $aErrores['codDepartamento2'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento2'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento2'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento2'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio2'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio2'], 5000, 0, OBLIGATORIO);
                $aErrores['codDepartamento3'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento3'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento3'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento3'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio3'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio3'], 5000, 0, OBLIGATORIO);
                
                /*
                 * Recorrido del array de errores.
                 * Si existe alguno, cambia el manejador de errores a false
                 * y limpia el campo en el $_REQUEST.
                 */
                foreach ($aErrores as $sCampo => $sError) {
                    if ($sError != null) {
                        $_REQUEST[$sCampo] = ''; //Limpieza del campo.
                        $bEntradaOK = false;
                    }
                }
                
            }
            
            /*
             * Si el formulario no ha sido enviado, pone el manejador de errores
             * a false para poder mostrar el formulario.
             */
            else {
                $bEntradaOK = false;
            }
            
            /*
             * Si el formulario ha sido enviado y no ha tenido errores
             * muestra la información enviada.
             */
            if ($bEntradaOK) {
                /*
                 * Recogida de la información enviada.
                 */
                $aFormulario['codDepartamento1'] = $_REQUEST['codDepartamento1'];
                $aFormulario['descDepartamento1'] = $_REQUEST['descDepartamento1'];
                $aFormulario['volumenNegocio1'] = $_REQUEST['volumenNegocio1'];
                $aFormulario['codDepartamento2'] = $_REQUEST['codDepartamento2'];
                $aFormulario['descDepartamento2'] = $_REQUEST['descDepartamento2'];
                $aFormulario['volumenNegocio2'] = $_REQUEST['volumenNegocio2'];
                $aFormulario['codDepartamento3'] = $_REQUEST['codDepartamento3'];
                $aFormulario['descDepartamento3'] = $_REQUEST['descDepartamento3'];
                $aFormulario['volumenNegocio3'] = $_REQUEST['volumenNegocio3'];
                
                /*
                 * Inserción en la base de datos.
                 */
                try{
                    // Conexión con la base de datos.
                    $oDB = new PDO(HOST, USER, PASSWORD);
                    
                    // Mostrado de las excepciones.
                    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Queries de inserción.
                    $sInsert1 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento1']}', '{$aFormulario['descDepartamento1']}', null, {$aFormulario['volumenNegocio1']});
                    QUERY;
                    $sInsert2 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento2']}', '{$aFormulario['descDepartamento2']}', null, {$aFormulario['volumenNegocio2']});
                    QUERY;
                    $sInsert3 = <<<QUERY
                            INSERT INTO Departamento VALUES
                            ('{$aFormulario['codDepartamento3']}', '{$aFormulario['descDepartamento3']}', null, {$aFormulario['volumenNegocio3']});
                    QUERY;
                    
                    // Inicio de la transacción, deshabilita el autocommit.
                    $oDB->beginTransaction();
                            
                    /*
                     * Ejecución de los queries.
                     */
                    $iRegistros = $oDB->exec($sInsert1);
                    $iRegistros = $oDB->exec($sInsert2);
                    $iRegistros = $oDB->exec($sInsert3);
                    
                    /*
                     * Si no ha habido ningún error, commitea los cambios.
                     */
                    $oDB->commit();
                    
                    /*
                    * Mostrado del contenido recogido por el formulario
                    * en una tabla.
                    */
                   echo "<h2>Registros realizados:</h2>";
                   echo '<table class="showVariables">';
                   foreach ($aFormulario as $key => $value) {
                       echo '<tr>';
                       echo "<td>$key</td><td>$value</td>";
                       echo '</tr>';
                   }
                   echo '</table>';
                    
                }catch(PDOException $exception){
                    /*
                     * Si ha habido algún error, vuelve atrás.
                     */
                    $oDB->rollback();
                    /*
                     * Mostrado del código de error y su mensaje.
                     */
                    echo '<div>Se han encontrado errores:</div><ul>';
                    echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
                    echo '</ul>';
                }
                finally{
                    unset($oDB);
                }
                
            }
            
            /*
             * Si el formulario no ha sido enviado o ha tenido errores
             * muestra el formulario.
             */
            else {
                
                /*
                 * Por cada input, el valor por defecto se inicializa al que tiene
                 * $_REQUEST, si es que tiene alguno.
                 * Si tiene algún error, lo muestra al lado del input.
                 */
                ?>
            
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <fieldset>
                    <legend>Primer registro</legend>
                    <table>
                        <tr>
                            <td><label class="obligatorio" for="codDepartamento1">Código del departamento</label></td>
                            <td><label class="obligatorio" for="descDepartamento1">Descripción</label></td>
                            <td><label class="obligatorio" for="volumenNegocio1">Volumen de negocio</label></td>
                        </tr>
                        <tr>
                            <td><input class="inputObligatorio" type="text" name="codDepartamento1" id="codDepartamento1" value="<?php echo $_REQUEST['codDepartamento1'] ?? '' ?>" placeholder="ABC"></td>
                            <td><input class="inputObligatorio" type="text" name="descDepartamento1" id="descDepartamento1" value="<?php echo $_REQUEST['descDepartamento1'] ?? '' ?>"></td>
                            <td><input class="inputObligatorio" type="text" name="volumenNegocio1" id="volumenNegocio1" value="<?php echo $_REQUEST['volumenNegocio1'] ?? '' ?>" placeholder="Ej.: 1.75"></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span>' . $aErrores['codDepartamento1'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['descDepartamento1'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['volumenNegocio1'] . '</span>' ?></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <legend>Segundo registro</legend>
                    <table>
                        <tr>
                            <td><label class="obligatorio" for="codDepartamento2">Código del departamento</label></td>
                            <td><label class="obligatorio" for="descDepartamento2">Descripción</label></td>
                            <td><label class="obligatorio" for="volumenNegocio2">Volumen de negocio</label></td>
                        </tr>
                        <tr>
                            <td><input class="inputObligatorio" type="text" name="codDepartamento2" id="codDepartamento2" value="<?php echo $_REQUEST['codDepartamento2'] ?? '' ?>" placeholder="ABC"></td>
                            <td><input class="inputObligatorio" type="text" name="descDepartamento2" id="descDepartamento2" value="<?php echo $_REQUEST['descDepartamento2'] ?? '' ?>"></td>
                            <td><input class="inputObligatorio" type="text" name="volumenNegocio2" id="volumenNegocio2" value="<?php echo $_REQUEST['volumenNegocio2'] ?? '' ?>" placeholder="Ej.: 1.75"></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span>' . $aErrores['codDepartamento2'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['descDepartamento2'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['volumenNegocio2'] . '</span>' ?></td>
                        </tr>
                    </table>
                </fieldset>
                <fieldset>
                    <legend>Tercer registro</legend>
                    <table>
                        <tr>
                            <td><label class="obligatorio" for="codDepartamento3">Código del departamento</label></td>
                            <td><label class="obligatorio" for="descDepartamento3">Descripción</label></td>
                            <td><label class="obligatorio" for="volumenNegocio3">Volumen de negocio</label></td>
                        </tr>
                        <tr>
                            <td><input class="inputObligatorio" type="text" name="codDepartamento3" id="codDepartamento3" value="<?php echo $_REQUEST['codDepartamento3'] ?? '' ?>" placeholder="ABC"></td>
                            <td><input class="inputObligatorio" type="text" name="descDepartamento3" id="descDepartamento3" value="<?php echo $_REQUEST['descDepartamento3'] ?? '' ?>"></td>
                            <td><input class="inputObligatorio" type="text" name="volumenNegocio3" id="volumenNegocio3" value="<?php echo $_REQUEST['volumenNegocio3'] ?? '' ?>" placeholder="Ej.: 1.75"></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span>' . $aErrores['codDepartamento3'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['descDepartamento3'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['volumenNegocio3'] . '</span>' ?></td>
                        </tr>
                    </table>
                </fieldset>
                <input type="submit" name="submit" id="submit">
            </form>
            
            <?php
            }
            
            /**
            * Extrae de una consulta el número de columnas tomadas, y crea una línea
            * de una tabla con una celda para el nombre de cada una.
            * 
            * @param PDOStatement $oResultadoConsulta Sentencia preparada de la
            * que extraer los nombres de las columnas.
            */
            function columnsNameRow($oResultadoConsulta){
                $iNumColumnas = $oResultadoConsulta->columnCount();
                echo '<tr>';
                for($iColumna = 0; $iColumna<$iNumColumnas ;$iColumna++){
                    echo "<th>".$oResultadoConsulta->getColumnMeta($iColumna)['name']."</th>";
                }
                echo '</tr>';
            }
            ?>
        </main>


    </body>
</html>
