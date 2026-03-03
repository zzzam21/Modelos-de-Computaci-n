<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="assets/styles/styles.css">
    <title>La liga</title>
</head>
<body>
    <div class="content-wrapper" style="background-color: white;">
        
        <section class="content-header">
            <div class="container-fluid">
                <h1><span><img src="assets/img/LaLigaIcon.png" alt="descripción" width="27px"></span><b>Posiciones</b></h1>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
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
        </section>

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
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Posiciones</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Equipos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Partidos</p>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>