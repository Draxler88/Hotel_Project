<?php
include "../../connexion.php";
require('../../fpdf/fpdf.php');
$id = $_GET["id"];
$requet = $connexion->prepare("SELECT * FROM chambre
                                INNER JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre
                                INNER JOIN client ON client.Id_client = reservation.Id_client
                                WHERE chambre.Id_chambre = ?
                                ");
$requet->execute([$id]);
$chambres = $requet->fetchAll(PDO::FETCH_OBJ);

if (isset($_GET['imprimer'])) {
    // Create a new PDF document
    $pdf = new FPDF('P','mm', 'A4');
    $pdf->AddPage();

    // Set the title
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Client Registry', 0, 1, 'C');
    $pdf->Ln(10);

    // Set the table header
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(30, 10, 'Date de reservation', 1);
    $pdf->Cell(40, 10, 'Nom Client', 1);
    $pdf->Cell(30, 10, 'Telephone', 1);
    $pdf->Cell(30, 10, 'Date d\'arrivee', 1);
    $pdf->Cell(30, 10, 'Date de depart', 1);
    $pdf->Cell(30, 10, 'Prix', 1);
    $pdf->Ln();

    // Add the data to the table
    $pdf->SetFont('Arial', '', 12);
    foreach ($chambres as $chambre) {
        $pdf->Cell(30, 10, $chambre->Date_heure_reservation, 1);
        $pdf->Cell(40, 10, $chambre->Nom_complet, 1);
        $pdf->Cell(30, 10, $chambre->Telephone, 1);
        $pdf->Cell(30, 10, $chambre->Date_arrivée, 1);
        $pdf->Cell(30, 10, $chambre->Date_départ, 1);
        $pdf->Cell(30, 10, $chambre->Montant_total, 1);
        $pdf->Ln();
    }

    // Output the PDF
    $pdf->Output();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registry</title>
    <link href="../../bootstrap.min.css" rel="stylesheet">
    <link href="../../bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-8 mt-3">
                <h2 class="mb-4">Client Registry</h2>
            </div>
            <div class="col-2 mt-3 text-end">
                    <a href="afficher.php?afficherid=<?=$id?>" class="btn btn-danger" name="back"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
            <div class="col-2 mt-3">
                <form>
                    <button type="button"  class="btn btn-danger" name="imprimer"><i class="bi bi-printer"></i> Imprimer</button>
                </form>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Date de réservation</th>
                    <th scope="col">Nom Client</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Date d'arrivée</th>
                    <th scope="col">Date de départ</th>
                    <th scope="col">Prix</th>
                </tr>
            </thead>
            <tbody>
              ,
                <?php foreach($chambres as $chambre) : ?>
                <tr>
                    <td><?=$chambre->Date_heure_reservation?></td>
                    <td><?=$chambre->Nom_complet?></td>
                    <td><?=$chambre->Telephone?></td>
                    <td><?=$chambre->Date_arrivée?></td>
                    <td><?=$chambre->Date_départ?></td>
                    <td><?=$chambre->Montant_total?></td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
</html>
