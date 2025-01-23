<?php 
// Include il file di configurazione del database
include('config.php');

// Recupera l'ID della visita inviato tramite POST
$id = $_POST['id'];

// Query per ottenere l'ID del referto associato alla visita
$sql_id_referto = "SELECT id_referto FROM referto WHERE id_visita = '$id'";
$query_id_referto = mysqli_query($con, $sql_id_referto);

// Verifica se la query per ottenere l'ID del referto è stata eseguita correttamente
if($query_id_referto){
    // Se sono stati trovati referti associati alla visita, restituisce un messaggio di errore
    if(mysqli_num_rows($query_id_referto) > 0){
        $data = array(
            'status'=>'false',
            'message' => "Impossibile eliminare, è stato salvato un referto"
        );
        echo json_encode($data);
    } else {
        // Altrimenti, procedi con l'eliminazione della visita
        $sql_visita = "DELETE FROM visita WHERE id_visita='$id'";
        $query_visita = mysqli_query($con, $sql_visita);

        // Verifica se l'eliminazione della visita è avvenuta con successo
        if($query_visita){
            // Se l'eliminazione è avvenuta con successo, restituisce uno stato positivo
            $data = array(
                'status'=>'true',
            );
            echo json_encode($data);
        } else {
            // Se si è verificato un errore durante l'eliminazione della visita, restituisce un messaggio di errore
            $data = array(
                'status'=>'false',
                'message' => "Errore nell'eliminazione della visita"
            );
            echo json_encode($data);
        }     
    }
} else {
    // Se si è verificato un errore durante la ricerca di referti associati, restituisce un messaggio di errore
    $data = array(
        'status'=>'false',
        'message' => "Errore nella ricerca di probabili referti salvati"
    );
    echo json_encode($data); 
}
?>
