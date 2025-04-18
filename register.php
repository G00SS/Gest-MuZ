<?php ##########################################################################
# @Name : register.php
# @Description : Page création de compte
# @Call : login.php si pas de session
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<?php
session_start();
require_once 'inc/db.php';

// Récupération de variables de configuration globale

// On récupère tout le contenu de la table tconf_globale
$reponse = $dbh->query('SELECT * FROM tconf_param;');

// On affiche chaque entrée une à une

while ($donnees = $reponse->fetch())
{
$structure = $donnees['structure'];
$resident = $donnees['resident'];
$collectivite = $donnees['collectivite'];
$default_dept = $donnees['d_dept'];
$default_pays = $donnees['d_pays'];
$open = $donnees['ouverture'];
$close = $donnees['fermeture'];
$infos = $donnees['infos'];
}
// Termine le traitement de la requête
$reponse->closeCursor();

if (isset($_POST['register'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = htmlspecialchars($_POST['password']);
    $confirm = htmlspecialchars($_POST['confirm']);

    // Validation simple
    if ($password !== $confirm) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
    } else {
        // Vérifie si l'utilisateur existe déjà
        $check = $dbh->prepare("SELECT * FROM tconf_users WHERE username = ?");
        $check->execute([$username]);

        if ($check->rowCount() > 0) {
            $_SESSION['error'] = "Nom d'utilisateur déjà utilisé.";
        } else {
            // Hash du mot de passe
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insertion
            $stmt = $dbh->prepare("INSERT INTO tconf_users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashed]);

            $_SESSION['success'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header("Location: index.php");
            exit;
        }
    }
}
?>
<!-- Affichage du formulaire d'inscription -->
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nicolas GOUSSARD, and Bootstrap contributors">
    <link rel="icon" type="image/png" href="./img/logo.png" />
    <title>Gest'MuZ</title>
      
    <!-- ##############################
       # INTEGRATION DES STYLES CSS #
       ############################## -->
    <?php include('./inc/css.php'); ?>
    <!-- Custom CSS -->
    <link href="css/signin.css" rel="stylesheet">

  </head> 
  <body class="d-flex justify-content-center text-center">
     <main>
      <div class="title-signin">
           <img class="mb-1" src="./img/logo.png" alt="" width="200">
           <h1 class="display-2 h3 mb-4 fw-normal"><?php echo ($structure);?></h1>
      </div>

      <div class="row form-signin">
          <h2>Inscription</h2>
          <?php
          if (isset($_SESSION['error'])) {
              echo "<p class='text-danger'>{$_SESSION['error']}</p>";
              unset($_SESSION['error']);
          }
          ?>
          <form action="register.php" method="POST"> 
             <div class="form-floating mb-2">  
                  <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Nom d'Utilisateur" required>
                  <label for="floatingInput">Utilisateur</label> 
             </div> 
             <div class="form-floating mb-2"> 
                  <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de Passe" required>  
                  <label for="floatingPassword">Mot de Passe</label>
             </div> 
             <div class="form-floating mb-2"> 
                  <input type="password" name="confirm" class="form-control" id="floatingConfirm" placeholder="Confirmez le Mot de Passe" required>  
                  <label for="floatingConfirm">Confirmez le Mot de Passe</label>
             </div>
              <button type="submit" name="register" class="btn btn-info mt-2">Créer un compte</button>
          </form>
      </div>
      <p class="mt-3">Déjà un compte ? <a href="index.php">Connexion</a></p>
      <p class="mt-5 mb-1 text-muted">&copy; Smart G0osS 2024-2030</p>
      <p class="mb-3 text-muted">- Gest'MuZ V2.0.0 -</p>
</main>
  </body>
</html>