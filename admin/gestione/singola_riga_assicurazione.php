<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID dell'utente inviato tramite POST
$id = $_POST['id'];

// Query per selezionare le informazioni del paziente, dell'assicurazione e della compagnia associate all'ID utente
$sql = "SELECT * FROM UteAnaPazAssCom WHERE id_utente='$id' LIMIT 1";

// Esegui la query sul database
$query = mysqli_query($con,$sql);

// Ottieni la riga risultante dalla query
$riga = mysqli_fetch_assoc($query);

// Converte la riga in formato JSON e la restituisce
echo json_encode($riga);
?>