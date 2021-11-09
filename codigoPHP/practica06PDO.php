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
            
            /*
             * Definición de constantes para el parámetro "obligatorio"
             */
            define("OBLIGATORIO", 1);
            define("OPCIONAL", 0);

            /*
             * Inicialización del array de elementos del formulario.
             */
            $aFormulario = [
                'codDepartamento' => '',
                'descDepartamento' => '',
                'volumenNegocio' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'codDepartamento' => '',
                'descDepartamento' => '',
                'volumenNegocio' => ''
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
                $aErrores['codDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, OBLIGATORIO);
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 5, OBLIGATORIO);
                $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'], 5000, 0, OBLIGATORIO);
                
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
                $aFormulario['codDepartamento'] = $_REQUEST['codDepartamento'];
                $aFormulario['descDepartamento'] = $_REQUEST['descDepartamento'];
                $aFormulario['volumenNegocio'] = $_REQUEST['volumenNegocio'];
                
                /*
                 * Inserción en la base de datos.
                 */
                try{
                    // Conexión con la base de datos.
                    $oDB = new PDO(HOST, USER, PASSWORD);
                    
                    // Mostrado de las excepciones.
                    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Consulta preparada.
                    $oConsulta = $oDB->prepare(<<<QUERY
                            insert into Departamento
                            values (:codDep, :descDep, null, :volNeg);
                    QUERY);
                            
                    /*
                     * Array con la información que sustituirá los parámetros.
                     */
                    $aParametros = [
                        ':codDep' => $aFormulario['codDepartamento'],
                        ':descDep' => $aFormulario['descDepartamento'],
                        ':volNeg' => $aFormulario['volumenNegocio']
                    ];
                            
                    /*
                     * Ejecución de la consulta preparada
                     */
                    $oConsulta->execute($aParametros);
                    
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
                    <legend>Registro</legend>
                    <table>
                        <tr>
                            <td><label class="obligatorio" for="codDepartamento">Código del departamento</label></td>
                            <td><label class="obligatorio" for="descDepartamento">Descripción</label></td>
                            <td><label class="obligatorio" for="volumenNegocio">Volumen de negocio</label></td>
                        </tr>
                        <tr>
                            <td><input class="inputObligatorio" type="text" name="codDepartamento" id="codDepartamento" value="<?php echo $_REQUEST['codDepartamento'] ?? '' ?>" placeholder="ABC"></td>
                            <td><input class="inputObligatorio" type="text" name="descDepartamento" id="descDepartamento" value="<?php echo $_REQUEST['descDepartamento'] ?? '' ?>"></td>
                            <td><input class="inputObligatorio" type="text" name="volumenNegocio" id="volumenNegocio" value="<?php echo $_REQUEST['volumenNegocio'] ?? '' ?>" placeholder="Ej.: 1.75"></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span>' . $aErrores['codDepartamento'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?></td>
                            <td><?php echo '<span>' . $aErrores['volumenNegocio'] . '</span>' ?></td>
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
