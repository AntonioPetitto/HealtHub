<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni i dati inviati tramite POST
$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$codice_fiscale=$_POST['codice_fiscale'];
$cie=$_POST['cie'];
$telefono=$_POST['telefono'];
$id_paziente = $_POST['id_paziente'];
$id = $_POST['id'];

// Aggiorna i dati dell'anagrafica del paziente nel database
$sql_anagrafica = "UPDATE `anagrafica` SET  `nome`='$nome' , `cognome`= '$cognome'  ,`codice_fiscale`= '$codice_fiscale'  ,`cie`= '$cie'  ,`telefono`= '$telefono' WHERE id_utente='$id' ";
$query_anagrafica = mysqli_query($con, $sql_anagrafica);

// Verifica se entrambe le query sono state eseguite con successo e conferma la transazione o esegue il rollback
if($query_anagrafica){
    $data = array(
        'status'=>'true',
    );
    echo json_encode($data);
}else{
    $data = array(
        'status'=>'false',
    );
    echo json_encode($data);
} 