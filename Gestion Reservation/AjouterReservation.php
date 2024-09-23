<?php
include "../connexion.php";
include "../Users/NavbarRec.php";
session_start();

$typeQuery = $connexion->prepare("SELECT * FROM type_chambre");
$typeQuery->execute();
$types = $typeQuery->fetchAll(PDO::FETCH_OBJ);

$successMessage = '';
$warningMessage = '';
$errorMessage = '';

if (isset($_POST["sift"])) {
    $dateArrivee = $_POST["date_arrivee"] ?? '';
    $dateDepart = $_POST["date_depart"] ?? '';
    $nombreAdultesEnfants = $_POST["nbr_adultes_enfants"] ?? '';
    $type = $_POST["type"] ?? '';

    if (!empty($dateArrivee) && !empty($dateDepart) && !empty($nombreAdultesEnfants)) {
        if ($dateArrivee <= $dateDepart) {
            $query = "SELECT * FROM chambre
                      INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
                      LEFT JOIN reservation ON chambre.Id_chambre = reservation.Id_chambre
                      WHERE chambre.Id_chambre NOT IN (
                          SELECT Id_chambre FROM reservation
                          WHERE (Date_arrivée BETWEEN ? AND ?)
                          OR (Date_départ BETWEEN ? AND ?)
                          OR (? BETWEEN Date_arrivée AND Date_départ)
                          OR (? BETWEEN Date_arrivée AND Date_départ)
                      )
                      AND chambre.Nombre_adultes_enfants_ch >= ?";
            
            $params = [$dateArrivee, $dateDepart, $dateArrivee, $dateDepart, $dateArrivee, $dateDepart, $nombreAdultesEnfants];

            if (!empty($type)) {
                $query .= " AND type_chambre.Id_type = ?";
                $params[] = $type;
            }

            $stmt = $connexion->prepare($query);
            $stmt->execute($params);
            $chambres = $stmt->fetchAll(PDO::FETCH_OBJ);

            if ($stmt->rowCount() > 0) {
                $successMessage = "<div class='alert alert-success'>Nous avons trouvé des chambres disponibles.</div>";
            } else {
                $warningMessage = "<div class='alert alert-warning'>Aucune chambre disponible pour ces critères.</div>";
            }
        } else {
            $errorMessage = "<div class='alert alert-warning'>La date de départ doit être après la date d'arrivée.</div>";
        }
    } else {
        $errorMessage = "<div class='alert alert-warning'>Tous les champs sont requis.</div>";
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
                <a href="ListReservation.php" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Retour</a>
            </div>
        </div>
        <?php echo $successMessage ?>
        <?php echo $warningMessage ?>
        <?php echo $errorMessage ?>
        <div class="mb-2">
            <form method="POST">
                <div class="row my-2">
                    <div class="mb-3 col-6">
                        <label for="date_arrivee" class="form-label">Date d'Arrivée</label>
                        <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="date_depart" class="form-label">Date de Départ</label>
                        <input type="date" name="date_depart" id="date_depart" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="nbr_adultes_enfants" class="form-label">Nombre d'Adultes et Enfants</label>
                        <input type="number" name="nbr_adultes_enfants" id="nbr_adultes_enfants" class="form-control" required>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="tc" class="form-label">Type Chambre</label>
                        <select name="type" id="tc" class="form-select">
                            <option value="">----Choisir une------</option>
                            <?php foreach ($types as $type) : ?>
                                <option value="<?= $type->Id_type ?>"><?= $type->Type_chambre ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="sift" class="btn btn-primary mt-3">Rechercher</button>
            </form>
            <?php if (isset($_POST["sift"]) && !empty($dateArrivee) && !empty($dateDepart) && !empty($nombreAdultesEnfants)) : ?>
                <?php if ($dateArrivee <= $dateDepart) : ?>
                    <?php if ($stmt->rowCount() > 0) : ?>
                        <table class="table table-hover table-dark mt-3">
                            <thead>
                                <tr>
                                    <th class="p-3">Numéro de Chambre</th>
                                    <th class="p-3">Type</th>
                                    <th class="p-3">Nombre Adultes et Enfants</th>
                                    <th class="p-3">Période</th>
                                    <th class="p-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($chambres as $chambre) : ?>
                                    <tr>
                                        <td><?= $chambre->Numéro_chambre ?></td>
                                        <td><?= $chambre->Type_chambre ?></td>
                                        <td><?= $chambre->Nombre_adultes_enfants_ch ?></td>
                                        <td>Du <?= $chambre->Date_arrivée ?> jusqu'à <?= $chambre->Date_départ ?></td>
                                        <td>
                                            <a href="Confirme.php?id=<?= $chambre->Id_chambre ?>&date_arrivee=<?= $_POST["date_arrivee"] ?>&date_depart=<?= $_POST["date_depart"] ?>&nbr=<?= $chambre->Nombre_adultes_enfants_ch ?>&id_type=<?= $chambre->Id_type ?>" class="btn btn-primary">Suivant <i class="bi bi-arrow-right-circle"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <?php else : ?>
                        <div class="py-3 mt-4">
                            <h1 class="text-danger text-center">Aucune chambre disponible pour cette période</h1>
                        </div>
                    <?php endif ?>
                <?php endif ?>
            <?php endif ?>
        </div>
    </div>
</body>
</html>