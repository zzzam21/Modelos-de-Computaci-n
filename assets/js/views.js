document.addEventListener('DOMContentLoaded', () => {
    
    // Seleccionamos todos los botones de navegación
    const navButtons = document.querySelectorAll('.btn-navegar');
    // Seleccionamos todas las secciones de contenido
    const views = document.querySelectorAll('.content-view');

    navButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const targetId = button.getAttribute('data-target');
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                // 1. Ocultar todas las vistas
                views.forEach(view => {
                    view.style.display = 'none';
                });

                // 2. Mostrar la vista seleccionada
                targetElement.style.display = 'block';

                // 3. Gestionar clase 'active' en el menú
                navButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');

                // 4. Lógica específica por sección
                if (targetId === 'view-positions') {
                    document.getElementById('titleContent').innerHTML = '<span><img src="assets/img/LaLigaIcon.png" alt="descripción" width="27px"></span><b>Posiciones</b>';
                    listMatches();
                }else{
                    document.getElementById('titleContent').innerHTML = '<span><img src="assets/img/LaLigaIcon.png" alt="descripción" width="27px"></span><b>Enfrentamientos</b>';
                    listGames();
                }
            }
        });
    });
});