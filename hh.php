<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-auto">
                <form>
                    <button type="submit" class="btn btn-success" name="new">New +</button>
                </form>
            </div>
            <div class="col-auto">
                <form action="" method="get">
                    <div class="input-group">
                        <input class="form-control" type="text" name="searchname" id="country1" placeholder="Search by Name">
                        <button name="search1" class="btn btn-success">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <form method="get">
                    <div class="input-group">
                        <input class="form-control" type="text" name="searchc" id="country2" placeholder="Search by Country Or City">
                        <button name="search2" class="btn btn-success">Search</button>
                    </div>
                </form>
            </div>
            <div class="col-auto ms-auto">
                <a href="registre.php?id=" class="btn btn-info" name="back">Registre</a>
            </div>
        </div>
    </div>
</body>
</html>
<?php
$condition = '';
$var = [];
if($_POST["inpute1"]){
    $condition .= 
}
?>
