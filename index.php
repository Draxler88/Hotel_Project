<?php
include "connexion.php";
session_start();
$arak = '';
$users = $connexion->prepare("SELECT * FROM users_app");
$users->execute();
$users = $users->fetchAll(PDO::FETCH_OBJ);
if(isset($_POST["sift"])){
    if(empty($_POST["username"]) || empty($_POST["password"])){
        $arak = "<div class='alert alert-danger'>Saisir tous les Champs</div>";
    }else{
        foreach($users as $user){
            if($user->Username == $_POST["username"] and $user->Password == $_POST["password"]){
                if($user->Type == "manager"){
                    $_SESSION["nom_complet"] = $user->Nom . " " . $user->Prénom;
                    $_SESSION["type"] = $user->Type;
                    header("location:Users/Manager.php");
                }
                elseif($user->Type == "receptionniste" && $user->Etat == "active"){
                    $_SESSION["nom_complet"] = $user->Nom . " " . $user->Prénom;
                    $_SESSION["type"] = $user->Type;
                    $_SESSION["etat"] = $user->Etat ;
                    header("location:Users/Receptionniste.php");
                }else{
                    $_SESSION["nom_complet"] = $user->Nom . " " . $user->Prénom;
                    $_SESSION["etat"] = $user->Etat ;
                    $_SESSION["type"] = $user->Type;
                    header("location:Users/Receptionniste.php");
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accuille</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body style="min-height: 100vh;" class="d-flex align-items-center justify-content-center bg-light">
    <div class=" w-50 bg-dark-subtle p-4 rounded-4 shadow-sm">
        <h1 class="text-center">Admin Login</h1>
        <div class="">
            <p class="text-center">sign in to start session</p>
            <form action="" method="post">
                <input class="form-control" type="text" name="username" id="" placeholder="Username"><br>
                <input  class="form-control" type="password" name="password" id="" placeholder="Password">
                <button class="btn btn-primary mt-3 w-100" type="submit" name="sift">Login</button>
            </form>
        </div>
    </div>
</body>
</html>