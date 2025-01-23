<?php 
// Include il file di configurazione del database
include('config.php');

// Ottiene l'ID del farmaco da eliminare dall'input POST
$id = $_POST['id'];

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Array contenente gli ID delle farmacie in cui il farmaco è disponibile
$id_farmacie = array(1, 2, 3, 4, 5);

// Itera attraverso ogni ID di farmacia nell'array
foreach ($id_farmacie as $id_farmacia) {
    // Query per eliminare il farmaco dalla farmacia specificata
    $sql_farmaci_disponibili = "DELETE FROM farmaci_disponibili WHERE id_farmaco = '$id' AND id_farmacia = '$id_farmacia'";
    $query_farmaci_disponibili = mysqli_query($con, $sql_farmaci_disponibili);

    // Se la query di eliminazione dei farmaci disponibili fallisce
    if (!$query_farmaci_disponibili) {
        // Annulla la transazione e restituisce un messaggio di errore
        mysqli_rollback($con); 
        $data = array(
            'status'=>'false',
            'message'=>"Errore durante l'eliminazione dei farmaci_disponibili",
        );
        echo json_encode($data);
    }
}

// Query per eliminare il farmaco dalla tabella farmaci
$sql_farmaco = "DELETE FROM farmaci WHERE id_farmaco='$id'";
$query_farmaco = mysqli_query($con, $sql_farmaco);

// Se la query per eliminare il farmaco ha successo
if($query_farmaco) {
    // Conferma la transazione
    mysqli_commit($con); 
    $data = array(
        'status' => 'true',
        'message'=>"Farmaci eliminati con successo",
    );
    echo json_encode($data);
} else {
    // Se la query per eliminare il farmaco fallisce, annulla la transazione e restituisce un messaggio di errore
    mysqli_rollback($con);
    $data = array(
        'status' => 'false', 
        'message'=>"Errore durante l'eliminazione dei farmaci",
    );
    echo json_encode($data);
}
?>