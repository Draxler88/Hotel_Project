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

$chambre = $connexion->prepare("SELECT * FROM chambre
                                INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type WHERE Id_chambre = ?");
$chambre->execute([$_GET["modifyid"]]);
$chambre = $chambre->fetchObject();



if(isset($_POST["modify"])){
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
        $send = $connexion->prepare("UPDATE chambre SET 	
            Numéro_chambre = ?,
            Nombre_adultes_enfants_ch = ?,	
            Renfort_chambre = ?,	
            Etage_chambre = ?,	
            Nbr_lits_chambre = ?,	
            Id_type = ?,	
            Id_capacité = ?,	
            Id_tarif = ?
            WHERE Id_chambre = ?
");
        $data = [
            $numero,
            $nombrepersonnes,
            $Renfort,
            $Etage,
            $Nombrelits,
            $type,
            $capacity,
            $tarif,
            $_GET["modifyid"]
        ];
        $send->execute($data);
        echo "<div class='alert alert-success'>Chambre Modify avec succes .</div>";
        header("location:ListChambre.php");
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
                <h1 class="mb-4">Modify Chambre</h1>
            </div>
            <div class="col-2 p-3">
                <a href="ListChambre.php" class="btn btn-danger"><i class="bi bi-backspace"></i> Back</a>
            </div>
        </div>
        
        <form class="" method="POST">
            <div class="mb-3">
                <label for="nc" class="form-label">Numéro Chambre</label>
                <input type="number" name="nchambre" id="nc" class="form-control" value="<?=$chambre->Numéro_chambre?>">
            </div>
            <div class="mb-3">
                <label for="tc" class="form-label">Type Chambre</label>
                <select name="typechambre" id="tc" class="form-select">
                    <option value="">----Choisir une------</option>
                    <?php foreach($typs as $type) :?>
                        <option <?php echo $chambre->Id_type == $type->Id_type ? "selected" : '';?> value="<?=$type->Id_type?>"><?=$type->Type_chambre?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nombrepersonne" class="form-label">Nombre des Personnes</label>
                <input type="number" name="nombrepersonne" value="<?=$chambre->Nombre_adultes_enfants_ch?>" id="nombrepersonne" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Renfort Chambre</label>
                <div class="form-check">
                    <input type="radio" <?php echo $chambre->Renfort_chambre == 0 ? "checked" : '';?> name="renfort" id="non" value="0" class="form-check-input">
                    <label for="non" class="form-check-label">Non</label>
                </div>
                <div class="form-check">
                    <input type="radio" <?php echo $chambre->Renfort_chambre == 1 ? "checked" : '';?> name="renfort" id="oui" value="1" class="form-check-input">
                    <label for="oui" class="form-check-label">Oui</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="etage" class="form-label">Étage Chambre</label>
                <input type="number" name="etagechambre" value="<?=$chambre->Etage_chambre?>" id="etage" class="form-control">
            </div>
            <div class="mb-3">
                <label for="lits" class="form-label">Nombre de Lits</label>
                <input type="number" name="nombrelits" value="<?=$chambre->Nbr_lits_chambre?>" id="lits" class="form-control">
            </div>
            <div class="mb-3">
                <label for="cc" class="form-label">Capacité Chambre</label>
                <select name="capacitychambre" id="cc" class="form-select">
                    <option value="">----Choisir une------</option>
                    <?php foreach($capacitys as $capacity) :?>
                        <option <?php echo $chambre->Id_capacité == $capacity->Id_capacité ? "selected" : '';?> value="<?=$capacity->Id_capacité?>"><?=$capacity->Titre_capacite?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tac" class="form-label">Tarif Chambre</label>
                <select name="tarifchambre" id="tac" class="form-select">
                    <option value="">----Choisir une------</option>
                    <?php foreach($tarifs as $tarif) :?>
                        <option <?php echo $chambre->Id_tarif == $tarif->Id_tarif ? "selected" : '';?> value="<?=$tarif->Id_tarif?>"><?=$tarif->Prix_base_nuit?></option>
                    <?php endforeach?>
                </select>
            </div>
            <div class="mb-3">
                    <input class="form-control" type="file" name="photo" id="" value="<?=$chambre->Photos?>">
            </div>
            <button type="submit" class="btn btn-primary" name="modify">Modify</button>
        </form>
    </div>
</body>
</html>