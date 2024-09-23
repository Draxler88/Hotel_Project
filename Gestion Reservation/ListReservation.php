<?php
include "../connexion.php";
include "../Users/NavbarMan.php";
include "../Users/NavbarRec.php";
session_start();

// Fetch reservations
$data = $connexion->prepare("SELECT * FROM reservation
                            INNER JOIN client ON reservation.Id_client = client.Id_Client
                            INNER JOIN chambre ON reservation.Id_chambre = chambre.Id_chambre");
$data->execute();
$reservations = $data->fetchAll(PDO::FETCH_OBJ);

// Fetch clients and rooms for the filters
$client = $connexion->query("SELECT * FROM client");
$clients = $client->fetchAll(PDO::FETCH_OBJ);

$chambre = $connexion->query("SELECT * FROM chambre");
$chambres = $chambre->fetchAll(PDO::FETCH_OBJ);

// Handle search filter
if (isset($_GET["search"])) {
    $conditions = [];
    $params = [];

    if (!empty($_GET["date_arrivee"]) && !empty($_GET["date_depart"])) {
        $conditions[] = "reservation.Date_arrivée >= ? AND reservation.Date_départ <= ?";
        $params[] = $_GET["date_arrivee"];
        $params[] = $_GET["date_depart"];
    }
    if (!empty($_GET["client"])) {
        $conditions[] = "reservation.Id_client = ?";
        $params[] = $_GET["client"];
    }
    if (!empty($_GET["Numero_chambre"])) {
        $conditions[] = "reservation.Id_chambre = ?";
        $params[] = $_GET["Numero_chambre"];
    }

    $query = "SELECT * FROM reservation
              INNER JOIN client ON reservation.Id_client = client.Id_Client
              INNER JOIN chambre ON reservation.Id_chambre = chambre.Id_chambre";
    if (count($conditions) > 0) {
        $query .= " WHERE " . implode(' AND ', $conditions);
    }

    $data = $connexion->prepare($query);
    $data->execute($params);
    $reservations = $data->fetchAll(PDO::FETCH_OBJ);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réservations</title>
    <link href="../bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .mt-x {
            margin-top: 32px;
        }
    </style>
    <?php if ($_SESSION["type"] == "manager") {
        style1();
    } else {
        style2();
    } ?>
</head>
<body>
<?php if ($_SESSION["type"] == "manager") {
    nav1();
} else {
    nav2();
} ?>
<div class="container mt-2">
    <div class="row">
        <div class="row mt-4">
            <div class="col-5 mt-3">
                <h1 class="mb-4">Liste des Réservations</h1>
            </div>
            <div class="col-7">
                <div class="row">
                    <div class="col-3">
                        <?php if ($_SESSION["type"] == "receptionniste") : ?>
                            <a href="AjouterReservation.php" class="btn btn-sm btn-outline-success w-100 h-100 d-flex justify-content-center">
                                <span class="align-self-center"><i class="bi bi-plus-circle"></i> Réservation</span>
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="col-3">
                        <a href="ListReservationPlanifiee.php" class="btn btn-sm btn-primary w-100 h-100 p-4">
                            <span><i class="bi bi-list"></i> Réservation Planifiée</span>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="ListReservationEnCours.php" class="btn btn-sm btn-primary w-100 h-100 p-4">
                            <span><i class="bi bi-list"></i> Réservation En cours</span>
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="ListReservationTerminee.php" class="btn btn-sm btn-primary w-100 h-100 p-4">
                            <span><i class="bi bi-list"></i> Réservation Terminée</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <form>
            <div class="row my-3">
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="date_arrivee">Date d'arrivée</label>
                            <input class="form-control col-6" type="date" name="date_arrivee" id="date_arrivee">
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="date_depart">Date de départ</label>
                            <input class="form-control col-6" type="date" name="date_depart" id="date_depart">
                        </div>
                    </div>
                </div>
                <div class="col-2">
                    <label class="form-label" for="Numero_chambre">Numéro chambre</label>
                    <select class="form-control text-center" name="Numero_chambre" id="Numero_chambre">
                        <option value="">-----Chambre------</option>
                        <?php foreach ($chambres as $chambre): ?>
                            <option value="<?= $chambre->Id_chambre ?>"><?= $chambre->Numéro_chambre ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-3">
                    <label class="form-label" for="client">Client</label>
                    <select class="form-control text-center" name="client" id="client">
                        <option value="">-----Sélectionner Client------</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?= $client->Id_Client ?>"><?= $client->Nom_complet ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="col-1">
                    <input class="btn btn-success mt-x" type="submit" name="search" id="search" value="Rechercher">
                </div>
            </div>
        </form>
    </div>
    <table class="table table-bordered table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Code Réservation</th>
                <th class="col-2">Date et Heure de Réservation</th>
                <th class="col-2">Date d'Arrivée</th>
                <th class="col-2">Date de Départ</th>
                <th>Nombre de Jours</th>
                <th>Montant Total</th>
                <th>Téléphone</th>
                <th class="col-2">Client</th>
                <th>Numéro de Chambre</th>
                <th class="col-2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation): ?>
            <tr>
                <td><?= $reservation->Code_reservation ?></td>
                <td><?= $reservation->Date_heure_reservation ?></td>
                <td><?= $reservation->Date_arrivée ?></td>
                <td><?= $reservation->Date_départ ?></td>
                <td><?= $reservation->Nbr_jours ?></td>
                <td><?= $reservation->Montant_total ?></td>
                <td><?= $reservation->Telephone ?></td>
                <td><?= $reservation->Nom_complet ?></td>
                <td><?= $reservation->Numéro_chambre ?></td>
                <td class="text-center">
                    <?php if ($_SESSION["type"] == "receptionniste") : ?>
                        <a href="?id=<?= $reservation->Id_reservation ?>" onclick="return confirm('Are you sure you want to delete this reservation?')" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></a>
                        <a href="ModifierReservation.php?id=<?= $reservation->Id_reservation ?>&type=<?= $reservation->Id_type ?>&date_arrivee=<?= $reservation->Date_arrivée ?>&date_depart=<?= $reservation->Date_départ ?>&nbr=<?= $reservation->Nbr_adultes_enfants ?>&code=<?= $reservation->Code_reservation ?>&client=<?= $reservation->Id_client ?>" class="btn btn-primary btn-sm"><i class="bi bi-pen"></i></a>
                    <?php endif ?>
                    <a href="ConsultationReservation.php?id=<?= $reservation->Id_reservation ?>" class="btn btn-info btn-sm"><i class="bi bi-info"></i></a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
</body>

<?php
if (isset($_GET['id'])) {
    ?>
    <script>
        if (confirm("Are you sure you want to delete this reservation?")) {
            <?php
            $delete = $connexion->prepare("DELETE FROM reservation WHERE Id_reservation = ?");
            $delete->execute([$_GET["id"]]);
            ?>
            alert("Reservation deleted successfully");
            window.location.href = "ListReservation.php";
        } else {
            window.location.href = "ListReservation.php";
        }
    </script>
    <?php
}
?>
</html>
