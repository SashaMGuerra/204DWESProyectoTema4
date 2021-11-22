<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 12/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-3 MySQLi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        
        <style>
            .obligatorio:after{
                content: "*";
                color: red;
            }
            .inputObligatorio{
                background-color: gainsboro;
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
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 12/10/2021
             * Fecha de última modificación: 12/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Introducción de datos en la tabla Departamento mediante formulario.
             */

            //Librería de validación.
            include '../core/210322ValidacionFormularios.php';
            
            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBMySQLi.php';
            
            
            // Constantes para el parámetro "obligatorio".
            require_once '../config/configApp.php';

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
                $aErrores['codDepartamento'] = validarCodDepartamento($_REQUEST['codDepartamento']);
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
                    // Query de inserción.
                    $sSentencia = <<<QUERY
                            INSERT INTO Departamento VALUES
                            (?, ?, null, ?);
                    QUERY;
                    
                    // Conexión con la base de datos.
                    $oDB = new mysqli();
                    $oDB->connect(HOST, USER, PASSWORD, DB);
                    
                    /*
                     * Consulta preparada.
                     * Devuelve un mysqli statement.
                     */
                    $oConsulta = $oDB->prepare($sSentencia);
                    
                    /*
                     * Sustitución de los parámetros.
                     * En el primer parámetro se indican los tipos: string, string y double (float).
                     * En los siguientes parámetros, se le da valor a las ?
                     */
                    $oConsulta->bind_param('ssd', $aFormulario['codDepartamento'], $aFormulario['descDepartamento'], $aFormulario['volumenNegocio']);
                         
                    /*
                     * Ejecución de la consulta.
                     */
                    $oConsulta->execute();
                    
                    
                    /*
                    * Mostrado del contenido recogido por el formulario
                    * en una tabla.
                    */
                   echo "<h2>Registro realizado:</h2>";
                   echo '<table class="showVariables">';
                   foreach ($aFormulario as $key => $value) {
                       echo '<tr>';
                       echo "<td>$key</td><td>$value</td>";
                       echo '</tr>';
                   }
                   echo '</table>';
                    
                }catch(Exception $exception){
                    /*
                     * Mostrado del código de error y su mensaje.
                     */
                    echo '<div>Se han encontrado errores:</div><ul>';
                    echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
                    echo '</ul>';
                }
                finally{
                    $oDB->close();
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
                    <legend>Inserción en la tabla Departamento</legend>
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
             * Comprueba la validez del código de departamento.
             * Debe tener tres letras mayúsculas.
             * No puede existir ya en la base de datos.
             * 
             * @param string $codDepartamento Código del departamento introducido.
             * @return string|null String si ha encontrado un error, con su descripción.
             * Null si no ha habido ningún error.
             */
            function validarCodDepartamento($codDepartamento){
                /*
                 * Comprobación del texto introducido como alfabético y de tres caracteres.
                 */
                $errorCode = validacionFormularios::comprobarAlfabetico($_REQUEST['codDepartamento'], 3, 3, OBLIGATORIO);
                
                /*
                 * Comprobación si el código introducido está en mayúscula.
                 */
                if($codDepartamento !== strtoupper($codDepartamento)){
                    $errorCode = 'El código del departamento debe estar en mayúscula.';
                }
                else{
                    /*
                    * Comprobación de existencia en la base de datos.
                    */
                   try{
                        // Query de selección.
                        $sConsulta = <<<QUERY
                                SELECT codDepartamento FROM Departamento WHERE codDepartamento = '{$codDepartamento}';
                        QUERY;

                        // Conexión con la base de datos.
                        $oDB = new mysqli();
                        $oDB->connect(HOST, USER, PASSWORD, DB);

                        /*
                         * Ejecución del query.
                         * Devuelve un mysqli result o false.
                         */
                        $oResultado = $oDB->query($sConsulta);

                        if($oResultado->num_rows>0){
                            $errorCode = 'No puede haber dos departamentos con el mismo código.';
                        }

                    }catch(PDOException $exception){
                        /*
                         * Mostrado del código de error y su mensaje.
                         */
                        echo '<div>Se han encontrado errores en la validación:</div><ul>';
                        echo '<li>'.$exception->getCode().' : '.$exception->getMessage().'</li>';
                        echo '</ul>';
                    }
                    finally{
                        $oDB->close();
                   }
                }
                
                
                
                return $errorCode;
            }
            
            ?>
        </main>


        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
