<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <a class="navbar-brand m-0" href="../home/home.php">
            <img src=".././assets/img/logo.svg" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">HealtHub Dipedente</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-home text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Visite</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'visite_corso.php') ? 'active' : ''; ?>" href="visite_corso.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user-injured text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Visite in corso</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'visite_svolte.php') ? 'active' : ''; ?>" href="visite_svolte.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-user text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Visite fatte</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Altre informazioni</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'turni.php') ? 'active' : ''; ?>" href="turni.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa fa-calendar text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Turni</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?php echo ($currentPageFile === 'farmaci.php') ? 'active' : ''; ?>" href="farmaci.php">
                    <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-syringe text-dark text-lg"></i>
                    </div>
                    <span class="nav-link-text ms-1">Farmaci disponibili</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3">
    <a class="btn logoutbtn bg-gradient-primary mt-3 w-100 text-dark text-lg" href="#!">Logout</a>
    </div>
</aside>

<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script>
$(document).on('click', '.logoutbtn', function(event) {    
    event.preventDefault();
    if (confirm("Sei sicuro di voler effettuare il logout?")) {
        $.ajax({
            url: "gestione/logout.php",
            type: "POST",
            success: function(response) {
                // Se il logout è avvenuto con successo, reindirizza alla pagina di login
                window.location.href = '../home/home.php';
            },
            error: function(xhr, status, error) {
                // In caso di errore durante la richiesta AJAX, mostra un messaggio di errore
                alert("Si è verificato un errore durante il logout.");
            }
        });
    }
});

    var currentPageFile = window.location.pathname.split('/').pop();
    var navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(function(link) {
        var linkPath = link.getAttribute('href').split('/').pop();
        if (currentPageFile === linkPath) {
            link.classList.add('active');
        }
    });
</script>

