<?php 
// Include l'header della pagina
include('includes/header.php');

// Avvia la sessione
session_start();

// Verifica se l'utente è già autenticato come paziente
if(isset($_SESSION['id_paziente'])) {
    // Se l'utente è già autenticato, reindirizza alla dashboard del paziente
    header("Location: ../paziente/dashboard.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Pazienti</title>
</head>
<body>
    <!-- Contenitore principale -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <!-- Titolo -->
                        <h2 class="font-weight-bolder text-center text-success  text-gradient" style="color:#7BAE37">Effettua l'accesso</h2>
                    </div>
                    <div class="card-body">
                        <!-- Box per gli errori -->
                        <div id="error-box" class="alert alert-danger text-white text-center" style="display: none; font-size: 1.15rem;"></div>
                        <!-- Form per il login del paziente -->
                        <form id="login_paziente_form" method="POST" action="javascript:void(0);">

                            <!-- login -->
                            <fieldset>
                                <legend class="text-center">Inserisci i dati</legend>
                                <div class="mb-3">
                                    <label>Email</label>
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
                        <!-- Link per la registrazione -->
                        <a href="registrazione_pazienti.php" style="text-decoration: underline;">Se non sei registrato, clicca qui.</a>
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
    $('#login_paziente_form').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize(); // Serializza i dati del modulo
        // Invia i dati del modulo tramite AJAX
        $.ajax({
            type: 'POST',
            url: 'gestione/loginPaz.php', 
            data: formData, 
            success: function(response){
                var json = JSON.parse(response); 
                var status = json.status; 
                var message = json.message; 
                if (status == 'true') {
                    // Se l'accesso ha successo, reindirizza l'utente alla dashboard del paziente
                    window.location.href = '../paziente/dashboard.php';
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
