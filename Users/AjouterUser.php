<?php
include "../connexion.php";
session_start();
$div = '';
$fault = '';
if(isset($_POST["sift"])){
    if(empty($_POST["nom"]) || empty($_POST["prenom"]) || empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["etat"]) || empty($_POST["type"])){
        $fault = "<div class='alert alert-warning'>Vuillez saisir tous les champs</div>";
    }else{
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $etat = $_POST["etat"];
        $type = $_POST["type"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $reponse = $connexion->prepare("INSERT INTO users_app VALUES (null,?,?,?,?,?,?)");
        $data = [
            $nom,
            $prenom,
            $username,
            $password,
            $type,
            $etat
        ];
        $reponse->execute($data);
        $div = "<div class='alert alert-success'>Nouveu compte Ajoute avec success</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-5">
        <?=$div?>
        <?=$fault?>
        <div class="row">
            <div class="col-10">
                <h1 class="mb-4">Ajouter Utilisateur</h1>
            </div>
            <div class="col-2">
                <a href="ListUsers.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Annuler</a>
            </div>
        </div>
        <form method="POST" >
            <div class="row">
                <div class="form-group col-6 my-2">
                    <label for="nom" class="mb-2">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrer Nom">
                </div>
                <div class="form-group col-6 my-2">
                    <label for="prenom" class="mb-2">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrer Prénom">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6 my-2">
                    <label for="username" class="mb-2">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Entrer Username">
                </div>
                <div class="form-group col-6 my-2">
                    <label for="password" class="mb-2">Password</label>
                    <input type="text" class="form-control" id="password" name="password" placeholder="Entrer Password">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6 my-2">
                    <label for="type" class="mb-2">Type</label>
                    <select class="form-control" id="type" name="type">
                        <option value="">----Choisir un Type----</option>
                        <option value="manager">Manager</option>
                        <option value="receptionniste">Le réceptionniste</option>
                        <option value="caissier">Caissier</option>
                    </select>
                </div>
                <div class="form-group col-6 my-2">
                    <label for="etat" class="mb-2">Etat</label>
                    <select class="form-control" id="etat" name="etat">
                        <option value="">----Choisir un Etat----</option>
                        <option value="active">Activé</option>
                        <option value="Bloque">Bloqué</option>
                    </select>
                </div>
            </div>
            <button type="submit" name="sift" class="btn btn-primary my-3">Ajouter</button>
        </form>
    </div>
</body>
</html>
