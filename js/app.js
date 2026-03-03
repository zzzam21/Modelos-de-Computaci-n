const tableMatches = document.getElementById('tableMatches');

async function listMatches() {
    try {
        const response = await fetch("./API/crud.php", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        });
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        const data = await response.json();
        
        
        const matches = Array.isArray(data) ? data : data.datos;
        
        if (!matches || matches.length === 0) {
            tableMatches.innerHTML = "<tr><td colspan='11'>No hay datos</td></tr>";
            return;
        }
         
        var $i = 1;
        tableMatches.innerHTML = "";

        matches.forEach(match => {
            tableMatches.innerHTML += `
            <tr>
                <td>${$i++}</td>
                <td class="club-cell"><img src="${match.logo}" alt="" width="15px"> ${match.Club}</td>
                <td>${match.played_games}</td>
                <td>${match.wins}</td>
                <td>${match.draws}</td>
                <td>${match.lost}</td>
                <td>${match.goals_in_favor}</td>
                <td>${match.goals_against}</td>
                <td>${match.goals_diference}</td>
                <td>${match.points}</td>
                <td class="actions">
                    <button class="edit-btn" onclick="showTeamInfo(${match.id})">Editar</button>
                    <button class="delete-btn" onclick="deleteTeam(${match.id})">Eliminar</button>
                </td>
            </tr>
            `
        });
    } catch (error) {
        console.error("Error al traer datos:", error);
        tableMatches.innerHTML = `<tr><td colspan='11'>Error: ${error.message}</td></tr>`;
    }
}

async function addTeam(event) {
    event.preventDefault();
    
    const clubName = document.getElementById('clubName').value;
    const logoUrl = document.getElementById('logoUrl').value;

    const response = await fetch("./API/crud.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"},
        body: JSON.stringify({
            clubName: clubName,
            logoUrl: logoUrl})
    });
    

    const data = await response.json();
    
    if (!response.ok) {
        console.error("Error del servidor:", data);
        throw new Error(data.error || "Error desconocido");
    }
    await listMatches();

    document.getElementById('clubName').value = "";
    document.getElementById('logoUrl').value = "";
    document.getElementById('addTeamModal').close();

    await Swal.fire({
        icon: 'success',
        title: 'Actualizado',
        text: 'Equipo agregado correctamente',
        timer: 2000,
        showConfirmButton: false
    });
}

async function deleteTeam(id) {

    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: 'Este equipo será eliminado permanentemente',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (!result.isConfirmed) return;

    const response = await fetch(`./API/crud.php`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: id })
    });

    const data = await response.json();

    if (!response.ok) {
        console.error("Error del servidor:", data);
        throw new Error(data.error || "Error desconocido");
    }
    await listMatches();

}

async function saveTeamEdits(event) {
    event.preventDefault();
    
    const id = document.getElementById("editTeamId").value;
    const clubName = document.getElementById("editClubName").value;
    const logo = document.getElementById("editLogoUrl").value;
    const pj = document.getElementById("editPJ").value;
    const w = document.getElementById("editW").value;
    const e = document.getElementById("editE").value;
    const p = document.getElementById("editP").value;
    const gf = document.getElementById("editGF").value;
    const gc = document.getElementById("editGC").value;
    const dg = parseInt(gf) - parseInt(gc);
    const points = parseInt(w) * 3 + parseInt(e);

    if (w + e + p < pj) {
        cleanInputFields();
        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'La cantidad de partidos jugados no puede ser menor que la suma de ganados, empatados y perdidos.',
            showConfirmButton: true
        });
        return;
    }

    const response = await fetch("./API/crud.php", {
        method: "PUT",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id: id,
            clubName: clubName,
            logoUrl: logo,
            played_games: pj,
            wins: w,
            draws: e,
            lost: p,
            goals_in_favor: gf,
            goals_against: gc,
            goals_diference: dg,
            points: points
        })
    });

    const data = await response.json();

    if (!response.ok) {
        console.error("Error del servidor:", data);
        throw new Error(data.error || "Error desconocido");
    }

    await listMatches();
    
    cleanInputFields();

    await Swal.fire({
        icon: 'success',
        title: 'Actualizado',
        text: 'Equipo actualizado correctamente',
        timer: 1500,
        showConfirmButton: false
    });

}

async function showTeamInfo(id){
    const data = await getTeam(id);

    const editTeamId = document.getElementById("editTeamId");
    const editClubName = document.getElementById("editClubName")
    const editLogoUrl = document.getElementById("editLogoUrl")
    const editPJ = document.getElementById("editPJ")
    const editG = document.getElementById("editW")
    const editE = document.getElementById("editE")
    const editP = document.getElementById("editP")
    const editGF = document.getElementById("editGF")
    const editGC = document.getElementById("editGC")

    editTeamId.value = id;
    editClubName.value = data.Club;
    editLogoUrl.value = data.logo;
    editPJ.value = data.played_games;
    editG.value = data.wins;
    editE.value = data.draws;
    editP.value = data.lost;
    editGF.value = data.goals_in_favor;
    editGC.value = data.goals_against;

    document.getElementById("editTeamModal").showModal();
}

async function getTeam(id) {
    const response = await fetch(`./API/crud.php?id=${id}`, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        }
    });

    const data = await response.json();

    if (!response.ok) {
        console.error("Error del servidor:", data);
        throw new Error(data.error || "Error")
    }

    return data;
}

async function cleanInputFields() {
    document.getElementById("editTeamId").value = '';
    document.getElementById("editClubName").value = '';
    document.getElementById("editLogoUrl").value = '';
    document.getElementById("editPJ").value = '';
    document.getElementById("editW").value = '';
    document.getElementById("editE").value = '';
    document.getElementById("editP").value = '';
    document.getElementById("editGF").value = '';
    document.getElementById("editGC").value = '';
    document.getElementById("editTeamModal").close();
}
// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', listMatches);