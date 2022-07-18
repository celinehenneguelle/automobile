<?php
session_start();
require_once("./pdo.php");


$name = $_SESSION["name"] ?? '';
$error = $_SESSION["error"] ??  false;
$_SESSION["autos_id"]=$_GET["autos_id"]??'';

if (!isset($_SESSION["name"])){
  die("ACCÈS REFUSÉ");
}

if (isset($_POST["annuler"])) {
  header("Location: ./index.php");
  return;
}


if (isset($_POST["sauvegarder"])) {
if (isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"])) {
 if (!empty(trim($_POST["make"])) && !empty(trim($_POST["model"])) && !empty(trim($_POST["year"])) && !empty(trim($_POST["mileage"]))) {
 if (!is_numeric($_POST["year"])) {
 $_SESSION["error"] = "L'année doit être numérique";
 header("Location: edit.php?autos_id=".$_REQUEST['id']);
return;

 } else if (!is_numeric($_POST["mileage"])) {
 $_SESSION["error"] = "Le kilométrage doit être numérique";
 header("Location: edit.php?autos_id=".$_REQUEST['id']);
 return;

 } else {
$sql = "UPDATE autos SET make=:make, model=:model, year=:year, mileage=:mileage WHERE autos_id = {$_SESSION["autos_id"]}  ";
$stmt = $pdo->prepare($sql);
 $stmt->execute([
":make" => $_POST["make"],
 ":model" => $_POST["model"], 
 ":year" => $_POST["year"],
 ":mileage"=>$_POST["mileage"],
    
 ]);

 $_SESSION["success"] = "Enregistrement edité";
 header("Location: ./index.php");
 return;
 }
 
} else {
$_SESSION["error"] = "Tous les champs sont requis";
 header("Location: edit.php?autos_id=".$_REQUEST['id']);
return;
}
}
}


$sql = "SELECT * FROM autos WHERE  autos_id = :autos_id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
":autos_id" =>$_SESSION["autos_id"],
]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>editer</title>
</head>

<body>

<h1>Modifier une automobile</h1>
<?php
 if ($error) {
echo  "<p style='color: red'>$error</p>";
unset($_SESSION['error']);
}
?>
  <form method="POST">

 <div>
  <label for="make">Marque :</label>
  <input type="text" name="make" id="make"value="<?= $row["make"]?>">
  </div><br>
  <div>
  <label for="model">Modèle :</label>
  <input type="text" name="model" id="model"value="<?= $row["model"] ?>">
  </div><br>
  <div>
  <label for="year">Année :</label>
  <input type="text" name="year" id="year"value="<?= $row["year"] ?>" >
  </div><br>
  <div>
  <label for="mileage">Kilométrage:</label>
  <input type="text" name="mileage" id="mileage"value="<?= $row["mileage"] ?>">
  </div><br>

   <button type="submit" name="sauvegarder">sauvegarder</button>
   <button type="submit" name="annuler">Annuler</button>

    </form>

</body>

</html>