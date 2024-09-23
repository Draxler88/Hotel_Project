<?php
include "../connexion.php";
session_start();

$type = $connexion->prepare("SELECT * FROM type_chambre");
$type->execute();
$types = $type->fetchAll(PDO::FETCH_OBJ);

$arak = '';
$mcha = '';
$pro_date = '';

$date_arrivee = $_GET["date_arrivee"];
$date_depart = $_GET["date_depart"];
$nombre_adults_enfants = $_GET["nbr"];
$type = $_GET["type"];
$id_reservation = $_GET["id"];
$chambres = [];


if (isset($_POST["Search"])) {
    $condition = "";
    $vars = [];
    if ($_POST["date_depart"] != "" && $_POST["date_arrivee"] != "") {
        $condition .= $condition != "" ? " AND chambre.Id_chambre NOT IN (
                SELECT reservation.Id_chambre FROM reservation 
                WHERE (reservation.Date_arrivée BETWEEN ? AND ?)
                OR (reservation.Date_départ BETWEEN ? AND ?)
                OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
                OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ))" :
            "chambre.Id_chambre NOT IN (
                SELECT reservation.Id_chambre FROM reservation 
                WHERE (reservation.Date_arrivée BETWEEN ? AND ?)
                OR (reservation.Date_départ BETWEEN ? AND ?)
                OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
                OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ))";
        array_push($vars, $_POST["date_arrivee"], $_POST["date_depart"], $_POST["date_arrivee"], $_POST["date_depart"], $_POST["date_arrivee"], $_POST["date_depart"]);
    }
    if ($_POST["nbr_adultes_enfants"] != "") {
        $condition .= $condition != "" ? " AND chambre.Nombre_adultes_enfants_ch >= ?" : "chambre.Nombre_adultes_enfants_ch >= ?";
        array_push($vars, $_POST["nbr_adultes_enfants"]);
    }
    if ($_POST["type"] != "") {
        $condition .= $condition != "" ? " AND type_chambre.Id_type = ?" : "type_chambre.Id_type = ?";
        array_push($vars, $_POST["type"]);
    }
    $date_arrivee = $_POST["date_arrivee"];
    $date_depart = $_POST["date_depart"];
    $nombre_adults_enfants = $_POST["nbr_adultes_enfants"];
    $type = $_POST["type"];


    if ($date_arrivee <= $date_depart) {
        $requet = $connexion->prepare("SELECT * FROM chambre
                                    INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                                    INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
                                    INNER JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre
                                    WHERE $condition
                                    ");
        $requet->execute($vars);
        $chambres = $requet->fetchAll(PDO::FETCH_OBJ);
        if ($requet->rowCount() > 0) {
            $mcha = "<div class='alert alert-success'>لقينا ليك شي غرف</div>";
        }
    } else {
        $arak = "<div class='alert alert-warning'>وقت الحجز اكبر من وقت المغادرة</div>";
    }
}

if (isset($_POST["modify"])) {

    $chambra = $connexion->prepare("SELECT * FROM chambre
    INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
    WHERE chambre.Id_chambre = ?
    ");
    $chambra->execute([$_POST["modify"]]);
    $chambr = $chambra->fetchObject();

    $date_now = date("Y-m-d");
    $date_arrivee = $_POST["dateArrivee"];
    $date_depart = $_POST["dateDepart"];
    $nombre_adults_enfants = $_GET["nbr"];
    $type = $_GET["type"];
    // $arrivee_number = strtotime($date_arrivee);
    $arrivee_number = new DateTime($date_arrivee);
    $depart_number = new DateTime($date_depart);
    // $depart_number = strtotime($date_depart);
    // $nbr_jours = ceil(($depart_number  - $arrivee_number) / (60 * 60 * 24));
    $nbr_jours = $depart_number->diff($arrivee_number)->d;
    $prix_nuit = (float)$chambr->Prix_base_nuit;
    $montant_total = $prix_nuit * $nbr_jours;
    if ($date_arrivee > $date_now and $date_depart > $date_now) {
        $Etat = "Planifiée";
    } else if ($date_arrivee <= $date_now and $date_depart >= $date_now) {
        $Etat = "En cours";
    } elseif ($date_arrivee < $date_now and $date_depart < $date_now) {
        $Etat = "Terminée";
    }

    $mody = $connexion->prepare("UPDATE reservation SET 
                                    Date_arrivée = ?,	
                                    Date_départ	= ?,
                                    Nbr_jours = ?,
                                    Nbr_adultes_enfants	= ?,
                                    Montant_total = ?,
                                    Etat = ?,
                                    Id_chambre = ?
                                    WHERE reservation.Id_reservation = ?");
    if ($mody->execute([$date_arrivee, $date_depart, $nbr_jours, $nombre_adults_enfants, $montant_total, $Etat, $chambr->Id_chambre, $_GET["id"]])) {
        header("location:ListReservation.php");
    }
}

// if (!empty($_POST["date_depart"]) && !empty($_POST["date_arrivee"]) && !empty($_POST["nbr_adultes_enfants"]) && !empty($_POST["type"])) {
//     if (isset($_POST["modify"])) {


//         $chambra = $connexion->prepare("SELECT * FROM chambre
//         INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
//         WHERE chambre.Id_chambre = ?
//         ");
//         $chambra->execute([$_POST["modify"]]);
//         $chambr = $chambra->fetchObject();


//         $date_arrivee = $_POST["date_arrivee"];
//         $date_depart = $_POST["date_depart"];
//         $nombre_adults_enfants = $_POST["nbr"];
//         $type = $_POST["type"];
//         $arrivee_number = strtotime($date_arrivee);
//         $depart_number = strtotime($date_depart);
//         $nbr_jours = ceil(($depart_number  - $arrivee_number) / (60 * 60 * 24));
//         $prix_nuit = (float)$chambr->Prix_base_nuit;
//         $montant_total = $prix_nuit * $nombre_des_jours;
//         if ($date_arrivee > $date_now and $date_depart > $date_now) {
//             $Etat = "Planifiée";
//         } else if ($date_arrivee <= $date_now and $date_depart >= $date_now) {
//             $Etat = "En cours";
//         } elseif ($date_arrivee < $date_now and $date_depart < $date_now) {
//             $Etat = "Terminée";
//         }
//         $id_chambre = $_GET["id_chambre"];

//         $mody = $connexion->prepare("UPDATE reservation SET 
//                                         Date_arrivée = ?	
//                                         Date_départ	= ?
//                                         Nbr_jours = ?
//                                         Nbr_adultes_enfants	= ?
//                                         Montant_total = ?
//                                         Etat = ?
//                                         Id_chambre = ?
//                                         WHERE reservation.Id_reservation = ?");
//         $mody->execute([$date_arrivee, $date_depart, $nbr_jours, $nombre_adults_enfants, $montant_total, $Etat, $id_chambre, $id_reservation]);
//         header("location:ListReservation.php");
//     }
// } elseif (!empty($_POST["date_depart"]) && !empty($_POST["date_arrivee"]) && !empty($_POST["nbr_adultes_enfants"])) {

//     if (isset($_POST["modify"])) {
//         $chambra = $connexion->prepare("SELECT * FROM chambre
//                                 INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
//                                 WHERE chambre.Id_chambre = ?
//                                 ");
//         $chambra->execute([$_POST["modify"]]);
//         $chambr = $chambra->fetchObject();


//         $date_arrivee = $_POST["date_arrivee"];
//         $date_depart = $_POST["date_depart"];
//         $nombre_adults_enfants = $_POST["nbr"];
//         $arrivee_number = strtotime($date_arrivee);
//         $depart_number = strtotime($date_depart);
//         $nbr_jours = ceil(($depart_number  - $arrivee_number) / (60 * 60 * 24));
//         $prix_nuit = (float)$chambr->Prix_base_nuit;
//         $montant_total = $prix_nuit * $nombre_des_jours;
//         if ($date_arrivee > $date_now and $date_depart > $date_now) {
//             $Etat = "Planifiée";
//         } else if ($date_arrivee <= $date_now and $date_depart >= $date_now) {
//             $Etat = "En cours";
//         } elseif ($date_arrivee < $date_now and $date_depart < $date_now) {
//             $Etat = "Terminée";
//         }
//         $id_chambre = $_GET["id_chambre"];

//         $mody = $connexion->prepare("UPDATE reservation SET 
//                                         Date_arrivée = ?	
//                                         Date_départ	= ?
//                                         Nbr_jours = ?
//                                         Nbr_adultes_enfants	= ?
//                                         Montant_total = ?
//                                         Etat = ?
//                                         Id_chambre = ?
//                                         WHERE reservation.Id_reservation = ?");
//         $mody->execute([$date_arrivee, $date_depart, $nbr_jours, $nombre_adults_enfants, $montant_total, $Etat, $id_chambre, $id_reservation]);
//         header("location:ListReservation.php");
//     }
// }

// if (isset($_POST["Search"])) {
//     if (!empty($_POST["date_depart"]) && !empty($_POST["date_arrivee"]) && !empty($_POST["nbr_adultes_enfants"]) && !empty($_POST["type"])) {
//         $date_arrivee = $_POST["date_arrivee"];
//         $date_depart = $_POST["date_depart"];
//         $nombre_adults_enfants = $_POST["nbr_adultes_enfants"];
//         $type = $_POST["type"];

//         if ($date_arrivee <= $date_depart) {
//             $requet = $connexion->prepare("SELECT * FROM chambre
//                                     INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
//                                     INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
//                                     INNER JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre
//                                     WHERE chambre.Id_chambre NOT IN (
//                                         SELECT reservation.Id_chambre FROM reservation 
//                                         WHERE (reservation.Date_arrivée BETWEEN ? AND ?)
//                                         OR (reservation.Date_départ BETWEEN ? AND ?)
//                                         OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
//                                         OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
//                                     )
//                                     AND chambre.Nombre_adultes_enfants_ch >= ?
//                                     AND type_chambre.Id_type = ?
//                                     ");
//             $requet->execute([$date_arrivee, $date_depart, $date_arrivee, $date_depart, $date_arrivee, $date_depart, $nombre_adults_enfants, $type]);
//             $chambres = $requet->fetchAll(PDO::FETCH_OBJ);
//             if ($requet->rowCount() > 0) {
//                 $mcha = "<div class='alert alert-success'>لقينا ليك شي غرف</div>";
//             }
//         } else {
//             $arak = "<div class='alert alert-warning'>وقت الحجز اكبر من وقت المغادرة</div>";
//         }
//     } elseif (!empty($_POST["date_depart"]) && !empty($_POST["date_arrivee"]) && !empty($_POST["nbr_adultes_enfants"])) {

//         $date_arrivee = $_POST["date_arrivee"];
//         $date_depart = $_POST["date_depart"];
//         $nombre_adults_enfants = $_POST["nbr_adultes_enfants"];
//         $type = $_POST["type"];

//         if ($date_arrivee <= $date_depart) {
//             $requet = $connexion->prepare("SELECT * FROM chambre
//                                                 INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
//                                                 INNER JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre
//                                                 INNER JOIN tarif_chambre ON chambre.Id_tarif = tarif_chambre.Id_tarif
//                                                 WHERE chambre.Id_chambre NOT IN (
//                                                     SELECT reservation.Id_chambre FROM reservation 
//                                                     WHERE (reservation.Date_arrivée BETWEEN ? AND ?)
//                                                     OR (reservation.Date_départ BETWEEN ? AND ?)
//                                                     OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
//                                                     OR (? BETWEEN reservation.Date_arrivée AND reservation.Date_départ)
//                                                 )
//                                                 AND chambre.Nombre_adultes_enfants_ch >= ?
//                                                 ");
//             $requet->execute([$date_arrivee, $date_depart, $date_arrivee, $date_depart, $date_arrivee, $date_depart, $nombre_adults_enfants]);
//             $chambres = $requet->fetchAll(PDO::FETCH_OBJ);


//             if ($requet->rowCount() > 0) {
//                 $mcha = "<div class='alert alert-success'>لقينا ليك شي غرف</div>";
//             }
//         } else {
//             $arak = "<div class='alert alert-warning'>وقت الحجز اكبر من وقت المغادرة</div>";
//         }
//     } else {
//         $arak = "<div class='alert alert-warning'>باقي شي حقول خاويين</div>";
//     }
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Réservation</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-10">
                <h1 class="mb-4">Ajouter Réservation</h1>
            </div>
            <div class="col-2">
                <a href="ListReservation.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Annuler</a>
            </div>
        </div>
        <?php echo $mcha ?>
        <?php echo $arak ?>
        <?php echo $pro_date ?>
        <div class="mb-2">
            <form method="POST">
                <div class="row my-2">
                    <div class="mb-3 col-6">
                        <label for="date_arrivee" class="form-label">Date d'Arrivée</label>
                        <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" value="<?= $date_arrivee ?>">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="date_depart" class="form-label">Date de Départ</label>
                        <input type="date" name="date_depart" id="date_depart" class="form-control" value="<?= $date_depart ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 mb-3">
                        <label for="nbr_adultes_enfants" class="form-label">Nombre d'Adultes et Enfants</label>
                        <input type="number" name="nbr_adultes_enfants" id="nbr_adultes_enfants" class="form-control" value="<?= $nombre_adults_enfants ?>">
                    </div>
                    <div class="col-6">
                        <label for="type_chambre" class="form-label">Type chambre</label>
                        <select class="form-control" name="type" id="type_chambre">
                            <option value="">----Choisir un Type----</option>
                            <?php foreach ($types as $type) : ?>
                                <option value="<?= $type->Id_type ?>"><?= $type->Type_chambre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="Search" class="btn btn-primary">Search</button>
            </form>
        </div>
        <?php if (isset($_POST["Search"])) : ?>
            <?php if ($date_arrivee <= $date_depart) : ?>
                <?php if ($requet->rowCount() > 0) : ?>
                    <table class="table table-hover table-dark mt-3">
                        <tr>
                            <th class="p-3">Numero chambre</th>
                            <th class="p-3">Type</th>
                            <th class="p-3">Nombre Adults et Enfants</th>
                            <th class="p-3">Pirioude</th>
                            <th class="p-3">Action</th>
                        </tr>
                        <?php foreach ($chambres as $chambre) : ?>
                            <tr>
                                <td><?= $chambre->Numéro_chambre ?></td>
                                <td><?= $chambre->Type_chambre ?></td>
                                <td><?= $chambre->Nombre_adultes_enfants_ch ?></td>
                                <td>Du <?= $chambre->Date_arrivée ?> jusqua <?= $chambre->Date_départ ?></td>
                                <td>
                                    <form action="" method="post">
                                        <button name="modify" value="<?= $chambre->Id_chambre ?>" class="btn btn-primary btn-sm">Modifier <i class="bi bi-arrow-right-circle"></i></button>
                                        <input type="hidden" name="dateArrivee" value="<?= $_POST["date_arrivee"] ?>" id="">
                                        <input type="hidden" name="dateDepart" value="<?= $_POST["date_depart"] ?>" id="">
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                <?php endif ?>
                <?php if ($requet->rowCount() == 0) : ?>
                    <div class="py-3 mt-4">
                        <h1 class="text-danger text-center">Pas de Chambres dans cette Periode</h1>
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php endif ?>
    </div>
</body>
<script>
    let types = document.querySelectorAll("#type_chambre option")
    for (let i of types) {
        if (i.value = "<?= $type ?>") {
            i.selected = true
        }
    }
</script>

</html>