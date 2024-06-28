<?php
session_start();

include_once 'dao.php';
$dao = new Dao();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Panel - Bassin carpe koi</title>
</head>
<body>
    <?php include('navbar.php');?>

    <section class="dashboard">
    <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
        </div>

        <div class="dash-content">
        <button class="btn-refresh" onclick="refreshValues()" style="
                    display: inline-block;
                    outline: none;
                    cursor: pointer;
                    font-weight: 600;
                    border-radius: 3px;
                    padding: 12px 24px;
                    border: 0;
                    color: #fff;
                    background: #000a47;
                    line-height: 1.15;
                    font-size: 16px;
                ">Rafraîchir</button>
            <div class="overview">
                <div class="title">
                    <i class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Mesure en temps réel</span>
                </div>

                <div class="boxes">
                <div class="box box1">
                        <i class="uil uil-temperature-three-quarter"></i>
                        <span class="text">Température</span>
                        <?php 
                            $resultat = $dao->getLastValue("Temperature", $_SESSION["id"]);
                            echo "<span class='number'>" . $resultat[0]->Valeur ."°C</span>";
                        ?>
                    </div>
                    <div class="box box2">
                        <i class="uil uil-flask-potion"></i>
                        <span class="text">Taux de pH</span>
                        <?php 
                            $resultat = $dao->getLastValue("pH", $_SESSION["id"]);
                            echo "<span class='number'>" . $resultat[0]->Valeur ." pH</span>";
                        ?>
                        
                    </div>
                    <div class="box box3">
                        <i class="uil uil-plug"></i>
                        <span class="text">Conductivité</span>
                        <?php 
                            $resultat = $dao->getLastValue("Conductivite", $_SESSION["id"]);
                            echo "<span class='number'>" . $resultat[0]->Valeur ."us/cm</span>";
                        ?>
                    </div>
                    <div class="box box5">
                        <i class="uil uil-water-glass"></i>
                        <span class="text">Niveau d'eau</span>
                        <?php 
                            $resultat = $dao->getLastValue("Eau", $_SESSION["id"]);
                            if($resultat[0]->Valeur <= 0){
                                echo "<span class='number'>" . 0 ."%</span>";
                              }else{
                                echo "<span class='number'>" . ($resultat[0]->Valeur*2) ."%</span>";
                              }
                        ?>
                    </div>
                </div>
            </div>

            <div class="activity">
                <div class="title">
                    <i class="uil uil-clock-three"></i>
                    <span class="text">Dernières mesures</span>
                </div>

                <div class="activity-data">
                    <div class="data names">
                        <span class="data-title">ID</span>
                        <?php 
                            $result = $dao->getAllResultsByClient($_SESSION["id"]);

                            foreach ($result as $mesure) {
                                $idMesure = $mesure->idMesure;                                
                                echo "<span class='data-list'>" . $idMesure ."</span>";
                            }
                        ?>
                    </div>
                    <div class="data names">
                        <span class="data-title">Type de capteur</span>
                        <?php 
                            foreach ($result as $mesure) {
                                $type = $mesure->type;
                                echo "<span class='data-list'>" . $type ."</span>";
                            }
                        ?>
                    </div>
                    <div class="data email">
                        <span class="data-title">Mesure</span>
                        <?php 
                            foreach ($result as $mesure) {
                                $valeur = $mesure->Valeur;
                                echo "<span class='data-list'>" . $valeur ."</span>";
                            }
                        ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title">Date</span>
                        <?php 
                            foreach ($result as $mesure) {
                                $date = $mesure->date;
                                $datefor = date('d-m-Y H:i', strtotime($date));
                                echo "<span class='data-list'>" . $datefor."</span>";
                                
                            }
                        ?>
                    </div>
                    <div class="data joined">
                        <span class="data-title" style="margin-bottom:20px;">Action(s)</span>
                        <?php 
                            foreach ($result as $mesure) {
                                echo '<form method="POST" action="delete.php">';
                                echo '<input type="hidden" name="id" value="' . $mesure->idMesure . '">';
                                echo '<button type="submit" class="btn-delete" style="
                                display: inline-block;
                                outline: none;
                                cursor: pointer;
                                font-weight: 600;
                                border-radius: 3px;
                                padding: 12px 24px;
                                border: 0;
                                color: #fff;
                                background: red;
                                line-height: 1.15;
                                font-size: 16px;
                                margin-bottom: 5px;
                            ">Supprimer</button>';
                                echo '</form>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        // Fonction pour rafraîchir les valeurs
        function refreshValues() {
            // Code PHP pour afficher les valeurs
            location.reload();
        }
    </script>
    <script src="script.js"></script>
</body>
</html>
 
