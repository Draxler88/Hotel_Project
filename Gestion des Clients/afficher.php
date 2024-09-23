<?php
include("../connexion.php");
include "../Users/NavbarRec.php";
session_start();
$result = $connexion->prepare("SELECT * FROM client WHERE Id_Client = ?");
$result->execute([$_GET["id"]]);
$client = $result->fetchObject();
if(isset($_GET["back"])){
    header("location:listClients.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher client</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <style>
        th{
            color : yellow !important;
        }
    </style>
        <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1 class="align-self-center m-3 text-info">Details De <span class="text-primary"><?=$client->Nom_complet?></span></h1> 
            </div>
            <div class="col-2 mt-4 text-end">
                <form action="">
                    <button class="btn-danger btn text-center " name="back"><i class="bi bi-arrow-left-circle"></i> Back</button>
                </form>
            </div>
        </div>
        <table class="table table-hover table-bordered table-dark">
            <tr>
            <th>Id</th>
            <td><?=$client->Id_Client?></td>
            </tr>
            <tr>
                <th>Nom complet</th>
                <td><?=$client->Nom_complet?></td>
            </tr>
            <tr>
                <th>Sexe</th>
                <td><?=$client->Sexe?></td>
            </tr>
            <tr>
                <th>Date Naissance</th>
                <td><?=$client->Date_naissance?></td>
            </tr>
            <tr>
                <th>Age</th>
                <td><?=$client->Age?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?=$client->Pays?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?=$client->Ville?></td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td><?=$client->Adresse?></td>
            </tr>
            <tr>
                <th>Telephone</th>
                <td><?=$client->Telephone?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?=$client->Email?></td>
            </tr>
            <tr>
                <th>Autre details</th>
                <td><?=$client->Autres_details?></td>
            </tr>
        </table>
    </div>
</body>
</html>