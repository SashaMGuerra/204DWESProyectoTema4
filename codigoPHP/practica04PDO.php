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
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <link href="../webroot/css/footerDown.css" rel="stylesheet" type="text/css"/>
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
                width: 100%;
                max-width: 800px;
                margin: auto;
                table-layout: fixed;
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
             * Fecha de creación: 08/10/2021
             * Fecha de última modificación: 19/11/2021
             * @version 1.0
             * @author Sasha
             * 
             * Búsqueda y mostrado de departamentos según descripción.
             * Si no se da ninguna descripción o al cargarse por primera vez
             * la página, se cargan todos los registros.
             */

            //Librería de validación.
            include '../core/210322ValidacionFormularios.php';

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

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
             * Si el formulario ha sido enviado, valida el campo y registra los errores.
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
             * a false para que no entre en las acciones tras la validación
             * de entrada.
             * 
             */ else {
                $bEntradaOK = false;
            }

            /*
             * Si el formulario ha sido enviado y no ha tenido errores, busca
             * por la descripción dada.
             */
            if ($bEntradaOK) {
                /*
                 * Recogida de la información enviada.
                 */
                $aFormulario['descDepartamento'] = $_REQUEST['descDepartamento'];
            }

            
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
             * Carga y muestra los registros según la descripción de departamento
             * dada.
             * Si no se ha dado una o es la primera vez que se accede, esta variable
             * tiene valor '', y por lo tanto, carga todos los registros.
             */
            try {
                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Query de búsqueda.
                $sConsulta = <<<QUERY
                        SELECT * FROM Departamento WHERE descDepartamento LIKE '%{$aFormulario['descDepartamento']}%';
                    QUERY;

                /*
                 * Ejecución de la consulta preparada.
                 */
                $oResultadoConsulta = $oDB->prepare($sConsulta);
                $oResultadoConsulta->execute();

                echo '<h2>Departamentos encontrados: </h2>';
                /*
                 * Mostrado del select.
                 */
                $aDepartamento = $oResultadoConsulta->fetchObject();
                echo '<table class="showSelect">';
                while ($aDepartamento) {
                    ?>
                    <tr>
                        <td><?php echo $aDepartamento->codDepartamento ?></td>
                        <td><?php echo $aDepartamento->descDepartamento ?></td>
                        <td><?php echo $aDepartamento->fechaBaja ?></td>
                        <td><?php echo $aDepartamento->volumenNegocio ?></td>
                    </tr>
                    <?php
                    $aDepartamento = $oResultadoConsulta->fetchObject();
                }
                echo '</table>';
            } catch (PDOException $exception) {
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
