<?php
function getFormulario(){
    $action=$_SERVER['PHP_SELF'];
    $html=<<<Formulario
    <form method='post' action='$action'>
    <label for="encuesta">¿Independizar
    Linares de la provincia de Jaén?</label> <br>
    <label for="si">Si</label>
    <input type="radio" value="Si" name="opcion">
    <label for="no">No</label>
    <input type="radio" value="No" name="opcion"><br>
    <button type="submit" name="accion" value="guardar">Enviar</button>
    </form>

    Formulario;
    return $html;
}
function getMenu(){
    $html=<<<Menu
    <nav>
        <ul style="display:flex; list-style:none; justify-content:space-around;">
            <li><a href="?menu=Formulario">Formulario</a></li>
            <li><a href="?menu=Resultados">Ver Resultados</a></li>
        </ul>
    </nav>

    Menu;
    return $html;
}

function mostrar(array $resultados): string {

    $votos_si = $resultados['Si'] ?? 0;
    $votos_no = $resultados['No'] ?? 0;
    $total_votos = $votos_si + $votos_no;

   
    $porcentaje_si = ($total_votos > 0) ? round(($votos_si / $total_votos) * 100, 1) : 0;
    $porcentaje_no = ($total_votos > 0) ? round(($votos_no / $total_votos) * 100, 1) : 0;


    $html = <<<HTML
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Resultados: ¿Independizar Linares de Jaén?</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 2px 2px 5px rgba(0,0,0,0.1); }
            .bar-container { background-color: #f1f1f1; border-radius: 5px; margin-bottom: 10px; }
            .bar { color: white; text-align: right; padding-right: 5px; height: 25px; line-height: 25px; border-radius: 5px; }
            .si { background-color: #4CAF50; }
            .no { background-color: #f44336; }
            h1 { text-align: center; color: #333; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>¿Independizar Linares de la provincia de Jaén?</h1>
            <h2>📊 Resultados de la Encuesta</h2>
            <p>Total de Votos Registrados: <strong>{$total_votos}</strong></p>
            
            <hr>

            <div style="margin-top: 20px;">
                <h3>✅ Voto por el SÍ:</h3>
                <p><strong>{$votos_si}</strong> votos ({$porcentaje_si}%)</p>
                <div class="bar-container">
                    <div class="bar si" style="width: {$porcentaje_si}%;">
                        {$porcentaje_si}%
                    </div>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <h3>❌ Voto por el NO:</h3>
                <p><strong>{$votos_no}</strong> votos ({$porcentaje_no}%)</p>
                <div class="bar-container">
                    <div class="bar no" style="width: {$porcentaje_no}%;">
                        {$porcentaje_no}%
                    </div>
                </div>
            </div>

            <p style="margin-top: 30px;"><a href="index.php?menu=Formulario">Volver al Formulario de Votación</a></p>
        </div>
    </body>
    </html>
HTML;

    return $html;
}
?>