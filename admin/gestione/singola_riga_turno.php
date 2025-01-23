<?php 
// Include il file di configurazione del database
include('config.php');

// Ottieni l'ID e la data inviati tramite POST
$id = $_POST['id'];
$data = $_POST['data'];

// Ottieni il mese, l'anno e la settimana dalla data specificata
$mese = date("m", strtotime($data));
$anno = date("Y", strtotime($data));
$settimana = date('W', strtotime($data));
$data_odierna = date('Y-m-d');

// Definisce un array di orari per ogni giorno della settimana
$orari = array(
    'lunedì' => null,
    'martedì' => null,
    'mercoledì' => null,
    'giovedì' => null,
    'venerdì' => null,
    'sabato' => null,
    'domenica' => null
);

// Inizializza la stringa per la query SQL
$sql_orari = ""; 

// Costruisce una query SQL per selezionare gli orari per ogni giorno della settimana
foreach ($orari as $giorno => $orario) {
    $sql_orario = "SELECT '$giorno' AS giorno, ora_inizio, ora_fine FROM UteAnaDipConTurCal WHERE giorno = '$giorno' AND settimana = '$settimana' AND mese = '$mese' AND anno='$anno' AND id_dipendente='$id'";
    // Aggiungi le query di selezione degli orari in un'unica stringa SQL con UNION
    $sql_orari .= ($sql_orari == "") ? $sql_orario : " UNION " . $sql_orario;
}

// Esegui la query per ottenere gli orari per tutti i giorni della settimana
$query_orari = mysqli_query($con, $sql_orari);

// Array per memorizzare gli orari per ogni giorno della settimana
$orari_per_turno = array();

// Ciclo sui risultati della query e memorizza gli orari
while ($riga_orario = mysqli_fetch_assoc($query_orari)) {
    $giorno = $riga_orario['giorno'];
    // Memorizza gli orari di inizio e fine per ciascun giorno
    $orari_per_turno[$giorno]['inizio'] = $riga_orario['ora_inizio'];
    $orari_per_turno[$giorno]['fine'] = $riga_orario['ora_fine'];
}

// Restituisce gli orari per turno in formato JSON
echo json_encode($orari_per_turno);
?>