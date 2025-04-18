<?php ##########################################################################
# @Name : menu.php
# @Description : Menu du Gest'Muz
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<!-- MENU / BARRE DE NAVIGATION -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="index.php">
      <p class=" text-center test-break text-capitalize fw-bold fst-italic m-0 p-0">
    <?php echo($structure);?>
      </p></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Menu" aria-controls="Menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="Menu">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <!-- Gest° Visites -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-nowrap <?php if(isset($_GET['page']) AND $_GET['page']=='vis') echo 'active' ?>" id="gestvisi" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-people-fill"></i> Nouvelles Visites</a>
          <div class="dropdown-menu" aria-labelledby="gestvisi">
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='vis') AND $_GET['subpage']=='indiv') echo 'active' ?>" href="index.php?page=vis&subpage=indiv">Visites Individuels</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='vis') AND $_GET['subpage']=='grp') echo 'active' ?>" href="index.php?page=vis&subpage=grp">Visites Groupes</a>
          </div>
        </li>
        <!-- Gest° Données -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-nowrap <?php if((isset($_GET['page']) AND $_GET['page']=='rec') OR ((isset($_GET['page']) AND $_GET['page']=='edit'))) echo 'active' ?>" id="gestdata" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-pencil-square"></i> Modifier</a>
          <div class="dropdown-menu" aria-labelledby="gestdata">
            <a class="dropdown-item <?php if(((isset($_GET['page']) AND $_GET['page']=='rec') AND $_GET['subpage']=='indiv') OR ((isset($_GET['page']) AND $_GET['page']=='edit') AND $_GET['subpage']=='indiv')) echo 'active' ?>" href="index.php?page=rec&subpage=indiv">Entrées Individuelles</a>
            <a class="dropdown-item <?php if(((isset($_GET['page']) AND $_GET['page']=='rec') AND $_GET['subpage']=='grp') OR ((isset($_GET['page']) AND $_GET['page']=='edit') AND $_GET['subpage']=='grp')) echo 'active' ?>" href="index.php?page=rec&subpage=grp">Entrées Groupes</a>
          </div>
        </li>
        <!-- Statistiques -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-nowrap <?php if(isset($_GET['page']) AND $_GET['page']=='stat') echo 'active' ?>" id="stat" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-pie-chart-fill"></i> Statistiques</a>
          <div class="dropdown-menu" aria-labelledby="stat">
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='stat') AND $_GET['subpage']=='indiv') {echo 'active';}?>" href="index.php?page=stat&subpage=indiv">Visites Individuelles</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='stat') AND $_GET['subpage']=='grp') {echo 'active';}?>" href="index.php?page=stat&subpage=grp">Visites Groupes</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='stat') AND $_GET['subpage']=='glob') {echo 'active';} else {echo 'disabled';} ?>" href="index.php?page=stat&subpage=glob">Globales</a>
          </div>
        </li>
        <!-- Paramétrage -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-nowrap <?php if((isset($_GET['page']) AND $_GET['page']=='param')) echo 'active' ?>" id="param" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-gear-fill"></i> Paramètres</a>
          <div class="dropdown-menu" aria-labelledby="param">
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='evt') echo 'active' ?> <?php if($_SESSION["role"]>2) echo 'disabled' ?>" href="index.php?page=param&subpage=evt">Les Événements</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='expo') echo 'active' ?> <?php if($_SESSION["role"]>2) echo 'disabled' ?>" href="index.php?page=param&subpage=expo">Les Expositions</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='atel') echo 'active' ?> <?php if($_SESSION["role"]>2) echo 'disabled' ?>" href="index.php?page=param&subpage=atel">Les Ateliers</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='conf') echo 'active' ?> <?php if($_SESSION["role"]!=1) echo 'disabled' ?>" href="index.php?page=param&subpage=conf">Configuration</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='perso') echo 'active' ?> <?php if($_SESSION["role"]!=1) echo 'disabled' ?>" href="index.php?page=param&subpage=perso">Personnalisation</a>
            <a class="dropdown-item <?php if((isset($_GET['page']) AND $_GET['page']=='param') AND $_GET['subpage']=='users') echo 'active' ?> <?php if($_SESSION["role"]!=1) echo 'disabled' ?>" href="index.php?page=param&subpage=users">Utilisateurs</a>
          </div>
        </li>
      </ul>
      <li class="navbar-nav nav-item dropdown">
        <a href="php/logout.php" class="nav-link text-nowrap active"><i class="bi bi-box-arrow-right"></i> Quitter</a>
      </li>
    </div>
  </div>
</nav>
<!-- Fin du MENU -->
