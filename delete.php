<?php
session_start();
require_once("./pdo.php");

$GET["auto_id"]= $_SESSION["autos_id"] ?? '';
$_GET["make"]=$_SESSION["make"]??'';


if (isset($_POST["annuler"])) {
header("Location: ./index.php");
 return;
}

if (isset($_POST["delete"])) {
$sql = "DELETE FROM autos WHERE autos_id = :autos_id";
$stmt = $pdo->prepare($sql);
 $stmt->execute([
 "autos_id" => $_GET["autos_id"]
]);
$_SESSION["success"] = "Enregistrement supprimé";
header("Location: ./index.php");
 return;
}

$sql = "SELECT autos_id, make FROM autos WHERE  autos_id = :autos_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  ":autos_id" => $_GET["autos_id"]
]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Suppression</title>

</head>

<body>
  
 <p>Confirmer la suppression de : <?= $row["make"] ?></p>
<form method="POST">
 <input type="hidden" value="<?= $row["autos_id"] ?>">
 <button type="submit" name="delete">Supprimer</button>
 <button type="submit" name="annuler">Annuler</button>
 </form>
</body>
</html>