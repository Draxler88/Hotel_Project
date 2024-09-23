<?php
            include "../../connexion.php";
            include "../../Users/NavbarRec.php";
            session_start();
            echo "<div></div>";
            if(isset($_POST["send"])){
                if(empty($_POST["type_chambre"]) || empty($_POST["description_type"])){
                    header("location:Typechambre.php?alert=5");
                }else{
                $resulta = $connexion->prepare("INSERT INTO type_chambre VALUES (NULL,?,?,?)");
                $resulta->execute([$_POST["type_chambre"],$_POST["description_type"],$_POST["photo"]]);
                header("location:Typechambre.php?alert=6");
                }
            }

if (isset($_GET["alert"])){
    if ($_GET["alert"] == 5){
        echo "<div class='alert alert-danger'>veuillez saisir tout les champs !!</div>";
    } else if ($_GET["alert"] == 6){
        echo "<div class='alert alert-success'>le nouveau type est ajouter avec success</div>";
    }
}

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
                <label for="type" class="form-label">Type Chambre</label>
                <input type="text" name="type_chambre" id="type" class="form-control">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description Type</label>
                <input type="text" name="description_type" id="description" class="form-control">
            </div>
            <div class="mb-3">
                <label for="phototype" class="form-label">Photos Type</label>
                <input type="file" class="form-control" name="photo" id="phototype">
            </div>
            <button type="submit" name="send" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
