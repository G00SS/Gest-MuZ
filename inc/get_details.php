<?php ##########################################################################
# @Name : get_details.php
# @Description : Création des Formulaire Modaux de modification des champs des
#                tables principales
# @Call : param-conf.php via param-conf.js
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<?php include "db.php";

if (isset($_POST['sectId'])) {
  $sectid = $_POST['sectId'];

  // ### Récupération des infos de la table tconf_secteurs pour l'id qui nous intéresse ###
  $req = $dbh->prepare('SELECT * FROM `tconf_secteurs` WHERE tconf_secteurs.id ='.$sectid);
  $req->execute();
  $donnees = $req->fetch();

  if ($req->rowCount() > 0) {
    // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
    $id_sect = $donnees[0];
    $name_sect = $donnees[1];
    $classe_sect = $donnees[2];
    // Termine le traitement de la requête
    $req->closeCursor();
  }
  ?>

  <form method="post" action ="../php/sect-add.php">
      <div class="row justify-content-evenly">
        <input type="hidden" name="id_sect" value="<?php echo ($id_sect);?>">
        <!-- Secteur -->
        <div class="col-xs-auto col-sm-12">
          <div class="input-group mb-3">
            <span class="input-group-text" id="name">Désignation</span>
            <input type="text" class="form-control" name="name" value="<?php echo ($name_sect);?>" placeholder="Désignation" aria-describedby="name" autocomplete="off" required>
          </div>
        </div>
        <!-- Classe CSS -->
        <div class="col-xs-auto col-sm-12">
          <div class="input-group mb-3">
            <span class="input-group-text" id="classecss">Classe CSS</span>
            <input type="texte" class="form-control"  name="classecss" value="<?php echo ($classe_sect);?>" placeholder="Classe CSS" aria-describedby="classecss" autocomplete="off">
          </div>
        </div>
      </div>

    <div class="modal-footer justify-content-evenly">
      <input type="submit" value="MODIFIER" class="btn btn-success"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la modification'">ANNULER</button>
    </div>
  </form>
<?php

} elseif (isset($_POST['motivId'])) {

  $motivid = $_POST['motivId'];

  // ### Récupération des infos de la table tsoci_motiv pour l'id qui nous intéresse ###
  $req = $dbh->prepare('SELECT * FROM `tsoci_motiv` WHERE tsoci_motiv.id ='.$motivid);
  $req->execute();
  $donnees = $req->fetch();

  if ($req->rowCount() > 0) {
    // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
    $id_motiv = $donnees[0];
    $name_motiv = $donnees[1];
    // Termine le traitement de la requête
    $req->closeCursor();
  }
  ?>

  <form method="post" action ="../php/motiv-add.php">
    <div class="row justify-content-center">
        <input type="hidden" name="id_motiv" value="<?php echo ($id_motiv);?>">
      <!-- Désignation de la motivation -->
      <div class="input-group mb-3">
        <span class="input-group-text" id="name">Motivation</span>
        <input type="text" class="form-control" name="name" value="<?php echo ($name_motiv);?>" placeholder="Nom du type de groupe" aria-describedby="name_motiv" autocomplete="off" required>
      </div>
    </div>

    <div class="modal-footer justify-content-evenly">
      <input type="submit" value="MODIFIER" class="btn btn-success"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la modification'">ANNULER</button>
    </div>
  </form>
<?php

} elseif (isset($_POST['grpId'])) {

  $grpid = $_POST['grpId'];

  // ### Récupération des infos de la table tconf_grp_typ pour l'id qui nous intéresse ###
  $req = $dbh->prepare('SELECT * FROM `tconf_grp_typ` WHERE tconf_grp_typ.id ='.$grpid);
  $req->execute();
  $donnees = $req->fetch();

  if ($req->rowCount() > 0) {
    // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
    $id_grp = $donnees[0];
    $name_grp = $donnees[1];
    $scol_grp = $donnees[2];
    // Termine le traitement de la requête
    $req->closeCursor();
  }
  ?>

  <form method="post" action ="../php/grptyp-add.php">
    <div class="row justify-content-center">
        <input type="hidden" name="id_grp" value="<?php echo ($id_grp);?>">
      <!-- Nom du type de Groupe -->
      <div class="input-group mb-3">
        <span class="input-group-text" id="name">Groupe</span>
        <input type="text" class="form-control" name="name" value="<?php echo ($name_grp);?>" placeholder="Nom du type de groupe" aria-describedby="name_grp" autocomplete="off" required>
      </div>

      <!-- Scolaire -->
      <div class="col-4">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="scol" name="scol" value="1" 
            <?php if($scol_grp==1){echo " checked";}; ?>>
            <label class="form-check-label" for="scol">Scolaire</label>
          </div>
      </div>
    </div>

    <div class="modal-footer justify-content-evenly">
      <input type="submit" value="MODIFIER" class="btn btn-success"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la modification'">ANNULER</button>
    </div>
  </form>
<?php

} elseif (isset($_POST['sociageId'])) {

  $sociageid = $_POST['sociageId'];

  // ### Récupération des infos de la table tsoci_ages pour l'id qui nous intéresse ###
  $req = $dbh->prepare('SELECT * FROM `tsoci_ages` WHERE tsoci_ages.id ='.$sociageid);
  $req->execute();
  $donnees = $req->fetch();

  if ($req->rowCount() > 0) {
    // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
    $id_sociage = $donnees[0];
    $ages_sociage = $donnees[1];
    $name_sociage = $donnees[2];
    // Termine le traitement de la requête
    $req->closeCursor();
  }
  ?>

  <form method="post" action ="../php/age-add.php">
      <div class="row justify-content-evenly">
        <input type="hidden" name="id_sociage" value="<?php echo ($id_sociage);?>">
        <!-- Classe d'âges -->
        <div class="col-xs-auto col-sm-12">
          <div class="input-group mb-3">
            <span class="input-group-text" id="ages">Classe d'âges</span>
            <input type="text" class="form-control" name="ages" value="<?php echo ($ages_sociage);?>" placeholder="7 - 77 ans" aria-describedby="ages" autocomplete="off" required>
          </div>
        </div>
        <!-- Désignation -->
        <div class="col-xs-auto col-sm-12">
          <div class="input-group mb-3">
            <span class="input-group-text" id="sociagenom">Désignation</span>
            <input type="texte" class="form-control"  name="sociagenom" value="<?php echo ($name_sociage);?>" placeholder="Adultes" aria-describedby="sociagenom" autocomplete="off">
          </div>
        </div>
      </div>
    <div class="modal-footer justify-content-evenly">
      <input type="submit" value="MODIFIER" class="btn btn-success"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la modification'">ANNULER</button>
    </div>
  </form>
<?php

} elseif (isset($_POST['publicId'])) {

  $publicid = $_POST['publicId'];

  // ### Récupération des infos de la table tconf_publics pour l'id qui nous intéresse ###
  $req = $dbh->prepare('SELECT * FROM `tconf_publics` WHERE tconf_publics.id ='.$publicid);
  $req->execute();
  $donnees = $req->fetch();

  if ($req->rowCount() > 0) {
    // On stock les infos de la configuration dans des variables que nous pourrons utiliser plus tard dans le script
    $id_public = $donnees[0];
    $name_public = $donnees[1];
    $ages_public = $donnees[2];
    $scol_public = $donnees[3];
    // Termine le traitement de la requête
    $req->closeCursor();
  }
  ?>

  <form method="post" action ="../php/public-add.php">
    <div class="row justify-content-center">
      <input type="hidden" name="id_public" value="<?php echo ($id_public);?>">
      <!-- Nom du Public -->
      <div class="col-8">
        <div class="input-group mb-3">
          <span class="input-group-text" id="name">Public</span>
          <input type="text" class="form-control" name="name" value="<?php echo ($name_public);?>" placeholder="Nom du Public" aria-describedby="name_public" autocomplete="off" required>
        </div>
      </div>

      <!-- Scolaire -->
      <div class="col-3">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="scol" name="scol" value="1" <?php if($scol_public==1){echo " checked";}; ?>>
            <label class="form-check-label" for="scol">Scolaire</label>
          </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <!-- Selection de la classe d'âges -->
      <div class="col-auto">
        <div class="input-group mb-3">
          <label class="input-group-text" for="grpages">Classe d'âges</label>
          <select class="form-select" id="grpages" name="grpages">
          <?php
          // On récupère tout le contenu de la table grpage
          $reponse = $dbh->query('SELECT * FROM tsoci_ages');
          // On affiche chaque entrée une à une
          while ($donnees = $reponse->fetch())
          { ?>
            <option value="<?php echo $donnees['id']; ?>" <?php if ($donnees['id'] == $ages_public) {echo "selected='selected'"; }?>><?php echo $donnees['age']; ?></option>
          <?php }
          $reponse->closeCursor(); // Termine le traitement de la requête
          ?>
          </select>
        </div>
      </div>
    </div>

    <div class="modal-footer justify-content-evenly">
      <input type="submit" value="MODIFIER" class="btn btn-success"/>
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Annuler la modification'">ANNULER</button>
    </div>
  </form>
<?php

} else {
  // code...
} ?>
