<?php ##########################################################################
# @Name : vis-grp.php
# @Description : Page d'enregistrement des visites de groupes
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<form action="./php/grp-add.php" method="post">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6 my-2">
      <!-- Formulaire Groupes -->
      <div class="card h-100 shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Informations sur le Groupe</h3>
          <p class="text-center">Qui êtes vous ?</p>
        </div>
        <div class="card-body">
          <fieldset class="border-bottom">
            <div class="row justify-content-evenly d-flex align-items-center">
              <!-- Nombre de visiteurs -->
              <div class="col-6 col-md-2 col-lg-6 col-xl-2 my-3">
                <label for="nb" class="form-label">Nombre</label>
                <input type="number" class="form-control" placeholder="0" name="nb" autocomplete="off" required>
              </div>
              <!-- Type de groupe -->
              <div class="col-6 col-md-3 col-lg-6 col-xl-3 my-3">
                <label for="type" class="form-label">Type :</label>
                <select class="form-select" id="type" name="type">
                  <?php
                  // On récupère tout le contenu de la table type de groupe
                  $reponse = $dbh->query('SELECT * FROM tconf_grp_typ');
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  { ?>
                    <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == 22) {echo "selected='selected'"; }?>><?php echo $donnees['type']; ?></option>
                  <?php }
                  $reponse->closeCursor(); // Termine le traitement de la requête
                  ?>
                  </select>
              </div>
              <!-- CCPI ou non ? -->
              <div class="col-6 col-md-3 col-lg-6 col-xl-3 my-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="resi" name="resi" value="1" onclick="checkBoxName(this,'col')">
                  <label class="form-check-label" for="resi"><?php echo($resident);?></label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="col" name="col" value="1">
                  <label class="form-check-label" for="col"><?php echo($collectivite);?></label>
                </div>
              </div>
            </div>
          </fieldset>

          <fieldset class="border-bottom">
            <div class="row justify-content-evenly d-flex align-items-center">
              <!-- Code Postal -->
              <div class="col-6 col-md-2 col-lg-6 col-xl-2 my-3">
                <label for="zip" class="form-label">Code Postal :</label>
                <input type="number" class="form-control" placeholder="36100" name="zip" autocomplete="off" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==5) return false;">
              </div>

              <!-- Département -->
              <div class="col-6 col-md-3 col-lg-6 col-xl-3 my-3">
                <label for="dept" class="form-label">Département :</label>
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
              <!-- Pays -->
              <div class="col-6 col-md-3 col-lg-6 col-xl-3 my-3">
                <label for="country" class="form-label">Pays :</label>
                  <select class="form-select" id="country" name="pays">
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
          </fieldset>

          <div class="row justify-content-evenly d-flex align-items-center py-3">
            <!-- Informations / Mémo -->
            <?php echo($infos); ?>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-6 my-2">
      <!-- Formulaire musée -->
      <div class="card h-100 shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Informations sur la Visite</h3>
          <p class="text-center">Que venez vous voir ?</p>
        </div>
        <div class="card-body">
          <div class="row justify-content-between">
            <!-- Parcours complet -->
            <div class="col-auto">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="allinterest" onclick="checkBoxClass('allinterest', '.interests');">
                <label class="form-check-label" for="allinterest">Parcours Complet</label>
              </div>
            </div>
            <!-- Types de visite -->
            <div class="col-auto me-5">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="guide" name="guide" value="1" <?php if ($grpgui==1) { echo "checked";} ?>>
                <label class="form-check-label" for="guide">Visite guidée</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="payant" name="payant" value="1" <?php if ($grppay==1) { echo "checked";} ?>>
                <label class="form-check-label" for="payant">Visite payante</label>
              </div>
            </div>
          </div>
          <!-- Les Parties du Musée -->
          <fieldset>
            <legend>Les Secteurs <i>(Les parties visitées)</i></legend>
            <div class="row justify-content-around mb-3">
              <?php
              // On récupère tout le contenu de la table secteurs
              $reponse = $dbh->query('SELECT * FROM tconf_secteurs ORDER BY tconf_secteurs.name ASC');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              { if ($donnees['id']!=1) {
                ?>
                <div class="form-check col-auto">
                  <input class="form-check-input interests" type="checkbox" id="<?php echo $donnees['class']; ?>" name="secteurs[]" value="<?php echo $donnees['id']; ?>" onclick="checkBoxClass('<?php echo $donnees['class']; ?>', '<?php echo ".".$donnees['class']; ?>');">
                  <label class="form-check-label" for="<?php echo $donnees['class']; ?>"><?php echo $donnees['name']; ?></label>
                </div>
                <?php
                }
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </div>
          </fieldset>

          <!-- Les Expositions -->
          <fieldset class="border-top">
            <legend>Les Expositions <i>(Les Expositions visibles en cours)</i></legend>
            <div class="row justify-content-around mb-3">
              <?php
              // On récupère tout le contenu de la table expositions dont les entrées sont disponibles maintenant
              $reponse = $dbh->query('SELECT tconf_expo.id AS id, tconf_expo.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class , tconf_secteurs.name AS secteur FROM tconf_expo INNER JOIN tconf_secteurs ON tconf_expo.sect_id = tconf_secteurs.id WHERE NOW() BETWEEN tconf_expo.deb AND tconf_expo.fin ORDER BY tconf_secteurs.name,tconf_expo.name ASC');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              {
              ?>
              <div class="form-check col-auto">
                <input class="form-check-input interests <?php echo $donnees['class']; ?>" type="checkbox" id="<?php echo $donnees['id']; ?>" name="expos[]" value="<?php echo $donnees['id']; ?>">
                <label class="form-check-label interests <?php echo $donnees['class']; ?>" for="<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></label>
              </div>
              <?php
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </div>
          </fieldset>

          <!-- Les Evènements -->
          <?php
            // On récupère tout le contenu de la table evenements dont les entrées sont disponibles maintenant
            $reponse = $dbh->query('SELECT COUNT(id) FROM tconf_evts WHERE NOW() BETWEEN tconf_evts.deb AND tconf_evts.fin');
            $evenement = $reponse->fetch();
            $reponse->closeCursor();
            if ($evenement[0]!=0) { 
              $reponse = $dbh->query('SELECT * FROM tconf_evts WHERE NOW() BETWEEN tconf_evts.deb AND tconf_evts.fin'); ?>
              <fieldset class="border-top">
                <legend>Les Evènements <i>(Les Activités & Evènements spéciaux)</i></legend>
                <div class="row justify-content-around mb-3">
                  <?php
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  {
                  ?>
                  <div class="form-check col-auto">
                    <input class="form-check-input" type="checkbox" id="evt<?php echo $donnees['id']; ?>" name="evts[]" value="<?php echo $donnees['id']; ?>" >
                    <label class="form-check-label" for="evt<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></label>
                  </div>
                  <?php
                  }
                  // Termine le traitement de la requête
                  $reponse->closeCursor();
                  ?>
                </div>
              </fieldset><?php
              $reponse->closeCursor();
            } else {
            }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-12 col-lg-6 my-2">
      <!-- Formulaire Atelier -->
      <div class="card h-100 shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Informations sur les Ateliers</h3>
          <p class="text-center">Que venez vous faire ?</p>
        </div>
        <div class="card-body">
          <div class="row justify-content-between">
          <!-- Les Publics des Ateliers -->
          <fieldset>
            <legend>Public concerné :</legend>
            <div class="row justify-content-around mb-3">
              <?php
              $publiclistID = [];
              // On récupère tout le contenu de la table publics
              $reponse = $dbh->query('SELECT * FROM tconf_publics');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              {
                array_push($publiclistID, $donnees['id']);
              ?>
                <div class="form-check col-xs-auto col-sm-5 col-md-3">
                  <input class="form-check-input" type="radio" name="public" id="public<?php echo $donnees['id'];?>" value="<?php echo $donnees['id'];?>" <?php if ($donnees['id']==1) {echo 'checked';} ?>  onclick="switchDiv('hiddendiv<?php echo $donnees['id'];?>','.hiddendiv')">
                  <label class="form-check-label" for="public<?php echo $donnees['id'];?>">
                    <?php echo $donnees['name'];?>
                  </label>
                </div>
              <?php
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </div>
          </fieldset>
          <!-- Les Ateliers -->
          <fieldset class="border-top">
            <legend>Les Ateliers <i>(Les Ateliers disponibles à ce moment là, pour ce public)</i></legend>
          </br>
            <?php
            foreach ($publiclistID as $pubID) {
              if ($pubID == 1) { ?>
                <div id="hiddendiv<?php echo $pubID;?>" class="row justify-content-around mb-3 hiddendiv">
                <?php
                // On récupère le contenu de la table tconf_atel dont les entrées sont disponibles actuellement
                $reponse = $dbh->prepare('SELECT tconf_atel.id AS id, tconf_atel.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class FROM tconf_atel INNER JOIN tconf_secteurs ON tconf_atel.sect_id = tconf_secteurs.id WHERE (NOW() BETWEEN tconf_atel.deb AND tconf_atel.fin) ORDER BY tconf_atel.sect_id, tconf_atel.name ASC');
                $reponse->execute();

                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch()) { ?>
                  <div class="form-check col-xs-auto col-sm-5 col-md-4">
                    <input class="form-check-input" type="radio" name="atel" id="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>" value="<?php echo $donnees['id']; ?>">
                    <label class="form-check-label interests" for="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></label>
                  </div>
                <?php
                }
                // Termine le traitement de la requête
                $reponse->closeCursor();
                ?>
                </div>
                <?php
              } else { ?>
                <div id="hiddendiv<?php echo $pubID;?>" class="row justify-content-around mb-3 hiddendiv d-none">
                <?php
                // On récupère le contenu de la table tconf_atel dont les entrées sont disponibles actuellement et en fonction du public
                $reponse = $dbh->prepare('SELECT tconf_atel.id AS id, tconf_atel.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class FROM tconf_atel INNER JOIN tconf_secteurs ON tconf_atel.sect_id = tconf_secteurs.id WHERE (NOW() BETWEEN tconf_atel.deb AND tconf_atel.fin) AND ((tconf_atel.public_id=1) OR (tconf_atel.public_id=?)) ORDER BY tconf_atel.sect_id, tconf_atel.name ASC');
                $reponse->execute([$pubID]);

                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch()) { ?>
                  <div class="form-check col-4">
                    <input class="form-check-input" type="radio" name="atel" id="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>" value="<?php echo $donnees['id']; ?>">
                    <label class="form-check-label interests" for="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></label>
                  </div>
                <?php
                }
                // Termine le traitement de la requête
                $reponse->closeCursor();
                ?>
                </div>
                <?php
              }
            }
            ?>
          </fieldset>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 d-flex align-items-start justify-content-evenly">
      <div class="d-flex flex-wrap justify-content-evenly mt-5">
        <button type="submit" class="btn btn-lg btn-success m-3">Enregistrer</button>
        <button type="reset" class="btn btn-lg btn-secondary m-3">Annuler</button>
      </div>
    </div>
  </div>

</form>