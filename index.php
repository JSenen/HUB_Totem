<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <style>
        .video-container {
            width: 90%; /* Ancho del contenedor de video */
            position: relative;
            margin: 0 auto;
            overflow: hidden; /* Ocultar el desbordamiento de los videos */
        }
        .video {
            width: 50%; /* Ancho del video al 50% del contenedor */
            height: 100%; /* Altura del video al 100% del contenedor */
            float: left; /* Alinear los videos uno al lado del otro */
            transform: scaleX(1); /* Restaurar la orientación normal para el primer video */

         
        }
        #video2 {
            transform: scaleX(-1); /* Voltear horizontalmente el segundo video */
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
        
        .video-container {
            border: solid 5px transparent;
            border-radius: 10px;
            background-image: linear-gradient(white, white),
            linear-gradient(315deg,#833ab4,#fdidid 50%,#fcb045);
            background-origin: border-box;
            background-clip: content-box, border-box;
        }
    </style>
</head>
<body>
    <h1>Aplicación de cámara web</h1>
    <div class="video-container">
        <video class="video" id="video1" autoplay></video>
        <video class="video" id="video2" autoplay></video>
    </div>
    <button id="botonPantallaCompleta">Pantalla Completa</button>
    <button id="botonCapturar">Capturar</button>
    <canvas id="canvas" class="gradient-border" ></canvas>

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

        // Capturar una imagen de la cámara web
        // document.getElementById('botonCapturar').addEventListener('click', function() {
        //     var video1 = document.getElementById('video1');
        //     var canvas = document.getElementById('canvas');
        //     var context = canvas.getContext('2d');
        //     canvas.width = video1.videoWidth;
        //     canvas.height = video1.videoHeight;
        //     context.drawImage(video1, 0, 0, canvas.width, canvas.height);
            
        //     // Convertir la imagen a Base64 y enviarla al servidor
        //     var dataURL = canvas.toDataURL();
        //     var xhr = new XMLHttpRequest();
        //     xhr.open('POST', 'guardar_imagen.php', true);
        //     xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        //     xhr.send('imagen=' + dataURL);
        // });
             // Capturar una imagen de la cámara web al hacer clic en el botón
        document.getElementById('botonCapturar').addEventListener('click', function() {
            var video1 = document.getElementById('video1');
            var canvas = document.getElementById('canvas');
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
