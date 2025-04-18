<?php ##########################################################################
# @Name : stat-grp.php
# @Description : Page de statistiques pour les visites de Groupes
# @Call : index.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>


<form method="post">
  <div class="row justify-content-center">
    <div class="col-xs-auto col-sm-12 col-md-6 col-xl-4">
      <div class="card shadow">
        <div class="card-header text-white bg-primary">
          <h3 class="card-title fw-bold text-center">Période ciblée</h3>
        </div>
        <div class="card-body">
          <form method="post">
          <div class="row justify-content-center">
            <div class="col-12">
              <div class="input-group d-flex justify-content-center mb-3">
                <span class="input-group-text" id="dateFrom">Du :</span>
                <input type="date" name="dateFrom" value="<?php echo date('Y-m-d', strtotime("-1 months")); ?>" />
                <span class="input-group-text"> Au : </span>
                <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
                <span class="input-group-text">  </span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="d-grid gap-2 d-flex justify-content-evenly">
              <input type="submit" value="EXTRAIRE" class="btn btn-success" title="Extraire les statistiques"/>
              <a href="./index.php" class="btn btn-secondary" title="Revenir au Dashboard">RETOUR</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>

<?php if (isset($_POST['dateFrom']) and ($_POST['dateTo']))
{?>

<!-- FORMULAIRE DATE -->
<div class="row justify-content-center my-5">
  <div class="col text-center">
    <?php
    $dateFrom = strtotime($_POST['dateFrom']);
    $dateTo = strtotime($_POST['dateTo']);
    ?>
    <h2>Statistiques des visites de groupes effectuées entre <br>le <strong><?php echo date('d M Y', $dateFrom);?></strong> et le <strong><?php echo date('d M Y', $dateTo); ?></strong></h2>
    <?php
      $Toteff=0;
      $Toteffext=0;
      $Toteffextscol=0;
      $Toteffextpay=0;
      $Toteffextgui=0;
      $Toteffcol=0;
      $Toteffcolscol=0;
      $Toteffcolpay=0;
      $Toteffcolgui=0;
      $Toteffres=0;
      $Toteffresscol=0;
      $Toteffrespay=0;
      $Toteffresgui=0;
      $Totgrp=0;
      $Totgrpext=0;
      $Totgrpextscol=0;
      $Totgrpextpay=0;
      $Totgrpextgui=0;
      $Totgrpcol=0;
      $Totgrpcolscol=0;
      $Totgrpcolpay=0;
      $Totgrpcolgui=0;
      $Totgrpres=0;
      $Totgrpresscol=0;
      $Totgrprespay=0;
      $Totgrpresgui=0;

      $req = $dbh->prepare('SELECT tconf_atel.id AS AtelierID, tconf_atel.name AS Atelier, tgrp.col, tgrp.resi, tconf_grp_typ.scol AS scol, tgrp.visite AS gui, tgrp.payant AS pay, COUNT(tgrp.id) AS Seances, SUM(tgrp.nb) AS Frequentation, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS Groupes, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS Effectif, ROUND(AVG(tgrp.nb)) AS MoyEff FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_atel.name,tgrp.col,tgrp.resi,tconf_grp_typ.scol,tgrp.visite,tgrp.payant ORDER BY tconf_atel.id,tgrp.col,tgrp.resi,tconf_grp_typ.scol,tgrp.visite,tgrp.payant ASC');
      $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
      while($row=$req->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $Toteff= $Toteff + $Effectif;
        $Totgrp= $Totgrp + $Groupes;

        if ($col==0) {
          $Toteffext = $Toteffext + $Effectif;
          $Totgrpext= $Totgrpext + $Groupes;
          if ($scol==1) {
            $Toteffextscol = $Toteffextscol + $Effectif;
            $Totgrpextscol= $Totgrpextscol + $Groupes;
          }
          if ($pay==1) {
            $Toteffextpay = $Toteffextpay + $Effectif;
            $Totgrpextpay = $Totgrpextpay + $Groupes;
          }
          if ($gui==1) {
            $Toteffextgui = $Toteffextgui + $Effectif;
            $Totgrpextgui = $Totgrpextgui + $Groupes;
          }
        } else {
          if ($resi==0) {
            $Toteffcol = $Toteffcol + $Effectif;
            $Totgrpcol= $Totgrpcol + $Groupes;
            if ($scol==1) {
              $Toteffcolscol = $Toteffcolscol + $Effectif;
              $Totgrpcolscol= $Totgrpcolscol + $Groupes;
            }
            if ($pay==1) {
              $Toteffcolpay = $Toteffcolpay + $Effectif;
              $Totgrpcolpay = $Totgrpcolpay + $Groupes;
            }
            if ($gui==1) {
              $Toteffcolgui = $Toteffcolgui + $Effectif;
              $Totgrpcolgui = $Totgrpcolgui + $Groupes;
            }
          } else {
            $Toteffres = $Toteffres + $Effectif;
            $Totgrpres = $Totgrpres + $Groupes;
            if ($scol==1) {
              $Toteffresscol = $Toteffresscol + $Effectif;
              $Totgrpresscol= $Totgrpresscol + $Groupes;
            }
            if ($pay==1) {
              $Toteffrespay = $Toteffrespay + $Effectif;
              $Totgrprespay = $Totgrprespay + $Groupes;
            }
            if ($gui==1) {
              $Toteffresgui = $Toteffresgui + $Effectif;
              $Totgrpresgui = $Totgrpresgui + $Groupes;
            }
          }
        }
      }
      $req->closeCursor();

      $GrpEffTot=[$Toteffres,$Toteffcol,$Toteffext];
      $GrpTot=[$Totgrpres,$Totgrpcol,$Totgrpext];
    ?>
    <h2 class="text-danger"><strong><?php echo $Totgrp;?></strong> Groupes soit <strong><?php echo $Toteff;?></strong> Visiteurs au total</h2>
  </div>
</div>

<!-- REPRESENTATION GLOBALE DES VISITES DE GROUPES -->
<div class="row justify-content-center mb-4">
  <div class="col">
    <div class="card h-100 shadow mb-3">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Représentation Globale des Visites de Groupes</h3>
        </div>
      </div>
      <div class="card-body">
        <!-- DOUGHNUTS DES EFFECTIFS -->
        <div class="row justify-content-center mb-2">
          <!-- DOUGHNUT PROVENANCE & SCOL -->
          <div class="col-xs-auto col-sm-7 col-xl-4 mb-3">
                <?php
                  $EfGrpDetail1= [0,0,0,0,0,0];
                  $EfGrpDetail1[0]= $Toteffresscol;
                  $EfGrpDetail1[1]= $Toteffres-$Toteffresscol;
                  $EfGrpDetail1[2]= $Toteffcolscol;
                  $EfGrpDetail1[3]= $Toteffcol-$Toteffcolscol;
                  $EfGrpDetail1[4]= $Toteffextscol;
                  $EfGrpDetail1[5]= $Toteffext-$Toteffextscol;
                ?>
                  <canvas id="GraphDoughEfGPP"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & PAYANT -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-3">
                  <?php
                  $EfGrpDetail2= [0,0,0,0,0,0];
                  $EfGrpDetail2[0]= $Toteffres-$Toteffrespay;
                  $EfGrpDetail2[1]= $Toteffrespay;
                  $EfGrpDetail2[2]= $Toteffcol-$Toteffcolpay;
                  $EfGrpDetail2[3]= $Toteffcolpay;
                  $EfGrpDetail2[4]= $Toteffext-$Toteffextpay;
                  $EfGrpDetail2[5]= $Toteffextpay;
                ?>
                  <canvas id="GraphDoughEfGPF"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & GUIDEE -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-3">
                  <?php
                  $EfGrpDetail3= [0,0,0,0,0,0];
                  $EfGrpDetail3[0]= $Toteffres-$Toteffresgui;
                  $EfGrpDetail3[1]= $Toteffresgui;
                  $EfGrpDetail3[2]= $Toteffcol-$Toteffcolgui;
                  $EfGrpDetail3[3]= $Toteffcolgui;
                  $EfGrpDetail3[4]= $Toteffext-$Toteffextgui;
                  $EfGrpDetail3[5]= $Toteffextgui;
                ?>
                  <canvas id="GraphDoughEfGPG"></canvas>
          </div>
        </div>
        <!-- DOUGHNUTS DES GROUPES -->
        <div class="row justify-content-around mb-2">
          <!-- DOUGHNUT PROVENANCE & SCOL -->
          <div class="col-xs-auto col-sm-7 col-xl-3 mb-3">
                <?php
                  $GrpDetail1= [0,0,0,0,0,0];
                  $GrpDetail1[0]= $Totgrpresscol;
                  $GrpDetail1[1]= $Totgrpres-$Totgrpresscol;
                  $GrpDetail1[2]= $Totgrpcolscol;
                  $GrpDetail1[3]= $Totgrpcol-$Totgrpcolscol;
                  $GrpDetail1[4]= $Totgrpextscol;
                  $GrpDetail1[5]= $Totgrpext-$Totgrpextscol;
                ?>
                  <canvas id="GraphDoughGPP"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & PAYANT -->
          <div class="col-xs-auto col-md-6 col-xl-3 mb-3">
                  <?php
                  $GrpDetail2= [0,0,0,0,0,0];
                  $GrpDetail2[0]= $Totgrpres-$Totgrprespay;
                  $GrpDetail2[1]= $Totgrprespay;
                  $GrpDetail2[2]= $Totgrpcol-$Totgrpcolpay;
                  $GrpDetail2[3]= $Totgrpcolpay;
                  $GrpDetail2[4]= $Totgrpext-$Totgrpextpay;
                  $GrpDetail2[5]= $Totgrpextpay;
                ?>
                  <canvas id="GraphDoughGPF"></canvas>
          </div>
          <!-- DOUGHNUT PROVENANCE & GUIDEE -->
          <div class="col-xs-auto col-md-6 col-xl-3 mb-3">
                  <?php
                  $GrpDetail3= [0,0,0,0,0,0];
                  $GrpDetail3[0]= $Totgrpres-$Totgrpresgui;
                  $GrpDetail3[1]= $Totgrpresgui;
                  $GrpDetail3[2]= $Totgrpcol-$Totgrpcolgui;
                  $GrpDetail3[3]= $Totgrpcolgui;
                  $GrpDetail3[4]= $Totgrpext-$Totgrpextgui;
                  $GrpDetail3[5]= $Totgrpextgui;
                ?>
                  <canvas id="GraphDoughGPG"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FREQUENTATION DU MUSEE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Fréquentation du <?php echo ($structure); ?></h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-center mb-2">
          <!-- FREQUENTATION JOURNALIERE MOYENNE -->
          <div class="col-xs-auto col-md-4 col-lg-2 align-middle fw-bolder mb-3">
            <?php
              // Compter les jours
              $startDate = strtotime($_POST['dateFrom']);
              $endDate = strtotime($_POST['dateTo']);
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

              // Effectif total
              $req = $dbh->prepare('SELECT COUNT(tgrp.id) AS EFF, SUM(tgrp.nb) AS EFF FROM `tgrp` WHERE tgrp.create_date BETWEEN ? AND ?');
                $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
                while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                  extract($row);
                  $Effectif = $EFF;
                  $Nombre = $NB;
                }
                $req->closeCursor();

              $EffMoyD = round($Effectif / round(($datediff/7)*$workingdays));
              $NbMoyD = round($Nombre / round(($datediff/7)*$workingdays));
            ?>
            <p class="text-center fw-bold" style="font-family:Segoe UI, Helvetica Neue, Arial; font-size: 10em"><?php echo ($NbMoyD); ?></p>
            <p class="text-center fw-bold" style="font-family:Segoe UI, Helvetica Neue, Arial; font-size: 5em"><?php echo ($EffMoyD); ?></p>

            <p class="text-center" style="font-family:Segoe UI, Helvetica Neue, Arial; font-size: 15px">Fréquentation moyenne journalière</p>
          </div>
          <!-- FREQUENTATION MOYENNE PAR JOUR -->
          <div class="col-xs-auto col-md-5 col-lg-5 mb-3">
            <!-- COMPTAGE DES NOMBRES DE JOURS PAR JOUR ENTRE 2 DATES-->
            <?php
              // input start and end date
              $startDate = $_POST['dateFrom'];
              $endDate = $_POST['dateTo'];
              
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
            ?>
            <!-- EFFECTIFS PAR JOUR ENTRE 2 DATES-->
            <?php
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
              $req = $dbh->prepare('SELECT DAYNAME(tgrp.create_date) AS joursemaine, SUM(tgrp.nb) AS "Frequ", COUNT(tgrp.id) AS "Nb" FROM `tgrp` WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY joursemaine');
              $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

              $freqEffGrpD = $qtenull;
              $freqGrpD = $qtenull;
              //Insertion des effectif en fonction de l'ID des classes d'âges
              while($row=$req->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $freqEffGrpD[$joursemaine]= $Frequ;
                $freqGrpD[$joursemaine]= $Nb;
              }
              $req->closeCursor();
              
              //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>';

              foreach ($freqEffGrpD as $x => $y) {
                $freqEffGrpD[$x] = floor($freqEffGrpD[$x]/$countDays[$x]);
              }

              $freqEffGrpD = array_values($freqEffGrpD);
              foreach ($freqEffGrpD as $x => $y) {
                if ($freqEffGrpD[$x]==0) {
                  $freqEffGrpD[$x]=Null;
                }
              }

              foreach ($freqGrpD as $x => $y) {
                $freqGrpD[$x] = floor($freqGrpD[$x]/$countDays[$x]);
              }

              $freqGrpD = array_values($freqGrpD);
              foreach ($freqGrpD as $x => $y) {
                if ($freqGrpD[$x]==0) {
                  $freqGrpD[$x]=Null;
                }
              }
            ?>
              <canvas id="GraphGD" height="150"></canvas>
          </div>
          <!-- FREQUENTATION MOYENNE PAR HEURES -->
          <div class="col-xs-auto col-md-9  col-lg-5 mb-3">
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
              $startDate = strtotime($_POST['dateFrom']);
              $endDate = strtotime($_POST['dateTo']);
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
            $req = $dbh->prepare('SELECT HOUR(tgrp.create_time) AS horaire, SUM(tgrp.nb) AS Frequ, COUNT(tgrp.id) AS "Nb" FROM `tgrp` WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY horaire');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

            $frequGrpH = $hoursnull;
            $frequEffGrpH = $hoursnull;
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if (array_key_exists((sprintf('%02d', $horaire)),$frequGrpH)) {
                $frequGrpH[sprintf('%02d', $horaire)] = floor($Nb/(round(($datediff/7)*$workingdays)));
              }
              if (array_key_exists((sprintf('%02d', $horaire)),$frequEffGrpH)) {
                $frequEffGrpH[sprintf('%02d', $horaire)] = floor($Frequ/(round(($datediff/7)*$workingdays)));
              }
            }
            $req->closeCursor();

            // Reset des keys de l'array
            $frequGrpH = array_values($frequGrpH);
            foreach ($frequGrpH as $x => $y) {
              if ($frequGrpH[$x]==0) {
                $frequGrpH[$x]=Null;
              }
            }

            // Reset des keys de l'array
            $frequEffGrpH = array_values($frequEffGrpH);
            foreach ($frequEffGrpH as $x => $y) {
              if ($frequEffGrpH[$x]==0) {
                $frequEffGrpH[$x]=Null;
              }
            }
            ?>
              <canvas id="GraphGH" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ACTIVITE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Activités au <?php echo ($structure); ?></h3>
        </div>
      </div>
      <div class="card-body">
        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/SECTEUR -->
          <div class="col-xs-auto col-md-5 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par secteurs et scolaires
            $req = $dbh->prepare('SELECT tconf_secteurs.id AS ID, tconf_secteurs.name AS name, tconf_grp_typ.scol AS scol, COUNT(tgrp.id) AS grp, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_sect ON tgrp_sect.grp_id=tgrp.id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tgrp_sect.sect_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_secteurs.id, tconf_grp_typ.scol ORDER BY tconf_secteurs.name, tconf_grp_typ.scol ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelSECT=[];
            $effSECT=[];
            $effSECTP=[];
            $grpSECT=[];
            $grpSECTP=[];

            // Insertion des effectifs en fonction de l'ID des secteurs et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelSECT[$ID] = $name;
                if ($scol == 0) {
                  $effSECT[$ID] = $Effectif;
                  $grpSECT[$ID] = $grp;
                } else {
                  $effSECTP[$ID] = $Effectif;
                  $grpSECTP[$ID] = $grp;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelSECT as $i => $x) {
              if (array_key_exists($i,$effSECT)) {
                // code...
              } else {
                $effSECT[$i]=Null;
              }
              if (array_key_exists($i,$effSECTP)) {
                // code...
              } else {
                $effSECTP[$i]=Null;
              }
            }
            foreach ($LabelSECT as $i => $x) {
              if (array_key_exists($i,$grpSECT)) {
                // code...
              } else {
                $grpSECT[$i]=Null;
              }
              if (array_key_exists($i,$grpSECTP)) {
                // code...
              } else {
                $grpSECTP[$i]=Null;
              }
            }

            // Reset des keys de l'array
            $LabelSECT = array_values($LabelSECT);
            $effSECTP = array_values($effSECTP);
            $effSECT = array_values($effSECT);
            $grpSECTP = array_values($grpSECTP);
            $grpSECT = array_values($grpSECT);
            ?>
            <canvas id="GraphSECT"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/EXPOSITIONS -->
          <div class="col-xs-auto col-md-7 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par exposition et primo
            $req = $dbh->prepare('SELECT tconf_expo.id AS ID, tconf_expo.name AS name, tconf_grp_typ.scol AS scol, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_expo ON tgrp_expo.grp_id=tgrp.id INNER JOIN tconf_expo ON tconf_expo.id=tgrp_expo.expo_id INNER JOIN tconf_secteurs ON tconf_secteurs.id=tconf_expo.sect_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_expo.id, tconf_grp_typ.scol ORDER BY tconf_secteurs.name,tconf_expo.name, tconf_grp_typ.scol ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelEXPO=[];
            $effEXPO=[];
            $effEXPOP=[];

            // Insertion des effectifs en fonction de l'ID des expositions et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelEXPO[$ID] = $name;
                if ($scol == 0) {
                  $effEXPO[$ID] = $Effectif;
                } else {
                  $effEXPOP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelEXPO as $i => $x) {
              if (array_key_exists($i,$effEXPO)) {
                // code...
              } else {
                $effEXPO[$i]=Null;
              }
              if (array_key_exists($i,$effEXPOP)) {
                // code...
              } else {
                $effEXPOP[$i]=Null;
              }
            }
            ksort($effEXPO);
            ksort($effEXPOP);

            // Reset des keys de l'array
            $LabelEXPO = array_values($LabelEXPO);
            $effEXPOP = array_values($effEXPOP);
            $effEXPO = array_values($effEXPO);
            ?>
            <canvas id="GraphEXPO"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/EVENEMENT -->
          <div class="col-xs-auto col-md-6 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par exposition et primo
            $req = $dbh->prepare('SELECT tconf_evts.id AS ID, tconf_evts.name AS name, tconf_grp_typ.scol AS scol, SUM(tgrp.nb) AS Effectif FROM `tgrp` INNER JOIN tgrp_evts ON tgrp_evts.grp_id=tgrp.id INNER JOIN tconf_evts ON tconf_evts.id=tgrp_evts.evt_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_evts.id, tconf_grp_typ.scol ORDER BY tconf_evts.name, tconf_grp_typ.scol ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelEVT=[];
            $effEVT=[];
            $effEVTP=[];

            // Insertion des effectifs en fonction de l'ID des expositions et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelEVT[$ID] = $name;
                if ($scol == 0) {
                  $effEVT[$ID] = $Effectif;
                } else {
                  $effEVTP[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelEVT as $i => $x) {
              if (array_key_exists($i,$effEVT)) {
                // code...
              } else {
                $effEVT[$i]=Null;
              }
              if (array_key_exists($i,$effEVTP)) {
                // code...
              } else {
                $effEVTP[$i]=Null;
              }
            }
            ksort($effEVT);
            ksort($effEVTP);

            // Reset des keys de l'array
            $LabelEVT = array_values($LabelEVT);
            $effEVTP = array_values($effEVTP);
            $effEVT = array_values($effEVT);
            ?>
            <canvas id="GraphEVT"></canvas>
          </div>
        </div>
        <div class="row justify-content-around mb-2">
          <!-- TABLEAU ATELIERS GROUPES -->
          <div class="col-xs-auto col-lg-10 mt-2">
            <h6 class="fw-bold text-center">Fréquentation des Ateliers par nombre de Groupes</h6>
            <?php
            $req = $dbh->prepare('SELECT tconf_atel.id AS " ", tconf_atel.name AS Atelier, tconf_publics.name AS Public, COUNT(tgrp.id) AS Séances, ROUND(COUNT(tgrp.id)/tconf_atel.seance) AS "Nb de Groupes", ROUND(SUM(tgrp.resi)/tconf_atel.seance) AS ?, ROUND((SUM(tgrp.col)-SUM(tgrp.resi))/tconf_atel.seance) AS ?,(GREATEST((ROUND(COUNT(tgrp.id)/tconf_atel.seance))-(SUM(tgrp.col)),0)) AS Extérieurs, ROUND(AVG(tgrp.nb)) AS "Effectif moy" FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_atel.name ORDER BY ROUND(SUM(tgrp.nb)/tconf_atel.seance) DESC');
            $req->execute([$resident,$collectivite,$_POST['dateFrom'],$_POST['dateTo']]);
            ?>
            <table id="grpAP" class="table table-striped dt-responsive cell-border compact stripe" style="width:100%">
            <?php
              // Affichage de la requête sous forme de tableau
              echo ("<thead>");
              // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
              echo "<tr>";
              // Affichage des noms d'attributs de chacune des colonnes
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
                if ($row[0]!=1) {
                  echo ("<tr>");
                  for ($i=0; $i < $req->columnCount(); $i++) {
                    // si le champs est vide
                    if (empty($row[$i])) $row[$i] = 0;
                    echo "<td>" . $row[$i] . "</td>";
                  }
                  echo "</tr>\n";
                }
              }
              echo ("</tbody>");
            $req->closeCursor();
            ?>
            </table>
          </div>
          <!-- TABLEAU ATELIERS VISITES -->
          <div class="col-xs-auto col-lg-10 mt-2">
            <h6 class="fw-bold text-center">Fréquentation des Ateliers par nombre de Visiteurs</h6>
            <?php
            $req = $dbh->prepare('SELECT tconf_atel.id AS " ", tconf_atel.name AS Atelier, tconf_publics.name AS Public, SUM(tgrp.nb) AS Fréquentation, IFNULL(resi.eff,0) AS ?,  IFNULL(col.eff,0) AS ?, IFNULL(ext.eff,0) AS Extérieurs, ROUND(AVG(tgrp.nb)) AS "Effectif moy", ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS "Effectif Total" FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id LEFT JOIN (SELECT tconf_atel.id AS atelid, tconf_atel.name AS Atelier, SUM(tgrp.nb) AS Fréquentation, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS eff FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE tgrp.resi = 1 GROUP BY tconf_atel.name) AS resi ON resi.atelid=tconf_atel.id LEFT JOIN (SELECT tconf_atel.id AS atelid, tconf_atel.name AS Atelier, SUM(tgrp.nb) AS Fréquentation, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS eff FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE tgrp.resi = 0 AND tgrp.col = 1 GROUP BY tconf_atel.name) AS col ON col.atelid=tconf_atel.id LEFT JOIN (SELECT tconf_atel.id AS atelid, tconf_atel.name AS Atelier, SUM(tgrp.nb) AS Fréquentation, ROUND(SUM(tgrp.nb) / tconf_atel.seance ) AS eff FROM `tgrp` INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id WHERE tgrp.resi = 0 AND tgrp.col = 0 GROUP BY tconf_atel.name) AS ext ON ext.atelid=tconf_atel.id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_atel.name ORDER BY ROUND(SUM(tgrp.nb)/tconf_atel.seance) DESC');
            $req->execute([$resident,$collectivite,$_POST['dateFrom'],$_POST['dateTo']]);
            ?>
            <table id="grpAE" class="table table-striped dt-responsive cell-border compact stripe" style="width:100%">
            <?php
              // Affichage de la requête sous forme de tableau
              echo ("<thead>");
              // Avant la première ligne, on affiche l'en-tête du tables HTML avec le nom des attributs de chaque colonne
              echo "<tr>";
              // Affichage des noms d'attributs de chacune des colonnes
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
                if ($row[0]!=1) {
                  echo ("<tr>");
                  for ($i=0; $i < $req->columnCount(); $i++) {
                    // si le champs est vide
                    if (empty($row[$i])) $row[$i] = 0;
                    echo "<td>" . $row[$i] . "</td>";
                  }
                  echo "</tr>\n";
                }
              }
              echo ("</tbody>");
            $req->closeCursor();
            ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- SOCIOLOGIE -->
<div class="row justify-content-center mb-3">
  <div class="col">
    <div class="card h-100 shadow">
      <div class="card-header text-white bg-primary">
        <div class="row">
          <h3 class="card-title fw-bold text-center">Répartitions Sociologiques des Visiteurs</h3>
        </div>
          <?php
          // On récupère le nom du département par défaut 
          $req = $dbh->prepare('SELECT tloc_depts.name AS dept FROM `tloc_depts` WHERE tloc_depts.id=?;');
          $req->execute([$default_dept]);

          // On affiche chaque entrée une à une
          while ($row=$req->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $default_deptname = $dept;
          }
          // Termine le traitement de la requête
          $reponse->closeCursor();
          
          // On récupère le nom de la région du département par défaut
          $req = $dbh->prepare('SELECT tloc_depts.reg_id AS reg, tloc_regions.name as regn FROM `tloc_depts` INNER JOIN tloc_regions ON tloc_regions.id=tloc_depts.reg_id WHERE tloc_depts.id=?;');
          $req->execute([$default_dept]);

          // On affiche chaque entrée une à une
          while ($row=$req->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $default_regid = $reg;
            $default_regname = $regn;
          }
          // Termine le traitement de la requête
          $reponse->closeCursor();
          ?>
      </div>
      <div class="card-body">
        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/TYPES DE GROUPES -->
          <div class="col-xs-auto col-md-6 col-lg-4 mb-2">
            <?php
            // Récupération des effectifs par Public
            $req = $dbh->prepare('SELECT tconf_grp_typ.id AS ID, tconf_grp_typ.type AS Name, tconf_grp_typ.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS NbGrpes, SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_grp_typ ON tconf_grp_typ.id = tgrp.typ_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_grp_typ.id ORDER BY tconf_grp_typ.id ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $type=[];
            $effGrpT=[];
            $nbGrpT=[];
            $GrpTScol=[];

            // Insertion des effectif en fonction de l'ID des régions globales et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $type[$ID] = $Name;
              $effGrpT[$ID] = $Effectif;
              $nbGrpT[$ID] = $NbGrpes;
              if ($scol==1) {
                $GrpTScol[$ID]= '#e5cf19';
              } else {
                $GrpTScol[$ID]= '#f2e78a';
              }
            }
            $req->closeCursor();
            ksort($effGrpT);
            ksort($nbGrpT);
            ksort($GrpTScol);

            // Reset des keys de l'array
            $type = array_values($type);
            $effGrpT = array_values($effGrpT);
            $nbGrpT = array_values($nbGrpT);
            $GrpTScol = array_values($GrpTScol);

            ?>
            <canvas id="GraphG"></canvas>
          </div>

          <!-- GRAPHIQUE REPARTITION EFFECTIFS/PUBLIC -->
          <div class="col-xs-auto col-md-6 col-lg-4 mb-2">
            <?php
            // Récupération des effectifs par Public
            $req = $dbh->prepare('SELECT tconf_publics.id AS ID, tconf_publics.name AS Public, tsoci_ages.age AS "Classe", tsoci_ages.name AS "Categories",  tconf_publics.scol AS scol, COUNT(tgrp.id) AS "Seances", SUM(tgrp.nb) AS Fréquentation, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id INNER JOIN tsoci_ages ON tsoci_ages.id = tconf_publics.age WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_publics.name ORDER BY tconf_publics.id ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $public=[];
            $effGrpP=[];
            $GrpScol=[];

            // Insertion des effectif en fonction de l'ID des régions globales et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $public[$ID] = $Public;
                $effGrpP[$ID] = $Effectif;
                if ($scol==1) {
                  $GrpScol[$ID]= '#e5cf19';
                } else {
                  $GrpScol[$ID]= '#f2e78a';
                }
              }
            }
            $req->closeCursor();
            ksort($effGrpP);
            ksort($GrpScol);

            // Reset des keys de l'array
            $public = array_values($public);
            $effGrpP = array_values($effGrpP);
            $GrpScol = array_values($GrpScol);

            ?>
            <canvas id="GraphP"></canvas>
          </div>

          <!-- GRAPHIQUE REPARTITION EFFECTIFS/CLASSES D'AGES -->
          <div class="col-xs-auto col-md-6 col-lg-4 mb-2">
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
                  $qtenull[$ID] = Null;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $ages = array_values($ages);

            // Récupération des effectifs par classes d'ages
            $req = $dbh->prepare('SELECT tsoci_ages.id AS ID, tsoci_ages.age AS "Classe", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif", tsoci_ages.name AS "Catégories" FROM tgrp INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id INNER JOIN tsoci_ages ON tsoci_ages.id = tconf_publics.age WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tsoci_ages.name, tconf_publics.scol ORDER BY tsoci_ages.age ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);

            $effGrpA = $qtenull;
            $effGrpAS = $qtenull;

            // Insertion des effectif en fonction de l'ID des classes d'âges
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                if ($scol==1) {
                 $effGrpAS[$ID]= $Effectif;
                } else
                 $effGrpA[$ID]= $Effectif;
              }
            }
            $req->closeCursor();
            // Reset des keys de l'array
            $effGrpAS = array_values($effGrpAS);
            $effGrpA = array_values($effGrpA);
            ?>
            <canvas id="GraphAS"></canvas>
          </div>
        </div>

        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE EFFECTIFS FRANCAIS -->
          <div class="col-xs-auto col-md-6 col-lg-2 mb-2 d-none d-lg-block">
            <?php
            $req = $dbh->prepare('SELECT tloc_pays.id AS ID, tloc_pays.name AS "Pays", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tloc_pays ON tloc_pays.id = tgrp.pays_id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id WHERE tloc_pays.id=? AND tgrp.create_date BETWEEN ? AND ? GROUP BY tconf_publics.scol ORDER BY tconf_publics.scol ASC');
            $req->execute([$default_pays,$_POST['dateFrom'],$_POST['dateTo']]);

            $GrpFrScol= [];
            $EffFrScol= [];

            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($scol==1) {
                $GrpFrScol[0]=$NbGrpes;
                $EffFrScol[0]=$Effectif;
              } else {
                $GrpFrScol[1]=$NbGrpes;
                $EffFrScol[1]=$Effectif;
              }
            }
            $req->closeCursor();
            ?>
            <canvas id="GraphFR"></canvas>
          </div>
          <!-- GRAPHIQUE REPARTITION REGIONNALE DES EFFECTIFS -->
          <div class="col-xs-auto col-md-6 col-lg-5 col-xl-4 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_depts.id AS ID, tloc_depts.name AS "name", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tloc_depts ON tloc_depts.id = tgrp.depts_id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id WHERE tloc_depts.reg_id=? AND tgrp.create_date BETWEEN ? AND ? GROUP BY tloc_depts.nb,tconf_publics.scol ORDER BY tloc_depts.id,tconf_publics.scol ASC');
            $req->execute([$default_regid,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelREG=[];
            $LabelREGP=[];
            $LabelREGTP=[];
            $effREG=[];
            $effREGP=[];
            $effREGT=[];
            $effREGTP=[];
            $REGT=0;
            //count($LabelREGP)

            // Insertion des effectif en fonction de l'ID des départements et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                $LabelREG[$ID] = $name;
                if ($scol == 1) {
                  $effREGP[$ID] = $Effectif;
                } else {
                  $effREG[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();

            foreach ($LabelREG as $i => $x) {
              if (array_key_exists($i,$effREG)) {
                // code...
              } else {
                $effREG[$i]=Null;
              }
              if (array_key_exists($i,$effREGP)) {
                // code...
              } else {
                $effREGP[$i]=Null;
              }
            }
            ksort($effREG);
            ksort($effREGP);

            // Reset des keys de l'array
            $LabelREG = array_values($LabelREG);
            $effREGP = array_values($effREGP);
            $effREG = array_values($effREG);

            foreach ($LabelREG as $i => $x) {
              $effREGT[$i] = $effREG[$i]+$effREGP[$i];
              array_push($effREGTP,$effREGP[$i],$effREG[$i]);
              array_push($LabelREGP,"Scolaires-".$x,"Non-Scolaires-".$x);
            }
            $LabelREGTP=$LabelREGP;

            foreach ($LabelREG as $i => $x) {
              array_push($LabelREGTP,$x);
              $REGT=$REGT+$effREGT[$i];
            }


            ?>

            <canvas id="GraphDoughREG"></canvas>
          </div>

          <!-- GRAPHIQUE REPARTITION EFFECTIFS/DEPARTEMENTS -->
          <div class="col-xs-auto col-md-6 col-lg-5 col-xl-6 mb-2">
            <?php
            // Récupération des effectifs par départements et primo
            $req = $dbh->prepare('SELECT tloc_depts.id AS ID, tloc_depts.name AS "name", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tloc_depts ON tloc_depts.id = tgrp.depts_id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id WHERE tloc_depts.reg_id<>? AND tgrp.create_date BETWEEN ? AND ? GROUP BY tloc_depts.nb,tconf_publics.scol ORDER BY tloc_depts.id,tconf_publics.scol ASC');
            $req->execute([$default_regid,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelDEP=[];
            $effDEP=[];
            $effDEPP=[];

            // Insertion des effectif en fonction de l'ID des départements et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 1) {
                if ($ID != (int)$default_dept) {
                  $LabelDEP[$ID] = $name;
                  if ($scol == 1) {
                    $effDEPP[$ID] = $Effectif;
                  } else {
                    $effDEP[$ID] = $Effectif;
                  }
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelDEP as $i => $x) {
              if (array_key_exists($i,$effDEP)) {
                // code...
              } else {
                $effDEP[$i]=Null;
              }
              if (array_key_exists($i,$effDEPP)) {
                // code...
              } else {
                $effDEPP[$i]=Null;
              }
            }
            ksort($effDEP);
            ksort($effDEPP);

            // Reset des keys de l'array
            $LabelDEP = array_values($LabelDEP);
            $effDEPP = array_values($effDEPP);
            $effDEP = array_values($effDEP);
            ?>
            <canvas id="GraphDEP"></canvas>
          </div>
        </div>

        <div class="row justify-content-around mb-2">
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/PAYS -->
          <div class="col-xs-auto col-md-6 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_pays.id AS ID, tloc_pays.name AS "Pays", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tloc_pays ON tloc_pays.id = tgrp.pays_id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id WHERE tgrp.create_date BETWEEN ? AND ? GROUP BY tloc_pays.id,tconf_publics.scol ORDER BY tloc_pays.id,tconf_publics.scol ASC');
            $req->execute([$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelPIP=[];
            $effIPI=[];
            $effIPIP=[];

            // Insertion des effectif en fonction de l'ID des pays et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
                if ($ID != 199) {
                  if($ID != $default_pays) {
                  $LabelPIP[$ID] = $Pays;
                  if ($scol == 0) {
                    $effIPIP[$ID] = $Effectif;
                  } else {
                    $effIPI[$ID] = $Effectif;
                  }
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelPIP as $i => $x) {
              if (array_key_exists($i,$effIPI)) {
                // code...
              } else {
                $effIPI[$i]=Null;
              }
              if (array_key_exists($i,$effIPIP)) {
                // code...
              } else {
                $effIPIP[$i]=Null;
              }
            }
            ksort($effIPI);
            ksort($effIPIP);

            // Reset des keys de l'array
            $LabelPIP = array_values($LabelPIP);
            $effIPIP = array_values($effIPIP);
            $effIPI = array_values($effIPI);
            ?>
            <canvas id="GraphIPI"></canvas>
          </div>
        
          <!-- GRAPHIQUE REPARTITION EFFECTIFS/REGIONGLOBE -->
          <div class="col-xs-auto col-md-6 mb-2">
            <?php
            // Récupération des effectifs par régions globales et primo
            $req = $dbh->prepare('SELECT tloc_globreg.id AS ID, tloc_globreg.name AS "name", tconf_publics.scol AS scol, ROUND(COUNT(tgrp.id) / tconf_atel.seance ) AS "NbGrpes", SUM(ROUND((tgrp.nb) / tconf_atel.seance )) AS "Effectif" FROM tgrp INNER JOIN tloc_pays ON tloc_pays.id = tgrp.pays_id INNER JOIN tconf_atel ON tconf_atel.id = tgrp.atel_id INNER JOIN tconf_publics ON tconf_publics.id = tgrp.public_id INNER JOIN tloc_globreg ON tloc_globreg.id = tloc_pays.globreg_id WHERE  tloc_pays.id <> ? AND tgrp.create_date BETWEEN ? AND ? GROUP BY tloc_globreg.id,tconf_publics.scol ORDER BY tloc_globreg.id,tconf_publics.scol ASC');
            $req->execute([$default_pays,$_POST['dateFrom'],$_POST['dateTo']]);
            $LabelGRP=[];
            $effIGR=[];
            $effIGRP=[];

            // Insertion des effectif en fonction de l'ID des régions globales et primo
            while($row=$req->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              if ($ID != 18) {
                $LabelGRP[$ID] = $name;
                if ($scol == 0) {
                  $effIGRP[$ID] = $Effectif;
                } else {
                  $effIGR[$ID] = $Effectif;
                }
              }
            }
            $req->closeCursor();
            foreach ($LabelGRP as $i => $x) {
              if (array_key_exists($i,$effIGR)) {
                // code...
              } else {
                $effIGR[$i]=Null;
              }
              if (array_key_exists($i,$effIGRP)) {
                // code...
              } else {
                $effIGRP[$i]=Null;
              }
            }
            ksort($effIGR);
            ksort($effIGRP);

            // Reset des keys de l'array
            $LabelGRP = array_values($LabelGRP);
            $effIGRP = array_values($effIGRP);
            $effIGR = array_values($effIGR);
            ?>
            <canvas id="GraphIRG"></canvas>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>



<?php //echo '<pre>' . print_r(get_defined_vars(), true) . '</pre>'; ?>


<?php } ?>

