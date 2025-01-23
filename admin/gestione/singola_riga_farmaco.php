<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID del farmaco inviato tramite POST
$id = $_POST['id'];

// Query per selezionare il nome del farmaco associato all'ID specificato
$sql = "SELECT nome FROM farmaci WHERE id_farmaco='$id' LIMIT 1";

// Esegui la query sul database
$query = mysqli_query($con,$sql);

// Ottieni la riga risultante dalla query
$riga = mysqli_fetch_assoc($query);

// Converte la riga in formato JSON e la restituisce
echo json_encode($riga);
?>