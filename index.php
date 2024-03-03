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
    <div class="buttons-container">
        <div class="button-wrapper">
            <div class="text-container">
                <p class="t1">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris </p>
                <p class="t2">Integer semper blandit felis, a mollis quam commodo ac 2</p>
            </div>
<!---
            <div>
                <button id="botonCapturar">Capturar</button>
            </div>
-->
            <div>
                <button id="botonEmpezar" onclick="window.location.href='takephoto.php'" style="font-size: 30px;">Empezar</button>
            </div>

        </div>
    </div>
    <!-- Botón de pantalla completa -->
<div id="botonPantallaCompleta" class="fullscreen-button" onclick="toggleFullScreen()">
    <i class="fas fa-expand"></i> <!-- Ícono de pantalla completa -->
</div>

<script>
    function toggleFullScreen() {
        var elem = document.documentElement;

        var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;
        var exitFullScreen = document.exitFullscreen || document.mozCancelFullScreen || document.webkitExitFullscreen || document.msExitFullscreen;

        if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
            requestFullScreen.call(elem);
        } else {
            exitFullScreen.call(document);
        }
    }
    // Almacenar el estado de pantalla completa antes de cambiar de página
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('pantallaCompleta', document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement);
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
        /* // Capturar una imagen de la cámara web al hacer clic en el botón
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
        });*/
        
        
    </script>
</body>
</html>
