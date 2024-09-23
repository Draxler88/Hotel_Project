<?php
function style2(){?>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar-custom {
            background-color: #007bff;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #ffffff;
        }
        .navbar-custom .nav-link:hover {
            color: #cccccc;
        }

        .manager-name {
            color: #ffffff;
            margin-right: 15px;
        }
        .btn-logout {
            background-color: #dc3545;
            color: #ffffff;
        }
        .btn-logout:hover {
            background-color: #c82333;
            color: #ffffff;
        }
    </style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php }?>
<?php function nav2(){?>
<nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid ">
            <a class="navbar-brand" href="http://localhost/Mini-projet/Users/Receptionniste.php">Hotel Manager</a>
            <div <?php if($_SESSION["etat"] != "active"){ ?>style="margin-left: 60%;"<?php } ?> class="collapse navbar-collapse" id="navbarNav">
                <?php if($_SESSION["etat"] == "active"){ ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Gestion%20des%20Clients/listClients.php"><i class="bi bi-people"></i> Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Getion%20des%20Chambres/Chambre/ListChambre.php"><i class="bi bi-door-closed"></i> Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Getion%20des%20Chambres/Type%20Chambre/ListTypeChambre.php"><i class="bi bi-boxes"></i> Types Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Getion%20des%20Chambres/Capacite%20Chambre/ListCapaciteChambre.php"><i class="bi bi-box"></i> Capacités Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Getion%20des%20Chambres/Tarif%20Chambre/ListTarifChambre.php"><i class="bi bi-cash"></i> Tarifs Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservation.php"><i class="bi bi-calendar-check"></i> Reservations</a>
                    </li>
                </ul>
                <?php } ?>
                    <span class="manager-name text-center bg-success p-1"><?=$_SESSION["type"]?> : <?=$_SESSION["nom_complet"]?></span>
                    <a href="http://localhost/Mini-projet/deconnect.php" class="btn btn-logout btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i> Deconnection</a>
                </div>
        </div>
    </nav>
<?php }?>