document.addEventListener('DOMContentLoaded', function() {
    const animalSounds = document.getElementById('animal-sounds');
    const sound = document.getElementById('sound');

    // Realizar una solicitud AJAX para obtener los datos de los animales desde el servidor
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'server.php', true);
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            const animales = JSON.parse(xhr.responseText);
            animales.forEach(animal => {
                // Crear una imagen para cada animal y asociar el sonido correspondiente
                const img = document.createElement('img');
                img.src = 'img/' + animal.nombre.toLowerCase() + '.jpg';
                img.alt = animal.nombre;
                img.addEventListener('click', function() {
                    sound.src = 'sonidos/' + animal.sonido;
                    sound.play();
                });
                animalSounds.appendChild(img);
            });
        } else {
            console.error('Error al obtener los datos de los animales');
        }
    };
    xhr.send();
});
