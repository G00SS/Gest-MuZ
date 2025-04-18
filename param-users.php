<?php ##########################################################################
# @Name : param-users.php
# @Description : Page de gestion des utilisateurs
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<div class="row justify-content-center">
  <div class="col-xs-auto col-sm-12 col-md-6 col-xl-4">
    <div class="card shadow">
      <div class="card-header text-white bg-success">
        <h3 class="card-title fw-bold text-center">Créer un Nouvel Utilisateur</h3>
      </div>
      <div class="card-body">
        <form method="post" action ="./php/users-add.php">

        <div class="row justify-content-evenly">
           <?php  
           if(isset($_SESSION['error']))  
           {  
                echo '<p class="text-danger text-center">'.$_SESSION['error'].'</p>';
                unset($_SESSION['error']); 
           }  
           ?>
           <?php  
           if(isset($_SESSION['success']))  
           {  
                echo '<p class="text-success text-center">'.$_SESSION['success'].'</p>';
                unset($_SESSION['success']); 
           }  
           ?>
          <!-- Nom de l'utilisateur -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="username">Utilisateur</span>
              <input type="text" class="form-control" name="username" value="" placeholder="Nom d'Utilisateur" aria-describedby="username" autocomplete="off" required>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Mot de passe -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="password">Mot de Passe</span>
              <input type="password" class="form-control" name="password" value="" placeholder="Mot de Passe" aria-describedby="password" autocomplete="off" required>
            </div>
          </div>
          <!-- Confirmation -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="confirm">Confirmation</span>
              <input type="password" class="form-control" name="confirm" value="" placeholder="Confirmez le Mot de Passe" aria-describedby="confirm" autocomplete="off" required>
            </div>
          </div>
        </div>

        <div class="row mb-3">
          <div class="d-grid gap-2 d-md-flex justify-content-evenly">
            <input type="radio" class="btn-check" name="role" id="option1" value="1" autocomplete="off">
            <label class="btn btn-outline-secondary" for="option1">Administrateur</label>

            <input type="radio" class="btn-check" name="role" id="option2" value="2" autocomplete="off">
            <label class="btn btn-outline-secondary" for="option2">Superviseur</label>

            <input type="radio" class="btn-check" name="role" id="option3" value="3" checked autocomplete="off">
            <label class="btn btn-outline-secondary" for="option3">Utilisateur</label>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-2 d-md-flex justify-content-evenly">
            <input type="submit" value="CREER" class="btn btn-success" title="Créer un Utilisateur"/>
            <a href="./index.php?page=param&subpage=users" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
          </div>
        </div>
        </form>
      </div>
    </div>
  </br>
  <?php
  if (isset($_GET['users_t']) and !empty($_GET['users_t'])) {
    $id_user = $_GET['users_t'];
        include('./inc/users-update.php');
  }
  ?>
  </div>
  <div class="col-xs-auto col-sm-12 col-md-6 col-xl-8">
    <!-- Tableau des Ateliers -->
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Liste des Utilisateurs Enregistrés</h3>
          </div>
        </div>
      </div>
      <?php
      $req = $dbh->prepare('SELECT tconf_users.id AS ID, tconf_users.username AS Utilisateur, tconf_users.password AS "Mot de Passe", tconf_users.role AS Rôle FROM `tconf_users` ORDER BY tconf_users.id ASC');
      $req->execute();
      ?>
      <div class="card-body">
        <table id="users" class="table table-striped dt-responsive nowrap" style="width:100%">
        <?php
          // Affichage de la requête sous forme de tableau
          echo ("<thead>");
          // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
          echo "<tr>";
          // Affichage des noms d'attributs de chacune des colonnes
          echo "<th></th>\n";
          for ($i = 0; $i < $req->columnCount(); $i++) {
                  $col = $req->getColumnMeta($i);
                  $legend = $col['name'];
                  echo "<th>" .$legend. "</th>\n";
          }
          echo "</tr>\n";
          echo ("</thead>");
          echo ("<tbody class='table-border-bottom-0'>");
          // Création des lignes du tableau
          while($row = $req->fetch()) {
            // on affiche les valeurs de chaque attributs
              echo ("<tr>");
              echo "<td><a class='link-success' title='Modifier cet utilisateur' href='" . $_SERVER['PHP_SELF'] . "?page=" . $_GET['page'] . "&subpage=" . $_GET['subpage'] . "&users_t=" . $row[0] . "'><i class='bi bi-pencil-square'></i></a></td>";
              for ($i=0; $i < $req->columnCount(); $i++) {
                      // si le champs est vide
                      if (empty($row[$i])) $row[$i] = "";
                      // le mot de passe
                      if ($i==2) {
                        $row[$i]='**************';
                      }
                      // le champs role
                      if ($i==3) {
                        if ($row[$i]==1) {
                          $row[$i]='Administrateur';
                        } elseif ($row[$i]==2) {
                          
                          $row[$i]='Superviseur';
                        } elseif ($row[$i]==3) {
                          
                          $row[$i]='Utilisateur';
                        }
                      }
                      echo "<td>" . $row[$i] . "</td>";
              }
              echo "</tr>\n";
          }
          echo ("</tbody>");
        ?>
        </table>
      </div>
      <?php $req->closeCursor(); ?>
    </div>
  </div>
</div>
<?php // echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>