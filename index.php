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
            overflow: hidden; /* Evitar desplazamiento de la página */
            position: relative; /* Para establecer posicionamiento absoluto de los botones */
        }
        .video-container {
            display: flex;
            height: 100%;
            width: 100%;
        }
        video {
            height: 100%;
            width: 50%;
            object-fit: cover; /* Escalar el video para cubrir */
        }
        .buttons-container {
            position: fixed; /* Posición fija en la ventana */
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .button-wrapper {
            background-color: white;
            padding: 10px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            width: max-content; /* Ancho ajustado al contenido */
        }
        button {
            padding: 20px 40px;
            background-color: grey;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
        }
        .text-container {
            text-align: center;
            margin-bottom: 20px; /* Ajusta la distancia entre los textos y los botones */
            margin-right: 220px; /* Ajusta la distancia lateral */
        }
        .text-container p {
            margin: 5px 0;
            white-space: nowrap; /* Evitar el ajuste de línea */
        }
        .t1 {
            font-size: 35px;
            font-style: bold;
            
        }
        .t2 {
            font-size: 20px;

        }
        .rounded-buttons {
            position: absolute;
            top: 20px; /* Ajusta la posición vertical */
            right: 20px; /* Ajusta la posición horizontal */
            display: flex;
            flex-direction: row;
            align-items: center;
        }
        .rounded-buttons button {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-top: 10px; /* Espacio entre los botones */
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
            background-color: white;
            color: black;
            cursor: pointer;
            font-size: 20px;
            font-style: bold;
        }
    </style>

</head>
<body>
    <div class="video-container">
        <video id="video1" autoplay></video>
        <video id="video2" autoplay></video>
    </div>
    <div class="buttons-container">
        <div class="button-wrapper">
            <div class="text-container">
                <p class="t1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris </p>
                <p class="t2">Integer semper blandit felis, a mollis quam commodo ac 2</p>
            </div>
            <div>
                <button id="botonPantallaCompleta">Pantalla Completa</button>
                <button id="botonCapturar">Capturar</button>
            </div>
        </div>
    </div>
       <!-- Botones redondos -->
    <div class="rounded-buttons">
        <button id="boton1">Normal</button>
        <button id="boton2">UV</button>
        <button id="boton3">Mixta</button>
    </div>

   <!-- Mostrar en consola los identificadores de las cámaras usadas -->
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
