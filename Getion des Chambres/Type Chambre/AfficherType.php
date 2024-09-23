
<?php
include "../../connexion.php";
include "../../Users/NavbarRec.php";
session_start();
$request = $connexion->prepare("SELECT * FROM type_chambre WHERE Id_type = ?");
$request->execute([$_GET["id"]]);
$type = $request->fetch(PDO::FETCH_OBJ);


$chambre = $connexion->prepare("SELECT Numéro_chambre FROM chambre
INNER JOIN type_chambre ON chambre.Id_type = type_chambre.Id_type
WHERE type_chambre.Id_type = ?
");
$chambre->execute([$_GET["id"]]);
$chambrs = $chambre->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consulter List</title>
    <link rel="stylesheet" href="../../bootstrap.min.css">
    <link rel="stylesheet" href="../../bootstrap-icons/font/bootstrap-icons.css">
    <style>
        img{
            width: 50%;
        }
    </style>
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container mt-4">
        <h1 class="mb-4">Consulter List</h1>
        <table class="table table-hover table-bordered col-12">
                <tr>
                    <th>Id type</th>
                    <td><?=$type->Id_type?></td>
                </tr>
                <tr>
                    <th>Type de chambre</th>
                    <td><?=$type->Type_chambre?></td>
                </tr>
                <tr>
                    <th>Description de type</th>
                    <td><?=$type->Description_type?></td>
                </tr>
                <tr>
                    <th class="col_3">Photo</th>
                    <td class="col-9"><img src="<?="../../Photos/".$type->Photos?>" alt></td>
                </tr>
                <tr>
                    <th>Numero de Chambre</th>
                    <td>
                        <?php 
                        if($chambre->rowCount() == 0){
                            Echo "Vide";
                        }else{
                            foreach($chambrs as $chambre){
                                echo $chambre->Numéro_chambre . " ";
                                }
                        }?>
                        </td>
                </tr>
        </table>
    </div>
</body>
</html>
