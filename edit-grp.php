<?php
// ### Récupération des infos de la table tgrp pour l'enregistrement qui nous intéresse ###
$req = $dbh->prepare('SELECT * FROM `tgrp` WHERE tgrp.id='.$_GET['id']);
$req->execute();
$donnees = $req->fetch();


if ($req->rowCount() > 0) {
  // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
  $id_grp = $donnees[0];
  $nb_grp = $donnees[1];
  $primo_grp = $donnees[2];
  $pays_grp = $donnees[3];
  $dept_grp = $donnees[4];
  $col_grp = $donnees[5];
  $resi_grp = $donnees[6];
  $public_grp = $donnees[7];
  $guide_grp = $donnees[8];
  $payant_grp = $donnees[9];
  $typ_grp = $donnees[10];
  $atel_grp = $donnees[11];
  $create_grp = $donnees[12];
  // Termine le traitement de la requête
  $req->closeCursor();
}

// ### Récupération des infos de la table tgrp_sect (une liste des secteurs visités par notre groupe) ###
$req = $dbh->prepare('SELECT tgrp_sect.sect_id FROM `tgrp_sect` WHERE tgrp_sect.grp_id ='.$_GET['id']);
$req->execute();
$sect_grp = $req->fetchAll(PDO::FETCH_COLUMN, 0);
// Termine le traitement de la requête
$req->closeCursor();

// ### Récupération des infos de la table tgrp_expo (une liste des expositions visitées par notre groupe) ###
$req = $dbh->prepare('SELECT tgrp_expo.expo_id FROM `tgrp_expo` WHERE tgrp_expo.grp_id ='.$_GET['id']);
$req->execute();
$expos_grp = $req->fetchAll(PDO::FETCH_COLUMN, 0);
// Termine le traitement de la requête
$req->closeCursor();

// ### Récupération des infos de la table tgrp_evt (une liste des événements auxquels a participé notre groupe) ###
$req = $dbh->prepare('SELECT tgrp_evts.evt_id FROM `tgrp_evts` WHERE tgrp_evts.grp_id ='.$_GET['id']);
$req->execute();
$evts_grp = $req->fetchAll(PDO::FETCH_COLUMN, 0);
// Termine le traitement de la requête
$req->closeCursor();

?>


<form action="./php/grp-add.php?id=<?php echo $id_grp;?>" method="post">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6 my-2">
      <!-- Formulaire Groupes -->
      <div class="card h-100 shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Modifier les Informations sur le Groupe</h3>
          <p class="text-center">Qui êtes vous ?</p>
        </div>
        <div class="card-body">
          <fieldset class="border-bottom">
            <div class="row justify-content-evenly d-flex align-items-center">
              <!-- Nombre de visiteurs -->
              <div class="col-6 col-md-2 col-lg-6 col-xl-2 my-3">
                <label for="nb" class="form-label">Nombre</label>
                <input type="number" class="form-control" value="<?php echo ($nb_grp);?>" name="nb" autocomplete="off" required>
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
                    <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $typ_grp) {echo "selected='selected'"; }?>><?php echo $donnees['type']; ?></option>
                  <?php }
                  $reponse->closeCursor(); // Termine le traitement de la requête
                  ?>
                  </select>
              </div>
              <!-- CCPI ou non ? -->
              <div class="col-6 col-md-3 col-lg-6 col-xl-3 my-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="resi" name="resi" value="1" <?php if ($resi_grp==1) {echo "checked";}?> onclick="checkBoxName(this,'col')">
                  <label class="form-check-label" for="resi"><?php echo($resident);?></label>
                </div>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="col" name="col" value="1" <?php if ($col_grp==1) {echo "checked";}?>>
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
                  // On récupère tout le contenu de la table des départements
                  $reponse = $dbh->query('SELECT * FROM tloc_depts');
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  {
                  ?>
                  <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $dept_grp) {echo "selected='selected'"; }?>><?php echo $donnees['nb'] . " - " . $donnees['name']; ?></option>
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
                  <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $pays_grp) {echo "selected='selected'"; }?>><?php echo $donnees['name']; ?></option>
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
          <h3 class="card-title fw-bold text-center">Modifier les Informations sur la Visite</h3>
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
                <input class="form-check-input" type="checkbox" id="guide" name="guide" value="1" <?php if ($guide_grp ==1) {echo "checked";}?>>
                <label class="form-check-label" for="guide">Visite guidée</label>
              </div>
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="payant" name="payant" value="1" <?php if ($payant_grp ==1) {echo "checked";}?>>
                <label class="form-check-label" for="payant">Visite payante</label>
              </div>
            </div>
          </div>
          <!-- Les Secteurs -->
          <fieldset>
            <legend>Les Secteurs <i>(Les parties visitées)</i></legend>
            <div class="row justify-content-around mb-3">
              <?php
              // On récupère tout le contenu de la table sect
              $reponse = $dbh->query('SELECT * FROM tconf_secteurs ORDER BY tconf_secteurs.name ASC');
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              { if ($donnees['id']!=1) {
                ?>
                <div class="form-check col-auto">
                  <input class="form-check-input interests" type="checkbox" id="<?php echo $donnees['class']; ?>" name="secteurs[]" value="<?php echo $donnees['id']; ?>" <?php if (in_array($donnees['id'], $sect_grp)) { echo "checked"; }?> onclick="checkBoxClass('<?php echo $donnees['class']; ?>', '<?php echo ".".$donnees['class']; ?>');">
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
            <legend>Les Expositions <i>(Les Expositions visibles à ce moment là)</i></legend>
            <div class="row justify-content-around mb-3">
              <?php
              // On récupère tout le contenu de la table expositions dont les entrées étaient disponibles à l'enregistrement de la visite
              $reponse = $dbh->prepare('SELECT tconf_expo.id AS id, tconf_expo.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class , tconf_secteurs.name AS secteur FROM tconf_expo INNER JOIN tconf_secteurs ON tconf_expo.sect_id = tconf_secteurs.id WHERE ? BETWEEN tconf_expo.deb AND tconf_expo.fin ORDER BY tconf_secteurs.name,tconf_expo.name ASC');
              $reponse->execute([$create_grp]);
              // On affiche chaque entrée une à une
              while ($donnees = $reponse->fetch())
              {
              ?>
              <div class="form-check col-auto">
                <input class="form-check-input interests <?php echo $donnees['class']; ?>" type="checkbox" id="<?php echo $donnees['id']; ?>" name="expos[]" value="<?php echo $donnees['id']; ?>" <?php if (in_array($donnees['id'], $expos_grp)) { echo "checked"; }?>>
                <label class="form-check-label interests <?php echo $donnees['class']; ?>" for="<?php echo $donnees['id']; ?>"><?php echo $donnees['name']; ?></label>
              </div>
              <?php
              }
              // Termine le traitement de la requête
              $reponse->closeCursor();
              ?>
            </div>
          </fieldset>

          <!-- Les Evénements -->
          <?php
            // On récupère tout le contenu de la table evenements dont les entrées sont disponibles à la création du groupe
            $reponse = $dbh->prepare('SELECT COUNT(id) FROM tconf_evts WHERE ? BETWEEN tconf_evts.deb AND tconf_evts.fin');
            $reponse->execute([$create_grp]);
            $evenement = $reponse->fetch();
            $reponse->closeCursor();
            if ($evenement[0]!=0) { 
              $reponse = $dbh->prepare('SELECT * FROM tconf_evts WHERE ? BETWEEN tconf_evts.deb AND tconf_evts.fin'); 
              $reponse->execute([$create_grp]);?>
              <fieldset class="border-top">
                <legend>Les Evènements <i>(Les Activités & Evènements spéciaux)</i></legend>
                <div class="row justify-content-around mb-3">
                  <?php
                  // On affiche chaque entrée une à une
                  while ($donnees = $reponse->fetch())
                  {
                  ?>
                  <div class="form-check col-auto">
                    <input class="form-check-input" type="checkbox" id="evt<?php echo $donnees['id']; ?>" name="evts[]" value="<?php echo $donnees['id']; ?>" <?php if (in_array($donnees['id'], $evts_grp)) { echo "checked"; }?>>
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
                <div class="form-check col-3">
                  <input class="form-check-input" type="radio" name="public" id="public<?php echo $donnees['id'];?>" value="<?php echo $donnees['id'];?>" <?php if ($donnees['id']==$public_grp) {echo 'checked';} ?>  onclick="switchDiv('hiddendiv<?php echo $donnees['id'];?>','.hiddendiv')">
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
                <div id="hiddendiv<?php echo $pubID;?>" class="row justify-content-around mb-3 hiddendiv <?php if ($pubID != $public_grp) {echo ' d-none';} ?>">
                <?php
                // On récupère le contenu de la table tconf_atel dont les entrées sont disponibles actuellement
                $reponse = $dbh->prepare('SELECT tconf_atel.id AS id, tconf_atel.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class FROM tconf_atel INNER JOIN tconf_secteurs ON tconf_atel.sect_id = tconf_secteurs.id WHERE (? BETWEEN tconf_atel.deb AND tconf_atel.fin) ORDER BY tconf_atel.sect_id, tconf_atel.name ASC');
                $reponse->execute([$create_grp]);

                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch()) { ?>
                  <div class="form-check col-4">
                    <input class="form-check-input" type="radio" name="atel" id="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>" value="<?php echo $donnees['id']; ?>" <?php if (($pubID==$public_grp) AND ($donnees['id']==$atel_grp)) {echo 'checked';} ?>>
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
                <div id="hiddendiv<?php echo $pubID;?>" class="row justify-content-around mb-3 hiddendiv<?php if ($pubID!=$public_grp) {echo ' d-none';} ?>">
                <?php
                // On récupère le contenu de la table tconf_atel dont les entrées sont disponibles actuellement et en fonction du public
                $reponse = $dbh->prepare('SELECT tconf_atel.id AS id, tconf_atel.name AS name, sect_id, deb, fin , tconf_secteurs.class AS class FROM tconf_atel INNER JOIN tconf_secteurs ON tconf_atel.sect_id = tconf_secteurs.id WHERE (? BETWEEN tconf_atel.deb AND tconf_atel.fin) AND ((tconf_atel.public_id=1) OR (tconf_atel.public_id=?)) ORDER BY tconf_atel.sect_id, tconf_atel.name ASC');
                $reponse->execute([$create_grp,$pubID]);

                // On affiche chaque entrée une à une
                while ($donnees = $reponse->fetch()) { ?>
                  <div class="form-check col-4">
                    <input class="form-check-input" type="radio" name="atel" id="atel<?php echo $pubID;?>a<?php echo $donnees['id']; ?>" value="<?php echo $donnees['id']; ?>" <?php if (($pubID==$public_grp) AND ($donnees['id']==$atel_grp)) {echo 'checked';} ?>>
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
      <div class="col-12 d-flex flex-wrap justify-content-evenly mb-2">
        <button type="submit" class="btn btn-lg btn-success my-2">MODIFIER</button>
        <a href="./index.php?page=rec&subpage=grp" class="btn btn-lg btn-secondary my-2" title="Annuler les modifications">ANNULER</a>
        <a  class="btn btn-lg btn-danger my-2" title="Supprimer l'enregistrement" data-bs-toggle="modal" data-bs-target="#ModalConfirm">SUPPRIMER</a>
      </div>
    </div>

</form>

<!-- Modal Supression-->
<div class="modal fade" id="ModalConfirm" tabindex="-1" aria-labelledby="ModalConfirmLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header text-white bg-danger">
        <h4 class="modal-title fw-bold text-center" id="ModalConfirmLabel">Voulez-vous Supprimer ?</h4>
        <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="fw-bold text-center">&#10060    Cette action ne pourra plus être annulée.    &#10060</p>
      </div>
      <div class="modal-footer justify-content-evenly">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la Suppression">ANNULER</button>
        <a type="button" class="btn btn-danger" href="./php/grp-del.php?id=<?php echo($id_grp); ?>" id="grpdel" title="Supprimer l'enregistrement">SUPPRIMER</a>
      </div>
    </div>
  </div>
</div>

<?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>