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
<!-- Hidden form to submit the image data -->
<form id="imageForm" method="post" action="likephoto.php" style="display: none;">
    <input type="hidden" id="imageData" name="imageData">
</form>
<script>
    /* document.addEventListener('DOMContentLoaded', function() {
        var pantallaCompleta = sessionStorage.getItem('pantallaCompleta');

        if (pantallaCompleta) {
            var elem = document.documentElement;
            var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;

            requestFullScreen.call(elem);
        }
    }); */
    document.addEventListener('DOMContentLoaded', function() {
    // Verificar si la página estaba en modo de pantalla completa antes
    var pantallaCompleta = sessionStorage.getItem('pantallaCompleta');

    if (pantallaCompleta) {
        var elem = document.documentElement;
        var requestFullScreen = elem.requestFullscreen || elem.mozRequestFullScreen || elem.webkitRequestFullscreen || elem.msRequestFullscreen;

        // Solicitar pantalla completa solo si no estamos ya en modo de pantalla completa
        if (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
            requestFullScreen.call(elem);
        }
    }

    // Almacenar el estado de pantalla completa antes de cambiar de página
    window.addEventListener('beforeunload', function() {
        sessionStorage.setItem('pantallaCompleta', document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement);
    });
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
            var video1 = document.getElementById('video1');
            video1.srcObject = stream;
            video1.play();
            // Devolvemos el stream de la primera cámara para usarlo luego
            return stream;
        })
        .catch(function(err) {
            console.error("Error al acceder a la primera cámara: ", err);
        });
}

// Función para obtener la segunda cámara disponible
function obtenerSegundaCamara(streamPrimerCamara) {
    // Enumeramos los dispositivos de video nuevamente para obtener la segunda cámara
    return navigator.mediaDevices.enumerateDevices()
        .then(function(devices) {
            var videoInputDevices = devices.filter(function(device) {
                return device.kind === 'videoinput';
            });

            if (videoInputDevices.length >= 2) {
                var constraints = {
                    video: {
                        deviceId: { exact: videoInputDevices[1].deviceId }
                    }
                };

                return navigator.mediaDevices.getUserMedia(constraints)
                    .then(function(stream) {
                        var video2 = document.getElementById('video2');
                        video2.srcObject = stream;
                        video2.play();
                    })
                    .catch(function(err) {
                        console.error("Error al acceder a la segunda cámara: ", err);
                    });
            } else {
                console.error("No se encontraron suficientes dispositivos de video.");
            }
        })
        .catch(function(err) {
            console.error("Error al enumerar dispositivos: ", err);
        });
}

// Obtener y aplicar las cámaras disponibles al cargar la página
window.addEventListener('load', function() {
    obtenerPrimeraCamara()
        .then(obtenerSegundaCamara)
        .catch(function(err) {
            console.error("Error al obtener las cámaras: ", err);
        });
});

        // Capturar una imagen de la cámara web al hacer clic en el botón
        document.getElementById('botonCamara').addEventListener('click', function() {
        var video1 = document.getElementById('video1');
        var video2 = document.getElementById('video2');
        
        var canvas = document.createElement('canvas');
        var context = canvas.getContext('2d');
        
        canvas.width = video1.videoWidth + video2.videoWidth;
        canvas.height = Math.max(video1.videoHeight, video2.videoHeight);
        
        context.drawImage(video1, 0, 0);
        context.drawImage(video2, video1.videoWidth, 0);
        
        var dataURL = canvas.toDataURL('image/png');
        
        // Set the image data to the hidden input field
        document.getElementById('imageData').value = dataURL;
        
        // Submit the form
        document.getElementById('imageForm').submit();
    });
       
</script>
</body>
</html>