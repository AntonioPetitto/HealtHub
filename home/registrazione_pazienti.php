<!-- Include l'header della pagina -->
<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
</head>
<body>
    <!-- Contenitore principale -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <!-- Titolo -->
                        <h2 id="registrazione" class="font-weight-bolder text-center text-success  text-gradient" style="color:#7BAE37">Effettua la registrazione</h2>
                    </div>
                    <div class="card-body">
                        <!-- Box per gli errori -->
                        <div id="error-box" class="alert alert-danger text-white text-center" style="display: none; font-size: 1.15rem;"></div>
                        <!-- Form per la registrazione del paziente -->
                        <form id="registrazione_paziente_form" method="POST" action="javascript:void(0);">

                             <!-- Credenziali -->
                            <fieldset>
                                <legend class="text-center">Credenziali</legend>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" id="EmailCampo" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" id="PasswordCampo" name="password" class="form-control" required>
                                </div>
                            </fieldset>

                            <!-- Anagrafica -->
                            <fieldset>
                                <legend class="text-center">Anagrafica</legend>
                                <div class="mb-3">
                                    <label>Nome</label>
                                    <input type="text" id="NomeCampo" name="nome" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Cognome</label>
                                    <input type="text" id="CognomeCampo" name="cognome" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Codice fiscale</label>
                                    <input type="text" id="CodicefiscaleCampo" name="codice_fiscale" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>CIE</label>
                                    <input type="text" id="CieCampo" name="cie" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Data di nascita</label>
                                    <input type="date" id="DataNascitaCampo" name="data_nascita" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Sesso</label><br>
                                        <input type="radio" id="SessoMaschioCampo" name="sesso" value="M" required>Maschio
                                        <input type="radio" id="SessoFemminaCampo" name="sesso" value="F" required>Femmina
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label>Nazionalità</label>
                                    <input type="text" id="NazionalitaCampo" name="nazionalita" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Città</label>
                                    <input type="text" id="CittàCampo" name="città" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Indirizzo</label>
                                    <input type="text" id="IndirizzoCampo" name="indirizzo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Telefono</label>
                                    <input type="number" id="TelefonoCampo"  name="telefono" class="form-control" required>
                                </div>
                            </fieldset>

                            <!-- Assicurazione -->
                            <fieldset>
                                <legend class="text-center">Assicurazione</legend>
                                <div class="mb-3">
                                    <label>Possiede l'assicurazione</label><br>
                                        <input type="radio" name="assicurazione" id="possesso1" value="si" required onclick="abilitaCampi()">Si
                                        <input type="radio" name="assicurazione" id="possesso2" value="no" required onclick="abilitaCampi()">No
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label>Numero polizza</label>
                                    <input type="text" id="NumeroPolizzaCampo" name="numero_polizza" class="form-control" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>tipo</label>
                                    <input type="text" id="TipoCampo" name="tipo" class="form-control" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>Data Scadenza</label>
                                    <input type="date" id="DataScadenzaCampo" name="data_scadenza" class="form-control" disabled>
                                </div>
                                <div class="mb-3">
                                    <label>Compagnia</label>
                                    <select id="CompagniaCampo" name="compagnia" class="form-control" disabled>
                                        <option value="">Seleziona compagnia</option>
                                        <option value="1">StaySafe</option>
                                        <option value="2">HealthCare</option>
                                        <option value="3">SafeShield</option>
                                    </select>
                                </div>
                            </fieldset>
                            
                            <!-- Bottone per l'invio del form -->
                            <div class="container mt-3">
                                <div class="card-body text-center">
                                    <button type="submit" class="btn bg-gradient-success text-dark text-lg">Registrati</button>
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
// Funzione per abilitare/disabilitare i campi relativi all'assicurazione
function abilitaCampi() {
    var possesso1 = document.getElementById('possesso1'); 
    var NumeroPolizzaCampo = document.getElementById('NumeroPolizzaCampo');
    var TipoCampo = document.getElementById('TipoCampo');
    var DataScadenzaCampo = document.getElementById('DataScadenzaCampo'); 
    var CompagniaCampo = document.getElementById('CompagniaCampo'); 

    // Abilita o disabilita i campi in base alla selezione dell'opzione "Si" o "No"
    if (possesso1.checked) {
        NumeroPolizzaCampo.disabled = false; 
        TipoCampo.disabled = false; 
        DataScadenzaCampo.disabled = false; 
        CompagniaCampo.disabled = false; 
    } else {
        NumeroPolizzaCampo.disabled = true; 
        TipoCampo.disabled = true; 
        DataScadenzaCampo.disabled = true;
        CompagniaCampo.disabled = true; 
    }
}
</script>

<script>
$(document).ready(function(){
    // Gestione dell'invio del modulo di registrazione tramite AJAX
    $('#registrazione_paziente_form').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize(); // Serializza i dati del modulo
        // Invia i dati del modulo tramite AJAX
        $.ajax({
            type: 'POST',
            url: 'gestione/registrazionePaz.php', 
            data: formData, 
            success: function(data){
                // Gestisce la risposta dal server
                var json = JSON.parse(data); 
                var status = json.status; 
                var message = json.message; 
                if (status == 'true') {
                    // Se la registrazione ha successo, reindirizza l'utente alla dashboard del paziente
                    window.location.href = '../paziente/dashboard.php';
                } else {
                    // Se ci sono errori, mostra il messaggio di errore e scorrere fino alla parte superiore della pagina
                    $('body, html').animate({scrollTop:$('#registrazione').offset().top}, 'slow');  
                    $('#error-box').text(message).show();     
                }
            },
            error: function(xhr, status, error){
                // Gestisce gli errori durante la richiesta AJAX mostrando un messaggio di errore
                alert("Errore durante l'inserimento");
            }
        });
    });
});
</script>
</body>
</html>
