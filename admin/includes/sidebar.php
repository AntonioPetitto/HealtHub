<!-- Barra laterale di navigazione -->
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <!-- Logo e nome -->
        <a class="navbar-brand m-0" href="../home/home.php">
            <img src=".././assets/img/logo.svg" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">HealtHub Admin</span>
        </a>
    </div>
    <!-- Linea orizzontale -->
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <!-- Elementi di navigazione -->
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-home text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Utenti</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'utenti.php') ? 'active' : ''; ?>" href="utenti.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Utenti</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'dipendenti.php') ? 'active' : ''; ?>" href="dipendenti.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-md text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dipendenti</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'pazienti.php') ? 'active' : ''; ?>" href="pazienti.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-injured text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pazienti</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Inserisci Utenti</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'aggiungi_dipendenti.php') ? 'active' : ''; ?>" href="aggiungi_dipendenti.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-md text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dipendenti</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'aggiungi_pazienti.php') ? 'active' : ''; ?>" href="aggiungi_pazienti.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-injured text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pazienti</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Altre informazioni</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'turni.php') ? 'active' : ''; ?>" href="turni.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-alt text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Turni</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'assicurazione.php') ? 'active' : ''; ?>" href="assicurazione.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-file-medical text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">assicurazione</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'farmaci.php') ? 'active' : ''; ?>" href="farmaci.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-syringe text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">farmaci</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Pulsante di logout -->
    <div class="sidenav-footer mx-3">
        <a class="btn logoutbtn bg-gradient-primary mt-3 w-100 text-dark text-lg" href="#!">Logout</a>
    </div>
</aside>

<!-- Script JavaScript per gestire il logout e l'evidenziazione del link attivo -->
<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script>
// Gestione del click sul pulsante di logout
$(document).on('click', '.logoutbtn', function(event) {    
    event.preventDefault();
    // Conferma il logout
    if (confirm("Sei sicuro di voler effettuare il logout?")) {
        // Effettua una richiesta AJAX per eseguire il logout
        $.ajax({
            url: "gestione/logout.php",
            type: "POST",
            success: function(response) {
                // Reindirizza alla pagina di login dopo il logout
                window.location.href = '../home/home.php';
            },
            error: function(xhr, status, error) {
                // Mostra un messaggio di errore in caso di problemi durante il logout
                alert("Si è verificato un errore durante il logout.");
            }
        });
    }
});

// Rileva il percorso del file corrente per evidenziare il link attivo nella barra laterale
var currentPageFile = window.location.pathname.split('/').pop();
var navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(function(link) {
    var linkPath = link.getAttribute('href').split('/').pop();
    // Aggiunge la classe 'active' al link corrente
    if (currentPageFile === linkPath) {
        link.classList.add('active');
    }
});
</script>