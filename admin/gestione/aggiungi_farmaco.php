<?php
// Include il file di configurazione del database
include('config.php');

// Recupera i valori inviati tramite metodo POST dal modulo HTML
$id_farmaco = $_POST['id_farmaco'];
$nome = $_POST['nome'];

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Inserisce il nuovo farmaco nella tabella 'farmaci'
$sql_farmaci = "INSERT INTO farmaci (id_farmaco, Nome) VALUES ('$id_farmaco', '$nome')";
$query_farmaci = mysqli_query($con, $sql_farmaci);

// Verifica se l'inserimento dei farmaci ha avuto successo
if ($query_farmaci) {
    // Lista di id di farmacie dove il farmaco è disponibile
    $id_farmacie = array(1, 2, 3, 4, 5);

    // Itera attraverso ogni id di farmacia e inserisce il farmaco disponibile nella tabella 'farmaci_disponibili'
    foreach ($id_farmacie as $id_farmacia) {
        $sql_farmaci_disponibili = "INSERT INTO farmaci_disponibili (id_farmaco, id_farmacia) VALUES ('$id_farmaco', '$id_farmacia')";
        $query_farmaci_disponibili = mysqli_query($con, $sql_farmaci_disponibili);
        
        // Se l'inserimento fallisce, esegue il rollback della transazione e restituisce un messaggio di errore JSON
        if (!$query_farmaci_disponibili) {
            mysqli_rollback($con); 
            $data = array(
                'status'=>'false',
                'message'=>"Errore durante l'inserimento in farmaci_disponibili",
            );
            echo json_encode($data);
        }
    }

    // Se tutte le operazioni hanno successo, conferma la transazione e restituisce uno stato 'true'
    mysqli_commit($con); 
    $data = array(
        'status'=>'true',
        'message'=>"Farmaci inseriti con successo",
    );
    echo json_encode($data);
} else {
    // Se l'inserimento dei farmaci fallisce, esegue il rollback della transazione e restituisce un messaggio di errore JSON
    mysqli_rollback($con); 
    $data = array(
        'status'=>'false',
        'message'=>"Errore durante l'inserimento in farmaci",
    );
    echo json_encode($data);
}
?>