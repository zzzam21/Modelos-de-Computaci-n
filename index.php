<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <title>La liga</title>
</head>
<body>
    <div class="content-wrapper" style="background-color: white;">
        
        <section class="content-header">
            <div class="container-fluid">
                
                <h1 id="titleContent"><span><img src="assets/img/LaLigaIcon.png" alt="descripción" width="27px"></span><b>Posiciones</b></h1>
            </div>
        </section>

        <section class="content">
            <div class="content-view" id="view-positions">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="col">
                                <form action="">
                                    <input type="text" placeholder="Nombre del club">
                                    <button class="delete-btn">Buscar <span><i class="bi bi-search"></i></span></button>
                                    <button type="button" class="edit-btn" id="openModal">Agregar <i class="bi bi-plus"></i></button>
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
                                            <th>Puntos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableMatches"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-view" id="view-matches" style="display: none;">
                <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="col">
                            <form action="">
                                <button type="button" class="edit-btn" id="openModalMatch">Programar Partido <i class="bi bi-calendar-plus"></i></button>
                            </form>
                        </div>

                        <div class="table">
                            <table class="table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-right">Equipo 1</th>
                                        <th class="text-center">Goles</th>
                                        <th class="text-center">vs</th>
                                        <th class="text-center">Goles</th>
                                        <th class="text-left">Equipo 2</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tableGamesList">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>


    <!-- Modals matches -->
    <!-- Añadir enfrentamiento -->
    <dialog id="addMatchModal">
        <h1 class="header">Programar Nuevo Encuentro</h1>

        <form id="formAddMatch" onsubmit="addGame(event)">
            <div class="col">
                <label for="selectTeam1"><b>Equipo Local:</b></label>
                <select id="selectTeam1" name="team1" required class="form-control">
                    <option value="">Seleccione un equipo...</option>
                    </select>
            </div>

            <div class="text-center my-2">
                <span class="badge badge-secondary">VS</span>
            </div>

            <div class="col">
                <label for="selectTeam2"><b>Equipo Visitante:</b></label>
                <select id="selectTeam2" name="team2" required class="form-control">
                    <option value="">Seleccione un equipo...</option>
                    </select>
            </div>

            <div class="col" style="margin-top: 15px;">
                <label for="matchDate"><b>Fecha del Partido:</b></label>
                <input type="date" id="matchDate" name="matchDate" required>
            </div>

            <div class="footer">
                <button type="button" onclick="document.getElementById('addMatchModal').close()" class="btn-secondary">Cancelar</button>
                <button type="submit" class="add">Programar Partido</button>
            </div>
        </form>
    </dialog>
    <!-- Editar enfrentamiento -->
    <dialog id="editMatchModal">
        <h1 class="header">Registrar Resultado</h1>

        <form id="formEditMatch" onsubmit="saveGameResults(event)">
            <input type="hidden" id="editMatchId">
            
            <div class="score-container" style="display: flex; align-items: center; justify-content: space-around; padding: 20px;">
                <div class="team-label text-center">
                    <p id="labelTeam1" style="font-weight: bold;"></p>
                    <input type="number" id="editGoals1" min="0" required class="form-control" style="width: 80px; text-align: center; font-size: 1.5rem;">
                </div>

                <div style="font-size: 2rem; font-weight: bold;">-</div>

                <div class="team-label text-center">
                    <p id="labelTeam2" style="font-weight: bold;"></p>
                    <input type="number" id="editGoals2" min="0" required class="form-control" style="width: 80px; text-align: center; font-size: 1.5rem;">
                </div>
            </div>

            <div class="footer">
                <button type="button" onclick="document.getElementById('editMatchModal').close()" class="btn-secondary">Cerrar</button>
                <button type="submit" class="add">Finalizar Partido</button>
            </div>
        </form>
    </dialog>

    <!-- Modals view-position -->
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

        <div class="footer">
            <button id="closeEditModal">Cerrar</button>
            <button type="button" onclick="saveTeamEdits(event)" class="add">Guardar</button>
        </div>
    </dialog>
    
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="https://www.laliga.com/laliga-easports/clasificacion" class="brand-link">
            <img src="assets/img/LaLigaIconWhite.png" class="brand-image" alt="" width="20px">
            <span class="brand-text font-weight-bold"><b>La Liga</b></span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="#" class="nav-link btn-navegar active" data-target="view-positions">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Posiciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link btn-navegar" data-target="view-matches">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Enfrentamientos</p>
                    </a>
                </li>
            </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>


    <script src="assets/js/modal.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/views.js"></script>
    <script src="assets/js/matches.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>