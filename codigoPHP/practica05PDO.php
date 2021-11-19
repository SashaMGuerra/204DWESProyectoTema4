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
        <link href="../webroot/css/proyectoTema4common.css" rel="stylesheet" type="text/css"/>
        <link href="../webroot/css/footerDown.css" rel="stylesheet" type="text/css"/>
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
        <header>
            <?php include_once './elementoBtVolver.php'; // Botón de regreso, ya formateado ?>
            <h1>Introducción de tres departamentos.</h1>
        </header>
        <main>
            <?php
            /*
             * Fecha de creación: 08/10/2021
             * Fecha de última modificación: 11/10/2021
             * @version 1.0
             * @author Sasha
             * 
             * Añadido de tres registros a Departamento; deben añadirse los tres
             * o ninguno (transacción).
             */

            // Constantes para la conexión con la base de datos.
            require_once '../config/configDBPDO.php';
            
            // Departamentos a insertar.
            $aDepartamentos = [
                ['codDepartamento' => 'IOT',
                'descDepartamento' => 'Departamento Iota',
                'volumenNegocio' => '87.5'],
                
                ['codDepartamento' => 'KAP',
                'descDepartamento' => 'Departamento Kappa',
                'volumenNegocio' => '85.5'],
                
                ['codDepartamento' => 'LAM',
                'descDepartamento' => 'Departamento Lambda',
                'volumenNegocio' => '7.32'],
            ];
            
            
            try{
                // Query de inserción.
                $sSentencia = <<<QUERY
                        INSERT INTO Departamento VALUES
                        (:codDepartamento, :descDepartamento, null, :volumenNegocio);
                QUERY;

                // Conexión con la base de datos.
                $oDB = new PDO(HOST, USER, PASSWORD);

                // Mostrado de las excepciones.
                $oDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Inicio de la transacción, deshabilita el autocommit.
                $oDB->beginTransaction();

                // Preparación de la sentencia.
                $oConsulta = $oDB->prepare($sSentencia);

                /**
                 * Por cada departamento, ejecución de la consulta.
                 */
                foreach ($aDepartamentos as $aDepartamento) {
                    $aParametros = [
                        ':codDepartamento' => $aDepartamento['codDepartamento'],
                        ':descDepartamento' => $aDepartamento['descDepartamento'],
                        ':volumenNegocio' => $aDepartamento['volumenNegocio']
                    ];

                    $oConsulta->execute($aParametros);
                    
                }
                
                /*
                 * Si no ha habido ningún error, commitea los cambios.
                 */
                $oDB->commit();

                echo '<div>Los datos se han introducido con éxito.</div>';
                
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
                
            ?>
        </main>

        <?php include_once './elementoFooter.php'; // Footer, ya formateado ?>

    </body>
</html>
