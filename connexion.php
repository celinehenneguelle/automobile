<?php
session_start();
require_once("./pdo.php");
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
$message = $_SESSION["message"] ?? false;

if (isset($_POST["name"]) && isset($_POST["password"])) {
if (!empty(trim($_POST["name"])) && !empty(trim($_POST["password"]))) {
if (hash("md5", "$salt{$_POST["password"]}") === $stored_hash) {
 unset($_SESSION["name"]);
 $_SESSION["name"] = $_POST["name"];
 header("Location: ./index.php");
 return;
} else {
$_SESSION["message"] = "Votre mot de passe est incorrect";
header("Location: ./connexion.php");
return;
} } else {
$_SESSION["message"] = "Le nom d'utilisateur et le mot de passe sont requis";
header("Location: ./connexion.php");
 return;
}
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="index.css"/>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>connexion</title>
</head>

<form method="POST" clas="formulairec">
 <h1>Connectez-vous</h1> 
<?php
if ($message) {
 echo "<p style='color: red'>$message</p>";
 unset($_SESSION["message"]);
 }
 ?>
<p class>Nom d'utilisateur:</p>
 <input type="text" name="name" id="namec">
 <p>Mot de Passe:</p>
   <input type="text" name="password" id="passwordc"><br><br>
  <input type="submit" name="envoyer" value="Se connecter" class="btnc">


 </form>
</body>
</html>