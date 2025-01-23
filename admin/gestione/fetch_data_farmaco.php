<?php 
// Include il file di configurazione del database
include('config.php');

// Inizializza un array per l'output
$output = array();

// Query per selezionare tutti i farmaci
$sql = "SELECT id_farmaco, nome FROM farmaci";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
    0 => 'id_farmaco',
    1 => 'nome',
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
    $ricerca = $_POST['search']['value'];
    $sql .= " WHERE id_farmaco LIKE '%".$ricerca."%'";
    $sql .= " OR nome LIKE '%".$ricerca."%'";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
    $sql .= " ORDER BY id_farmaco ASC";
}

// Gestione della paginazione
if($_POST['length'] != -1) {
    $inizio = $_POST['start'];
    $lunghezza = $_POST['length'];
    $sql .= " LIMIT ".$inizio.", ".$lunghezza;
}   

$query = mysqli_query($con, $sql);
$conto_righe = mysqli_num_rows($query);

// Inizializza un array per i dati
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while($riga = mysqli_fetch_assoc($query)) {
    $sub_array = array();
    $sub_array[] = $riga['id_farmaco'];
    $sub_array[] = $riga['nome'];
    // Aggiungi pulsanti per modificare ed eliminare
    $sub_array[] = '<a href="javascript:void();" data-id="'.$riga['id_farmaco'].'" class="btn bg-gradient-info btn-sm editbtn align-middle mb-0">Modifica</a> <a href="javascript:void();" data-id="'.$riga['id_farmaco'].'" class="btn bg-gradient-danger btn-sm deleteBtn align-middle mb-0">Elimina</a>';
    $data[] = $sub_array;
}

// Costruisce l'array per la risposta JSON
$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => $conto_righe,
    'recordsFiltered' => $totale_righe,
    'data' => $data,
);

// Restituisce la risposta JSON
echo json_encode($output);
?>