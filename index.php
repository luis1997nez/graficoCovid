<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Casos COVID</title>
		<script src="librerias/jquery-3.6.0.min.js"></script>
		<script src="librerias/plotly-2.3.0.min.js"></script>
		<link rel="stylesheet" type="text/css" href="estilo/estilo.css">

	</head>

	<body>

		<?php

			require_once "backend/conectar.php";

			$conexion = conexion();

			//Consultar datos de la base de datos
			//Query para seleccionar los datos
			$sql = "SELECT municipio, casosPosi FROM casos";
			$datos = mysqli_query($conexion,$sql);

			//Creación de los arreglos para almacenar los datos
			$muniX=array();
			$casosY=array();

			//Se extraen los valores de la consulta realizada
		  	while($resultado = mysqli_fetch_row($datos)){
		    	$muniX[] = $resultado[0];
		    	$casosY[] = $resultado[1];
		  	}

			//Los arreglos se convierten en formato JSON para poder ser procesados en JavaScript.
		  	$municiX=json_encode($muniX);
		  	$casosCY=json_encode($casosY);

		?>

		<!--Aquí se mostrará la gráfica-->
		<div id = "graficaBarras" class = "grafica"></div>


	</body>
</html>

<script>
	//La información obtenida en formato JSON en PHP se tiene que convertir a JavaScript
	function convertirJS(json){
    	var parsed = JSON.parse(json);
    	var arr = [];
    	for(var x in parsed){
      		arr.push(parsed[x]);
    	}
    	return arr;
  	}

  	//Se reciben los parseados a JavaScript
	municiX = convertirJS('<?php echo $municiX ?>');
    casosCY = convertirJS('<?php echo $casosCY ?>');
	

	//----Código del gráfico----
	//Se pasan los valores convertidos para JavaScript
	var xValue = municiX;

	var yValue = casosCY;
	var yValue2 = casosCY;

	//Se indican en que lugar de plano cartesiano se van a reflejar los valores  
	var trace1 = {
 		x: xValue,
  		y: yValue,
  		type: 'bar',
  		text: yValue.map(String),
  		textposition: 'auto',
  		hoverinfo: 'none',
  		opacity: 0.5,
  		marker: {
    		color: 'rgb(158,202,225)',
    		line: {
      			color: 'rgb(8,48,107)',
      			width: 1.5
    		}
  		}
	};

	//Se almacena la estrutara de valores de la gráfica
	var data = [trace1];

	//Estilos de la gráfica
	var layout = {
		barmode: "overlay",
  		title: 'Cantidad de infectados en ls municipios',
  		xaxis: {
      		title: 'Municipios'
    	},
    	yaxis: {
      		title: 'Infectados'
    	}
	};

	//Se reciben los parámetros de la gráfica
	Plotly.newPlot('graficaBarras', data, layout);

</script>
