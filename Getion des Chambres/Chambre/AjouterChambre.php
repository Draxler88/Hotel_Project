<?php
include("../../connexion.php");
include "../../Users/NavbarRec.php";
session_start();
$type = $connexion->prepare("SELECT * FROM type_chambre");
$type->execute();
$typs = $type->fetchAll(PDO::FETCH_OBJ);

$capacity = $connexion->prepare("SELECT * FROM capacité_chambre");
$capacity->execute();
$capacitys = $capacity->fetchAll(PDO::FETCH_OBJ);

$tarif = $connexion->prepare("SELECT * FROM tarif_chambre");
$tarif->execute();
$tarifs = $tarif->fetchAll(PDO::FETCH_OBJ);

if(isset($_POST["submit"])){
    $numero = $_POST["nchambre"];
    $type = $_POST["typechambre"];
    $nombrepersonnes = $_POST["nombrepersonne"];
    $Renfort = '';
    if(isset($_POST["renfort"])){
        $Renfort = $_POST["renfort"];
    }
    $Etage = $_POST["etagechambre"];
    $Nombrelits = $_POST["nombrelits"];
    $capacity = $_POST["capacitychambre"];
    $tarif = $_POST["tarifchambre"];

    if($numero == '' || $type == '' || $capacity == '' || $Nombrelits == '' || $Etage == '' || $tarif == '' || $nombrepersonnes == ''){
        echo "<div class='alert alert-warning'>Saisir les Champs</div>";
    }else{
        $send = $connexion->prepare("INSERT INTO chambre VALUES (NULL,?,?,?,?,?,?,?,?)");
        $data = [
            $numero,
            $nombrepersonnes,
            $Renfort,
            $Etage,
            $Nombrelits,
            $type,
            $capacity,
            $tarif
        ];
        $send->execute($data);
        echo "<div class='alert alert-success'>Chambre ajouter avec succes .</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Chambre</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container pb-4 mt-4">
        <div class="row">
            <div class="col-10">
                <h1 class="mb-4">Ajouter Chambre</h1>
            </div>
            <div class="col-2 p-3">
                <a href="ListChambre.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
        </div>
        <form class="" action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nc" class="form-label">Numéro Chambre</label>
                    <input type="number" name="nchambre" id="nc" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="tc" class="form-label">Type Chambre</label>
                    <select name="typechambre" id="tc" class="form-select">
                        <option value="">----Choisir une------</option>
                        <?php foreach($typs as $type) :?>
                            <option value="<?=$type->Id_type?>"><?=$type->Type_chambre?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="nombrepersonne" class="form-label">Nombre des Personnes</label>
                    <input type="number" name="nombrepersonne" id="nombrepersonne" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label class="form-label">Renfort Chambre</label>
                    <div class="form-check">
                        <input type="radio" name="renfort" id="non" value="0" class="form-check-input">
                        <label for="non" class="form-check-label">Non</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="renfort" id="oui" value="1" class="form-check-input">
                        <label for="oui" class="form-check-label">Oui</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="etage" class="form-label">Étage Chambre</label>
                    <input type="number" name="etagechambre" id="etage" class="form-control">
                </div>
                <div class="mb-3 col-6">
                    <label for="lits" class="form-label">Nombre de Lits</label>
                    <input type="number" name="nombrelits" id="lits" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-6">
                    <label for="cc" class="form-label">Capacité Chambre</label>
                    <select name="capacitychambre" id="cc" class="form-select">
                        <option value="">----Choisir une------</option>
                        <?php foreach($capacitys as $capacity) :?>
                            <option value="<?=$capacity->Id_capacité?>"><?=$capacity->Titre_capacite?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="mb-3 col-6">
                    <label for="tac" class="form-label">Tarif Chambre</label>
                    <select name="tarifchambre" id="tac" class="form-select">
                        <option value="">----Choisir une------</option>
                        <?php foreach($tarifs as $tarif) :?>
                            <option value="<?=$tarif->Id_tarif?>"><?=$tarif->Prix_base_nuit?></option>
                        <?php endforeach?>
                    </select>
                </div>
            </div>
                <button type="submit" class="btn btn-primary" name="submit">Enregistrer</button>
        </form>
    </div>
</body>
</html>
