<?php
include "../connexion.php";
include "NavbarMan.php";
session_start();
$user = $connexion->prepare("SELECT * FROM users_app");
$user->execute();
$users = $user->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Table</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <?php style1()?>
</head>
<body>
<?php nav1()?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h2 class="mb-4 text-center">User Table</h2>
            </div>
            <div class="col-2">
                <a href="AjouterUser.php" class="btn btn-success">+ User</a>
            </div>
        </div>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Type</th>
                    <th>Etat</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) : ?>
                <tr  class="text-center">
                    <td><?=$user->Nom?></td>
                    <td><?=$user->Prénom?></td>
                    <td><?=$user->Username?></td>
                    <td><?=$user->Password?></td>
                    <td><?=$user->Type?></td>
                    <td class="<?= $user->Etat == "active" ? "text-success" : "text-danger" ?>"><?=$user->Etat?></td>
                    <?php if($user->Type == "receptionniste") : ?>
                    <td>
                        <a href="?id=<?=$user->Id_user?>" onclick="return confirm('Really')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                        <a href="Modify.php?id=<?=$user->Id_user?>" class="btn btn-sm btn-primary"><i class="bi bi-pen"></i></a>
                        <a href="Consultation.php?id=<?=$user->Id_user?>" class="btn btn-sm btn-info"><i class="bi bi-info"></i></a>
                    </td>
                    <?php endif ?>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</body>
</html>
