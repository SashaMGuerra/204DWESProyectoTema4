<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 16/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-4 PDO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        
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
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 16/10/2021
             * Fecha de última modificación: 16/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Búsqueda y mostrado de departamentos según descripción mediante
             * MySQLi.
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
                'descDepartamento' => ''
            ];

            /*
             * Inicialización del array de errores.
             */
            $aErrores = [
                'descDepartamento' => ''
            ];
            
            /*
             * Formulario de búsqueda. Siempre se muestra, se haya enviado
             * o no la información.
             * Su único input es obligatorio.
             * Si tiene algún error, lo muestra debajo del input.
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
                    // Query de búsqueda.
                    $sConsulta = <<<QUERY
                        SELECT * FROM Departamento WHERE descDepartamento LIKE '%{$aFormulario['descDepartamento']}%';
                    QUERY;
                        
                    // Conexión con la base de datos.
                    $oDB = new mysqli();
                    $oDB->connect(HOST, USER, PASSWORD, DB);
                    
                    /*
                     * Ejecución de la consulta.
                     * Devuelve un mysqli_result.
                     */
                    $oResultadoConsulta = $oDB->query($sConsulta);
                    
                    echo '<h2>Departamentos encontrados: </h2>';
                    /*
                     * Mostrado del select.
                     */
                    $aDepartamento = $oResultadoConsulta->fetch_object();
                    echo '<table class="showSelect">';
                    while($aDepartamento){
                        echo '<tr>';
                        echo "<td>$aDepartamento->codDepartamento</td>";
                        echo "<td>$aDepartamento->descDepartamento</td>";
                        echo "<td>$aDepartamento->fechaBaja</td>";
                        echo "<td>$aDepartamento->volumenNegocio</td>";
                        echo '</tr>';
                        $aDepartamento = $oResultadoConsulta->fetch_object();
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
                    $oDB->close();
                }
            }
            ?>
        </main>
        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>


    </body>
</html>
