
<?php
include "../connexion.php";
include "../Users/NavbarRec.php";
session_start();
$id = $_GET["id"];
$date_arrivee = $_GET["date_arrivee"];
$date_depart = $_GET["date_depart"];
$nombre_adults_enfants = $_GET["nbr"];
$type = $_GET["id_type"];

$client = $connexion->prepare("SELECT * FROM client");
$client->execute();
$clients = $client->fetchAll(PDO::FETCH_OBJ); #for clients


$arak = '';
$mcha = '';
$pro_date = '';


if(isset($_POST["sift"])){
    $chambre = $connexion->prepare("SELECT * FROM chambre
                                INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
                                WHERE type_chambre.Id_type = ? AND chambre.Nombre_adultes_enfants_ch >= ?
                                AND chambre.Id_chambre = ?
                                ");
    $chambre->execute([$type,$nombre_adults_enfants,$id]);
    $chambre = $chambre->fetchObject();

    if(empty($_POST["code_reservation"]) || empty($_POST["client"])){
        $arak = "<div class='alert alert-warning'>Echec de votre Informations</div>";
    }else{
        $info = $connexion->prepare("INSERT INTO reservation (Code_reservation, Date_heure_reservation, Date_arrivée, Date_départ, Nbr_jours, Nbr_adultes_enfants, Montant_total, Etat, Id_client, Id_chambre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    
        $code = $_POST["code_reservation"];
        $date_time_resrv = date("Y-m-d H:i:s");
        $arrivee_number = strtotime($date_arrivee);
        $depart_number = strtotime($date_depart);
        $nombre_des_jours = ceil(($depart_number  - $arrivee_number)/(60 * 60 * 24));
        $id_client = $_POST["client"];
        $id_chambre = $id;
        $prix_nuit = (float)$chambre->Prix_base_nuit;
        $montant_total = $prix_nuit * $nombre_des_jours;
        $date_now = date("Y-m-d");


        

            if($date_arrivee > $date_now and $date_depart > $date_now){
                $Etat = "Planifiée";
            }else if($date_arrivee <= $date_now and $date_depart >= $date_now){
                $Etat = "En cours";
            }elseif($date_arrivee < $date_now and $date_depart < $date_now){
                $Etat = "Terminée";
            }
            
            $data = [
                $code,
                $date_time_resrv,
                $date_arrivee,
                $date_depart,
                $nombre_des_jours,
                $nombre_adults_enfants,
                $montant_total,
                $Etat,
                $id_client,
                $id
            ];
            $info->execute($data);
            $mcha = "<div class='alert alert-success'>Informations envoyer</div>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Réservation</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h1 class="mb-4">Ajouter Réservation</h1>
            </div>
            <div class="col-2">
                <a href="ListReservation.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Back</a>
            </div>
        </div>
        <?php echo $mcha?>
        <?php echo $arak?>
        <?php echo $pro_date?>
        <div class="mb-2">
            <form  method="POST">
                <div class="row mb-3">
                    <div class="col-6 mb-3">
                        <label for="code_reservation" class="form-label">Code Réservation</label>
                        <input type="text" name="code_reservation" id="code_reservation" class="form-control">
                    </div>
                    <div class="col-6">
                        <label for="id_client" class="form-label">ID Client</label>
                        <select class="form-control" name="client" id="id_client">
                            <option value="">----Choisir un Client----</option>
                            <?php foreach($clients as $client) :?>
                            <option value="<?=$client->Id_Client?>"><?=$client->Nom_complet?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="sift" class="btn btn-primary">Ajouter</button>
            </form>
        </div>
    </div>
</body>
</html>
