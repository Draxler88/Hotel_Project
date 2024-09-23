<?php
include "../connexion.php";
include "NavbarMan.php";
session_start();

$reservations = $connexion->prepare("SELECT * FROM reservation");
$reservations->execute();

$Users = $connexion->prepare("SELECT * FROM users_app");
$Users->execute();

$Chambres = $connexion->prepare("SELECT * FROM chambre");
$Chambres->execute();


$clients = $connexion->prepare("SELECT * FROM client");
$clients->execute();

$reser_en = $connexion->prepare("SELECT * FROM reservation
                                    WHERE reservation.Etat = ?
                                    ");
$reser_en->execute(["En cours"]);
$montant = $connexion->prepare("SELECT Montant_total FROM reservation
                                    ");
$montant->execute();
$montants = $montant->fetchAll(PDO::FETCH_OBJ);
$total = 0;
foreach($montants as $montant){
    $total += intval($montant->Montant_total);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionniste Dashbord</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <?php style1()?>
    <style>
        .card-custom {
            margin: 10px 0;
        }

        .card-icon {
            font-size: 2rem;
        }

        .card-text-large {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .view-report {
            font-size: 0.9rem;
        }
        .aha{
            text-decoration: none;
        }
        .aha:hover{
            font-size: 1.0rem;
            text-decoration: underline;
        }
    </style>
        <?php style1(); ?>
</head>
<body>
<?php nav1(); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Reservations</h5>
                                <p class="card-text card-text-large"><?=$reservations->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-calendar card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservation.php" class="text-white view-report">View Reservation &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Users</h5>
                                <p class="card-text card-text-large"><?=$Users->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-person card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Users/ListUsers.php" class="text-white view-report aha">View Users &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total Chambres</h5>
                                <p class="card-text card-text-large"><?=$Chambres->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-building card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="text-white view-report aha"> .</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Reservation En Cours</h5>
                                <p class="card-text card-text-large"><?=$reser_en->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-door-closed card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservationEnCours.php" class="text-white view-report aha">View Chambre reservé &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Total des gains</h5>
                                <p class="card-text card-text-large"><?=$total?></p>
                            </div>
                            <div>
                                <i class="bi bi-currency-dollar card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservation.php" class="text-white view-report aha">View Total &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Clients</h5>
                                <p class="card-text card-text-large"><?=$clients->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-people card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="#" class="text-white view-report aha"> .</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>