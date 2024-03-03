<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <!-- Link CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .container {
            display: flex; /* Utilizar el modelo de caja flexible */
        }

        .rectangulo {
            position: relative; /* Cambiado a relativo */
            width: 400px; /* Ancho del rectángulo */
            height: 600px; /* Altura del rectángulo */
            background-color: #f0f0f0; /* Color de fondo del rectángulo frontal */
            border-radius: 20px; /* Bordes redondeados del rectángulo frontal */
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 1); /* Sombra para dar volumen */
            z-index: 1; /* Asegurar que esté delante de la sombra */
            transform: rotate(-13deg); /* Inclinar el rectángulo hacia la derecha */
        }

        .photo {
            width: 100%; /* Ancho de la imagen */
            height: 100%; /* Altura de la imagen */
            object-fit: cover; /* Ajustar la imagen para cubrir el contenedor sin deformación */
        }

        .sidebar {
            padding: 20px; /* Espaciado interno */
        }

        .textos {
            margin-bottom: 20px; /* Margen inferior */
            text-align: center; 
        }

        .boton {
            margin-right: 10px; /* Margen derecho */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="rectangulo">
            <?php
                $imageData = isset($_POST['imageData']) ? $_POST['imageData'] : '';
                if ($imageData) {
                    echo '<img class="photo" src="' . $imageData . '" alt="Foto compuesta">';
                }
            ?>
        </div>
        <div class="sidebar">
            <div class="textos">
                <p>Texto superior</p>
                <p>Texto inferior</p>
            </div>
            <button class="boton">Botón 1</button>
            <button class="boton">Botón 2</button>
        </div>
    </div>
</body>
</html>