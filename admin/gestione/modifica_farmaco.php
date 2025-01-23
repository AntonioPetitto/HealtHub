<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$nome = $_POST['nome'];
$id = $_POST['id'];

// Prepara e esegui la query per aggiornare il nome del farmaco nel database
$sql_farmaco = "UPDATE `farmaci` SET  `nome`='$nome' WHERE id_farmaco='$id' ";
$query_farmaco= mysqli_query($con,$sql_farmaco);

// Verifica se la query è stata eseguita con successo
if($query_farmaco){
    // Se la query ha avuto successo, restituisce un messaggio di successo
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
}else{
    // Se si è verificato un errore durante l'esecuzione della query, restituisce un messaggio di errore
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 
?>