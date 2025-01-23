<?php 
// e l'header della pagina
include('includes/header.php');

// Avvia la sessione
session_start();

// Verifica se l'utente è già autenticato
if(isset($_SESSION['id_utente']) && isset($_SESSION['ruolo'])) {
    // L'utente è già autenticato, reindirizza alla dashboard appropriata in base al ruolo
    $ruolo = $_SESSION['ruolo']; 
    if($ruolo == 'medico' || $ruolo == 'infermiere') {
        header("Location: ../dipendente/dashboard.php");
    } else if($ruolo == 'admin') {
        header("Location: ../admin/dashboard.php");
    }
    exit(); 
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>HealtHubAreaDip</title>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Pazienti</title>
</head>
<body>
    <style>


    </style>
    <!-- Contenitore principale -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <!-- Titolo -->
                        <h2 class="font-weight-bolder text-center text-success  text-gradient" style="color:#7BAE37">Effettua l'accesso come dipendente</h2>
                    </div>
                    <div class="card-body">
                        <!-- Box per gli errori -->
                        <div id="error-box" class="alert alert-danger text-white text-center" style="display: none; font-size: 1.15rem;"></div>
                        <!-- Form per il login del dipendente -->
                        <form id="login_dipendente_form" method="POST" action="javascript:void(0);">

                            <!-- login -->
                            <fieldset>
                                <legend class="text-center">Inserisci i dati</legend>
                                <div class="mb-3">
                                    <label>Email istituzionale</label>
                                    <input type="email" id="EmailCampo" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" id="PasswordCampo" name="password" class="form-control" required>
                                </div>
                            </fieldset>

                            <!-- Bottone per l'invio del form -->
                            <div class="container mt-3">
                                <div class="card-body text-center">
                                    <button type="submit" class="btn bg-gradient-success text-dark text-lg">Accedi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Include jQuery -->
<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>

<script>
$(document).ready(function(){
    // Quando il modulo di accesso viene inviato
    $('#login_dipendente_form').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize(); // Serializza i dati del modulo
        // Invia i dati del modulo tramite AJAX
        $.ajax({
            type: 'POST',
            url: 'gestione/loginDip.php', 
            data: formData, 
            success: function(response){
                var json = JSON.parse(response); 
                var status = json.status; 
                var ruolo = json.ruolo; 
                var message = json.message; 
                if (status == 'true') {
                    // Se l'accesso ha successo, reindirizza l'utente alla dashboard appropriata
                    if (ruolo=='medico' || ruolo=='infermiere') {
                        window.location.href = '../dipendente/dashboard.php';
                    } else if(ruolo=='admin') {
                        window.location.href = '../admin/dashboard.php';
                    }
                } else {
                    // Se ci sono errori, mostra il messaggio di errore
                    $('#error-box').text(message).show();
                }
            },
            error: function(xhr, status, error){
                // Gestisce gli errori durante la richiesta AJAX
                alert("Errore durante l'inserimento");
            }
        });
    });
});
</script>
</body>
</html>
