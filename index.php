<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Impostazioni base della pagina -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Collegamento al CSS di Bootstrap per lo styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <title>Lista Hotel</title>
</head>
<body>

<?php
// Array principale che contiene tutti i dati degli hotel
// Ogni hotel è un array associativo con: nome, descrizione, parcheggio, voto e distanza
$hotels = [
    [
        'name' => 'Hotel Belvedere',
        'description' => 'Hotel Belvedere Descrizione',
        'parking' => true,        // true = ha parcheggio, false = non ha parcheggio
        'vote' => 4,             // voto da 1 a 5 stelle
        'distance_to_center' => 10.4  // distanza dal centro in km
    ],
    [
        'name' => 'Hotel Futuro',
        'description' => 'Hotel Futuro Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 2
    ],
    [
        'name' => 'Hotel Rivamare',
        'description' => 'Hotel Rivamare Descrizione',
        'parking' => false,
        'vote' => 1,
        'distance_to_center' => 1
    ],
    [
        'name' => 'Hotel Bellavista',
        'description' => 'Hotel Bellavista Descrizione',
        'parking' => false,
        'vote' => 5,
        'distance_to_center' => 5.5
    ],
    [
        'name' => 'Hotel Milano',
        'description' => 'Hotel Milano Descrizione',
        'parking' => true,
        'vote' => 2,
        'distance_to_center' => 50
    ]
];

// PREPARAZIONE VARIABILI PER IL FORM
// Controllo se è stato selezionato il filtro parcheggio e preparo l'attributo "checked"
$parkingChecked = ($_GET['parking'] ?? '') ? 'checked' : '';

// Memorizzo il voto selezionato per mantenerlo nel select dopo il submit
$selectedVote = $_GET['vote'] ?? '';

// LOGICA DI FILTRO DEGLI HOTEL
// Creo un nuovo array vuoto che conterrà solo gli hotel che superano i filtri
$filteredHotels = [];

// Scorro tutti gli hotel uno per uno
foreach ($hotels as $hotel) {
    // Variabile che decide se mostrare questo hotel (inizialmente true)
    $showHotel = true;

    // FILTRO 1: Controllo il filtro parcheggio
    // Se l'utente ha selezionato "Solo con parcheggio"
    if ($_GET['parking'] ?? false) {
        // Se l'hotel non ha parcheggio, non lo mostro
        if ($hotel['parking'] != true) {
            $showHotel = false;
        }
    }

    // FILTRO 2: Controllo il filtro voto minimo
    // Se l'utente ha selezionato un voto minimo
    if (($_GET['vote'] ?? '') != '') {
        // Converto il voto in numero intero
        $minVote = (int)($_GET['vote'] ?? 0);
        // Se il voto dell'hotel è inferiore al minimo richiesto, non lo mostro
        if ($hotel['vote'] < $minVote) {
            $showHotel = false;
        }
    }

    // Se l'hotel ha superato tutti i filtri, lo aggiungo all'array filtrato
    if ($showHotel) {
        $filteredHotels[] = $hotel;
    }
}
?>

<div class="container mt-3">
    <!-- Titolo principale della pagina -->
    <h1>Lista Hotel</h1>

    <!-- FORM PER I FILTRI -->
    <!-- Uso il metodo GET per passare i parametri nell'URL -->
    <form method="GET" class="mb-3">
        <!-- Checkbox per filtrare solo hotel con parcheggio -->
        <input type="checkbox" name="parking" value="1" <?php echo $parkingChecked; ?>> Solo con parcheggio

        <!-- Select per scegliere il voto minimo -->
        <select name="vote">
            <option value="">Voto minimo</option>
            <!-- Ogni opzione controlla se è quella selezionata per aggiungere "selected" -->
            <option value="1" <?php echo $selectedVote == '1' ? 'selected' : ''; ?>>1</option>
            <option value="2" <?php echo $selectedVote == '2' ? 'selected' : ''; ?>>2</option>
            <option value="3" <?php echo $selectedVote == '3' ? 'selected' : ''; ?>>3</option>
            <option value="4" <?php echo $selectedVote == '4' ? 'selected' : ''; ?>>4</option>
            <option value="5" <?php echo $selectedVote == '5' ? 'selected' : ''; ?>>5</option>
        </select>

        <!-- Pulsante per applicare i filtri -->
        <button type="submit">Filtra</button>
        <!-- Link per rimuovere tutti i filtri (torna alla pagina senza parametri GET) -->
        <a href="?">Reset</a>
    </form>


    <!-- TABELLA DEGLI HOTEL -->
    <!-- Tabella Bootstrap per mostrare i risultati -->
    <table class="table">
        <!-- Intestazione della tabella -->
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrizione</th>
                <th>Parcheggio</th>
                <th>Voto</th>
                <th>Distanza (km)</th>
            </tr>
        </thead>
        <!-- Corpo della tabella con i dati -->
        <tbody>
            <!-- Scorro solo gli hotel filtrati (non tutti gli hotel originali) -->
            <?php foreach ($filteredHotels as $hotel) { ?>
                <tr>
                    <!-- Mostro il nome dell'hotel -->
                    <td><?php echo $hotel['name']; ?></td>
                    <!-- Mostro la descrizione dell'hotel -->
                    <td><?php echo $hotel['description']; ?></td>
                    <!-- Controllo se ha parcheggio: se true mostro "Sì", altrimenti "No" -->
                    <td><?php echo $hotel['parking'] ? 'Sì' : 'No'; ?></td>
                    <!-- Mostro il voto con formato "numero/5" -->
                    <td><?php echo $hotel['vote']; ?>/5</td>
                    <!-- Mostro la distanza dal centro -->
                    <td><?php echo $hotel['distance_to_center']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>