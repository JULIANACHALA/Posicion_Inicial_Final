<!DOCTYPE html>
<html lang="en">
    <head>
       
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link rel="stylesheet" type="text/css" href="styles.css">
       <title>Posicion Inicial y Final</title>
       <meta charset="UTF-8">
        <style>
            
            td {
                
                width: 25px;
                height: 25px;
                text-align: center;
                
            }
            
            .primerArray {
                color: red;
                
            }
            
            .segundoArray {
                color: blue;
            }
            
            .indice {
                color: black;
            }
            
        </style>
    </head>
    <body>
    <div class="container">

     <div class="from-content">
     <h1 id="title">Posicion Inicial y Final</h1>
        
        <form action="index.php" method="post">
            Posicion Inicial: <input type="number" name="posicionInicial" min="0" max="9" placeholder="0" autofocus><br>
            Posicion Final: <input type="number" name="posicionFinal" min="0" max="9" placeholder="9"><br>
            <input type="submit" name="submit" id="enviar" value="Enviar"><br>
            
            <?php
            
            $numero; // Variable numero para el array
            $numero2; // Variable para el segundo array
            $posicionInicial; // Variable para la posicion Inicial
            $posicionFinal; // Variable para la posicion Final
            $numeroTexto = ""; // Variable auxiliar para luego explotar en un array
            $arrayLength = 10; // Variable para la longitud del array
            
            // Si es la primera vez que entramos
            if (!isset($_POST['submit'])) {
                // Inicializa el array con valores aleatorios
                for ($i = 0; $i < $arrayLength; $i++) {
                    // Asignamos valor aleatorio a la posicion actual del array
                    $numero[$i] = rand(0, 50);
                    // Asignamos el numero y un espacio a la variable tipo string 
                    $numeroTexto .= $numero[$i];
                    $numeroTexto .= " ";
                }
                // Mandamos numeroTexto en un hidden
                echo '<input type="hidden" name="numeroTexto" value="', $numeroTexto,'">';
            }
            ?>
            
        </form>
        
        <?php
            // Salto de linea
            echo '<br>';
        
        // Si hemos enviado el formulario 
        if (isset($_POST['submit'])) {
            
            // Desactivar el boton submit  (cambiar enviar por la ID correspondiente)
            echo '<script>document.getElementById("enviar").disabled=true</script>';

            // Boton de recargar pagina
            echo '<button onclick ="document.location.href = document.location.href;">Recargar</button><br>';
            
            // Recogemos el string para luego explotarlo
            $numeroTexto = $_POST['numeroTexto'];
            
            // Recogemos el valor del campo posicionInicial
            $posicionInicial = $_POST['posicionInicial'];
            // Si se ha mandado vacio lo asignamos como 0
            if($posicionInicial == "") {
                $posicionInicial = 0;
            }
            
            // Recogemos el valor del campo PosicionFinal
            $posicionFinal = $_POST['posicionFinal'];
            // Si se ha mandado vacio lo asignamos como 9
            if ($posicionFinal == "") {
                $posicionFinal = 9;
            }
            
            // Hacemos un substr para quitar el espacio final indeseado del string
            $numeroTexto = substr($numeroTexto, 0, -1);
            
            // Explotamos el string para convertirlo en array
            $numero = explode(" ", $numeroTexto);
            
            // Primera parte del programa, mueve los numeros 1 lugar hacia la derecha
            // desde la ultima posicion hasta posicionInicial
            for ($i = 0; $i <= $posicionInicial; $i++) {
                // Si la posicion es 0
                if ($i == 0) {
                    // A la posicion 0 le asignamos la ultima posicion (arraylength - 1)
                    $numero2[$i] = $numero[($arrayLength - 1)]; 
                } else {
                    // Para el resto de numeros asignamos al nuevo array la posicion
                    // del numero anterior del primer array
                    $numero2[$i] = $numero[($i - 1)];
                }
            }
            
            // Copia los valores tal cual de las posiciones intermedias entre
            // posicionInicial y posicionFinal
            for ($i = ($posicionInicial + 1); $i < $posicionFinal; $i++) {
                $numero2[$i] = $numero[$i];
            }
            
            // Asignamos los valores al segundo array desde posicionFinal hasta el final
            // del array
            for ($i = $posicionFinal; $i < $arrayLength; $i++) {
                // Si estamos en la posicion final
                if ($i == $posicionFinal) {
                    // En la posicionFinal asignamos el numero de la posicionInicial del otro array
                    $numero2[$i] = $numero[$posicionInicial];
                    
                } else {
                    // Para el resto de numeros los copiamos desplazados 1 posicion
                    $numero2[$i] = $numero[($i - 1)];
                }
            }  
        } // Fin del if
        
        ?>
        
        <table border="1">
            <tr>
                <?php
                // Pintamos el Indice
                for ($i = 0; $i < $arrayLength; $i++) {
                    echo '<td class="indice">', $i, '</td>';
                }
                ?>
            </tr>
            
            <tr>
                <?php
                // Pintamos el Array original
                for ($i = 0; $i < $arrayLength; $i++) {
                    echo '<td class="primerArray">', $numero[$i], '</td>';
                }
                ?>
            </tr>
            <tr>
                <?php
                // Pintamos el array modificado
                if (isset($_POST['submit'])) {
                    for ($i = 0; $i < $arrayLength; $i++) {
                        echo '<td class="segundoArray">', $numero2[$i] , '</td>';
                    }
                }
                ?>
            </tr>
        
        </table>
       </div>
        
     </div>
     
    <script src="script.js"></script>
    </body>
</html>