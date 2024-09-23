<?php
            include "../../connexion.php";
            include "../../Users/NavbarRec.php";
            session_start();
            echo "<div></div>";
            if(isset($_POST["Modifier"])){
                if(empty($_POST["type_chambre"]) || empty($_POST["description_type"])){
                    header("location:Typechambre.php?alert=5");
                }else{
                $resulta = $connexion->prepare("UPDATE type_chambre SET
                Type_chambre = ?,
                Description_type= ?,
                Photos = ?
                WHERE Id_type = ?
                ");
                $resulta->execute([$_POST["type_chambre"],$_POST["description_type"],$_POST["photo"],$_GET["idModType"]]);
                header("location:Typechambre.php?alert=6");
                header("location:ListTypeChambre.php");
                }
            }

            if (isset($_GET["alert"])){
                if ($_GET["alert"] == 5){
                    echo "<div class='alert alert-danger'>veuillez saisir tout les champs !!</div>";
                } else if ($_GET["alert"] == 6){
                    echo "<div class='alert alert-success'>le nouveau type est ajouter avec success</div>";
                }
            }
            $mod = $connexion->prepare("SELECT * FROM type_chambre WHERE Id_type = ?");
            $mod->execute([$_GET["idModType"]]);
            $resultat = $mod->fetchObject();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Type Chambre</title>
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
            <div class="col-10">
                <h1 class="mb-4">New Type Chambre</h1>
            </div>
            <div class="col-2 p-3">
                <a href="ListTypeChambre.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
        </div>        
        <form action="" method="POST">
            <div class="mb-3">
                <label for="type" class="form-label">New Type Chambre</label>
                <input type="text" name="type_chambre" id="type" class="form-control" value="<?=$resultat->Type_chambre?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">New Description Type</label>
                <textarea type="text" name="description_type" rows="5" id="description" placeholder="Description Type" class="form-control"><?=$resultat->Description_type?></textarea>
            </div>
            <div class="mb-3">
                <label for="phototype" class="form-label">Photos Type</label>
                <input type="file" class="form-control" name="photo" id="phototype" value="<?=$resultat->Photos?>">
            </div>
            <button type="submit" name="Modifier" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
</html>
