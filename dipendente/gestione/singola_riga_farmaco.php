<?php
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID del farmaco e il nome dell'ambulatorio dalla richiesta POST
$id_farmaco = $_POST['id'];
$nome_ambulatorio = $_POST['nome_ambulatorio'];

// Seleziona la quantità e la scadenza del farmaco specificato
$sql = "SELECT quantità, scadenza FROM AmbFarFarFar WHERE id_farmaco='$id_farmaco' AND nome_ambulatorio='$nome_ambulatorio' LIMIT 1";
$query = mysqli_query($con, $sql);

// Estrai la riga risultante dalla query
$riga = mysqli_fetch_assoc($query);

// Restituisce i dati della riga come JSON
echo json_encode($riga);
?>

