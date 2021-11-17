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
        <style>
            fieldset{
                border: none;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Importación a la tabla Departamento.</h1>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 15/10/2021
             * Fecha de última modificación: 15/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Requiere un documento al usuario con información de departamentos
             * en xml y los añade a la tabla Departamento (importar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';

            //Librería de validación.
            include '../core/210322ValidacionFormularios.php';
            // Constantes para el parámetro "obligatorio".
            require_once '../config/configApp.php';



            /**
             * Recogida de los datos de la tabla Departamento.
             */
            $aFormulario = [
                'fileUpload' => ''
            ];

            /**
             * Array de errores.
             */
            $aErrores = [
                'fileUpload' => ''
            ];

            /**
             * Si el archivo ha sido enviado, comprueba que exista y sea correcta.
             */
            if (isset($_REQUEST['submit'])) {

                /*
                 * Manejador de errores. Por defecto asume que no hay ningún
                 * error (true). Si encuentra alguno se pone a false.
                 */
                $bEntradaOK = true;

                /*
                 * Registro de errores. Valida si se ha subido algún fichero.
                 */
                $aErrores['fileUpload'] = validacionFormularios::comprobarAlfaNumerico($_FILES['fileUpload']['name'], 300, 5, OBLIGATORIO);

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
             */ else {
                $bEntradaOK = false;
            }

            /*
             * Si el formulario ha sido enviado y no ha tenido errores
             * lleva la información a la base de datos.
             */
            if ($bEntradaOK) {
                // Directorio en que se subirá el fichero.
                $sDirectorioSubida = '../tmp/';

                /*
                 * Recogida y construcción del archivo donde se guardará,
                 * uniendo el directorio de subida con el nombre del archivo (habiendo
                 * quitado su directorio original) y su timestamp (para evitar que
                 * haya archivos repetidos).
                 */
                $oDateTimeNow = new DateTime();
                $sArchivoTarget = $sDirectorioSubida . $oDateTimeNow->getTimestamp() . basename($_FILES['fileUpload']['name']);

                /**
                 * Movimiento del archivo subido a una nueva ubicación.
                 * En lugar del nombre original, se toma su nombre temporal.
                 */
                move_uploaded_file($_FILES['fileUpload']['tmp_name'], $sArchivoTarget);

                /*
                 * Inserción en la base de datos.
                 */
                try {
                    // Query de inserción.
                    $sSentencia = <<<QUERY
                               INSERT INTO Departamento
                               VALUES (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio);
                       QUERY;

                    // Conexión con la base de datos.
                    $oDB = new PDO(HOST, USER, PASSWORD);

                    // Mostrado de las excepciones.
                    $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Consulta preparada.
                    $oConsulta = $oDB->prepare($sSentencia);

                    /*
                     * Creación del lector, que formatee la salida con indentación y espacios.
                     */
                    $oDoc = new DOMDocument();
                    $oDoc->formatOutput = true;

                    /* 
                     * Si es capaz de cargar el archivo, introduce los datos
                     * en la base de datos.
                     * 
                     * Si se introduce un archivo ilegible, muestra una advertencia.
                     * Para evitarlo, se deshabilitan los errores libxml.
                     */
                    libxml_use_internal_errors(true);
                    if ($oDoc->load($sArchivoTarget)) {
                        $nodeDepartamento = $oDoc->getElementsByTagName('departamento');

                        foreach ($nodeDepartamento as $departamento) {
                            $codDep = $departamento->getElementsByTagName('codDepartamento')->item(0)->nodeValue;
                            $descDep = $departamento->getElementsByTagName('descDepartamento')->item(0)->nodeValue;
                            /*
                             * Fecha baja puede tener valor null. Cuando lo carga del archivo,
                             * lo hace como una cadena vacía.
                             * Comprueba si es una cadena vacía, y si lo es, indica que
                             * es null.
                             */
                            $fechaBaja = ($departamento->getElementsByTagName('fechaBaja')->item(0)->nodeValue) == '' ? null : $fechaBaja;
                            $volNeg = $departamento->getElementsByTagName('volumenNegocio')->item(0)->nodeValue;

                            $oConsulta->bindParam(':codDepartamento', $codDep);
                            $oConsulta->bindParam(':descDepartamento', $descDep);
                            $oConsulta->bindParam(':fechaBaja', $fechaBaja);
                            $oConsulta->bindParam(':volumenNegocio', $volNeg);

                            // Ejecución del select.
                            $oConsulta->execute();
                        }

                        echo '<div>Se han introducido los datos con éxito.</div>';
                    }
                    /*
                     * Si no ha sido capaz de cargar los datos, lo indica.
                     */
                    else{
                        echo '<div>No se han podido introducir los datos.</div>';
                    }
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

                /*
                 * Eliminación del fichero recién creado.
                 */
                unlink($sArchivoTarget);
            }

            /*
             * Si el formulario no ha sido enviado o ha tenido errores
             * muestra el formulario.
             */ else {
                /*
                 * Por cada input, el valor por defecto se inicializa al que tiene
                 * $_REQUEST, si es que tiene alguno.
                 * Si tiene algún error, lo muestra al lado del input.
                 */

                /*
                 * El formulario necesita enctype para especificar cómo los datos
                 * del formulario deben ser codificados al subirse al servidor.
                 * Sólo puede usarse con método post.
                 */
                ?>
                <h2>Elija el archivo con que desea importar.</h2>
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <fieldset>
                        <input type="file" id="fileUpload" name="fileUpload" accept=".xml">
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
