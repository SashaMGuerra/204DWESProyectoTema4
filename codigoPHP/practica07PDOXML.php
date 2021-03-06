<!DOCTYPE html>
<!--
    Autor: Isabel Martínez Guerra
    Fecha: 11/11/2021
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>IMG - DWES 4-7 PDO XML</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <link href="../webroot/css/footerDown.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
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
             * Toma datos de tablaDepartamento.xml en la carpeta tmp  y los añade a
             * la tabla Departamento (importar).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';
            
            $sSentencia = <<<QUERY
                    INSERT INTO Departamento
                    VALUES (:codDepartamento, :descDepartamento, :fechaBaja, :volumenNegocio);
            QUERY;

            /**
             * Recogida de los datos de la tabla Departamento.
             */
            try {
                
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
                $oDoc -> formatOutput = true;
                
                // Comienzo de la transacción.
                $oDB->beginTransaction();
                
                // Carga del archivo.
                $oDoc->load('../tmp/tablaDepartamento.xml');
                
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
                    $fechaBaja = ($departamento->getElementsByTagName('fechaBaja')->item(0)->nodeValue)==''?null:$fechaBaja;
                    $volNeg = $departamento->getElementsByTagName('volumenNegocio')->item(0)->nodeValue;
                    
                    $aParametros = [
                        ':codDepartamento' => $codDep,
                        ':descDepartamento' => $descDep,
                        ':fechaBaja' => $fechaBaja,
                        ':volumenNegocio' => $volNeg
                    ];
                    
                    // Ejecución del select.
                    $oConsulta->execute($aParametros);
                }
                
                //Si la transacción ha ido bien, comitea cambios.
                $oDB->commit();
                
                echo '<div>Se han introducido los datos con éxito.</div>';
                
            } catch (PDOException $exception) {
                //Si la transacción ha fallado, no efectúa ningún cambio.
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
            <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>
    </body>
</html>
