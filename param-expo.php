<?php ##########################################################################
# @Name : param-expo.php
# @Description : Page de configuration des expositions
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
        <h3 class="card-title fw-bold text-center">Programmer une Exposition</h3>
      </div>
      <div class="card-body">
        <form method="post" action ="./php/expo-add.php">
        <div class="row justify-content-center">
          <div class="col-auto">
            <div class="input-group mb-3">
              <span class="input-group-text" id="dateFrom">Du :</span>
              <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
              <span class="input-group-text"> Au : </span>
              <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
              <span class="input-group-text">  </span>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="input-group mb-3">
            <span class="input-group-text" id="name">Nom</span>
            <input type="text" class="form-control" name="name" value="" placeholder="Nom de l'exposition" aria-describedby="name_expo" autocomplete="off" required>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="input-group mb-3">
            <label class="input-group-text" for="secteur">Secteur</label>
            <select class="form-select" name="secteur" id="secteur">
              <!-- On créer un menu déroulant pour les Secteurs -->
              <?php
              // On récupère tout le contenu de la table tconf_secteurs
              $reponse = $dbh->query('SELECT * FROM tconf_secteurs');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              {
              ?>
              <option value=<?php echo $donnees['id']; ?> <?php if ($donnees['id'] == '1') {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
              <?php
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-2 d-md-flex justify-content-evenly">
            <input type="submit" value="PROGRAMMER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=expo" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
          </div>
        </div>
        </form>
      </div>
    </div>
  </br>
  <?php
  if (isset($_GET['expo']) and !empty($_GET['expo'])) {
    $id_expo = $_GET['expo'];
        include('./inc/expo-update.php');
  }
  ?>
  </div>
  <div class="col-xs-auto col-sm-12 col-md-6 col-xl-8">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Liste des Expositions Enregistrées</h3>
          </div>
          <div class="col-3">
            <form>
              <input id="myCustomSearchBox" class="form-control" type="text" placeholder="Rechercher" aria-label="Rechercher" autocomplete="off">
            </form>
          </div>
        </div>
      </div>
      <?php
      $req = $dbh->prepare('SELECT tconf_expo.id as "ID", tconf_expo.name as "Nom", tconf_secteurs.name AS "Secteur", tconf_expo.deb as "Début", tconf_expo.fin as "Fin" FROM `tconf_expo` INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_expo.sect_id ORDER BY tconf_expo.id DESC');
      $req->execute();
      ?>
      <div class="card-body">
        <table id="expo" class="table table-striped dt-responsive nowrap" style="width:100%">
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
              echo "<td><a class='link-success' title='Modifier cette exposition' href='" . $_SERVER['PHP_SELF'] . "?page=" . $_GET['page'] . "&subpage=" . $_GET['subpage'] . "&expo=" . $row[0] . "'><i class='bi bi-pencil-square'></i></a></td>";
              for ($i=0; $i < $req->columnCount(); $i++) {
                      // si le champs est vide
                      if (empty($row[$i])) $row[$i] = "";
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