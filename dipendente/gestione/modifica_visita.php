<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID della visita dalla richiesta POST
$id = $_POST['id'];
$id_paziente = $_POST['id_paziente'];
$importo = $_POST['importo'];

mysqli_autocommit($con, false);

// Query per aggiornare lo stato della visita a 'svolta'
$sql_visita = "UPDATE `visita` SET  `stato`='svolta' WHERE id_visita='$id' ";
$query_visita = mysqli_query($con, $sql_visita);

$sql_polizza = "SELECT numero_polizza FROM assicurazione WHERE id_paziente = '$id_paziente'";
$query_polizza = mysqli_query($con, $sql_polizza);

if(mysqli_num_rows($query_polizza) > 0) {
    $row = mysqli_fetch_assoc($query_polizza);
    $numero_polizza = $row['numero_polizza']; 
    $sql_fattura = "INSERT INTO fattura (importo, id_visita, pagato, numero_polizza) VALUES ('$importo', '$id', 'no', '$numero_polizza')";
    $query_fattura = mysqli_query($con, $sql_fattura);

}else {
    $sql_fattura = "INSERT INTO fattura (importo, pagato, id_visita) VALUES ('$importo', 'no', '$id')";
    $query_fattura = mysqli_query($con, $sql_fattura);
}

if($query_visita && $query_polizza && $query_fattura){
    // Se la query ha avuto successo, restituisce un messaggio JSON con lo stato true
    mysqli_commit($con); 
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
} else {
    // Se la query non ha avuto successo, restituisce un messaggio JSON con lo stato false
    mysqli_rollback($con); 
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 
?>