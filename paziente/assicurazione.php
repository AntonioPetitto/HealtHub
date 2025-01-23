<?php 
// Include l'intestazione comune
include('includes/header.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua assicurazione</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center text-success text-gradient" style="color:#7BAE37">La tua assicurazione</h2>
                    </div>
                    <div class="card-body">
                        <!-- Tabella per visualizzare i dettagli dell'assicurazione -->
                        <table id="Tabella" class="table align-items-center mb-2">
                            <tbody>
                                <tr>    
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Nome compagnia:</h5>
                                        <h4 class="mb-3" id="nomecompagnia" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Numero polizza:</h5>
                                        <h4 class="mb-3" id="numeropolizza" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Email compagnia:</h5>
                                        <h4 class="mb-3" id="emailcompagnia" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Telefono compagnia:</h5>
                                        <h4 class="mb-3" id="telefonocompagnia" ></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td width=10%>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Tipo assicurazione:</h5>
                                        <h4 class="mb-3" id="tipo" ></h4>
                                    </td>
                                    <td>
                                        <h5 class="mb-0 font-weight-bolder text-success text-gradient" style="color:#7BAE37">Data scadenza:</h5>
                                        <h4 class="mb-3" id="datascadenza" ></h4>
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
        url: 'gestione/fetch_data_assicurazione.php', 
        type: 'POST',
        data: {}, // Nessun dato aggiuntivo da inviare
        success: function(response) {
            // Se la richiesta ha successo, aggiorna i dati nella tabella HTML con i dati ricevuti
            var json = JSON.parse(response); 
            $('#nomecompagnia').text(json.nome); 
            $('#numeropolizza').text(json.numero_polizza); 
            $('#emailcompagnia').text(json.email); 
            $('#telefonocompagnia').text(json.telefono); 
            $('#tipo').text(json.tipo); 
            $('#datascadenza').text(json.data_scadenza); 
        }
    });
});
</script>
</html>
