<?php
include "../../connexion.php";
include "../../Users/NavbarRec.php";
session_start();

if(isset($_GET["supprimerid"])){
    $reserv = $connexion->prepare("SELECT * FROM reservation WHERE Id_chambre = ?");
    $reserv->execute([$_GET["supprimerid"]]);
    if($reserv->rowCount()==0){
        $connexion->prepare("DELETE FROM chambre WHERE Id_chambre = ?")->execute([$_GET["supprimerid"]]);
        header("location:ListChambre.php");
    }else{
        echo "<div class='alert alert-warning'>chambre déjà un objet de réservation</div>";
    }
}
$chambre = $connexion->prepare("SELECT * FROM chambre 
INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif");
$chambre->execute();
$chambres = $chambre->fetchAll(PDO::FETCH_OBJ);



$request = $connexion->prepare("SELECT * FROM type_chambre");
$request->execute();
$types = $request->fetchAll(PDO::FETCH_OBJ);


$request = $connexion->prepare("SELECT * FROM capacité_chambre");
$request->execute();
$capacites = $request->fetchAll(PDO::FETCH_OBJ);



if (isset($_GET["search1"])) {
    if (empty($_GET["numero"]) && empty($_GET["type"]) && empty($_GET["capacite"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif");
        $chambre->execute();
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    } elseif (!empty($_GET["numero"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif      
                                        WHERE chambre.Numéro_chambre = ?");
        $chambre->execute([$_GET["numero"]]);
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    } elseif (!empty($_GET["type"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif      
                                        WHERE chambre.Id_type = ?");
        $chambre->execute([$_GET["type"]]);
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    } elseif (!empty($_GET["capacite"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif      
                                        WHERE chambre.Id_capacité = ?");
        $chambre->execute([$_GET["capacite"]]);
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    }
} 


if (isset($_GET["search2"])) {
    if (empty($_GET["date_debut"]) && empty($_GET["fin"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif");
        $chambre->execute();
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    } elseif (!empty($_GET["date_debut"]) && !empty($_GET["date_fin"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif
                                        INNER JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre      
                                        WHERE reservation.Date_arrivée AND reservation.Date_départ NOT BETWEEN ? AND ?");
        $chambre->execute([$_GET["date_debut"],$_GET["date_fin"]]);
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    }else{
        echo "<div class='alert alert-warning'>Saisir tous les champs(date_debut et date_fin)</div>";
    }
} 


if (isset($_GET["search3"])) {
    if (empty($_GET["min"]) && empty($_GET["max"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif");
        $chambre->execute();
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    } elseif (!empty($_GET["min"]) && !empty($_GET["max"])) {
        $chambre = $connexion->prepare("SELECT * FROM chambre 
                                        INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                        INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                        INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif
                                        WHERE tarif_chambre.Prix_base_nuit AND tarif_chambre.Prix_base_nuit BETWEEN ? AND ?");
        $chambre->execute([(floatval($_GET["min"])),floatval($_GET["max"])]);
        $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
    }else{
        echo "<div class='alert alert-warning'>Saisir tous les champs(Min_Prix et Max_Prix)</div>";
    }
} 
if(isset($_GET["annuler3"]) || isset($_GET["annuler1"]) || isset($_GET["annuler2"])){
    $chambre = $connexion->prepare("SELECT * FROM chambre 
                                    INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                    INNER JOIN capacité_chambre ON chambre.Id_capacité = capacité_chambre.Id_capacité
                                    INNER JOIN tarif_chambre ON chambre.Id_tarif  = tarif_chambre.Id_tarif");
    $chambre->execute();
    $chambres = $chambre->fetchAll(PDO::FETCH_OBJ);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Chambres</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-bottom: 20px;
        }
        .con {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            margin-top: 20px;
        }
        img{
            max-width: 100%;
        }
    </style>
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container con">
        <div class="row">
            <div class="col-9 bg-dark text-light rounded-3">
                <h1 class="mb-4 mt-2 "><i class="bi bi-list"></i> Liste Chambres</h1>
            </div>
            <div class="col-3">
                        <a href="AjouterChambre.php" class="btn btn-outline-success w-100 h-100 p-3"><div class="mt-2"><i class="bi bi-plus-circle"></i> New Chambre</div></a>
            </div>
        </div>
        <form >
            <div class="row mt-3 mx-4 border p-3">
                <div class="col-2 text-center">
                    <label for="" class="form-label">Numéro</label>
                    <input type="number" class="form-control" name="numero">
                </div>
                <div class="col-3 text-center">
                    <label for="" class="form-label">Type du chambre</label>
                    <select class="form-control text-center" name="type" id="">
                        <option value="">----Choisir un type----</option>
                        <?php foreach($types as $type) :?>
                        <option value="<?=$type->Id_type?>"><?=$type->Type_chambre?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="col-3 text-center">
                    <label for="" class="form-label">Capacite du chambre</label>
                    <select class="form-control text-center" name="capacite" id="">
                        <option value="">----Choisir un Capacite----</option>
                        <?php foreach($capacites as $capacite) :?>
                        <option value="<?=$capacite->Id_capacité?>"><?=$capacite->Titre_capacite?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="col-4 text-center mt-3">
                    <button type="submit" class="btn btn-success mt-3 mx-2" name="search1"  id=""><i class="bi bi-search"></i> Search</button>
                    <button type="submit" class="btn btn-danger mt-3 mx-2" name="annuler1"  id=""><i class="bi bi-x-circle"></i> Annuler</button>
                </div>
            </div>
        </form>
        <form>
        
            <div class="row mt-3 mx-4 border p-3">
                <div class="col-4 text-center">
                    <label for="" class="form-label">Date de début</label>
                    <input type="date" class="form-control" name="date_debut" id="">
                </div>
                <div class="col-4 text-center">
                    <label for="" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" name="date_fin" id="">
                </div>
                <div class="col-4 text-center mt-3">
                    <button type="submit" class="btn btn-success mt-3 mx-1" name="search2"  id=""><i class="bi bi-search"></i> Search</button>
                    <button type="submit" class="btn btn-danger mt-3 mx-1" name="annuler2"  id=""><i class="bi bi-x-circle"></i> Annuler</button>
                </div>
            </div>
        </form>
        <form>
        
            <div class="row mt-3 mx-4 border p-3">
                <div class="col-4 text-center">
                    <label for="" class="form-label">Min Prix</label>
                    <input type="number" class="form-control" name="min" id="">
                </div>
                <div class="col-4 text-center">
                    <label for="" class="form-label">Max Prix</label>
                    <input type="number" class="form-control" name="max" id="">
                </div>
                <div class="col-4 text-center mt-3">
                    <button type="submit" class="btn btn-success mt-3 mx-1" name="search3"  id=""><i class="bi bi-search"></i> Search</button>
                    <button type="submit" class="btn btn-danger mt-3 mx-1" name="annuler3"  id=""><i class="bi bi-x-circle"></i> Annuler</button>
                </div>
            </div>
        </form>
        <div class="table-container">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="col-1">Numéro</th>
                        <th class="col-1">Type</th>
                        <th class="col-1">Prix de Nuit</th>
                        <th class="col-1">Prix de passage</th>
                        <th class="col-1">Capacité</th>
                        <th class="col-1">Nombre de lits</th>
                        <th class="col-1">Etage</th>
                        <th class="col-1">Nombre des personnes</th>
                        <th class="col-2">Photos</th>
                        <th class="col-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($chambres as $chambre) :?>
                        <tr>
                            <td><?=$chambre->Numéro_chambre?></td>
                            <td><?=$chambre->Type_chambre?></td>
                            <td><?=$chambre->Prix_base_nuit?></td>
                            <td><?=$chambre->Prix_base_passage?></td>
                            <td><?=$chambre->Titre_capacite?></td>
                            <td><?=$chambre->Nbr_lits_chambre?></td>
                            <td><?=$chambre->Etage_chambre?></td>
                            <td><?=$chambre->Nombre_adultes_enfants_ch?></td>
                            <td><img src="../../Photos/<?=$chambre->Photos?>" alt=""></td>
                            <td>
                                <a href="?supprimerid=<?=$chambre->Id_chambre?>" onclick="return confirm('Really')" class="link btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></a>
                                <a href="modify.php?modifyid=<?=$chambre->Id_chambre?>" class="link btn btn-sm btn-outline-success"><i class="bi bi-pen"></i></a>
                                <a href="afficher.php?afficherid=<?=$chambre->Id_chambre?>" class="link btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                            </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
