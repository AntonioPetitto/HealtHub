<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID inviato tramite POST
$id = $_POST['id'];

// Query per selezionare le informazioni dell'utente specificato
$sql = "SELECT nome, cognome, email, pass, data_registrazione FROM UteAna WHERE id_utente='$id' LIMIT 1";

// Esegui la query sul database
$query = mysqli_query($con,$sql);

// Ottieni la riga risultante dalla query
$riga = mysqli_fetch_assoc($query);

// Restituisce le informazioni dell'utente in formato JSON
echo json_encode($riga);
?>
