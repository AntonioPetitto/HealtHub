<?php
// Include il file di configurazione del database
include("config.php");

// Verifica se la richiesta è di tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Controlla se un file è stato caricato senza errori
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {

        // Definisce la destinazione del file
        $destinazione = "../referti/"; // Modifica questo per il percorso desiderato per i file caricati
        $percorso = $destinazione . basename($_FILES["file"]["name"]);

        // Ottieni l'estensione del file
        $tipofile = strtolower(pathinfo($percorso, PATHINFO_EXTENSION));

        // Controlla se il tipo di file è consentito (puoi modificare questo per consentire tipi di file specifici)
        $tipi_consentiti = array("pdf");
        if (!in_array($tipofile, $tipi_consentiti)) {
            $data = array(
                'status'=>'false',
                'message' => 'Sono permessi solo i file PDF'
            );
            echo json_encode($data);
        } else {
            // Verifica se il nome del file è già presente nel database
            $nome_file_originale = $_FILES["file"]["name"];
            $nome_file_modificato = $nome_file_originale;
            $query_verifica_nome = "SELECT nome_file FROM referto WHERE nome_file = '$nome_file_modificato'";
            $result_verifica_nome = mysqli_query($con, $query_verifica_nome);

            // Se il nome del file è già presente nel database, aggiungi un suffisso numerico fino a ottenere un nome unico
            $i = 1;
            while (mysqli_num_rows($result_verifica_nome) > 0) {
                $nome_file_modificato = pathinfo($nome_file_originale, PATHINFO_FILENAME) . '_' . $i . '.' . pathinfo($nome_file_originale, PATHINFO_EXTENSION);
                $query_verifica_nome = "SELECT nome_file FROM referto WHERE nome_file = '$nome_file_modificato'";
                $result_verifica_nome = mysqli_query($con, $query_verifica_nome);
                $i++;
            }

            // Sposta il file caricato nella directory specificata con il nome unico
            $nuovo_percorso = $destinazione . $nome_file_modificato;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $nuovo_percorso)) {
                // Successo nel caricare il file, ora memorizza le informazioni nel database
                $nome_file = $nome_file_modificato;
                $peso_file = $_FILES["file"]["size"];
                $tipo_file = $_FILES["file"]["type"];
                $id_visita = $_POST["id"];

                // Inserisce le informazioni del file nel database
                $sql_referto = "INSERT INTO referto (nome_file, peso_file, tipo_file, id_visita) VALUES ('$nome_file', $peso_file, '$tipo_file', '$id_visita')";
                $query_referto = mysqli_query($con, $sql_referto);

                if ($query_referto) {
                    $data = array(
                        'status'=>'true',
                        'message' => 'Il file ' . $nome_file . ' è stato caricato con successo'
                    );
                    echo json_encode($data);
                } else {
                    $data = array(
                        'status'=>'false',
                        'message' => "C'è stato un errore nel conservare il file"
                    );
                    echo json_encode($data);
                }
            } else {
                $data = array(
                    'status'=>'false',
                    'message' => "C'è stato un errore nell'uploading del file"
                );
                echo json_encode($data);
            }
        }
    } else {
        $data = array(
            'status'=>'false',
            'message' => 'Nessun file è stato caricato'
        );
        echo json_encode($data);
    }
}
?>
