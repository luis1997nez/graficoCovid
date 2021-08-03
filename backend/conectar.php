<?php
    
//Conexion a la base de datos de casos de covid
function conexion(){
	return mysqli_connect('localhost', 'root', '', 'infeccionCovid');
}

?>