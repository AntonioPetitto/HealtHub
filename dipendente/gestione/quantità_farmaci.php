<?php
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati dalla richiesta POST
$nome_ambulatorio = $_POST['nome_ambulatorio'];
$id_farmaco = $_POST['id'];
$modifica = $_POST['modifica'];

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Seleziona l'id della farmacia associata all'ambulatorio
$sql_farmacia = "SELECT id_farmacia FROM AmbFarFarFar WHERE nome_ambulatorio = '$nome_ambulatorio'";
$query_farmacia = mysqli_query($con, $sql_farmacia);
$row = mysqli_fetch_assoc($query_farmacia);
$id_farmacia = $row['id_farmacia'];

// Seleziona la quantità attuale del farmaco
$sql_quantità = "SELECT quantità FROM AmbFarFarFar WHERE nome_ambulatorio = '$nome_ambulatorio' AND id_farmaco = '$id_farmaco'";
$query_quantità = mysqli_query($con, $sql_quantità);
$row = mysqli_fetch_assoc($query_quantità);
$quantità = $row['quantità'];

// Seleziona la scadenza del farmaco
$sql_scadenza = "SELECT DATE_FORMAT(scadenza, '%d/%m/%Y') AS scadenza FROM AmbFarFarFar WHERE nome_ambulatorio = '$nome_ambulatorio' AND id_farmaco = '$id_farmaco'";
$query_scadenza = mysqli_query($con, $sql_scadenza);
$row = mysqli_fetch_assoc($query_scadenza);
$scadenza = $row['scadenza'];

// Aggiorna la quantità attuale in base alla modifica ricevuta
$quantità += $modifica;

// Aggiorna la quantità del farmaco nel database
$sql_farmaco = "UPDATE farmaci_disponibili SET quantità = '$quantità' WHERE id_farmacia = '$id_farmacia' AND id_farmaco = '$id_farmaco'";
$query_farmaco = mysqli_query($con, $sql_farmaco);

// Verifica se tutte le query sono state eseguite con successo
if ($query_farmacia && $query_quantità && $query_farmaco && $query_scadenza) {
    // Se tutte le operazioni hanno avuto successo, conferma la transazione
    mysqli_commit($con);
    // Restituisce i dati aggiornati come JSON
    $data = array(
        'status' => 'true',
        'scadenza' => $scadenza,
        'quantità' => $quantità
    );
    echo json_encode($data);
} else {
    // Se una delle operazioni ha fallito, annulla la transazione
    mysqli_rollback($con);
    // Restituisce un messaggio di errore come JSON
    $data = array(
        'status' => 'false',
        'message' => 'Errore'
    );
    echo json_encode($data);
}
?>

