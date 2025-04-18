<?php ##########################################################################
# @Name : dash.php
# @Description : Page d'accueil avec dashboard
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<div class="row justify-content-center">
<!-- Now -->
  <div class="col-xs-auto col-md-4" style="margin-bottom: 1em;">
    <div class="card shadow">
      <div class="card-header text-white bg-primary">
        <h5 class="card-title fw-bold text-center">AUJOURD'HUI</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- HORLOGE -->
          <div class="col-xs-auto col-lg-6">
            <p id="clocktext" class="fs-1 text-nowrap text-center fw-bold"></p>
            <p class="fs-2 text-nowrap text-center fw-bold"><?php $today = date('d/m/Y'); echo $today ?></p>
          </div>
          <!-- DOUGHNUT NB INDIV/GROUPE TODAY -->
          <div class="col-xs-auto col-lg-6">
            <?php
            $req = $dbh->prepare('SELECT "Individuels" Visites, SUM(nb) AS Total FROM tindiv WHERE DATE(tindiv.create_date) = CURDATE() UNION SELECT "Groupes" Visites, SUM(nb) AS Total FROM tgrp WHERE DATE(tgrp.create_date) = CURDATE()');
            $req->execute();

            $labelVisitesD= [];
            $valVisitesD= [];
            $nbVisitesD=0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $labelVisitesD[]= $Visites;
              $valVisitesD[]= (int)$Total;
              $nbVisitesD += $Total;
            }
            $req->closeCursor();
            ?>
            <canvas id="visitesIGD" style="min-height: 9vmin;"></canvas>
          </div>
        </div>
        <div class="row mt-2 border-top">
          <div class="col-xs-auto col-md-6 text-center text-wrap mt-3">
            <a href="./index.php?page=vis&subpage=indiv" class="btn btn-warning" id="visindiv" title="Enregistrer des Entrées Individuelles"><i class="bi bi-person-fill"></i> INDIVIDUELS</a>
          </div>
          <div class="col-xs-auto col-md-6 text-center text-wrap mt-3">
            <a href="./index.php?page=vis&subpage=grp" class="btn btn-warning" id="visgrp" title="Enregistrer des Entrées de Groupes"><i class="bi bi-people-fill"></i> GROUPES</a>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Cette semaine -->
  <div class="col-xs-auto col-md-8" style="margin-bottom: 1em;">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <h5 class="card-title fw-bold text-center">CETTE SEMAINE</h5>
      </div>
      <div class="card-body">
        <div class="row justify-content-evenly">
          <!-- DOUGHNUT NB INDIV/GROUPE WEEK -->
          <div class="col-xs-auto col-md-6 col-lg-3 mb-2">
            <?php
            $req = $dbh->prepare('SELECT "Individuels" Visites, SUM(nb) AS Total FROM tindiv WHERE WEEK(tindiv.create_date)=WEEK(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT "Groupes" Visites, SUM(nb) AS Total FROM tgrp WHERE WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();

            $labelVisitesW= [];
            $valVisitesW= [];
            $nbVisitesW=0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $labelVisitesW[]= $Visites;
              $valVisitesW[]= (int)$Total;
              $nbVisitesW += $Total;
            }
            $req->closeCursor();
            ?>
            <canvas id="visitesIGW"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION RESIDENTS/LOCAUX/OTHERS WEEK -->
          <div class="col-xs-auto col-md-6 col-lg-3 mb-2">
            <?php
            $resiW= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.resi=1 AND WEEK(tindiv.create_date)=WEEK(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.resi=1 AND WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $resiW[]= $Effectif;
            }
            $req->closeCursor();
            $colW= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=1 AND tindiv.resi=0 AND WEEK(tindiv.create_date)=WEEK(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=1 AND tgrp.resi=0 AND WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $colW[]= $Effectif;
            }
            $req->closeCursor();
            $OtherW= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=0 AND tindiv.resi=0 AND WEEK(tindiv.create_date)=WEEK(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=0 AND tgrp.resi=0 AND WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $OtherW[]= $Effectif;
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphIW"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION GRP/SCOL WEEK -->
          <div class="col-xs-auto col-md-6 col-lg-2 mb-2 d-none d-lg-block">
            <?php
            $req = $dbh->prepare('SELECT tconf_grp_typ.scol AS Scolaire, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(AVG(tgrp.nb)) AS MoyEff, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS Eff FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_grp_typ.scol');
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $scol[]= (int)$Scolaire;
              $valFreqSW[]= (int)$Frequentation;
            }
            $req->closeCursor();

            if (isset($scol[0])) {
              if ($scol[0]==0) {
                if (isset($scol[1])) {
                  //do nothing
                } else {
                  $valFreqSW[1] = Null;
                }
              } else {
                $valFreqSW[1] = $valFreqSW[0];
                $valFreqSW[0] = Null;
              }
            } else {
              $valFreqSW[0] = Null;
              $valFreqSW[1] = Null;
            }
            $scol=[];
            ?>
            <canvas id="GraphSW"></canvas>
          </div>
          <!-- DOUGHNUT REPARTITION GRP/ATEL WEEK -->
          <div class="col-xs-auto col-md-12 col-lg-4 mb-2">
            <?php
            $req = $dbh->prepare('SELECT tconf_atel.name AS Atelier, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, SUM(tgrp.col) AS Collectivite, SUM(tgrp.resi) AS Resident, ROUND(AVG(tgrp.nb)) AS MoyEff, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS Effectif FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE WEEK(tgrp.create_date)=WEEK(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_atel.name ORDER BY tconf_atel.name ASC');
            $req->execute();

            $labelAtelierW= [];
            $valSeancesW= [];
            $valFreqW= [];
            $valGrpW= [];
            $valcollW= [];
            $valResW= [];
            $valEffW= [];
            $TotEffW= 0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($Atelier != 'Non Renseigné') {
                $labelAtelierW[]= $Atelier;
                $valSeancesW[]= (int)$Seances;
                $valFreqW[]= (int)$Frequentation;
                $valGrpW[]= (int)$Groupes;
                $valcollW[]= ((int)$Collectivite - (int)$Resident);
                $valResW[]= (int)$Resident;
                $valEffW[]= (int)$Effectif;
                $TotEffW= $TotEffW + ((int)$Effectif);
              }
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphAW"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Ce mois-ci -->
<div class="row justify-content-center">
  <div class="col-xs-auto" style="margin-bottom: 1em;">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <h5 class="card-title fw-bold text-center">CE MOIS CI</h5>
      </div>
      <div class="card-body">
        <div class="row justify-content-evenly">
          <!-- DOUGHNUT NB INDIV/GROUPE MONTH -->
          <div class="col-xs-auto col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-2">
            <?php
            $req = $dbh->prepare('SELECT "Individuels" Visites, SUM(nb) AS Total FROM tindiv WHERE MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT "Groupes" Visites, SUM(nb) AS Total FROM tgrp WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();

            $labelVisitesM= [];
            $valVisitesM= [];
            $nbVisitesM=0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $labelVisitesM[]= $Visites;
              $valVisitesM[]= (int)$Total;
              $nbVisitesM += $Total;
            }
            $req->closeCursor();
            ?>
            <canvas id="visitesIGM"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION RESIDENTS/LOCAUX/OTHERS MONTH -->
          <div class="col-xs-auto col-sm-4 col-md-4 col-lg-4 col-xl-2 mb-2">
            <?php
            $resiM= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.resi=1 AND MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.resi=1 AND MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $resiM[]= $Effectif;
            }
            $req->closeCursor();
            $colM= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=1 AND tindiv.resi=0 AND MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=1 AND tgrp.resi=0 AND MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $colM[]= $Effectif;
            }
            $req->closeCursor();
            $OtherM= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=0 AND tindiv.resi=0 AND MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=0 AND tgrp.resi=0 AND MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $OtherM[]= $Effectif;
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphIM"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION GRP/SCOL MONTH -->
          <div class="col-xs-auto col-sm-2 col-md-2 col-lg-2 col-xl-1 mb-2">
            <?php
            $req = $dbh->prepare('SELECT tconf_grp_typ.scol AS Scolaire, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(AVG(tgrp.nb)) AS MoyEff, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS Eff FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_grp_typ.scol');
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $scol[]= (int)$Scolaire;
              $valEffSM[]= (int)$Eff;
            }
            $req->closeCursor();
            
            if (isset($scol[0])) {
              if ($scol[0]==0) {
                if (isset($scol[1])) {
                  //do nothing
                } else {
                  $valEffSM[1] = Null;
                }
              } else {
                $valEffSM[1] = $valEffSM[0];
                $valEffSM[0] = Null;
              };
            } else {
              $valEffSM[0] = Null;
              $valEffSM[1] = Null;
            }
            $scol=[];
            ?>
            <canvas id="GraphSM"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/CLASSES D'AGES MONTH -->
          <div class="col-xs-auto col-sm-8 col-md-8 col-lg-8 col-xl-3 mb-2">
            <?php
            // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, tsoci_ages.name AS Categorie FROM `tsoci_ages` ORDER BY tsoci_ages.age ASC');
            $req->execute();
            $ages = [];
            $cat = [];
            $qtenull = [];

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                  $ages[$ID] = $Classe;
                  $cat[$ID] = $Categorie;
                  $qtenull[$ID] = ' ';
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $ages = array_values($ages);


            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, SUM(tindiv.nb) AS Effectif, tsoci_ages.name AS Catégorie FROM `tindiv` INNER JOIN tsoci_ages ON tsoci_ages.id = tindiv.grpage_id WHERE MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) GROUP BY tsoci_ages.id ORDER BY tsoci_ages.age ASC');
            $req->execute();

            $effIndECM = $qtenull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $effIndECM[$ID]= $Effectif;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $effIndECM = array_values($effIndECM);


            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classes, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS Effectif, tsoci_ages.name AS Categories FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id INNER JOIN tsoci_ages ON tsoci_ages.id = tconf_publics.age WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tsoci_ages.name ORDER BY tsoci_ages.id');
            $req->execute();

            $effGrpECM = $qtenull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $effGrpECM[$ID]= $Effectif;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $effGrpECM = array_values($effGrpECM);
            ?>

            <?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>

            <canvas id="GraphECM"></canvas>
          </div>
        </div>
        <div class="row justify-content-evenly">
          <!-- DOUGHNUT REPARTITION GRP/ATEL MONTH -->
          <div class="col-xs-auto col-md-6 col-xl-3">
            <?php
            $req = $dbh->prepare('SELECT tconf_atel.name AS Atelier, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, SUM(tgrp.col) AS Collectivite, SUM(tgrp.resi) AS Resident, ROUND(AVG(tgrp.nb)) AS MoyEff, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS Effectif FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_atel.name ORDER BY tconf_atel.name ASC');
            $req->execute();

            $labelAtelierM= [];
            $valSeancesM= [];
            $valFreqM= [];
            $valGrpM= [];
            $valcollM= [];
            $valResM= [];
            $valEffM= [];
            $TotEffM= 0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($Atelier != 'Non Renseigné') {
                $labelAtelierM[]= $Atelier;
                $valSeancesM[]= (int)$Seances;
                $valFreqM[]= (int)$Frequentation;
                $valGrpM[]= (int)$Groupes;
                $valcollM[]= ((int)$Collectivite - (int)$Resident);
                $valResM[]= (int)$Resident;
                $valEffM[]= (int)$Effectif;
                $TotEffM= $TotEffM + ((int)$Effectif);
              }
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphAM"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATION JOURNALIERE MONTH -->
          <div class="col-xs-auto col-md-6 col-xl-3">
            <!-- COMPTAGE DES NOMBRES DE JOURS PAR JOUR ENTRE 2 DATES-->
            <?php
              // input start and end date
              $startDate = date('Y-m-01');
              $endDate = date("Y-m-d");
              
              $countDays = array('Monday' => 0,
              'Tuesday' => 0,
              'Wednesday' => 0,
              'Thursday' => 0,
              'Friday' => 0,
              'Saturday' => 0,
              'Sunday' => 0);

              // change string to date time object
              $startDate = new DateTime($startDate);
              $endDate = new DateTime($endDate);

              // iterate over start to end date
              while($startDate <= $endDate ){
                // find the timestamp value of start date
                $timestamp = strtotime($startDate->format('d-m-Y'));

                // find out the day for timestamp and increase particular day
                $weekDay = date('l', $timestamp);
                $countDays[$weekDay] = $countDays[$weekDay] + 1;

                // increase startDate by 1
                $startDate->modify('+1 day');
              }


              // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par jour
              $req = $dbh->prepare('SELECT tconf_days.EN AS EN, tconf_days.FR AS FR FROM `tconf_days` ORDER BY tconf_days.id ASC');
              $req->execute();
              $days = [];
              $qtenull = [];

              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $days[$FR] = $FR;
                $qtenull[$EN] = Null;
              }
              $req->closeCursor();
              // Reset des keys de l'array
              $days = array_values($days);


              // Récupération des moyennes de fréquentation des individuels par jour sur le mois
              $req = $dbh->prepare('SELECT DAYNAME(tindiv.create_date) AS joursemaine, SUM(tindiv.nb) AS "Frequ" FROM `tindiv` WHERE MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) GROUP BY joursemaine');
              $req->execute();

              $freqIndDM = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqIndDM[$joursemaine]= $Frequ;
              }
              $req->closeCursor();

              foreach ($freqIndDM as $x => $y) {
                if ($countDays[$x] != 0) {
                $freqIndDM[$x] = floor($freqIndDM[$x]/$countDays[$x]);
                }
              }
              // Reset des keys de l'array
              $freqIndDM = array_values($freqIndDM);
              foreach ($freqIndDM as $x => $y) {
                if ($freqIndDM[$x]==0) {
                  $freqIndDM[$x]=Null;
                }
              }

              // Récupération des moyennes de fréquentation des groupes par jour sur le mois
              $req = $dbh->prepare('SELECT DAYNAME(tgrp.create_date) AS joursemaine, SUM(tgrp.nb) AS "Frequ" FROM `tgrp` WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY joursemaine');
              $req->execute();

              $freqGrpDM = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqGrpDM[$joursemaine]= $Frequ;
              }
              $req->closeCursor();

              foreach ($freqGrpDM as $x => $y) {
                if ($countDays[$x] != 0) {
                $freqGrpDM[$x] = floor($freqGrpDM[$x]/$countDays[$x]);
                }
              }
              // Reset des keys de l'array
              $freqGrpDM = array_values($freqGrpDM);
              foreach ($freqGrpDM as $x => $y) {
                if ($freqGrpDM[$x]==0) {
                  $freqGrpDM[$x]=Null;
                }
              }
              ?>
              <canvas id="GraphDM"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATION HORAIRE MONTH -->
          <div class="col-xs-auto col-md-12 col-xl-5">
            <!-- CREATION D'UNE LISTE DES HEURES OUVREES -->
            <?php
            $period = new DatePeriod(
                new DateTime($open),
                new DateInterval('PT1H'),
                new DateTime($close)
            );

            $hours = [];
            $hoursnull = [];
            foreach ($period as $date) {
                //echo $date->format("H:i\n");
                $hours[] = $date->format("H:i");
                $hoursnull[$date->format("H")] = ' ';
            }

            // COMBIEN DE JOURS OUVRES SUR LA PERIODE
              // Compter les jours
              $startDate = strtotime(date('Y-m-01'));
              $endDate = strtotime(date("Y-m-d"));
              $datediff = $endDate - $startDate;
              $datediff = round($datediff / (60 * 60 * 24));

              // Nombre de jours ouvrés par semaine
              $req = $dbh->prepare('SELECT COUNT(tconf_days.id) AS NB FROM tconf_days WHERE tconf_days.work=1');
                $req->execute();
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $workingdays = $NB;
                }
                $req->closeCursor();

            // Récupération de la somme des fréquentations par heure sur la période pour les individuels
            $req = $dbh->prepare('SELECT HOUR(tindiv.create_time) AS horaire, SUM(tindiv.nb) AS Frequ FROM `tindiv` WHERE MONTH(tindiv.create_date)=MONTH(now()) AND YEAR(tindiv.create_date)=YEAR(now()) GROUP BY horaire');
            $req->execute();

            $freqIndHM = $hoursnull;
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$freqIndHM)) {
                $workingdaysmonth = round(($datediff/7)*$workingdays);
                if ($workingdaysmonth == 0) {
                  $workingdaysmonth = 1;
                }
                $freqIndHM[sprintf('%02d', $horaire)] = floor($Frequ/($workingdaysmonth));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $freqIndHM = array_values($freqIndHM);
            foreach ($freqIndHM as $x => $y) {
              if ($freqIndHM[$x]==0) {
                $freqIndHM[$x]=Null;
              }
            }



            // Récupération des moyennes de fréquentation par heure sur le mois pour les groupes
            $req = $dbh->prepare('SELECT HOUR(tgrp.create_time) AS horaire, SUM(tgrp.nb) AS Frequ FROM `tgrp` WHERE MONTH(tgrp.create_date)=MONTH(now()) AND YEAR(tgrp.create_date)=YEAR(now()) GROUP BY horaire');
            $req->execute();

            $freqGrpHM = $hoursnull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$freqGrpHM)) {
                $workingdaysmonth = round(($datediff/7)*$workingdays);
                if ($workingdaysmonth == 0) {
                  $workingdaysmonth = 1;
                }
                $freqGrpHM[sprintf('%02d', $horaire)] = floor($Frequ/($workingdaysmonth));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $freqGrpHM = array_values($freqGrpHM);
            foreach ($freqGrpHM as $x => $y) {
              if ($freqGrpHM[$x]==0) {
                $freqGrpHM[$x]=Null;
              }
            }
            ?>
            <canvas id="GraphHM"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Cette année -->
<div class="row justify-content-center">
  <div class="col-xs-auto" style="margin-bottom: 1em;">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <h5 class="card-title fw-bold text-center">CETTE ANNEE</h5>
      </div>
      <div class="card-body">
        <div class="row justify-content-evenly">
          <!-- DOUGHNUT NB INDIV/GROUPE YEAR -->
          <div class="col-xs-auto col-md-6 col-lg-6 col-xl-4 mb-2">
            <?php
            $req = $dbh->prepare('SELECT "Individuels" Visites, SUM(nb) AS Total FROM tindiv WHERE YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT "Groupes" Visites, SUM(nb) AS Total FROM tgrp WHERE YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();

            $labelVisitesY= [];
            $valVisitesY= [];
            $nbVisitesY=0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $labelVisitesY[]= $Visites;
              $valVisitesY[]= (int)$Total;
              $nbVisitesY += $Total;
            }
            $req->closeCursor();
            ?>
            <canvas id="visitesIGY" height="300"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION RESIDENTS/LOCAUX/OTHERS YEAR -->
          <div class="col-xs-auto col-md-6 col-lg-3 col-xl-2 mb-2">
            <?php
            $resiY= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.resi=1 AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.resi=1 AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $resiY[]= $Effectif;
            }
            $req->closeCursor();
            $colY= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=1 AND tindiv.resi=0 AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=1 AND tgrp.resi=0 AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $colY[]= $Effectif;
            }
            $req->closeCursor();
            $OtherY= [];
            $req = $dbh->prepare('SELECT SUM(nb) AS Effectif FROM tindiv WHERE tindiv.col=0 AND tindiv.resi=0 AND YEAR(tindiv.create_date)=YEAR(now()) UNION SELECT SUM(nb) AS Effectif FROM tgrp WHERE tgrp.col=0 AND tgrp.resi=0 AND YEAR(tgrp.create_date)=YEAR(now())');
            $req->execute();
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $OtherY[]= $Effectif;
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphIY" height="300"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION GRP/SCOL YEAR -->
          <div class="col-xs-auto col-md-2 col-lg-2 col-xl-1 mb-2">
            <?php
            $req = $dbh->prepare('SELECT tconf_grp_typ.scol AS Scolaire, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(AVG(tgrp.nb)) AS MoyEff, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS Eff FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_grp_typ.scol');
            $req->execute();

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $scol[]= (int)$Scolaire;
              $valEffSY[]= (int)$Eff;
            }
            $req->closeCursor();
            
            if (isset($scol[0])) {
              if ($scol[0]==0) {
                if (isset($scol[1])) {
                  //do nothing
                } else {
                  $valEffSY[1] = Null;
                }
              } else {
                $valEffSY[1] = $valEffSY[0];
                $valEffSY[0] = Null;
              }
            } else {
              $valEffSY[0] = Null;
              $valEffSY[1] = Null;
            }
            $scol=[];
            ?>
            <canvas id="GraphSY" height="300"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/CLASSES D'AGES YEAR -->
          <div class="col-xs-auto col-sm-8 col-md-8 col-lg-8 col-xl-3 mb-2">
            <?php
            // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, tsoci_ages.name AS Categorie FROM `tsoci_ages` ORDER BY tsoci_ages.age ASC');
            $req->execute();
            $ages = [];
            $cat = [];
            $qtenull = [];

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                  $ages[$ID] = $Classe;
                  $cat[$ID] = $Categorie;
                  $qtenull[$ID] = ' ';
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $ages = array_values($ages);


            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classe, SUM(tindiv.nb) AS Effectif, tsoci_ages.name AS Catégorie FROM `tindiv` INNER JOIN tsoci_ages ON tsoci_ages.id = tindiv.grpage_id WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY tsoci_ages.id ORDER BY tsoci_ages.age ASC');
            $req->execute();

            $effIndECY = $qtenull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $effIndECY[$ID]= $Effectif;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $effIndECY = array_values($effIndECY);


            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS Classes, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS Effectif, tsoci_ages.name AS Categories FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id INNER JOIN tsoci_ages ON tsoci_ages.id = tconf_publics.age WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tsoci_ages.name ORDER BY tsoci_ages.id');
            $req->execute();

            $NbGrpECY = $qtenull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $NbGrpECY[$ID]= $Groupes;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $NbGrpECY = array_values($NbGrpECY);
            ?>

            <?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>

            <canvas id="GraphECY" height="300"></canvas>
          </div>
        </div>
        <div class="row justify-content-evenly">
          <!-- DOUGHNUT REPARTITION GRP/ATEL YEAR -->
          <div class="col-xs-auto col-md-6 col-xl-4">
            <?php
            $req = $dbh->prepare('SELECT tconf_atel.name AS Atelier, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, SUM(tgrp.col) AS Collectivite, SUM(tgrp.resi) AS Resident, ROUND(AVG(tgrp.nb)) AS MoyEff, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS Effectif FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_atel.name ORDER BY tconf_atel.name ASC');
            $req->execute();

            $labelAtelierY= [];
            $valSeancesY= [];
            $valFreqY= [];
            $valGrpY= [];
            $valcollY= [];
            $valResY= [];
            $valEffY= [];
            $TotEffY= 0;

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($Atelier != 'Non Renseigné') {
                $labelAtelierY[]= $Atelier;
                $valSeancesY[]= (int)$Seances;
                $valFreqY[]= (int)$Frequentation;
                $valGrpY[]= (int)$Groupes;
                $valcollY[]= ((int)$Collectivite - (int)$Resident);
                $valResY[]= (int)$Resident;
                $valEffY[]= (int)$Effectif;
                $TotEffY= $TotEffY + ((int)$Effectif);
              }
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphAY" height="300"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATION HEBDOMADAIRE YEAR -->
          <div class="col-xs-auto col-md-6 col-xl-3">
            <!-- COMPTAGE DES NOMBRES DE JOURS PAR JOUR ENTRE 2 DATES-->
            <?php
              // input start and end date
              $firstDayOfYear = mktime(0, 0, 0, 1, 1, date("Y"));
              $firstDayOfYear = date("Y-m-d", $firstDayOfYear);
              $startDate = $firstDayOfYear;
              $endDate = date("Y-m-d");
              
              $countDays = array('Monday' => 0,
              'Tuesday' => 0,
              'Wednesday' => 0,
              'Thursday' => 0,
              'Friday' => 0,
              'Saturday' => 0,
              'Sunday' => 0);

              // change string to date time object
              $startDate = new DateTime($startDate);
              $endDate = new DateTime($endDate);

              // iterate over start to end date
              while($startDate <= $endDate ){
                // find the timestamp value of start date
                $timestamp = strtotime($startDate->format('d-m-Y'));

                // find out the day for timestamp and increase particular day
                $weekDay = date('l', $timestamp);
                $countDays[$weekDay] = $countDays[$weekDay] + 1;

                // increase startDate by 1
                $startDate->modify('+1 day');
              }


              // Préparation des Légendes utlilisables et d'une liste d'effectifs nuls par jour
              $req = $dbh->prepare('SELECT tconf_days.EN AS EN, tconf_days.FR AS FR FROM `tconf_days` ORDER BY tconf_days.id ASC');
              $req->execute();
              $days = [];
              $qtenull = [];

              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $days[$FR] = $FR;
                $qtenull[$EN] = Null;
              }
              $req->closeCursor();
              // Reset des keys de l'array
              $days = array_values($days);


              // Récupération des moyennes de fréquentation des individuels par jour sur le mois
              $req = $dbh->prepare('SELECT DAYNAME(tindiv.create_date) AS joursemaine, SUM(tindiv.nb) AS "Frequ" FROM `tindiv` WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY joursemaine');
              $req->execute();

              $freqIndDY = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqIndDY[$joursemaine]= $Frequ;
              }
              $req->closeCursor();

              foreach ($freqIndDY as $x => $y) {
                $freqIndDY[$x] = floor($freqIndDY[$x]/$countDays[$x]);
              }
              // Reset des keys de l'array
              $freqIndDY = array_values($freqIndDY);
              foreach ($freqIndDY as $x => $y) {
                if ($freqIndDY[$x]==0) {
                  $freqIndDY[$x]=Null;
                }
              }

              // Récupération des moyennes de fréquentation des groupes par jour sur le mois
              $req = $dbh->prepare('SELECT DAYNAME(tgrp.create_date) AS joursemaine, SUM(tgrp.nb) AS "Frequ" FROM `tgrp` WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY joursemaine');
              $req->execute();

              $freqGrpDY = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqGrpDY[$joursemaine]= $Frequ;
              }
              $req->closeCursor();

              foreach ($freqGrpDY as $x => $y) {
                $freqGrpDY[$x] = floor($freqGrpDY[$x]/$countDays[$x]);
              }
              // Reset des keys de l'array
              $freqGrpDY = array_values($freqGrpDY);
              foreach ($freqGrpDY as $x => $y) {
                if ($freqGrpDY[$x]==0) {
                  $freqGrpDY[$x]=Null;
                }
              }
              ?>
            <canvas id="GraphDY" height="300"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATION HORAIRE YEAR -->
          <div class="col-xs-auto col-md-12 col-xl-5">
            <!-- CREATION D'UNE LISTE DES HEURES OUVREES -->
            <?php
            $period = new DatePeriod(
                new DateTime($open),
                new DateInterval('PT1H'),
                new DateTime($close)
            );

            $hours = [];
            $hoursnull = [];
            foreach ($period as $date) {
                //echo $date->format("H:i\n");
                $hours[] = $date->format("H:i");
                $hoursnull[$date->format("H")] = ' ';
            }

            // COMBIEN DE JOURS OUVRES SUR LA PERIODE
              // Compter les jours
              // input start and end date
              $firstDayOfYear = mktime(0, 0, 0, 1, 1, date("Y"));
              $startDate = strtotime(date("Y-m-d", $firstDayOfYear));
              $endDate = strtotime(date("Y-m-d"));
              $datediff = $endDate - $startDate;
              $datediff = round($datediff / (60 * 60 * 24));

              // Nombre de jours ouvrés par semaine
              $req = $dbh->prepare('SELECT COUNT(tconf_days.id) AS NB FROM tconf_days WHERE tconf_days.work=1');
                $req->execute();
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $workingdays = $NB;
                }
                $req->closeCursor();

            // Récupération de la somme des fréquentations par heure sur la période pour les individuels
            $req = $dbh->prepare('SELECT HOUR(tindiv.create_time) AS horaire, SUM(tindiv.nb) AS Frequ FROM `tindiv` WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY horaire');
            $req->execute();

            $freqIndHY = $hoursnull;
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$freqIndHY)) {
                $freqIndHY[sprintf('%02d', $horaire)] = floor($Frequ/(round(($datediff/7)*$workingdays)));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $freqIndHY = array_values($freqIndHY);
            foreach ($freqIndHY as $x => $y) {
              if ($freqIndHY[$x]==0) {
                $freqIndHY[$x]=Null;
              }
            }

            // Récupération des moyennes de fréquentation par heure sur le mois pour les groupes
            $req = $dbh->prepare('SELECT HOUR(tgrp.create_time) AS horaire, SUM(tgrp.nb) AS Frequ FROM `tgrp` WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY horaire');
            $req->execute();

            $freqGrpHY = $hoursnull;
            //Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$freqGrpHY)) {
                $freqGrpHY[sprintf('%02d', $horaire)] = floor($Frequ/(round(($datediff/7)*$workingdays)));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $freqGrpHY = array_values($freqGrpHY);
            foreach ($freqGrpHY as $x => $y) {
              if ($freqGrpHY[$x]==0) {
                $freqGrpHY[$x]=Null;
              }
            }
            ?>
            <canvas id="GraphHY"></canvas>
          </div>
        </div>
        <div class="row justify-content-evenly">
          <!-- GRAPHIQUE FREQUENTATIONS/SECTEUR -->
          <div class="col-xs-auto col-md-5 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par secteurs et primo pour les indiv
            $req = $dbh->prepare('SELECT tconf_secteurs.id AS ID, tconf_secteurs.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_sect ON tindiv_sect.indiv_id=tindiv.id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tindiv_sect.sect_id WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY tconf_secteurs.id, tindiv.primo ORDER BY tconf_secteurs.name, tindiv.primo ASC');
            $req->execute();
            $LabelISECT=[];
            $effISECT=[];
            $effISECTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelISECT[$ID] = $name;
                if ($PRIMO == 0) {
                  $effISECT[$ID] = $Effectif;
                } else {
                  $effISECTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            // Récupération des effectifs par secteurs et scolaires pour les Groupes
            $req = $dbh->prepare('SELECT tconf_secteurs.id AS ID, tconf_secteurs.name AS name, tconf_grp_typ.scol AS Scolaire, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_sect ON tgrp_sect.grp_id=tgrp.id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tgrp_sect.sect_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_secteurs.id, tconf_grp_typ.scol ORDER BY tconf_secteurs.name, tconf_grp_typ.scol ASC');
            $req->execute();
            $LabelGSECT=[];
            $effGSECT=[];
            $effGSECTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelGSECT[$ID] = $name;
                if ($Scolaire == 0) {
                  $effGSECT[$ID] = $Effectif;
                } else {
                  $effGSECTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            $LabelSECT=[];

            foreach ($LabelISECT as $i => $x) {
              $LabelSECT[$i] = $x; 
            }
            foreach ($LabelGSECT as $i => $x) {
              $LabelSECT[$i] = $x; 
            }

            foreach ($LabelSECT as $i => $x) {
              if (array_key_exists($i,$effISECT)) {
                // code...
              } else {
                $effISECT[$i]=Null;
              }
              if (array_key_exists($i,$effISECTP)) {
                // code...
              } else {
                $effISECTP[$i]=Null;
              }
            }

            foreach ($LabelGSECT as $i => $x) {
              if (array_key_exists($i,$effGSECT)) {
                // code...
              } else {
                $effGSECT[$i]=Null;
              }
              if (array_key_exists($i,$effGSECTP)) {
                // code...
              } else {
                $effGSECTP[$i]=Null;
              }
            }
            ksort($effISECT);
            ksort($effISECTP);
            ksort($effGSECT);
            ksort($effGSECTP);

            // Reset des keys de l'array
            $LabelSECT = array_values($LabelSECT);
            $effISECTP = array_values($effISECTP);
            $effISECT = array_values($effISECT);
            $effGSECTP = array_values($effGSECTP);
            $effGSECT = array_values($effGSECT);

            //echo '<pre>' . print_r($hours) . '</pre>';
            //echo '<pre>' . print_r($freqIndHM) . '</pre>';
            //echo '<pre>' . print_r($freqGrpHM) . '</pre>';
            //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
            ?>
            <canvas id="GraphSECTY"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATIONS/EXPOSITION -->
          <div class="col-xs-auto col-md-7 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par secteurs et primo pour les indiv
            $req = $dbh->prepare('SELECT tconf_expo.id AS ID, tconf_expo.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_expo ON tindiv_expo.indiv_id=tindiv.id INNER JOIN tconf_expo ON tconf_expo.id=tindiv_expo.expo_id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_expo.sect_id WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY tconf_expo.id, tindiv.primo ORDER BY tconf_secteurs.name,tconf_expo.name, tindiv.primo ASC');
            $req->execute();
            $LabelIEXPO=[];
            $effIEXPO=[];
            $effIEXPOP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelIEXPO[$ID] = $name;
                if ($PRIMO == 0) {
                  $effIEXPO[$ID] = $Effectif;
                } else {
                  $effIEXPOP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            // Récupération des effectifs par secteurs et scolaires pour les Groupes
            $req = $dbh->prepare('SELECT tconf_expo.id AS ID, tconf_expo.name AS name, tconf_grp_typ.scol AS Scolaire, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_expo ON tgrp_expo.grp_id=tgrp.id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id INNER JOIN tconf_expo ON tconf_expo.id=tgrp_expo.expo_id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_expo.sect_id WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_expo.id, tconf_grp_typ.scol ORDER BY tconf_secteurs.name,tconf_expo.name, tconf_grp_typ.scol ASC');
            $req->execute();
            $LabelGEXPO=[];
            $effGEXPO=[];
            $effGEXPOP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelGEXPO[$ID] = $name;
                if ($Scolaire == 0) {
                  $effGEXPO[$ID] = $Effectif;
                } else {
                  $effGEXPOP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            $LabelEXPO=[];

            foreach ($LabelIEXPO as $i => $x) {
              $LabelEXPO[$i] = $x; 
            }
            foreach ($LabelGEXPO as $i => $x) {
              $LabelEXPO[$i] = $x; 
            }

            foreach ($LabelEXPO as $i => $x) {
              if (array_key_exists($i,$effIEXPO)) {
                // code...
              } else {
                $effIEXPO[$i]=Null;
              }
              if (array_key_exists($i,$effIEXPOP)) {
                // code...
              } else {
                $effIEXPOP[$i]=Null;
              }
            }

            foreach ($LabelGEXPO as $i => $x) {
              if (array_key_exists($i,$effGEXPO)) {
                // code...
              } else {
                $effGEXPO[$i]=Null;
              }
              if (array_key_exists($i,$effGEXPOP)) {
                // code...
              } else {
                $effGEXPOP[$i]=Null;
              }
            }
            ksort($effIEXPO);
            ksort($effIEXPOP);
            ksort($effGEXPO);
            ksort($effGEXPOP);

            // Reset des keys de l'array
            $LabelEXPO = array_values($LabelEXPO);
            $effIEXPOP = array_values($effIEXPOP);
            $effIEXPO = array_values($effIEXPO);
            $effGEXPOP = array_values($effGEXPOP);
            $effGEXPO = array_values($effGEXPO);

            //echo '<pre>' . print_r($hours) . '</pre>';
            //echo '<pre>' . print_r($freqIndHM) . '</pre>';
            //echo '<pre>' . print_r($freqGrpHM) . '</pre>';
            //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
            ?>
            <canvas id="GraphEXPOY"></canvas>
          </div>
          <!-- GRAPHIQUE FREQUENTATIONS/EVENEMENT -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par evenement et primo pour les indiv
            $req = $dbh->prepare('SELECT tconf_evts.id AS ID, tconf_evts.name AS name, tindiv.primo AS PRIMO, SUM(tindiv.nb) AS Effectif FROM `tindiv` INNER JOIN tindiv_evts ON tindiv_evts.indiv_id=tindiv.id INNER JOIN tconf_evts ON tconf_evts.id=tindiv_evts.evt_id WHERE YEAR(tindiv.create_date)=YEAR(now()) GROUP BY tconf_evts.id, tindiv.primo ORDER BY tconf_evts.name, tindiv.primo ASC');
            $req->execute();
            $LabelIEVT=[];
            $effIEVT=[];
            $effIEVTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelIEVT[$ID] = $name;
                if ($PRIMO == 0) {
                  $effIEVT[$ID] = $Effectif;
                } else {
                  $effIEVTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            // Récupération des effectifs par evenement et scolaires pour les Groupes
            $req = $dbh->prepare('SELECT tconf_evts.id AS ID, tconf_evts.name AS name, tconf_grp_typ.scol AS Scolaire, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_evts ON tgrp_evts.grp_id=tgrp.id INNER JOIN tconf_evts ON tconf_evts.id=tgrp_evts.evt_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE YEAR(tgrp.create_date)=YEAR(now()) GROUP BY tconf_evts.id, tconf_grp_typ.scol ORDER BY tconf_evts.name, tconf_grp_typ.scol ASC');
            $req->execute();
            $LabelGEVT=[];
            $effGEVT=[];
            $effGEVTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelGEVT[$ID] = $name;
                if ($Scolaire == 0) {
                  $effGEVT[$ID] = $Effectif;
                } else {
                  $effGEVTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            $LabelEVT=[];

            foreach ($LabelIEVT as $i => $x) {
              $LabelEVT[$i] = $x; 
            }
            foreach ($LabelGEVT as $i => $x) {
              $LabelEVT[$i] = $x; 
            }

            foreach ($LabelEVT as $i => $x) {
              if (array_key_exists($i,$effIEVT)) {
                // code...
              } else {
                $effIEVT[$i]=Null;
              }
              if (array_key_exists($i,$effIEVTP)) {
                // code...
              } else {
                $effIEVTP[$i]=Null;
              }
            }

            foreach ($LabelGEVT as $i => $x) {
              if (array_key_exists($i,$effGEVT)) {
                // code...
              } else {
                $effGEVT[$i]=Null;
              }
              if (array_key_exists($i,$effGEVTP)) {
                // code...
              } else {
                $effGEVTP[$i]=Null;
              }
            }
            ksort($effIEVT);
            ksort($effIEVTP);
            ksort($effGEVT);
            ksort($effGEVTP);

            // Reset des keys de l'array
            $LabelEVT = array_values($LabelEVT);
            $effIEVTP = array_values($effIEVTP);
            $effIEVT = array_values($effIEVT);
            $effGEVTP = array_values($effGEVTP);
            $effGEVT = array_values($effGEVT);

            //echo '<pre>' . print_r($hours) . '</pre>';
            //echo '<pre>' . print_r($freqIndHM) . '</pre>';
            //echo '<pre>' . print_r($freqGrpHM) . '</pre>';
            //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';
            ?>
            <canvas id="GraphEVTY"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>