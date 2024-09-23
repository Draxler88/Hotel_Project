<?php
include "../../connexion.php";
include "../../Users/NavbarRec.php";
session_start();

$tarif = $connexion->prepare("SELECT * FROM tarif_chambre ");
$tarif->execute();
$tarifs = $tarif->fetchAll(PDO::FETCH_OBJ);

if(isset($_GET["idSupTarif"])){
    $chamber = $connexion->prepare("SELECT * FROM chambre WHERE Id_tarif = ?");
    $chamber->execute([$_GET["idSupTarif"]]);
    if($chamber->rowCount() == 0){
        $sup = $connexion->prepare("DELETE FROM tarif_chambre WHERE Id_tarif = ?");
        $sup->execute([$_GET["idSupTarif"]]);
        header("location:ListTarifChambre.php");
    }else{
        echo "<div class='alert alert-warning'>Tarif déjà lié à une chambre</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tarifs</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <h1 class="mb-4"><i class="bi bi-card-list"></i> Liste des Tarifs</h1>
            </div>
            <div class="col-3 p-3">
                <a href="TarifChambre.php" class="btn btn-success w-100 h-100"><i class="bi bi-people"></i> New Tarif</a>
            </div>
            <div class="col-3 p-3">
                <a href="../Chambre/ListChambre.php" class="btn btn-primary w-100 h-100"><i class="bi bi-list"></i> List Chambre</a>
            </div>
        </div>
            <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr class="text-center text-bold">
                    <th scope="col">Id Tarif</th>
                    <th scope="col">Prix de Nuit</th>
                    <th scope="col">Prix de Passage</th>
                    <th scope="col">Nouveau prix de nuit</th>
                    <th scope="col">Nouveau prix de passage</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tarifs as $tarif) :?>
                <tr>
                    <td><?=$tarif->Id_tarif?></td>
                    <td><?=$tarif->Prix_base_nuit?></td>
                    <td><?=$tarif->Prix_base_passage?></td>
                    <td><?=$tarif->N_Prix_nuit?></td>
                    <td><?=$tarif->N_Prix_passage?></td>
                    <td class="text-center">
                        <a href="?idSupTarif=<?=$tarif->Id_tarif?>" onclick="return confirm('Really')" class="btn btn-outline-danger"><i class="bi bi-trash"></i></a>
                        <a href="ModifyTarif.php?idModTarif=<?=$tarif->Id_tarif?>" class="btn btn-outline-primary"><i class="bi bi-pen"></i></a>
                    </td>
                </tr>
                <?php endforeach?>
            </tbody>
        </table>
    </div>
</body>
</html>
