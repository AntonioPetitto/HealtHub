<?php 
// Include il file di configurazione del database
include("config.php");

// Recupera i dati inviati tramite POST
$percorso = $_POST['percorso']; 
$nome_file = $_POST['nome_file']; 
$id = $_POST['id']; 

// Verifica se il file è stato eliminato con successo dal server
if (unlink("../" . $percorso)) { // Utilizza la funzione unlink() per eliminare il file

    // Se il file è stato eliminato con successo, procedi ad eliminare il referto dal database
    $sql_referto = "DELETE FROM referto WHERE id_visita = '$id' AND nome_file='$nome_file'";
    $query_referto = mysqli_query($con, $sql_referto);

    // Verifica se la query di eliminazione del referto è stata eseguita con successo
    if($query_referto){
        // Se l'eliminazione è avvenuta con successo, restituisce una risposta JSON positiva
        $data = array(
            'status'=>'true',
            'message' => 'referto eliminato con successo'
        );
        echo json_encode($data);
    } else {
        // Se si è verificato un errore durante l'eliminazione del referto dal database, restituisce una risposta JSON negativa
        $data = array(
            'status'=>'false',
            'message' => "errore nell'eliminazione del referto dal database"
        );
        echo json_encode($data);  
    }
} else {
    // Se si è verificato un errore durante l'eliminazione del file dal server, restituisce una risposta JSON negativa
    $data = array(
        'status'=>'false',
        'message' => "errore nell'eliminazione del referto"
    );
    echo json_encode($data);
}
?>
