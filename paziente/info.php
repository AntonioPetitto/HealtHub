<?php 
// Include l'intestazione del file HTML
include('includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni personali</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center text-success text-gradient" style="color:#7BAE37">Informazioni personali</h2>
                    </div>
                    <div class="card-body">
                        <!-- Tabella per visualizzare le informazioni personali -->
                        <table id="Tabella" class="table align-items-center mb-2">
                            <tbody>
                                <!-- Righe della tabella con le informazioni personali -->
                                <tr>    
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Nome:</h5>
                                        <h4 class="mb-1" id="nome" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Cognome:</h5>
                                        <h4 class="mb-1" id="cognome" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Data di nascita:</h5>
                                        <h4 class="mb-1" id="datanascita" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Sesso:</h5>
                                        <h4 class="mb-1" id="sesso" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Codice fiscale:</h5>
                                        <h4 class="mb-1" id="codicefiscale" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">CIE:</h5>
                                        <h4 class="mb-1" id="cie" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Nazionalità:</h5>
                                        <h4 class="mb-1" id="nazionalità" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Città:</h5>
                                        <h4 class="mb-1" id="città" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Indirizzo:</h5>
                                        <h4 class="mb-1" id="indirizzo" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Telefono:</h5>
                                        <h4 class="mb-1" id="telefono" ></h4>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div>          
                </div>
            </div>
        </div>
    </div>
</body>

<script src="../assets/js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script>
// Quando il documento è pronto
$(document).ready(function() {
    // Effettua una richiesta AJAX per ottenere i dati dell'assicurazione
    $.ajax({ 
        url: 'gestione/fetch_data_info.php',
        type: 'POST',
        data: {}, // Nessun dato aggiuntivo da inviare
        success: function(response) {
            var json = JSON.parse(response); 
            // Se la richiesta ha successo, aggiorna i dati nella tabella HTML con i dati ricevuti
            $('#nome').text(json.nome);
            $('#cognome').text(json.cognome);
            $('#datanascita').text(json.data_nascita);
            $('#sesso').text(json.sesso);
            $('#codicefiscale').text(json.codice_fiscale);
            $('#cie').text(json.cie);
            $('#nazionalità').text(json.nazionalità);
            $('#città').text(json.città);
            $('#indirizzo').text(json.indirizzo);
            $('#telefono').text(json.telefono);
        }
    });
});

</script>
</html>
