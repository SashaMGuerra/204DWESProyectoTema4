<?php
$file_url = '../tmp/tablaDepartamento.xml';

/*
 * header envía encabezados HTTP sin formato.
 * 
 * Para preguntar al usuario si quiere guardar los datos que se están
 * enviando, se puede usar el encabezado Content-Disposition, para dar
 * un nombre de fichero y mostrar el diálogo de guardado.
 */
header('Content-type: text/xml');
header("Content-disposition: attachment; filename=\"" . basename($file_url). "\""); 

/*
 * readfile lee un fichero y escribe en el búfer de salida.
 */
readfile($file_url); 



