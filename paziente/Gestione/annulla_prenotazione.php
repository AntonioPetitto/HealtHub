<?php 
// Include il file di configurazione del database
include('config.php'); 

// Ottieni l'ID della visita dalla richiesta POST
$id = $_POST['id']; 

// Query per aggiornare lo stato della visita a "annullata"
$sql_visita = "UPDATE `visita` SET `stato`='annullata' WHERE id_visita='$id' ";
$query_visita = mysqli_query($con, $sql_visita); 

// Verifica se la query è stata eseguita con successo
if($query_visita){
    // Se la query è stata eseguita con successo, restituisce uno stato "true" come risposta JSON
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data); 
} else {
    // Se la query ha fallito, restituisce uno stato "false" come risposta JSON
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data); 
} 
?>
