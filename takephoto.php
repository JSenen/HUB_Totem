<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Aplicación de cámara web</title>
    <!-- Link CSS -->
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="video-container">
        <video id="video1" autoplay></video>
        <video id="video2" autoplay></video>
        
</div>
<!-- Boton captura foto -->
<div class="container-photo">
   
    <button id="botonCamara" class="rounded-button">
            <i class="fas fa-camera"></i>
            </button>
</div>
   <!-- Botones redondos -->
   <div class="rounded-buttons">
        <button id="boton1">Normal</button>
        <button id="boton2">UV</button>
        <button id="boton3">Mixta</button>
    </div>
    
    
    
    
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var pantallaCompleta = sessionStorage.getItem('pantallaCompleta');

        if (pantallaCompleta) {
            var elem = document.documentElement;
            var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;

            requestFullScreen.call(elem);
        }
    });
</script>
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
// Función para obtener la primera cámara disponible 
        function obtenerPrimeraCamara() {
            return navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    var video = document.getElementById('video1');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.error("Error al acceder a la primera cámara: ", err);
                });
        }

        // Función para obtener la segunda cámara disponible
        function obtenerSegundaCamara() {
            return navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    var video = document.getElementById('video2');
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.error("Error al acceder a la segunda cámara: ", err);
                });
        }
        // Obtener y aplicar las cámaras disponibles al cargar la página
        window.addEventListener('load', function() {
            navigator.mediaDevices.enumerateDevices()
                .then(function(devices) {
                    devices.forEach(function(device) {
                        if (device.kind === 'videoinput') {
                            if (!document.getElementById('video1').srcObject) {
                                obtenerPrimeraCamara();
                            } else if (!document.getElementById('video2').srcObject) {
                                obtenerSegundaCamara();
                            }
                        }
                    });
                })
                .catch(function(err) {
                    console.error('Error al enumerar dispositivos:', err);
                });
        });

         // Capturar una imagen de la cámara web al hacer clic en el botón
         document.getElementById('botonCamara').addEventListener('click', function() {
            var video1 = document.getElementById('video1');
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.width = video1.videoWidth * 2; // Ancho del canvas igual a la suma de los anchos de los videos
            canvas.height = video1.videoHeight;
            context.drawImage(video1, 0, 0, video1.videoWidth / 2, video1.videoHeight, 0, 0, video1.videoWidth / 2, video1.videoHeight); // Dibujar solo la mitad izquierda del primer video
            context.drawImage(video2, 0, 0, video1.videoWidth / 2, video1.videoHeight, video1.videoWidth / 2, 0, video1.videoWidth / 2, video1.videoHeight); // Dibujar solo la mitad derecha del segundo video
            var dataURL = canvas.toDataURL('image/png'); // Convertir el contenido del canvas a una imagen PNG
            // Descargar la imagen
            var link = document.createElement('a');
            link.href = dataURL;
            link.download = 'captura_camara.png';
            link.click();
        });
    </script>

</body>
</html>