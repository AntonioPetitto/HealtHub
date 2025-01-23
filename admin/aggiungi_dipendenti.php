<?php 
// Include l'intestazione comune
include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Dipendenti</title>
</head>
<body>
    <!-- Contenitore principale -->
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <!-- Titolo -->
                        <h4 id="registrazione">Inserisci nuovo dipendente</h4>
                    </div>
                    <div class="card-body">
                        <!-- Box per gli errori -->
                        <div id="error-box" class="alert alert-danger text-white text-center" style="display: none; font-size: 1.15rem;"></div>
                        <!-- Form per l'aggiunta del dipendente -->
                        <form id="aggiungi_dipendente_form" method="POST" action="javascript:void(0);">
                            
                            <!-- Credenziali -->
                            <fieldset>
                                <legend>Credenziali</legend>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" id="EmailCampo" name="email" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Password</label>
                                    <input type="password" id="PasswordCampo" name="password"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Data registrazione</label>
                                    <input type="date" id="DataRegistrazioneCampo" name="data_registrazione" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Ruolo</label>
                                    <select id="RuoloCampo" name="ruolo" class="form-control" required>
                                        <option value="">Seleziona ruolo</option>
                                        <option value="admin">Admin</option>
                                        <option value="medico">Medico</option>
                                        <option value="infermiere">Infermiere</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Ambulatorio</label>
                                    <select id="AmbulatorioCampo" name="ambulatorio" class="form-control" disabled>
                                        <option value="">Seleziona ambulatorio</option>
                                        <option value="1">cardiologia</option>
                                        <option value="2">chirurgia</option>
                                        <option value="3">Endocrinologia</option>
                                        <option value="4">Neurologia</option>
                                        <option value="5">Ortopedia</option>
                                    </select>
                                </div>
                            </fieldset>

                            <!-- Anagrafica --> 
                            <fieldset>
                                <legend>Anagrafica</legend>
                                <div class="mb-3">
                                    <label>Nome</label>
                                    <input type="text" id="NomeCampo" name="nome"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Cognome</label>
                                    <input type="text" id="CognomeCampo" name="cognome"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Codice fiscale</label>
                                    <input type="text" id="CodiceFiscaleCampo" name="codice_fiscale" class="form-control" required>
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
                                    <input type="number" id="TelefonoCampo" name="telefono" class="form-control" required>
                                </div>
                            </fieldset>

                            <!-- Contratto -->
                            <fieldset>
                                <legend>Contratto</legend>
                                <div class="mb-3">
                                    <label>Stipendio</label>
                                    <input type="number" id="StipendioCampo" name="stipendio"  class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label>Tipo</label>
                                    <select id="TipoCampo" name="tipo" class="form-control">
                                        <option value="">Seleziona tipo</option>
                                        <option value="determinato">Determinato</option>
                                        <option value="indeterminato">Indeterminato</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Data Cessazione</label>
                                    <input type="date" id="DataCessazioneCampo" name="data_cessazione" class="form-control" disabled>
                                </div>
                            </fieldset>
                            
                            <!-- Bottone per l'invio del form -->
                            <div class="container mt-3">
                                <div class="card-body text-center">
                                    <button type="submit" class="btn bg-gradient-primary text-dark text-lg" >Aggiungi Dipendente</button>
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
<!-- Script JavaScript per gestire il cambio di stato dei campi del form -->
<script>
// Funzione per disabilitare/abilitare il campo Ambulatorio in base al ruolo selezionato
var selRuolo = document.getElementById("RuoloCampo"), ambulatorio = document.getElementById("AmbulatorioCampo");

selRuolo.onchange = function(e) {
     ambulatorio.disabled = (selRuolo.value === "medico" || selRuolo.value === "infermiere") ? false : true;
};

// Funzione per disabilitare/abilitare il campo Data Cessazione in base al tipo di contratto selezionato
var selTipo = document.getElementById("TipoCampo"), data_cessazione = document.getElementById("DataCessazioneCampo");

selTipo.onchange = function(e) {
    data_cessazione.disabled = (selTipo.value === "determinato") ? false : true;
};
</script>

<!-- Script JavaScript per gestire l'invio del form tramite AJAX -->
<script>
$(document).ready(function(){
    $('#aggiungi_dipendente_form').submit(function(e){
        e.preventDefault(); 
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: 'gestione/aggiungi_dipendente.php',
            data: formData,
            success: function(response){
                // Analizza la risposta JSON
                var json = JSON.parse(response);
                var status = json.status;
                var message = json.message;
                // Mostra un messaggio di successo o di errore
                if (status == 'true') {
                    alert('Dipendente inserito con successo'); 
                    $('#aggiungi_dipendente_form')[0].reset();
                    $('body, html').animate({scrollTop:$('#aggiungi_dipendente_form').offset().top}, 'slow');
                } else {
                    $('body, html').animate({scrollTop:$('#registrazione').offset().top}, 'slow');  
                    $('#error-box').text(message).show(); 
                }
            },
            error: function(xhr, status, error){
                alert("Errore durante l'inserimento");
            }
        });
    });
});
</script>
</body>
</html>