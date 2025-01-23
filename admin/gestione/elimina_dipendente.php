<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID dell'utente da eliminare dall'input POST
$id = $_POST['id'];

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Query per ottenere l'ID del dipendente associato all'utente
$sql_id_dipendente = "SELECT id_dipendente FROM dipendente WHERE id_utente='$id'";
$result_id_dipendente = mysqli_query($con, $sql_id_dipendente);

if ($result_id_dipendente) {
    // Se la query ha successo
    if(mysqli_num_rows($result_id_dipendente) > 0) {
        // Estrae l'ID del dipendente
        $row = mysqli_fetch_assoc($result_id_dipendente);
        $id_dipendente = $row['id_dipendente'];

        // Conta il numero di visite associate al dipendente
        $sql_visita = "SELECT count(id_dipendente) as num_visite FROM visita WHERE id_dipendente='$id_dipendente'";
        $query_visita = mysqli_query($con, $sql_visita);

        if($query_visita){
            // Se la query ha successo
            $row = mysqli_fetch_assoc($query_visita);
            $num_visite = $row['num_visite'];

            if($num_visite == 0){
                // Se il dipendente non ha visite associate, procede con l'eliminazione
                
                // Elimina i contratti associati al dipendente
                $sql_contratto = "DELETE FROM contratto WHERE id_dipendente='$id_dipendente'";
                $query_contratto = mysqli_query($con, $sql_contratto);

                // Elimina l'anagrafica associata all'utente
                $sql_anagrafica = "DELETE FROM anagrafica WHERE id_utente='$id'";
                $query_anagrafica = mysqli_query($con, $sql_anagrafica);

                // Elimina il dipendente
                $sql_dipendente = "DELETE FROM dipendente WHERE id_utente='$id'";
                $query_dipendente = mysqli_query($con, $sql_dipendente);

                // Elimina l'utente
                $sql_utente = "DELETE FROM utente WHERE id_utente='$id'";
                $query_utente = mysqli_query($con, $sql_utente);
                
                // Se tutte le query di eliminazione hanno successo, conferma la transazione
                if($query_utente && $query_anagrafica && $query_dipendente && $query_contratto) {
                    mysqli_commit($con); 
                    $data = array(
                        'status' => 'true',
                    );
                    echo json_encode($data);
                } else {
                    // Se una qualsiasi delle query di eliminazione fallisce, annulla la transazione e restituisce un messaggio di errore
                    mysqli_rollback($con);
                    $data = array(
                        'status' => 'false',
                        'message' => "Errore nell'eliminazione" 
                    );
                    echo json_encode($data);
                }
            }else{
                // Se il dipendente ha visite associate, annulla la transazione e restituisce un messaggio di errore
                mysqli_rollback($con);
                $data = array(
                    'status' => 'false', 
                    'message' => 'Impossibile eliminare per non causare importanti perdite di informazioni dal database'
                );
                echo json_encode($data);
            }        
        }else{
            // Se la query per contare le visite fallisce, annulla la transazione e restituisce un messaggio di errore
            mysqli_rollback($con);
            $data = array(
                'status' => 'false', 
                'message' => 'Errore'
            );
            echo json_encode($data);
        }
    } else {
        // Se non viene trovato alcun dipendente per l'ID utente fornito, annulla la transazione e restituisce un messaggio di errore
        mysqli_rollback($con);
        $data = array(
            'status' => 'false', 
            'message' => 'Nessun dipendente trovato per l\'ID utente fornito'
        );
        echo json_encode($data);
    }
} else {
    // Se la query per recuperare l'ID del dipendente fallisce, annulla la transazione e restituisce un messaggio di errore
    mysqli_rollback($con);
    $data = array(
        'status' => 'false', 
        'message' => 'Errore nella query per recuperare l\'ID del dipendente'
    );
    echo json_encode($data);
}
?>