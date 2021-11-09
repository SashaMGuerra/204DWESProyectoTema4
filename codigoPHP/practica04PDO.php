<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 08/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-4 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            form{
                margin: auto;
                max-width: 500px;
            }
            table{
                margin: auto;
            }
            
            span{
                font-size: small;
                color: red;
            }
            
            .showSelect{
                border-collapse: collapse;
            }
            .showSelect td, .showSelect th{
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
             * Búsqueda y mostrado de departamentos según descripción.
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
                'descDepartamento' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'descDepartamento' => ''
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
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 3, OPCIONAL);
                
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
                $aFormulario['descDepartamento'] = $_REQUEST['descDepartamento'];
                
                /*
                 * Inserción en la base de datos.
                 */
                try{
                    // Conexión con la base de datos.
                    $oDB = new PDO(HOST, USER, PASSWORD);
                    
                    // Mostrado de las excepciones.
                    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Query de búsqueda.
                    if($aFormulario['descDepartamento']==''){
                        $sConsulta = 'select * from Departamento';
                    }
                    else{
                        $sConsulta = <<<QUERY
                            select * from Departamento where descDepartamento like '%{$aFormulario['descDepartamento']}%';
                        QUERY;
                    }
                    
                    /*
                     * Ejecución del query.
                     */
                    $oResultadoConsulta = $oDB->query($sConsulta);
                    
                    echo '<h2>Departamentos encontrados: </h2>';
                    /*
                     * Mostrado del select.
                     */
                    $aQuery = $oResultadoConsulta->fetchObject();
                    echo '<table class="showSelect">';
                    columnsNameRow($oResultadoConsulta);
                    while($aQuery){
                        echo '<tr>';
                        foreach ($aQuery as $valor) {
                            echo "<td>$valor</td>";
                        }
                        echo '</tr>';
                        $aQuery = $oResultadoConsulta->fetchObject();
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
                    <legend>Búsqueda de departamentos</legend>
                    <table>
                        <tr>
                            <td><label for="descDepartamento">Departamento a buscar</label></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="descDepartamento" id="descDepartamento" value="<?php echo $_REQUEST['descDepartamento'] ?? '' ?>"></td>
                        </tr>
                        <tr>
                            <td><?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?></td>
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
