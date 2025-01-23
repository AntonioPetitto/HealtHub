<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID inviato tramite POST
$id = $_POST['id'];

// Query per selezionare il nome, cognome e l'ID del paziente associato all'ID specificato
$sql = "SELECT paziente.id_utente, id_paziente, nome, cognome, codice_fiscale, cie, telefono FROM UteAna JOIN paziente ON uteana.id_utente=paziente.id_utente WHERE paziente.id_utente='$id' LIMIT 1";

// Esegui la query sul database
$query = mysqli_query($con,$sql);

// Ottieni la riga risultante dalla query
$riga = mysqli_fetch_assoc($query);

// Converte la riga in formato JSON e la restituisce
echo json_encode($riga);
?>