<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <title>La liga</title>
</head>
<body>

    <?php include 'connectiondb.php';?>

    <div class="container">
        
        <div class="col">
            <h1><span><img src="https://assets.laliga.com/assets/logos/LL_RGB_h_color/LL_RGB_h_color.png" alt="descripción" width="27px"></span>La Liga</h1>
        </div>

        <div class="col">
            <form action="">
                <input type="text" placeholder="Nombre del club">
                <button class="delete-btn">Buscar <span><img src="https://img.icons8.com/?size=100&id=3HmnX1ym1BDx&format=png&color=FFFFFF" alt="Buscar" width="12px"></span></button>
                <button type="button" class="edit-btn" id="openModal">Agregar</button>
            </form>
            
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Pos</th>
                        <th class="club-cell">Club</th>
                        <th>Pj</th>
                        <th>G</th>
                        <th>E</th>
                        <th>P</th>
                        <th>GF</th>
                        <th>GC</th>
                        <th>DG</th>
                        <th>Points</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableMatches"></tbody>
            </table>
        </div>
    </div>

    <dialog id="addTeamModal">
        
        <h1 class="header">Agregar Equipo</h1>
       
        <div class="col">
            <label for="clubName"><b>Nombre del club:</b></label>
            <input type="text" id="clubName" placeholder="Real Madrid" name="clubName" required>
        </div>

        <div class="col">
            <label for="logoUrl"><b>Logo Url:</b></label>
            <input type="text" id="logoUrl" placeholder="https://img.png" name="logoUrl" required>
        </div>
        
        <div class="footer">
            <button id="closeModal">Cerrar</button>
            <button onclick="addTeam(event)" type="button" class="add">Guardar</button>  
        </div>
        
    </dialog>

    <dialog id="editTeamModal">
        <h1 class="header">Editar Equipo</h1>  

        <input type="hidden" id="editTeamId">

        <div class="col">
            <label for="editClubName"><b>Nombre del club:</b></label>
            <input type="text" id="editClubName" placeholder="Real Madrid" name="editClubName" required>
        </div>

        <div class="col">
            <label for="editLogoUrl"><b>Logo Url:</b></label>
            <input type="text" id="editLogoUrl" placeholder="https://img.png" name="editLogoUrl" required>
        </div>
        
        <div class="col">
            <label for="editPJ"><b>Partidos Jugados:</b></label>
            <input type="text" id="editPJ" placeholder="30" name="editPJ" required>
        </div>

        <div class="col">
            <label for="editW"><b>Ganados:</b></label>
            <input type="text" id="editW" placeholder="20" name="editW" required>
        </div>

        <div class="col">
            <label for="editE"><b>Empatados:</b></label>
            <input type="text" id="editE" placeholder="5" name="editE" required>
        </div>

        <div class="col">
            <label for="editP"><b>Perdidos:</b></label>
            <input type="text" id="editP" placeholder="5" name="editP" required>
        </div>

        <div class="col">
            <label for="editGF"><b>Goles a Favor:</b></label>
            <input type="text" id="editGF" placeholder="60" name="editGF" required>
        </div>

        <div class="col">
            <label for="editGC"><b>Goles en Contra:</b></label>
            <input type="text" id="editGC" placeholder="30" name="editGC" required>
        </div>

        <div class="footer">
            <button id="closeEditModal">Cerrar</button>
            <button type="button" onclick="saveTeamEdits(event)" class="add">Guardar</button>
        </div>
        
    </dialog>
    
    <script src="assets/js/modal.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>