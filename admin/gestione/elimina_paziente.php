<?php 
// Include il file di configurazione del database
include('config.php');

// Ottiene l'ID dell'utente da eliminare dall'input POST
$id = $_POST['id'];

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Query per recuperare l'ID del paziente associato all'utente
$sql_id_paziente = "SELECT id_paziente FROM paziente WHERE id_utente='$id'";
$result_id_paziente = mysqli_query($con, $sql_id_paziente);

// Se la query per recuperare l'ID del paziente ha successo
if ($result_id_paziente) {
    // Controlla se ci sono risultati
    if(mysqli_num_rows($result_id_paziente) > 0) {
        // Ottiene l'ID del paziente
        $row = mysqli_fetch_assoc($result_id_paziente);
        $id_paziente = $row['id_paziente'];

        // Query per contare il numero di visite del paziente
        $sql_visita = "SELECT count(id_paziente) as num_visite FROM visita WHERE id_paziente='$id_paziente'";
        $query_visita = mysqli_query($con, $sql_visita);
        
        // Se la query per contare il numero di visite ha successo
        if($query_visita){
            // Ottiene il numero di visite
            $row = mysqli_fetch_assoc($query_visita);
            $num_visite = $row['num_visite'];

            // Se il paziente non ha visite attive
            if($num_visite == 0){

                // Elimina l'assicurazione associata al paziente
                $sql_id_assicurazione  = "SELECT numero_polizza FROM assicurazione WHERE id_paziente='$id_paziente'";
                $result_id_assicurazione = mysqli_query($con, $sql_id_assicurazione);

                // Se il paziente ha un'assicurazione, eliminala
                if(mysqli_num_rows($result_id_assicurazione) > 0) {
                    $sql_assicurazione = "DELETE FROM assicurazione WHERE id_paziente='$id_paziente'";
                    $query_assicurazione = mysqli_query($con, $sql_assicurazione);
                }

                // Elimina l'anagrafica associata al paziente
                $sql_anagrafica = "DELETE FROM anagrafica WHERE id_utente='$id'";
                $query_anagrafica = mysqli_query($con, $sql_anagrafica);

                // Elimina il paziente
                $sql_paziente = "DELETE FROM paziente WHERE id_utente='$id'";
                $query_paziente = mysqli_query($con, $sql_paziente);

                // Elimina l'utente
                $sql_utente = "DELETE FROM utente WHERE id_utente='$id'";
                $query_utente = mysqli_query($con, $sql_utente);

                // Verifica se tutte le query di eliminazione hanno avuto successo
                if(($query_utente && $query_anagrafica && $query_paziente && mysqli_num_rows($result_id_assicurazione) == 0) || ($query_utente && $query_anagrafica && $query_paziente && $query_assicurazione)) {
                    // Conferma la transazione
                    mysqli_commit($con); 
                    $data = array(
                        'status' => 'true',
                    );
                    echo json_encode($data);
                } else {
                    // Se una delle query di eliminazione fallisce, annulla la transazione e restituisce un messaggio di errore
                    mysqli_rollback($con);
                    $data = array(
                        'status' => 'false', 
                        'message' => "Errore nell'eliminazione" 
                    );
                    echo json_encode($data);
                }
            } else {
                // Se il paziente ha visite attive, annulla la transazione e restituisce un messaggio di errore
                mysqli_rollback($con);
                $data = array(
                    'status' => 'false', 
                    'message' => 'Impossibile eliminare per non causare importanti perdite di informazioni dal database'
                );
                echo json_encode($data);
            }
        } else {
            // Se c'è un errore nella query per contare il numero di visite, annulla la transazione e restituisce un messaggio di errore
            mysqli_rollback($con);
            $data = array(
                'status' => 'false', 
                'message' => 'Errore'
            );
            echo json_encode($data);
        }
    } else {
        // Se non viene trovato nessun paziente per l'ID utente fornito, annulla la transazione e restituisce un messaggio di errore
        mysqli_rollback($con);
        $data = array(
            'status' => 'false', 
            'message' => 'Nessun paziente trovato per l\'ID utente fornito'
        );
        echo json_encode($data);
    }
} else {
    // Se c'è un errore nella query per recuperare l'ID del paziente, annulla la transazione e restituisce un messaggio di errore
    mysqli_rollback($con);
    $data = array(
        'status' => 'false', 
        'message' => 'Errore nella query per recuperare l\'ID del paziente'
    );
    echo json_encode($data);
}
?>