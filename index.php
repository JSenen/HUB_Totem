<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0; /* Color de fondo */
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        .video-container {
            position: relative;
            width: 90%;
            /*max-width: 800px;*/
            border-radius: 10px; /* Bordes redondeados */
            overflow: hidden; /* Ocultar cualquier desbordamiento */
            margin-bottom: 20px; /* Espacio inferior para los botones */
            border: 10px solid transparent; /* Borde transparente */
            background-image: linear-gradient(315deg, #833ab4, #fd1d1d 50%, #fcb045); /* Gradiente en el borde */
            background-origin: border-box; /* La imagen de fondo comienza en el borde */
            
        }
        .video {
            width: 50%;
            height: auto;
            float: left;
        }
        .buttons-container {
            text-align: center;
        }
        button {
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="video-container">
            <video class="video" id="video1" autoplay></video>
            <video class="video" id="video2" autoplay></video>
        </div>
        <div class="buttons-container">
            <button id="botonPantallaCompleta">Pantalla Completa</button>
            <button id="botonCapturar">Capturar</button>
        </div>
    </div>

    <!-- Mostrar en consola los identificadores de las camaras usadas -->
    <script>
        navigator.mediaDevices.enumerateDevices()
            .then(function(devices) {
                devices.forEach(function(device) {
                    if (device.kind === 'videoinput') {
                        console.log('Dispositivo de video encontrado:', device.label, 'ID:', device.deviceId);
                    }
                });
            })
            .catch(function(err) {
                console.error('Error al enumerar dispositivos:', err);
            });
    </script>
    
    <script>
        // Acceder al video stream de la primera cámara USB
        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: 'wm8IYg6l5Wi7xZHA2VdxbvjKrpeUgZUfcGyd/KqrIbk=' } } })
            .then(function(stream) {
                var video1 = document.getElementById('video1');
                video1.srcObject = stream;
                video1.play();
            })
            .catch(function(err) {
                console.log("Error al acceder a la primera cámara: " + err);
            });

        // Acceder al video stream de la segunda cámara USB
        navigator.mediaDevices.getUserMedia({ video: { deviceId: { exact: 'Wa6epbQOMpOyErawWcpTmRZj2wXndy4zoK/Br1U4cMk=' } } })
            .then(function(stream) {
                var video2 = document.getElementById('video2');
                video2.srcObject = stream;
                video2.play();
            })
            .catch(function(err) {
                console.log("Error al acceder a la segunda cámara: " + err);
            });

        // Capturar una imagen de la cámara web al hacer clic en el botón
        document.getElementById('botonCapturar').addEventListener('click', function() {
            var video1 = document.getElementById('video1');
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.width = video1.videoWidth * 2; // Ancho del canvas igual a la suma de los anchos de los videos
            canvas.height = video1.videoHeight;
            context.drawImage(video1, 0, 0, video1.videoWidth, video1.videoHeight); // Dibujar el primer video
            context.drawImage(video2, video1.videoWidth, 0, video1.videoWidth, video1.videoHeight); // Dibujar el segundo video
            var dataURL = canvas.toDataURL('image/png'); // Convertir el contenido del canvas a una imagen PNG
            // Descargar la imagen
            var link = document.createElement('a');
            link.href = dataURL;
            link.download = 'captura_camara.png';
            link.click();
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
