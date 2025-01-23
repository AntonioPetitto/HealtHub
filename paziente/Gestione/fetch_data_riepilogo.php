<?php 
// Include il file di configurazione del database
include('config.php');

// Avvia la sessione
session_start();

// Recupera l'id del paziente dalla sessione
$id_paziente = $_SESSION['id_paziente'];

// Inizializza un array per l'output
$output= array();

// Query per selezionare le visite del paziente dal database
$sql = "SELECT id_visita, nome, cognome, nome_ambulatorio, data_visita, ora_visita, nome_file FROM UteAnaDipVisAmbRef WHERE id_paziente='$id_paziente' AND stato='svolta'";

// Esegue la query per ottenere il totale delle righe
$queryTotale = mysqli_query($con,$sql);
$totale_righe = mysqli_num_rows($queryTotale);

// Definisce le colonne per la tabella
$colonne = array(
    0 => 'id_visita',
    1 => 'nome',
    2 => 'nome_ambulatorio',
    3 => 'data_visita',
    4 => 'ora_visita',
);

// Gestione della ricerca
if(isset($_POST['search']['value']))
{
    $ricerca = $_POST['search']['value'];
    $sql .= " AND (nome like '%".$ricerca."%'";
    $sql .= " OR cognome like '%".$ricerca."%')";
}

// Gestione dell'ordinamento
if(isset($_POST['order']))
{
    $nome_colonna = $_POST['order'][0]['column'];
    $ordinamento = $_POST['order'][0]['dir'];
    $sql .= " ORDER BY ".$colonne[$nome_colonna]." ".$ordinamento."";
}
else
{
    $sql .= " ORDER BY id_visita desc";
}

// Gestione della paginazione
if($_POST['length'] != -1)
{
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
    $sub_array[] = $riga['nome'] . " " . $riga['cognome']; // Aggiunge il nome e cognome del medico
    $sub_array[] = $riga['nome_ambulatorio']; 
    $sub_array[] = date('d/m/Y', strtotime($riga['data_visita'])); // Formatta la data della visita
    $sub_array[] = date('h:i', strtotime($riga['ora_visita'])); 

    
    
    // Aggiungi il pulsante per visualizzare il referto
    if (!empty($riga['nome_file'])) {
        // Costruisce il percorso del file del referto
        $file_path = "../dipendente/referti/" . $riga['nome_file'];
        $sub_array[] = '<a href="' . $file_path . '" target="_blank" data-id="'.$riga['id_visita'].'"  class="btn bg-gradient-info btn-sm downloadbtn align-middle mb-0">Visualizza ref</a>';
    }else {
        $sub_array[] = '';
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