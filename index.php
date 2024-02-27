<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <style>
        #video {
            width: 50%;
            height: auto;
        }
        #canvas {
            display: none;
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
    <video id="video" autoplay></video>
    <button id="botonCapturar">Capturar</button>
    <canvas id="canvas"></canvas>

    <script>
        // Acceder al video stream de la cámara web
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                var video = document.getElementById('video');
                video.srcObject = stream;
                video.play();
            })
            .catch(function(err) {
                console.log("Error: " + err);
            });

        // Capturar una imagen de la cámara web
        document.getElementById('botonCapturar').addEventListener('click', function() {
            var video = document.getElementById('video');
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convertir la imagen a Base64 y enviarla al servidor
            var dataURL = canvas.toDataURL();
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'guardar_imagen.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('imagen=' + dataURL);
        });
    </script>

<script>
        // Solicitar pantalla completa al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            var elem = document.documentElement; // El elemento HTML
            var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;

            if (requestFullScreen) {
                requestFullScreen.call(elem);
            }

           // Ocultar la barra de herramientas
           document.addEventListener('mousemove', function() {
                hideToolbar();
            });

            function hideToolbar() {
                var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
                                     (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
                                     (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
                                     (document.msFullscreenElement && document.msFullscreenElement !== null);

                if (isInFullScreen) {
                    document.querySelector('.toolbar').style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>