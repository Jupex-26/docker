<?php
require_once "Votacion.php";
require_once "vista.php";
echo $_SERVER["SERVER_ADDR"];
echo getMenu();
$accion=$_GET['menu']??'Formulario';
switch ($accion){
    case 'Formulario':
        echo getFormulario();
        break;
    case 'Resultados':
        mostrarResultados();
        break;
}

if (isset($_POST['opcion'])) {
    $voto = ($_POST['opcion'] === 'Si') ? 'Si' : 'No';
    $exito = Votacion::save($voto); 
    if ($exito) {
        $mensaje_post = "<p style='color: green;'>¡Voto para el {$voto} registrado con éxito!</p>";
    } else {
        $mensaje_post = "<p style='color: red;'>Error al registrar el voto.</p>";
    }
    echo $mensaje_post;
}

function mostrarResultados(){
    $resultados=Votacion::findAll();
    if (count($resultados)>0){
        echo mostrar($resultados);
    }else{
        echo "<h1>No hay votos</h1>";
    }
    
    
}
?>