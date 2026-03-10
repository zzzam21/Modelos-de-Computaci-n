const tableGamesList = document.getElementById('tableGamesList');
document.addEventListener('DOMContentLoaded', listMatches);

async function listGames() {
    try {
        const response = await fetch("./api/crud_matches.php", { method: "GET" });
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        
        const data = await response.json();
        // Ajustamos para manejar la estructura de datos que devuelve tu PHP
        const games = Array.isArray(data) ? data : (data.datos || []);
        
        if (games.length === 0) {
            tableGamesList.innerHTML = "<tr><td colspan='8' class='text-center'>No hay partidos programados</td></tr>";
            return;
        }

        tableGamesList.innerHTML = "";
        games.forEach(game => {
            // Determinamos el color del badge según el status
            const statusBadge = game.status === 'finalizado' ? 'badge-success' : 'badge-warning';

            tableGamesList.innerHTML += `
            <tr>
                <td class="text-center">${game.match_date}</td>
                <td class="text-right"><strong>${game.name_team1}</strong></td>
                <td class="text-center"><span class="badge badge-dark">${game.goals_team1}</span></td>
                <td class="text-center">vs</td>
                <td class="text-center"><span class="badge badge-dark">${game.goals_team2}</span></td>
                <td class="text-left"><strong>${game.name_team2}</strong></td>
                <td class="text-center"><span class="badge ${statusBadge}">${game.status}</span></td>
                <td class="text-center">
                    <button class="edit-btn" onclick="showGameInfo(${game.id_match})"><i class="bi bi-pencil"></i></button>
                    <button class="delete-btn" onclick="deleteGame(${game.id_match})"><i class="bi bi-trash"></i></button>
                </td>
            </tr>`;
        });
    } catch (error) {
        console.error("Error al listar enfrentamientos:", error);
        tableGamesList.innerHTML = `<tr><td colspan='8' class='text-danger'>Error al cargar datos</td></tr>`;
    }
}

async function addGame(event) {
    event.preventDefault();
    
    const team1 = document.getElementById('selectTeam1').value;
    const team2 = document.getElementById('selectTeam2').value;
    const date = document.getElementById('matchDate').value;

    if(team1 === team2) {
        Swal.fire('Error', 'Un equipo no puede jugar contra sí mismo', 'error');
        return;
    }

    const response = await fetch("./api/crud_matches.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        // Enviamos los nombres de campos que espera el PHP
        body: JSON.stringify({ 
            id_team1: team1, 
            id_team2: team2, 
            match_date: date 
        })
    });

    if (response.ok) {
        await listGames();
        document.getElementById('addMatchModal').close();
        Swal.fire({ icon: 'success', title: 'Partido Programado', timer: 2000, showConfirmButton: false });
    }
}

async function saveGameResults(event) {
    event.preventDefault();
    
    const id = document.getElementById("editMatchId").value;
    const g1 = document.getElementById("editGoals1").value;
    const g2 = document.getElementById("editGoals2").value;

    const response = await fetch("./api/crud_matches.php", {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            id_match: id, // Nombre exacto de tu DB
            goals_team1: g1,
            goals_team2: g2
        })
    });

    if (response.ok) {
        await listGames();
        // Si existe la función en el otro archivo JS, actualizamos la tabla de posiciones
        if (typeof listMatches === "function") listMatches(); 
        
        document.getElementById("editMatchModal").close();
        Swal.fire({ icon: 'success', title: 'Resultado Guardado', timer: 1500, showConfirmButton: false });
    }
}

async function deleteGame(id) {
    const result = await Swal.fire({
        title: '¿Anular partido?',
        text: 'Se eliminará el registro permanentemente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar'
    });

    if (!result.isConfirmed) return;

    const response = await fetch(`./api/crud_matches.php`, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_match: id })
    });

    if (response.ok) {
        await listGames();
        if (typeof listMatches === "function") listMatches(); 
        Swal.fire('Eliminado', 'El partido ha sido quitado', 'success');
    }
}

// Función para llenar los selectores de equipos
async function loadTeamsToSelect() {
    try {
        const response = await fetch("./api/crud.php"); // Usamos tu API de equipos
        const data = await response.json();
        const teams = Array.isArray(data) ? data : data.datos;

        const select1 = document.getElementById('selectTeam1');
        const select2 = document.getElementById('selectTeam2');

        // Limpiamos opciones previas excepto la primera
        select1.innerHTML = '<option value="">Seleccione un equipo...</option>';
        select2.innerHTML = '<option value="">Seleccione un equipo...</option>';

        teams.forEach(team => {
            const option = `<option value="${team.id}">${team.Club}</option>`;
            select1.innerHTML += option;
            select2.innerHTML += option;
        });
    } catch (error) {
        console.error("Error al cargar equipos en el select:", error);
    }
}

async function showGameInfo(id_match) {
    try {
        // Obtenemos los datos del partido específico desde el servidor
        const response = await fetch(`./api/crud_matches.php?id=${id_match}`);
        const game = await response.json();

        if (!response.ok) throw new Error("No se pudo obtener la información del partido");

        // Llenamos los campos ocultos y etiquetas
        document.getElementById("editMatchId").value = game.id_match;
        document.getElementById("labelTeam1").innerText = game.name_team1 || "Local";
        document.getElementById("labelTeam2").innerText = game.name_team2 || "Visitante";
        
        // Ponemos los goles actuales (por si se quiere corregir)
        document.getElementById("editGoals1").value = game.goals_team1;
        document.getElementById("editGoals2").value = game.goals_team2;

        // Abrimos el modal
        document.getElementById("editMatchModal").showModal();
    } catch (error) {
        console.error("Error:", error);
        Swal.fire('Error', 'No se pudo cargar la información del partido', 'error');
    }
}

// Modificamos el evento del botón "Agregar" en la vista de enfrentamientos
document.getElementById('openModalMatch').addEventListener('click', () => {
    loadTeamsToSelect(); // Cargamos los equipos frescos
    document.getElementById('addMatchModal').showModal();
});