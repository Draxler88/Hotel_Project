<?php
include "../connexion.php";
session_start();
include "NavbarRec.php";
include "alertBloque.php";
$reservations = $connexion->prepare("SELECT * FROM reservation");
$reservations->execute();

$type_chambres = $connexion->prepare("SELECT * FROM type_chambre");
$type_chambres->execute();

$capacite_chambres = $connexion->prepare("SELECT * FROM capacité_chambre");
$capacite_chambres->execute();

$tarif_chambres = $connexion->prepare("SELECT * FROM tarif_chambre");
$tarif_chambres->execute();

$Chambres = $connexion->prepare("SELECT * FROM chambre");
$Chambres->execute();


$clients = $connexion->prepare("SELECT * FROM client");
$clients->execute();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionniste Dashbord</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
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
        <?php style3();?>
    </style>
        <?php style2();?>
</head>
<body>
    <?php nav2(); ?>
    <?php if($_SESSION["etat"] == "active"){ ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-primary">
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
                        <a href="http://localhost/Mini-projet/Gestion%20des%20Clients/listClients.php" class="text-white view-report aha">View Clients &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Chambres</h5>
                                <p class="card-text card-text-large"><?=$Chambres->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-building card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Getion%20des%20Chambres/Chambre/ListChambre.php" class="text-white view-report aha">View Chambres &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Types Chambres</h5>
                                <p class="card-text card-text-large"><?=$type_chambres->rowCount()?></p>
                            </div>
                            <div>
                                <i class="bi bi-door-open card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Getion%20des%20Chambres/Type%20Chambre/ListTypeChambre.php" class="text-white view-report aha">View Types Chambres &rarr;</a>
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
                                <h5 class="card-title">Capacites des Chambres</h5>
                                <p class="card-text card-text-large"><?=$capacite_chambres->rowCount()?></p>
                            </div>
                            <div>
                            <i class="bi bi-person-plus card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Getion%20des%20Chambres/Capacite%20Chambre/ListCapaciteChambre.php" class="text-white view-report aha">View Capacites des Chambres &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Tarifs des Chambres</h5>
                                <p class="card-text card-text-large"><?=$tarif_chambres->rowCount()?></p>
                            </div>
                            <div>
                            <i class="bi bi-currency-dollar card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Getion%20des%20Chambres/Tarif%20Chambre/ListTarifChambre.php" class="text-white view-report aha">View Tarifs des Chambres &rarr;</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 card-custom">
                <div class="card text-white bg-secondary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">Reservations</h5>
                                <p class="card-text card-text-large"><?=$reservations->rowCount()?></p>
                            </div>
                            <div>
                            <i class="bi bi-bookmark card-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservation.php" class="text-white view-report aha">View Reservations &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <?php }else{nav3();} ?>
    </div>
</body>
</html>