<?php
session_start();
require_once("./pdo.php");
$name = $_SESSION["name"] ?? '';
$error = $_SESSION["error"] ??  false;

if (!isset($_SESSION["name"])) {
  die("ACCÈS REFUSÉ");
}

if (isset($_POST["annuler"])) {
  header("Location: ./index.php");
  return;
}

if (isset($_POST["ajouter"])) {
if (isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"])) {
 if (!empty(trim($_POST["make"])) && !empty(trim($_POST["model"])) && !empty(trim($_POST["year"])) && !empty(trim($_POST["mileage"]))) {
 if (!is_numeric($_POST["year"])) {
 $_SESSION["error"] = "L'année doit être numérique";
 header("Location: ./add.php");
 return;

 } else if (!is_numeric($_POST["mileage"])) {
 $_SESSION["error"] = "Le kilométrage doit être numérique";
 header("Location: ./add.php");
 return;

 } else {
$sql = "INSERT INTO autos(make, model, year, mileage) VALUES(:make, :model,  :year, :mileage)";
$stmt = $pdo->prepare($sql);
 $stmt->execute([
  ":make" => $_POST["make"],
  ":model" => $_POST["model"],
  ":year" => $_POST["year"],
  ":mileage" => $_POST["mileage"],
 ]);

 $_SESSION["success"] = "Enregistrement ajouté";
 header("Location: ./index.php");
 return;
 }
 
} else {
$_SESSION["error"] = "Tous les champs sont requis";
header("Location: ./add.php");
return;
}
}
}
if(isset( $_POST["ajouter"])&& isset($_POST["edit"]) ){

 $_POST["make"] = $_SESSION["make"];
  $_POST["model"] = $_SESSION["model"]; 
   $_POST["year"] = $_SESSION["year"];
  $_POST["mileage"] = $_SESSION["mileage"];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ajouter</title>

</head>

<body>

    <h1>Ajouter une automobile pour <?= $name ?></h1>
    <?php
    if ($error) {
      echo  "<p style='color: red'>$error</p>";
      unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
    <div>
    <label for="make">Marque :</label>
    <input type="text" name="make" id="make">
    </div><br>
    <div>
    <label for="model">Modèle :</label>
    <input type="text" name="model" id="model">
    </div><br>
    <div>
    <label for="year">Année :</label>
    <input type="text" name="year" id="year">
    </div><br>
    <div>
    <label for="mileage">Kilométrage:</label>
    <input type="text" name="mileage" id="mileage">
    </div><br>
   <button type="submit" name="ajouter">Ajouter</button>
   <button type="submit" name="annuler">Annuler</button>
    </form>

</body>

</html>