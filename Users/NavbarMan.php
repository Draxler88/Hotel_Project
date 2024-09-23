<?php
function style1(){
?>
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
        .navbar-nav {
            margin: 0 auto;
        }
        .navbar-brand {
            margin-right: auto;
        }
        .nav-item {
            margin: 0 10px;
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
<?php }?>
<?php function nav1(){?>
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <a class="navbar-brand" href="http://localhost/Mini-projet/Users/Manager.php">Hotel Manager</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/Mini-projet/Gestion%20Reservation/ListReservation.php"><i class="bi bi-calendar-check"></i> Reservations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="http://localhost/Mini-projet/Users/ListUsers.php"><i class="bi bi-person"></i> Users</a>
                </li>
            </ul>
            <span class="manager-name text-center bg-success p-1"><?=$_SESSION["type"]?> : <?=$_SESSION["nom_complet"]?></span>
            <a href="http://localhost/Mini-projet/deconnect.php" class="btn btn-sm btn-danger"><i class="bi bi-box-arrow-right"></i> Deconnection</a>
        </div>
    </div>
</nav>
<?php }?>