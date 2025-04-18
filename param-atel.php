<?php ##########################################################################
# @Name : param-atel.php
# @Description : Page de configuration des ateliers
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
        <h3 class="card-title fw-bold text-center">Créer un Nouvel Atelier</h3>
      </div>
      <div class="card-body">
        <form method="post" action ="./php/atel-add.php">
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

        <div class="row justify-content-evenly">
          <!-- Nom de l'atelier -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-8">
            <div class="input-group mb-3">
              <span class="input-group-text" id="name">Nom</span>
              <input type="text" class="form-control" name="name" value="" placeholder="Nom de l'atelier" aria-describedby="name_atel" autocomplete="off" required>
            </div>
          </div>
          <!-- Nombre de séance -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-4">
            <div class="input-group mb-3">
              <span class="input-group-text" id="seance">Séances</span>
              <input type="number" class="form-control" value="" placeholder="1" name="seance" autocomplete="off">
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <!-- Public -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-6">
            <div class="input-group mb-3">
              <label class="input-group-text" for="public">Public</label>
              <select class="form-select" id="public" name="public">
              <?php
              // On récupère tout le contenu de la table tconf_publics
              $reponse = $dbh->query('SELECT * FROM tconf_publics');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              { ?>
                <option value="<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></option>
              <?php }
              $reponse->closeCursor(); // Termine le traitement de la requête
              ?>
              </select>
            </div>
          </div>
          <!-- Secteurs -->
          <div class="col-xs-auto col-sm-6 col-md-12 col-xl-6">
            <div class="input-group mb-3">
              <label class="input-group-text" for="sect">Secteur</label>
              <select class="form-select" id="sect" name="sect">
                <?php
                // On récupère tout le contenu de la table tconf_secteurs
                $reponse = $dbh->query('SELECT * FROM tconf_secteurs');
                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch())
                { ?>
                  <option value="<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></option>
                <?php }
                $reponse->closeCursor(); // Termine le traitement de la requête
                ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="d-grid gap-2 d-md-flex justify-content-evenly">
            <input type="submit" value="CREER" class="btn btn-success"/>
            <a href="./index.php?page=param&subpage=atel" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
          </div>
        </div>
        </form>
      </div>
    </div>
  </br>
  <?php
  if (isset($_GET['atel_t']) and !empty($_GET['atel_t'])) {
    $id_atel = $_GET['atel_t'];
        include('./inc/atel-update.php');
  }
  ?>
  </div>
  <div class="col-xs-auto col-sm-12 col-md-6 col-xl-8">
    <!-- Tableau des Ateliers -->
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <div class="col-9">
            <h3 class="card-title fw-bold text-center">Liste des Ateliers Enregistrés</h3>
          </div>
          <div class="col-3">
            <form>
              <input id="myCustomSearchBox" class="form-control" type="text" placeholder="Rechercher" aria-label="Rechercher" autocomplete="off">
            </form>
          </div>
        </div>
      </div>
      <?php
      $req = $dbh->prepare('SELECT tconf_atel.id as "ID", tconf_atel.name as "Nom", tconf_publics.name as "Public", tconf_secteurs.name as "Secteur", tconf_atel.seance as "Nb Séances", tconf_atel.deb as "Début", tconf_atel.fin as "Fin" FROM `tconf_atel` INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_atel.sect_id INNER JOIN tconf_publics ON tconf_publics.id=tconf_atel.public_id ORDER BY tconf_atel.id DESC');
      $req->execute();
      ?>
      <div class="card-body">
        <table id="atel_them" class="table table-striped dt-responsive nowrap" style="width:100%">
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
            if ($row[0]!=1) {
            // on affiche les valeurs de chaque attributs
              echo ("<tr>");
              echo "<td><a class='link-success' title='Modifier cet atelier' href='" . $_SERVER['PHP_SELF'] . "?page=" . $_GET['page'] . "&subpage=" . $_GET['subpage'] . "&atel_t=" . $row[0] . "'><i class='bi bi-pencil-square'></i></a></td>";
              for ($i=0; $i < $req->columnCount(); $i++) {
                      // si le champs est vide
                      if (empty($row[$i])) $row[$i] = "";
                      echo "<td>" . $row[$i] . "</td>";
              }
              echo "</tr>\n";
            }
          }
          echo ("</tbody>");
        ?>
        </table>
      </div>
      <?php $req->closeCursor(); ?>
    </div>
  </div>
</div>