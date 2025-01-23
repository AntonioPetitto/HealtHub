<?php
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera il nome dell'ambulatorio dalla sessione
$nome_ambulatorio = $_SESSION['nome_ambulatorio'];

// Inizializza un array per l'output
$output= array();

// Query per selezionare i dati delle visite relative all'ambulatorio corrente
$sql = "SELECT id_visita, id_paziente, nome, cognome, data_visita, ora_visita, nome_file FROM UteAnaPazVisDipAmb WHERE nome_ambulatorio='$nome_ambulatorio'";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con,$sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_visita',
    1 => 'id_paziente',
    2 => 'nome',
    3 => 'cognome',
    4 => 'data_visita',
    5 => 'ora_visita',
    6 => 'nome_file'
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " AND (nome like '%".$ricerca."%'";
    $sql .= " OR cognome like '%".$ricerca."%'";
    $sql .= " OR data_visita like '%".$ricerca."%'";
    $sql .= " OR ora_visita like '%".$ricerca."%')";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
    $sql .= " ORDER BY id_visita desc";
}

// Gestione della paginazione
if($_POST['length'] != -1) {
    $inizio = $_POST['start'];
    $lunghezza = $_POST['length'];
    $sql .= " LIMIT  ".$inizio.", ".$lunghezza;
}   

$query = mysqli_query($con,$sql);
$conto_righe = mysqli_num_rows($query);

// Inizializza un array per i dati
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while($riga = mysqli_fetch_assoc($query))
{
    $sub_array = array();
    $sub_array[] = $riga['id_visita'];
    $sub_array[] = $riga['id_paziente'];
    $sub_array[] = $riga['nome'];
    $sub_array[] = $riga['cognome'];
    $sub_array[] = date('d/m/Y', strtotime($riga['data_visita']));
    $sub_array[] = date('h:i', strtotime($riga['ora_visita']));
    $sub_array[] = $riga['nome_file'];
    // Aggiungi i pulsanti per le azioni relative ai referti
    $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_visita'].'"  data-id-paziente="'.$riga['id_paziente'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Svolta</a>  <a href="javascript:void();" data-id="'.$riga['id_visita'].'"  class="btn bg-gradient-danger btn-sm deleteBtn align-middle mb-0">Elimina</a>';
    if(!empty($riga['nome_file'])){
        $file_path = "referti/" . $riga['nome_file'];
        $sub_array[] = '<a href="' . $file_path . '" target="_blank" data-id="'.$riga['id_visita'].'"  class="btn bg-gradient-info btn-sm downloadbtn align-middle mb-0">Visualizza ref</a> <a href="javascript:void();" data-file-name="'.$riga['nome_file'].'" data-file-path="' . $file_path . '" data-id="'.$riga['id_visita'].'"  class="btn bg-gradient-danger btn-sm deletebtn align-middle mb-0">Elimina ref</a>';
    }else{
        $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_visita'].'" class="btn bg-gradient-primary btn-sm uploadbtn align-middle mb-0">Upload ref</a>';
    }
    $data[] = $sub_array;
}

// Costruisce l'array per la risposta JSON
$output = array(
    'draw'=> intval($_POST['draw']),
    'recordsTotal' =>$conto_righe ,
    'recordsFiltered'=>$totale_righe,
    'data'=>$data,
);

// Restituisce la risposta JSON
echo  json_encode($output);
?>