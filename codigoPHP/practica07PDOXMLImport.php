<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 15/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-7 PDO XML Importación</title>
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
             * Fecha de última modificación: 12/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Requiere un documento al usuario con información de departamentos
             * en xml y los añade a la tabla Departamento (importar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';
            

            /**
             * Recogida de los datos de la tabla Departamento.
             */
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
                $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfanumerico($_REQUEST['descDepartamento'], 255, 1, OPCIONAL);
                
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
                    
                    // Query de inserción.
                    $sSentencia = <<<QUERY
                            INSERT INTO Departamento
                            VALUES (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio);
                    QUERY;
                        
                        
                    
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
                <h2>Elija el archivo con que desea importar.</h2>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <fieldset>
                        <input type="file" id="fileUpload" name="fileUpload">
                    </fieldset>
                    <br>
                    <input type="submit" name="submit" id="submit">
                </form>
            <?php
            }
            
            ?>
        </main>
    </body>
</html>
