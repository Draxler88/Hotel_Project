<?php
include "../../connexion.php";
include "../../Users/NavbarRec.php";
session_start();
$capacite = $connexion->prepare("SELECT * FROM capacité_chambre");
$capacite->execute();
$capacits = $capacite->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET["idcapacite"])){
    $chamber = $connexion->prepare("SELECT * FROM chambre WHERE Id_capacité = ?");
    $chamber->execute([$_GET["idcapacite"]]);
    if($chamber->rowCount() == 0){
        $sup = $connexion->prepare("DELETE FROM capacité_chambre WHERE Id_capacité = ?");
        $sup->execute([$_GET["idcapacite"]]);
        header("location:ListCapaciteChambre.php");
    }else{
        echo "<div class='alert alert-warning'>Capacite déjà lié à une chambre</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Capacités de Chambre</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <h1 class="mb-4"><i class="bi bi-card-list"></i> Liste des Capacités</h1>
            </div>
            <div class="col-3 p-3">
                <a href="CapaciteChambre.php" class="btn btn-success w-100 h-100"><i class="bi bi-people"></i> New Capacité</a>
            </div>
            <div class="col-3 p-3">
                <a href="../Chambre/ListChambre.php" class="btn btn-primary w-100 h-100"><i class="bi bi-list"></i> List Chambre</a>
            </div>
        </div>
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr class="text-center">
                    <th scope="col">Id_capacité</th>
                    <th scope="col">Titre_capacite</th>
                    <th scope="col">Numero_capacite</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($capacits as $capacite) :?>
                <tr>
                    <td><?=$capacite->Id_capacité?></td>
                    <td><?=$capacite->Titre_capacite?></td>
                    <td><?=$capacite->Numero_capacite?></td>
                    <td class="text-center">
                        <a href="?idcapacite=<?=$capacite->Id_capacité?>" onclick="return confirm('Really')" class="btn btn-outline-danger"><i class="bi bi-trash"></i></a>
                        <a href="ModifyCapacite.php?idModCapacite=<?=$capacite->Id_capacité?>" class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
</html>
