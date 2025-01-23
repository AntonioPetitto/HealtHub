<?php 
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera il nome dell'ambulatorio dalla sessione
$nome_ambulatorio = $_POST['ambulatorio'];

// Inizializza un array per l'output
$output = array();

// Query per ottenere i dati dei farmaci disponibili nell'ambulatorio corrente
$sql = "SELECT  id_farmaco_disponibile, nome_ambulatorio, id_farmaco, nome_farmaco, quantità, scadenza FROM AmbFarFarFar WHERE nome_ambulatorio = '$nome_ambulatorio'";

// Esegui la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con, $sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne della tabella
$colonne = array(
	0 => 'id_farmaco_disponibile',
	1 => 'nome_ambulatorio',
	2 => 'id_farmaco',
	3 => 'nome_farmaco',
	4 => 'quantità',
	5 => 'scadenza',
);

// Gestione della ricerca
if(isset($_POST['search']['value'])) {
	$ricerca = $_POST['search']['value'];
	$sql .= " AND (nome_farmaco like '%".$ricerca."%'";
	$sql .= " OR scadenza like '%".$ricerca."%')";
}

// Gestione dell'ordinamento
if(isset($_POST['order'])) {
	$nome_colonna = $_POST['order'][0]['column'];
	$ordinamento = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
} else {
	$sql .= " ORDER BY id_farmaco asc";
}

// Gestione della paginazione
if($_POST['length'] != -1) {
	$inizio = $_POST['start'];
	$lunghezza = $_POST['length'];
	$sql .= " LIMIT  ".$inizio.", ".$lunghezza;
}	

$query = mysqli_query($con, $sql);
$conto_righe = mysqli_num_rows($query);

// Inizializza un array per i dati
$data = array();

// Costruisce l'array dei dati per la risposta JSON
while($riga = mysqli_fetch_assoc($query)) {
	$sub_array = array();
	$sub_array[] = $riga['nome_ambulatorio'];
	$sub_array[] = $riga['id_farmaco'];
	$sub_array[] = $riga['nome_farmaco'];
	$sub_array[] = $riga['quantità'];
	if ($riga['scadenza'] != null) {
        $sub_array[] = date('d/m/Y', strtotime($riga['scadenza']));
    } else {
        $sub_array[] = ''; 
    }
	// Aggiunge pulsanti per diminuire, impostare e aggiungere farmaci
	$sub_array[] = '<a href="javascript:void();" data-nome-farmaco="'.$riga['nome_farmaco'].'" data-nome-ambulatorio="'.$riga['nome_ambulatorio'].'" data-id="'.$riga['id_farmaco'].'" class="btn bg-gradient-danger btn-md diminuiscibtn align-middle mb-0"><i class="fas fa-minus-circle"></i></a> <a href="javascript:void();" data-nome-farmaco="'.$riga['nome_farmaco'].'" data-nome-ambulatorio="'.$riga['nome_ambulatorio'].'" data-id="'.$riga['id_farmaco'].'" class="btn bg-gradient-info btn-md editbtn align-middle mb-0">Imposta</a> <a href="javascript:void();" data-nome-farmaco="'.$riga['nome_farmaco'].'" data-nome-ambulatorio="'.$riga['nome_ambulatorio'].'" data-id="'.$riga['id_farmaco'].'" class="btn bg-gradient-primary btn-md aggiungibtn align-middle mb-0"><i class="fas fa-plus-circle"></i></a>';
	$data[] = $sub_array;
}

// Costruisce l'array per la risposta JSON
$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' => $conto_righe,
	'recordsFiltered' => $totale_righe,
	'data' => $data,
);

// Restituisce la risposta JSON
echo json_encode($output);
?>