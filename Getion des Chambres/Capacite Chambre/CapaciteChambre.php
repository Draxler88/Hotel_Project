<?php 
session_start();

include "../../connexion.php";
include "../../Users/NavbarRec.php";
        if(isset($_POST["send"])){
            if(empty($_POST["numero_capacite"])){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs !!</div>";
            }else{
                $capacite = $connexion->prepare("INSERT INTO capacité_chambre VALUES (NULL,?,?)");
                $capacite->execute([$_POST["titre_capacite"],(int)$_POST["numero_capacite"]]);
                echo "<div class='alert alert-success'>Capacite Chambre ajouter avec succes .</div>";
            }
        }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Capacité</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
    </style>
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container">
        <div class="row">
            <div class="col-10 ">
                <h1 class="mb-4">New Capacity Chambre</h1>
            </div>
            <div class="col-2 p-3">
                <a href="ListCapaciteChambre.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
        </div>        
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            <div class="mb-3">
                <label for="titre" class="form-label">Titre Capacité</label>
                <input type="text" name="titre_capacite" id="titre" class="form-control" >
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Numéro Capacité</label>
                <input type="number" name="numero_capacite" id="numero" class="form-control">
            </div>
            <button type="submit" name="send" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
