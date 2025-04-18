<?php ##########################################################################
# @Name : param-perso.php
# @Description : Page de personnalisation de la structure
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
  $req = $dbh->prepare('SELECT * FROM `tconf_param`');
  $req->execute();
  $donnees = $req->fetch();
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_param = $donnees[0];
  $structure = $donnees[1];
  $resident = $donnees[2];
  $collectivite = $donnees[3];
  $default_dept = $donnees[4];
  $default_pays = $donnees[5];
  $infos = $donnees[8];
  $indivpay = $donnees[9];
  $indivgui = $donnees[10];
  $grppay = $donnees[11];
  $grpgui = $donnees[12];
  // Termine le traitement de la requête
  $req->closeCursor();
?>
<form method="post" action ="./php/perso-add.php">
  <div class="row justify-content-center">
    <div class="col-xs-12 col-lg-6 col-xl-6">
      <!-- Personnalisation de la Structure -->
      <div class="card shadow mb-3">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Personnalisation de l'établissement</h3>
        </div>
        <div class="card-body">
          <div class="row justify-content-center">
            <!-- Nom de l'Etablissement -->
            <div class="col-auto">
              <div class="input-group mb-3">
                <span class="input-group-text" id="struct">Structure</span>
                <input type="text" class="form-control" name="struct" value="<?php echo $structure; ?>" placeholder="Nom de l'établissement" aria-describedby="struct" autocomplete="off" maxlength="15" required>
              </div>
            </div>
            <!-- Appellation des Résidents -->
            <div class="col-auto">
              <div class="input-group mb-3">
                <span class="input-group-text" id="resi">Résidents</span>
                <input type="text" class="form-control" name="resi" value="<?php echo $resident; ?>" placeholder="Gentilé des résidents" aria-describedby="resi" autocomplete="off" maxlength="15" required>
              </div>
            </div>
            <!-- Désignation de la Communauté de Commune -->
            <div class="col-auto">
              <div class="input-group mb-3">
                <span class="input-group-text" id="coll">Collectivité</span>
                <input type="text" class="form-control" name="coll" value="<?php echo $collectivite; ?>" placeholder="Nom de la ComCom" aria-describedby="coll" autocomplete="off" maxlength="15" required>
              </div>
            </div>
          </div>

          <div class="row justify-content-center mb-3">
            <div class="col-auto">
              <!-- Département -->
              <div class="input-group">
                <label class="input-group-text" for="dept">Département par défaut</label>
                <select class="form-select" id="dept" name="dept">
                  <?php
                  // On récupère tout le contenu de la table pays
                  $reponse = $dbh->query('SELECT * FROM tloc_depts');
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  {
                  ?>
                  <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $default_dept) {echo "selected='selected'"; }?>><?php echo $donnees['nb'] . " - " . $donnees['name']; ?></option>
                  <?php
                  }
                  // Termine le traitement de la requête
                  $reponse->closeCursor();
                  ?>
                </select>
              </div>
            </div>
            <div class="col-auto">
              <!-- Pays -->
              <div class="input-group">
                <label class="input-group-text" for="pays">Pays par défaut</label>
                <select class="form-select" id="pays" name="pays">
                  <?php
                  // On récupère tout le contenu de la table pays
                  $reponse = $dbh->query('SELECT * FROM tloc_pays');
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  {
                  ?>
                  <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $default_pays) {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
                  <?php
                  }
                  // Termine le traitement de la requête
                  $reponse->closeCursor();
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row justify-content-center mb-3">
            <div class="col-12">
              <div class="input-group">
                <span class="input-group-text">Informations / Mémo</span>
                <textarea class="form-control" aria-label="Infos" rows="10" name="infos"><?php echo($infos);?></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="d-grid gap-3 d-md-flex justify-content-evenly">
              <input type="submit" value="MODIFIER" class="btn btn-success"/>
              <a href="./index.php?page=param&subpage=perso" class="btn btn-secondary" title="Annuler les modifications">ANNULER</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xs-12 col-lg-6 col-xl-5">
      <!-- Planning -->

        <div class="card shadow mb-3">
          <div class="card-header text-white bg-primary">
            <h3 class="card-title fw-bold text-center">Horaires d'ouverture</h3>
          </div>
          <div class="card-body">
            <?php
              $req = $dbh->prepare('SELECT id, FR, work,TIME_FORMAT(tconf_days.open, "%H:%i") AS open , TIME_FORMAT(tconf_days.close, "%H:%i") AS close FROM `tconf_days` ORDER BY tconf_days.id ASC');
              $req->execute();

              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            ?>
            <div class="row justify-content-evently mb-3">
              <div class="col-4 d-grid">
                <input type="checkbox" class="btn-check" id="<?php echo($id);?>day" <?php if ($work == 1) { echo("checked"); }?> name="work[<?php echo($id);?>]" value="1" autocomplete="off">
                <label class="btn btn-outline-primary" for="<?php echo($id);?>day"><?php echo($FR);?></label>
              </div>
              <div class="col-8">
                <div class="input-group justify-content-center">
                  <span class="input-group-text" id="h<?php echo($id);?>">Horaires</span>
                  <input type="time" name="open[<?php echo($id);?>]" value="<?php echo($open);?>" <?php if ($work == 0) { echo("disabled"); }?>/>
                  <span class="input-group-text"> à </span>
                  <input type="time" name="close[<?php echo($id);?>]" value="<?php echo($close);?>" <?php if ($work == 0) { echo("disabled"); }?>/>
                  <span class="input-group-text">  </span>
                </div>
              </div>
            </div>
            <?php
              }
              $req->closeCursor();
            ?>

            <div class="row justify-content-center">
              <div class="input-group justify-content-center my-3">
                <?php
                  $req = $dbh->prepare('SELECT MIN(TIME_FORMAT(tconf_days.open, "%H:%i")) AS minH, MAX(TIME_FORMAT(tconf_days.close, "%H:%i")) AS maxh FROM `tconf_days` WHERE tconf_days.work = 1');
                  $req->execute();
                  $donnees = $req->fetch();
                ?>
                <span class="input-group-text" id="amplitude">Amplitude horaire max :</span>
                <input type="time" name="timeFrom" value="<?php echo $donnees[0]; ?>" readonly />
                <span class="input-group-text"> à </span>
                <input type="time" name="timeTo" value="<?php echo $donnees[1]; ?>" readonly/>
                <span class="input-group-text">  </span>
                <?php
                  // Termine le traitement de la requête
                  $req->closeCursor();
                ?>
              </div>
            </div>

          </div>
        </div>

        <!-- Visites -->
        <div class="card shadow mb-3">
          <div class="card-header text-white bg-primary">
            <h3 class="card-title fw-bold text-center">Etats par défaut des visites</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <h4>Visites Individuelles</h4>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="indivpay" name="indivpay" <?php if ($indivpay == 1) { echo("checked"); }?>>
                  <label class="form-check-label" for="indivpay">Payantes</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="indivgui" name="indivgui" <?php if ($indivgui == 1) { echo("checked"); }?>>
                  <label class="form-check-label" for="indivgui">Guidées</label>
                </div>
              </div>
              <div class="col-6">
                <h4>Visites de Groupes</h4>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="grppay" name="grppay" <?php if ($grppay == 1) { echo("checked"); }?>>
                  <label class="form-check-label" for="grppay">Payantes</label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="grpgui" name="grpgui" <?php if ($grpgui == 1) { echo("checked"); }?>>
                  <label class="form-check-label" for="grpgui">Guidées</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        

    </div>
  </div>
</form>
