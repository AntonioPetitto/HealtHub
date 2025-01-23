<?php
// Include il file di configurazione del database
include('config.php');

// Recupera i dati inviati tramite POST
$quantità = $_POST['quantità'];
$scadenza = isset($_POST['scadenza']) ? $_POST['scadenza'] : NULL;
$nome_ambulatorio = $_POST['nome_ambulatorio'];
$id_farmaco = $_POST['id'];

// Formatta la data di scadenza se è stata fornita
if ($scadenza != NULL){
    $timestamp = strtotime($scadenza);
    $data_formattata = date("Y-m-d", $timestamp);
}

// Disabilita l'autocommit per iniziare una transazione
mysqli_autocommit($con, false);

// Seleziona l'id della farmacia corrispondente all'ambulatorio
$sql_farmacia="SELECT id_farmacia FROM AmbFarFarFar WHERE nome_ambulatorio='$nome_ambulatorio'";
$query_farmacia=mysqli_query($con, $sql_farmacia);
$row=mysqli_fetch_assoc($query_farmacia);
$id_farmacia=$row['id_farmacia'];

// Aggiorna i dati del farmaco disponibile
if ($scadenza != NULL){
    $sql_farmaco= "UPDATE `farmaci_disponibili` SET  `quantità`='$quantità' , `scadenza`= '$data_formattata' WHERE id_farmacia='$id_farmacia' AND id_farmaco='$id_farmaco' ";
    $query_farmaco = mysqli_query($con, $sql_farmaco);
}else{
    $sql_farmaco= "UPDATE `farmaci_disponibili` SET  `quantità`='$quantità' , `scadenza`= NULL WHERE id_farmacia='$id_farmacia'AND id_farmaco='$id_farmaco' ";
    $query_farmaco = mysqli_query($con, $sql_farmaco);
}

// Commit della transazione se entrambe le query sono eseguite correttamente, altrimenti rollback
if($query_farmacia && $query_farmaco){
    mysqli_commit($con); 
    $data = array(
        'status'=>'true',
        'message' => 'modifica impostata'
    );
    echo json_encode($data);
}else{
    mysqli_rollback($con);
     $data = array(
        'status'=>'false',
        'message' => 'Errore'
    );
    echo json_encode($data);
} 
?>

