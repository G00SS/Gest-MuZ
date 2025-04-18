<?php ##########################################################################
# @Name : index.php
# @Description : Page Principale
# @Call : login.php après création de session
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php  
 //login_success.php  
 session_start();  
 if(isset($_SESSION["username"]))  
 { ?>

  <!doctype html>
  <html lang="fr">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="">
      <meta name="author" content="Nicolas GOUSSARD, and Bootstrap contributors">
      <link rel="icon" type="image/png" href="./img/logo.png" />

      <title>Gest'MuZ</title>
      
      <!-- ##############################
           # INTEGRATION DES STYLES CSS #
           ############################## -->
      <?php include('./inc/css.php'); ?>


    </head>

    <body>
      <!--  connection à la BDD -->
      <?php require './inc/db.php'; ?>

      <!-- Récupération de variables de configuration globale -->
      <?php
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
      $indivpay = $donnees['indivpay'];
      $indivgui = $donnees['indivgui'];
      $grppay = $donnees['grppay'];
      $grpgui = $donnees['grpgui'];
      }
      // Termine le traitement de la requête
      $reponse->closeCursor();
      ?>

      <!-- On va chercher le code pour afficher le menu -->
      <?php include('./inc/menu.php'); ?>

      <main role="main" class="container-fluid">

      <!--  ############################
            ##  AFFICHAGE DE LA PAGE  ## => On va chercher les pages en fonction du menu
            ##________________________## -->

      <?php
      /*Gest° des visiteurs*/ 
      if (isset($_GET['page']) AND $_GET['page']=='vis'){
        if (isset($_GET['subpage']) AND $_GET['subpage']=='indiv'){ include('./vis-indiv.php');}
        elseif(isset($_GET['subpage']) AND $_GET['subpage']=='grp'){include('./vis-grp.php');}
      /*Modifier les enregistrements*/ 
      } elseif(isset($_GET['page']) AND $_GET['page']=='rec'){
          if(isset($_GET['subpage']) AND $_GET['subpage']=='indiv'){include('./rec-indiv.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='grp'){include('./rec-grp.php');}
      /*Editer les Visites*/
      } elseif(isset($_GET['page']) AND $_GET['page']=='edit'){
          if (isset($_GET['subpage']) AND $_GET['subpage']=='indiv'){ include('./edit-indiv.php');}
          elseif (isset($_GET['subpage']) AND $_GET['subpage']=='grp'){ include('./edit-grp.php');}
      /*Traitement statisitique*/
      } elseif(isset($_GET['page']) AND $_GET['page']=='stat'){
          if (isset($_GET['subpage']) AND $_GET['subpage']=='indiv'){ include('./stat-indiv.php');}
          elseif (isset($_GET['subpage']) AND $_GET['subpage']=='grp'){ include('./stat-grp.php');}
          elseif (isset($_GET['subpage']) AND $_GET['subpage']=='glob'){ include('./stat-glob.php');}
      /*Paramétrage du Gest'Muz*/ 
      } elseif(isset($_GET['page']) AND $_GET['page']=='param'){
          if(isset($_GET['subpage']) AND $_GET['subpage']=='expo'){include('./param-expo.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='atel'){include('./param-atel.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='evt'){include('./param-evt.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='conf'){include('./param-conf.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='perso'){include('./param-perso.php');}
          elseif(isset($_GET['subpage']) AND $_GET['subpage']=='users'){include('./param-users.php');}
      /*Dashboard*/ 
      } else {
        include('./dash.php');
      }
      ?>

      <!-- ____________________
           ## FIN DE LA PAGE ##
            ################## -->
      </main>



      <!-- ########################
           # JAVASCRIPT PRINCIPAL # On va chercher le code pour inclure les scripts généraux
           ######################## -->
      <?php include('./inc/js.php'); ?>

      <!-- #########################
           # JAVASCRIPT SECONDAIRE # On va chercher les scripts spécifiques en fonction des pages appelées
           ######################### -->

      <script type="text/javascript">
        var checkAll = document.getElementById("id_check_uncheck_all");
        checkAll.addEventListener("change", function() {
           var checked = this.checked;
           var otherCheckboxes = document.querySelectorAll(".toggleable");
           [].forEach.call(otherCheckboxes, function(item) {
               item.checked = checked;
           });
        });
      </script>

      <?php
      if (isset($_GET['page']) AND isset($_GET['subpage'])){
        if (($_GET['page']=='vis') OR ($_GET['page']=='edit')) {
          if ($_GET['subpage']=='indiv') {
            echo '<script type="text/javascript" src="js/zipdisable.js"></script>';
            echo '<script type="text/javascript" src="js/chkboxnateldisplay.js"></script>';
          } elseif ($_GET['subpage']=='grp') {
            echo '<script type="text/javascript" src="js/zipdisable.js"></script>';
            echo '<script type="text/javascript" src="js/chkboxnateldisplay.js"></script>';
          }
        } elseif ($_GET['page']=='rec') {
          if ($_GET['subpage']=='indiv') {
            echo '<script type="text/javascript" src="js/table-rec-indiv.js"></script>';
          } elseif ($_GET['subpage']=='grp') {
            echo '<script type="text/javascript" src="js/table-rec-grp.js"></script>';
          }
        } elseif ($_GET['page']=='stat') {
          if ($_GET['subpage']=='indiv') {
            include('js/chart-stat-indiv.php');
          } elseif ($_GET['subpage']=='grp') {
            include('js/chart-stat-grp.php');
          }
        }  elseif ($_GET['page']=='param') {
          if ($_GET['subpage']=='expo') {
            echo '<script type="text/javascript" src="js/table-param-expo.js"></script>';
          } elseif ($_GET['subpage']=='atel') {
            echo '<script type="text/javascript" src="js/table-param-atel.js"></script>';
          } elseif ($_GET['subpage']=='evt') {
            echo '<script type="text/javascript" src="js/table-param-evt.js"></script>';
          } elseif ($_GET['subpage']=='conf') {
            echo '<script type="text/javascript" src="js/param-conf.js"></script>';
          } elseif ($_GET['subpage']=='perso') {
            echo '<script type="text/javascript" src="js/param-perso.js"></script>';
          } elseif ($_GET['subpage']=='users') {
            echo '<script type="text/javascript" src="js/table-param-users.js"></script>';
          }
        }
      } else {
        include('js/chart-dash.php');
        echo '<script type="text/javascript" src="js/dash-clock.js"></script>';
      }
      ?>  
    </body>
  </html>
<?php   
 }  
 else  
 {  
      header("location:login.php");  
 }  
 ?>