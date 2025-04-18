<?php ##########################################################################
# @Name : login.php
# @Description : Page de login
# @Call : index.php si pas de session
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<?php  
     session_start();  
     // Include db config
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

     if (isset($_POST['login'])) {
         $username = htmlspecialchars(trim($_POST['username']));
         $password = $_POST['password'];

         $stmt = $dbh->prepare("SELECT * FROM tconf_users WHERE username = ?");
         $stmt->execute([$username]);
         $user = $stmt->fetch();

         if ($user && password_verify($password, $user['password'])) {
             // Connexion réussie
             $_SESSION['user_id'] = $user['id'];
             $_SESSION['username'] = $user['username'];
             $_SESSION['role'] = $user['role'];
             header("Location: index.php");
             exit;
         } else {
             $_SESSION['error'] = "Identifiants incorrects.";
         }
     }  
?>

<!-- Affichage du formulaire d'authentification -->
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
          <h1 class="h3 mb-3 fw-normal">Veuillez vous identifier</h1>
               <div class="form-floating mb-2">
                    <form method="post">  
                    <div class="form-floating mb-2">  
                         <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Nom d'Utilisateur">
                         <label for="floatingInput">Utilisateur</label> 
                    </div> 
                    <div class="form-floating mb-2"> 
                         <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Mot de Passe">  
                         <label for="floatingPassword">Mot de Passe</label>
                    </div>  
                    <input type="submit" name="login" class="btn btn-info mt-2" value="Valider">
                    </form>
               </div>
          </div> 
          <div class="row mt-3"> 
           <?php  
           if(isset($_SESSION['error']))  
           {  
                echo '<label class="text-danger">'.$_SESSION['error'].'</label>';
                unset($_SESSION['error']); 
           }  
           ?>
          </div>
          <p class="mt-3">Pas encore de compte ? <a href="register.php">Inscription</a></p>
          <p class="mt-5 mb-1 text-muted">&copy; Smart G0osS 2024-2030</p>
          <p class="mb-3 text-muted">- Gest'MuZ V2.0.0 -</p>
     </main>
  </body>
</html>