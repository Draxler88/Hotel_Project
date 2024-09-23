<?php
include "../../connexion.php";
include "../../Users/NavbarRec.php";
session_start();
$type = $connexion->prepare("SELECT * FROM type_chambre");
$type->execute();
$types = $type->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET["idSupType"])){
    $chamber = $connexion->prepare("SELECT * FROM chambre WHERE Id_type = ?");
    $chamber->execute([$_GET["idSupType"]]);
    if($chamber->rowCount() == 0){
        $connexion->prepare("DELETE FROM type_chambre WHERE Id_type = ?")->execute([$_GET["idSupType"]]);
        header("location:ListTypeChambre.php");
    }else{
        echo "<div class='alert alert-warning'>Type déjà lié à une chambre</div>";
    }
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Tarifs</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: white;
        }
        img{
            max-width: 100%;
        }
    </style>
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1 class="mb-4"><i class="bi bi-card-list"></i> Liste des Types</h1>
            </div>
            <div class="col-3 p-3">
                <a href="Typechambre.php" class="btn btn-success w-100 h-100"><i class="bi bi-people"></i> New Type</a>
            </div>
            <div class="col-3 p-3">
                <a href="../Chambre/ListChambre.php" class="btn btn-primary w-100 h-100"><i class="bi bi-list"></i> List Chambre</a>
            </div>
        </div>        <table class="table table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <th class="col-1">Id Type</th>
                    <th class="col-1">Type Chambre</th>
                    <th class="col-6">Description de Type</th>
                    <th class="col-2">Photo de Type</th>
                    <th class="col-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($types as $type) :?>
                <tr>
                    <td><?=$type->Id_type?></td>
                    <td><?=$type->Type_chambre?></td>
                    <td><?=$type->Description_type?></td>
                    <td><img src="../../Photos/<?=$type->Photos?>" alt=""></td>
                    <td  class="text-center">
                        <a href="?idSupType=<?=$type->Id_type?>" onclick="return confirm('Really')" class="btn btn-danger mt-5 mx-1"><i class="bi bi-trash"></i></a>
                        <a href="ModifierType.php?idModType=<?=$type->Id_type?>" class="btn btn-primary mt-5 mx-1"><i class="bi bi-pen"></i></a>
                        <a href="AfficherType.php?id=<?=$type->Id_type?>" class="btn btn-info mt-5 mx-1"><i class="bi bi-info"></i></a>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
</html>
