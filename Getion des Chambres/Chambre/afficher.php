<?php
include("../../connexion.php");
include "../../Users/NavbarRec.php";
session_start();
$chambre = $connexion->prepare("SELECT * FROM chambre
INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
WHERE chambre.Id_chambre = ? 
");
$chambre->execute([$_GET["afficherid"]]);
$chambre = $chambre->fetchObject();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher client</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        th {
            color : red !important;
            padding: 10px;
        }
        td{
            font-weight: bold;
        }

    </style>
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1 class="align-self-center m-3 text-info">Details De Chambre <span class="text-primary"><?=$chambre->Numéro_chambre?></span></h1> 
            </div>
            <div class="col-2 mt-4 text-end">
                <a href="ListChambre.php" class="btn-danger btn text-center" name="back"><i class="bi bi-backspace"></i> Back</a>
            </div>
            <div class="col-2 mt-4">
                <a href="historique.php?id=<?=$chambre->Id_chambre?>" class="btn-info btn text-center" name="back"><i class="bi bi-clock-history"></i> Historique</a>
            </div>
        </div>

        <table class="table table-hover table-bordered table-info">
            <tr>
                <th>Id chambre</th>
                <td><?=$chambre->Id_chambre?></td>
            </tr>
            <tr>
                <th>Numero de chambre</th>
                <td><?=$chambre->Numéro_chambre?></td>
            </tr>
            <tr>
                <th>Nombre des adults</th>
                <td><?=$chambre->Nombre_adultes_enfants_ch?></td>
            </tr>
            <tr>
                <th>Renfort</th>
                <td><?=$chambre->Renfort_chambre == 0 ? "Non" : "Yes"?></td>
            </tr>
            <tr>
                <th>Etage</th>
                <td><?=$chambre->Etage_chambre?></td>
            </tr>
            <tr>
                <th>Number de lits</th>
                <td><?=$chambre->Nbr_lits_chambre?></td>
            </tr>
            <tr>
                <th>Type Chambre</th>
                <td><?=$chambre->Type_chambre?></td>
            </tr>
            <tr>
                <th>Description Type</th>
                <td><?=$chambre->Description_type?></td>
            </tr>
            <tr>
                <th>Titre Capacite</th>
                <td><?=$chambre->Titre_capacite?></td>
            </tr>
            <tr>
                <th>Numero Capacite</th>
                <td><?=$chambre->Numero_capacite?></td>
            </tr>
            <tr>
                <th>Prix Nuit</th>
                <td><?=$chambre->Prix_base_nuit?></td>
            </tr>
            <tr>
                <th>Prix Passage</th>
                <td><?=$chambre->Prix_base_passage?></td>
            </tr>
            <tr>
                <th>Photo</th>
                <td><img src="../../Photos/<?=$chambre->Photos?>" alt=""></td>
            </tr>
        </table>
    </div>
</body>
</html>