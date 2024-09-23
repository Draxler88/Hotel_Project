<?php
include("../connexion.php");
include "NavbarMan.php";
session_start();
$result = $connexion->prepare("SELECT * FROM users_app WHERE Id_user = ?");
$result->execute([$_GET["id"]]);
$user = $result->fetchObject();
if(isset($_GET["back"])){
    header("location:listUsers.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher user</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <style>
        th{
            color : yellow !important;
        }
    </style>
        <?php style1() ?>
</head>
<body>
<?php nav1() ?>
    <div class="container">
        <div class="row">
            <div class="col-8">
                <h1 class="align-self-center m-3 text-info">Details De <span class="text-primary"><?=$user->Nom?></span></h1> 
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
            <td><?=$user->Id_user?></td>
            </tr>
            <tr>
                <th>Nom</th>
                <td><?=$user->Nom?></td>
            </tr>
            <tr>
                <th>Prenom</th>
                <td><?=$user->Prénom?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?=$user->Username?></td>
            </tr>
            <tr>
                <th>Password</th>
                <td><?=$user->Password?></td>
            </tr>
            <tr>
                <th>Type</th>
                <td><?=$user->Type?></td>
            </tr>
            <tr>
                <th>Etat</th>
                <td><?=$user->Etat?></td>
            </tr>
        </table>
    </div>
</body>
</html>