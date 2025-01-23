<?php 
// Include il file di configurazione del database
include('config.php');

// Recupera i valori inviati tramite metodo POST dal modulo
$numero_polizza = $_POST['numero_polizza'];
$tipo = $_POST['tipo'];
$data_scadenza = $_POST['data_scadenza'];
$id_compagnia = $_POST['id_compagnia'];
$id_paziente = $_POST['id_paziente'];

// Converte la data di scadenza in un formato compatibile con il database (YYYY-MM-DD)
$timestamp = strtotime($data_scadenza);
$data_formattata = date("Y-m-d", $timestamp);

// Costruisce la query SQL per inserire i dati nel database
$sql_assicurazione = "INSERT INTO assicurazione (numero_polizza, tipo, data_scadenza, id_paziente, id_compagnie) VALUES ('$numero_polizza', '$tipo', '$data_formattata', '$id_paziente', '$id_compagnia')";

// Esegue la query SQL sul database
$query_assicurazione = mysqli_query($con, $sql_assicurazione);

// Verifica se la query ha avuto successo
if($query_assicurazione){
    // Se ha avuto successo, restituisce uno stato 'true' come JSON
    $data = array(
        'status'=>'true'
    );
    echo json_encode($data);
}else{
    // Se ha fallito, restituisce uno stato 'false' come JSON
    $data = array(
        'status'=>'false' 
    );
    echo json_encode($data);
}
?>
