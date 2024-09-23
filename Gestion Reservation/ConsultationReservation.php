<?php
include("../connexion.php");
session_start();
include "../Users/NavbarMan.php";
include "../Users/NavbarRec.php";
$request = $connexion->prepare("SELECT * FROM reservation
                                INNER JOIN chambre ON reservation.Id_chambre = chambre.Id_chambre
                                INNER JOIN client ON reservation.Id_client = client.Id_Client
                                where reservation.Id_reservation = ?
");
$request->execute([$_GET["id"]]);
$reservation = $request->fetchObject();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher client</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        th{
            color : yellow !important;
        }
    </style>
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
    <div class="container">
        <div class="row">
            <div class="col-10">
                <h1 class="align-self-center m-3 text-info">Details De Reservation Numero <span class="text-primary"><?=$reservation->Code_reservation?></span></h1> 
            </div>
            <div class="col-2 mt-4">
                    <a href="ListReservation.php" class="btn-danger btn text-center " name="back"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>

        <table class="table table-hover table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">Les info de Reservation</th>
            </tr>
            <tr>
                <th>Id_reservation</th>
                <td><?=$reservation->Id_reservation?></td>
            </tr>
            <tr>
                <th>Code_reservation</th>
                <td><?=$reservation->Code_reservation?></td>
            </tr>
            <tr>
                <th>Date_heure_reservation</th>
                <td><?=$reservation->Date_heure_reservation?></td>
            </tr>
            <tr>
                <th>Date_arrivée</th>
                <td><?=$reservation->Date_arrivée?></td>
            </tr>
            <tr>
                <th>Date_départ</th>
                <td><?=$reservation->Date_départ?></td>
            </tr>
            <tr>
                <th>Nbr_jours</th>
                <td><?=$reservation->Nbr_jours?></td>
            </tr>
            <tr>
                <th>Nbr_adultes_enfants</th>
                <td><?=$reservation->Nbr_adultes_enfants?></td>
            </tr>
            <tr>
                <th>Montant_total</th>
                <td><?=$reservation->Montant_total?></td>
            </tr>
            <tr>
                <th>Etat</th>
                <td><?=$reservation->Id_reservation?></td>
            </tr>
            <tr>
                <th>Id_client</th>
                <td><?=$reservation->Id_Client?></td>
            </tr>
            <tr>
                <th>Id_chambre</th>
                <td><?=$reservation->Id_chambre?></td>
            </tr>
            
        </table>

        <table class="table table-hover table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">Les info de Client</th>
            </tr>
            <tr>
                <th>Id_chambre</th>
                <td><?=$reservation->Id_chambre?></td>
            </tr>
            <tr>
                <th>Numéro_chambre</th>
                <td><?=$reservation->Numéro_chambre?></td>
            </tr>
            <tr>
                <th>Nombre_adultes_enfants_ch</th>
                <td><?=$reservation->Nombre_adultes_enfants_ch?></td>
            </tr>
            <tr>
                <th>Renfort_chambre</th>
                <td><?=$reservation->Renfort_chambre?></td>
            </tr>
            <tr>
                <th>Etage_chambre</th>
                <td><?=$reservation->Etage_chambre?></td>
            </tr>
            <tr>
                <th>Nbr_lits_chambre</th>
                <td><?=$reservation->Nbr_lits_chambre?></td>
            </tr>
            <tr>
                <th>Id_type</th>
                <td><?=$reservation->Id_type?></td>
            </tr>
            <tr>
                <th>Id_capacité</th>
                <td><?=$reservation->Id_capacité?></td>
            </tr>
            <tr>
                <th>Id_tarif</th>
                <td><?=$reservation->Id_tarif?></td>
            </tr>
        </table>

        <table class="table table-hover table-bordered table-dark">
            <tr>
                <th colspan="2" class="text-center">Les info de Chambre</th>
            </tr>
            <tr>
                <th>Id_Client</th>
                <td><?=$reservation->Id_Client?></td>
            </tr>
            <tr>
                <th>Nom_complet</th>
                <td><?=$reservation->Nom_complet?></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><?=$reservation->Sexe?></td>
            </tr>
            <tr>
                <th>Date_naissance</th>
                <td><?=$reservation->Date_naissance?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?=$reservation->Age?></td>
            </tr>
            <tr>
                <th>Pays</th>
                <td><?=$reservation->Pays?></td>
            </tr>
            <tr>
                <th>Ville</th>
                <td><?=$reservation->Ville?></td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td><?=$reservation->Adresse?></td>
            </tr>
            <tr>
                <th>Telephone</th>
                <td><?=$reservation->Telephone?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?=$reservation->Email?></td>
            </tr>
            <tr>
                <th>Autres_details</th>
                <td><?=$reservation->Autres_details?></td>
            </tr>
        </table>
    </div>
</body>
</html>