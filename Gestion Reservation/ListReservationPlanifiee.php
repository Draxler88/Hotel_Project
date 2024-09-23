<?php
    include "../connexion.php";
    include "../Users/NavbarMan.php";
    include "../Users/NavbarRec.php";
    session_start();
    $data = $connexion->prepare("SELECT * FROM reservation
                                INNER JOIN client ON reservation.Id_client = client.Id_client
                                INNER JOIN chambre ON reservation.Id_chambre = chambre.Id_chambre
                                WHERE reservation.Etat = ?
    ");
    $data->execute(["Planifiée"]);
    $reservations = $data->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réservations</title>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <?php
if($_SESSION["type"] == "manager"){
    style1();
}else{
    style2();
} ?>
</head>
<body>
<?php
if($_SESSION["type"] == "manager"){
    nav1();
}else{
    nav2();
} ?>
    <div class="container mt-2">
        <div class="row mt-4">
            <div class="col-10">
                <h1 class="mb-4">Liste des Réservations</h1>
            </div>
            <div class="col-2">
                <a href="ListReservation.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Code Reservation</th>
                    <th class="col-2">Date et Heure de Reservation</th>
                    <th class="col-2">Date d'Arrivee</th>
                    <th class="col-2">Date de Depart</th>
                    <th>Nombre de Jours</th>
                    <th>Montant Total</th>
                    <th>Telephone</th>
                    <th class="col-2">Client</th>
                    <th>Numero de Chambre</th>
                    <th class="col-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($reservations as $reservation): ?>
                <tr>
                    <td><?=$reservation->Code_reservation?></td>
                    <td><?=$reservation->Date_heure_reservation?></td>
                    <td><?=$reservation->Date_arrivée?></td>
                    <td><?=$reservation->Date_départ?></td>
                    <td><?=$reservation->Nbr_jours?></td>
                    <td><?=$reservation->Montant_total?></td>
                    <td><?=$reservation->Telephone?></td>
                    <td><?=$reservation->Nom_complet?></td>
                    <td><?=$reservation->Numéro_chambre?></td>
                    <td class="text-center">
                    <?php if($_SESSION["type"] == "receptionniste") :?>
                        <a href="?id=<?=$reservation->Id_reservation?>" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        <a href="ModifierReservation.php?id=<?=$reservation->Id_reservation?>" class="btn btn-primary btn-sm"><i class="bi bi-pen"></i></a>
                    <?php endif ?>
                        <a href="ConsultationReservation.php?id=<?=$reservation->Id_reservation?>" class="btn btn-info btn-sm"><i class="bi bi-info"></i></a>
                    </td>
                 </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
</html>
