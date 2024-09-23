<?php
require('../fpdf/fpdf.php'); // Adjust the path as per your directory structure
include "../connexion.php";

// Function to fetch clients based on the date range or without filtering
function fetchClients($connexion, $debut = null, $fin = null) {
    if ($debut && $fin) {
        $requet = $connexion->prepare("SELECT * FROM client
            INNER JOIN reservation ON client.Id_client = reservation.Id_client
            INNER JOIN chambre ON chambre.Id_chambre = reservation.Id_chambre
            WHERE (reservation.Date_arrivée BETWEEN ? AND ?)
            OR (reservation.Date_départ BETWEEN ? AND ?)
            OR (reservation.Date_arrivée <= ? AND reservation.Date_départ >= ?)");
        $requet->execute([$debut, $fin, $debut, $fin, $debut, $fin]);
    } else {
        $requet = $connexion->prepare("SELECT * FROM client
            INNER JOIN reservation ON client.Id_client = reservation.Id_client
            INNER JOIN chambre ON chambre.Id_chambre = reservation.Id_chambre");
        $requet->execute();
    }

    return $requet->fetchAll(PDO::FETCH_OBJ);
}

$clients = fetchClients($connexion, $_GET['debut'] ?? null, $_GET['fin'] ?? null);

if (isset($_GET['imprimer'])) {
    // Create a new PDF document
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Set the title
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(155, 5, 'Date : ', 0, 0, 'R');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(60, 5, "Le " . date("Y-m-d"), 0, 1);

    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(55, 5, 'Registre de Client : ', 0, 1);

    $pdf->Ln(5);

    $pdf->Cell(25, 5, 'Periode : ', 0, 0);
    $pdf->Cell(10, 5, 'Du', 0, 0);
    $pdf->Cell(27, 5, $_GET['debut'] ?? '', 0);
    $pdf->Cell(10, 5, 'au', 0, 0);
    $pdf->Cell(27, 5, $_GET['fin'] ?? '', 0, 1);

    $pdf->Ln(5);

    // Set the table header
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(5, 5, 'Id', 1);
    $pdf->Cell(35, 5, 'Date de reservation', 1);
    $pdf->Cell(30, 5, 'Nom Client', 1);
    $pdf->Cell(15, 5, 'Gender', 1);
    $pdf->Cell(10, 5, 'Age', 1);
    $pdf->Cell(20, 5, 'Date d\'arrivee', 1);
    $pdf->Cell(23, 5, 'Date de depart', 1);
    $pdf->Cell(32, 5, 'Numero de chambre', 1);
    $pdf->Cell(15, 5, 'Prix', 1);
    $pdf->Ln();

    // Add the data to the table
    $pdf->SetFont('Arial', '', 8);
    foreach ($clients as $client) {
        $pdf->Cell(5, 5, $client->Id_Client, 1);
        $pdf->Cell(35, 5, $client->Date_heure_reservation, 1);
        $pdf->Cell(30, 5, $client->Nom_complet, 1);
        $pdf->Cell(15, 5, $client->Sexe, 1);
        $pdf->Cell(10, 5, $client->Age, 1);
        $pdf->Cell(20, 5, $client->Date_arrivée, 1);
        $pdf->Cell(23, 5, $client->Date_départ, 1);
        $pdf->Cell(32, 5, $client->Numéro_chambre, 1);
        $pdf->Cell(15, 5, $client->Montant_total, 1);
        $pdf->Ln(5);
    }

    // Output the PDF
    $pdf->Output();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registry</title>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link href="../bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-8 mt-3">
                <h2 class="mb-4">Client Registry</h2>
            </div>
            <div class="col-2 mt-3 text-end">
                <a href="listClients.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
            <div class="col-2 mt-3">
                <form method="GET" action="<?=$_SERVER["PHP_SELF"]?>">
                    <button type="submit" class="btn btn-danger" name="imprimer"><i class="bi bi-printer"></i> Imprimer</button>
                </form>
            </div>
        </div>
        <form class="row my-3">
            <div class="col-5">
                <label class="form-label" for="date_debut">Date début</label>
                <input class="form-control" type="date" name="debut" id="date_debut" value="<?= $_GET['debut'] ?? '' ?>">
            </div>
            <div class="col-5">
                <label class="form-label" for="date_fin">Date fin</label>
                <input class="form-control" type="date" name="fin" id="date_fin" value="<?= $_GET['fin'] ?? '' ?>">
            </div>
            <div class="col-2 pt-4">
                <input class="btn btn-success" type="submit" name="sift" value="Search">
            </div>
        </form>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Client ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Age</th>
                    <th scope="col">Arrival Date</th>
                    <th scope="col">Departure Date</th>
                    <th scope="col">Room Number</th>
                    <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client) : ?>
                <tr>
                    <td><?=$client->Id_Client?></td>
                    <td><?=$client->Nom_complet?></td>
                    <td><?=$client->Sexe?></td>
                    <td><?=$client->Age?></td>
                    <td><?=$client->Date_arrivée?></td>
                    <td><?=$client->Date_départ?></td>
                    <td><?=$client->Numéro_chambre?></td>
                    <td><?=$client->Montant_total?></td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
