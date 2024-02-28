<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <style>
        .video-container {
            width: 45%; /* Ancho del contenedor de video */
            position: relative;
            display: inline-block;
            vertical-align: top;
        }
        .video {
            width: 100%; /* Ancho del video al 100% del contenedor */
            height: auto; /* Altura automática para mantener la relación de aspecto */
        }
        #video2 {
            transform: scaleX(-1); /* Voltear horizontalmente el video */
            position: absolute; /* Posición absoluta para superponer el segundo video */
            right: 0; /* Alinear el segundo video a la derecha */
            top: 0; /* Alinear el segundo video en la parte superior */
        }
        #canvas {
            display: none;
            width: 100%;
            height: auto;
        }
        #botonCapturar {
            display: block;
            margin: 10px auto;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Aplicación de cámara web</h1>
    <div class="video-container">
        <video class="video" id="video1" autoplay></video>
    </div>
    <div class="video-container">
        <video class="video" id="video2" autoplay></video>
    </div>
    <button id="botonPantallaCompleta">Pantalla Completa</button>
    <button id="botonCapturar">Capturar</button>
    <canvas id="canvas"></canvas>

    <script>
        // Acceder al video stream de la cámara web para el primer video
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                var video1 = document.getElementById('video1');
                video1.srcObject = stream;
                video1.play();
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });

        // Acceder al video stream de la cámara web para el segundo video
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                var video2 = document.getElementById('video2');
                video2.srcObject = stream;
                video2.play();
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });

        // Capturar una imagen de la cámara web
        document.getElementById('botonCapturar').addEventListener('click', function() {
            var video1 = document.getElementById('video1');
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            canvas.width = video1.videoWidth;
            canvas.height = video1.videoHeight;
            context.drawImage(video1, 0, 0, canvas.width, canvas.height);
            
            // Convertir la imagen a Base64 y enviarla al servidor
            var dataURL = canvas.toDataURL();
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'guardar_imagen.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('imagen=' + dataURL);
        });

        // Solicitar pantalla completa al hacer clic en el botón
        document.getElementById('botonPantallaCompleta').addEventListener('click', function() {
            var elem = document.documentElement;
            var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;

            if (requestFullScreen) {
                requestFullScreen.call(elem);
            }
        });
    </script>
</body>
</html>
