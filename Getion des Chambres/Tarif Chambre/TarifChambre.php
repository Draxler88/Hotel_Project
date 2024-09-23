<?php
        include "../../connexion.php";
        include "../../Users/NavbarRec.php";
        session_start();
        if(isset($_POST["send"])){
            if(empty($_POST["prix_base_nuit"]) || empty($_POST["prix_base_passage"])){
                echo "<div class='alert alert-danger'>veuillez saisir tout les champs !!</div>";
            }else{
                $nuit = $_POST["prix_base_nuit"];
                $passage = $_POST["prix_base_passage"];
                $_POST["n_prix_nuit"] ? $newnuit = $_POST["n_prix_nuit"] : $newnuit = 0;
                $_POST["n_prix_passage"] ? $newpassage = $_POST["n_prix_passage"] : $newpassage = 0;
                $tarifa = $connexion->prepare("INSERT INTO tarif_chambre VALUES (null,?,?,?,?)");
                $data = [
                    $nuit,
                    $passage,
                    $newnuit,
                    $newpassage
                ];
                $tarifa->execute($data);
                echo "<div class='alert alert-success'>Tarif Chambre ajouter avec succes .</div>";
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Tarif</title>
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
                <h1 class="mb-4">New Tarif Chambre</h1>
            </div>
            <div class="col-2 p-3">
                <a href="ListTarifChambre.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
        </div>
        <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="prix_nuit" class="form-label">Prix Base Nuit</label>
                    <input type="number" name="prix_base_nuit" id="prix_nuit" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="prix_passage" class="form-label">Prix Base Passage</label>
                    <input type="number" name="prix_base_passage" id="prix_passage" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="n_prix_nuit" class="form-label">Nouveau Prix Nuit pour Ancien Client</label>
                    <input type="number" name="n_prix_nuit" id="n_prix_nuit" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="n_prix_passage" class="form-label">Nouveau Prix Passage pour Ancien Client</label>
                    <input type="number" name="n_prix_passage" id="n_prix_passage" class="form-control">
                </div>
            </div>
            <button type="submit" name="send" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
</body>
</html>
