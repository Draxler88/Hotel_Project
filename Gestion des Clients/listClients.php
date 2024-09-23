<?php
include "../connexion.php";
include "../Users/NavbarRec.php";

session_start();

// Handle delete operation
if (isset($_GET['supprimer'])) {
    $clientId = $_GET['supprimer'];
    $deleteStmt = $connexion->prepare("DELETE FROM client WHERE Id_Client = ?");
    $deleteStmt->execute([$clientId]);
}

// Redirect to add client page
if (isset($_GET['new'])) {
    header("Location: ajouterClient.php");
    exit;
}

// Initialize search variables
$searchName = $_GET['searchname'] ?? '';
$searchCountryCity = $_GET['searchc'] ?? '';
$searchType = $_GET['search1'] ?? $_GET['search2'] ?? null;

// Prepare base query
$query = "SELECT Nom_complet, Ville, Pays, Telephone, Id_Client FROM client";
$params = [];

// Adjust query based on search type
if ($searchType === 'search1' && !empty($searchName)) {
    $query .= " WHERE Nom_complet LIKE ?";
    $params[] = "%$searchName%";
} elseif ($searchType === 'search2' && !empty($searchCountryCity)) {
    $query .= " WHERE Ville LIKE ? OR Pays LIKE ?";
    $params[] = "%$searchCountryCity%";
    $params[] = "%$searchCountryCity%";
}

// Execute query
$stmt = $connexion->prepare($query);
$stmt->execute($params);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="stylesheet" href="../bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-icons/font/bootstrap-icons.css">
    <?php style2() ?>
</head>
<body>
<?php nav2() ?>
    <div class="container">
        <div class="row my-4">
            <div class="col-4">
                <a href="ajouterClient.php" class="btn btn-success">New +</a>
            </div>
            <div class="col-auto">
                <form action="" method="get" class="input-group">
                    <input class="form-control" type="text" name="searchname" id="country1" placeholder="Search by Name">
                    <button name="search1" class="btn btn-success">Search</button>
                </form>
            </div>
            <div class="col-auto">
                <form action="" method="get" class="input-group">
                    <input class="form-control" type="text" name="searchc" id="country2" placeholder="Search by Country or City">
                    <button name="search2" class="btn btn-success">Search</button>
                </form>
            </div>
            <div class="col-auto ms-auto">
                <a href="registre.php" class="btn btn-info">Registre</a>
            </div>
        </div>
        <div class="text-center mt-3">
            <h1>List of Clients</h1>
        </div>
        <table class="table table-striped w-100 mt-3 text-center table-hover">
            <thead>
                <tr>
                    <th>FullName</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Phone Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['Nom_complet']) ?></td>
                        <td><?= htmlspecialchars($client['Ville']) ?></td>
                        <td><?= htmlspecialchars($client['Pays']) ?></td>
                        <td><?= htmlspecialchars($client['Telephone']) ?></td>
                        <td>
                            <a href="?supprimer=<?= $client['Id_Client'] ?>" onclick="return confirm('Are you sure you want to delete this client?');" class="btn btn-sm btn-danger mx-1">Delete</a>
                            <a href="modifier.php?id=<?= $client['Id_Client'] ?>" class="btn btn-sm btn-success mx-1">Edit</a>
                            <a href="afficher.php?id=<?= $client['Id_Client'] ?>" class="btn btn-sm btn-info mx-1">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
