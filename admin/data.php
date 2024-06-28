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

    <title>Données - Bassin carpe koi</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      
      function drawChart() {
        <?php 
          $temperature = array();
          $jour = array();
          
          $ph = array();
          $phjour = array();
          
          $conductivite = array();
          $conductivitejour = array();
          
          $eau = array();
          $eaujour = array();

          $temp = $dao->getAllResultsByType($_SESSION["id"], "Temperature");
          foreach ($temp as $mesure) {
            $temperature[] = $mesure->Valeur;
            $jour[] = date("d-m", strtotime($mesure->date));
          }

          $phm = $dao->getAllResultsByType($_SESSION["id"], "pH");
          foreach ($phm as $mesure) {
            $ph[] = $mesure->Valeur;
            $phjour[] = date("d-m", strtotime($mesure->date)); 
          }

          $cond = $dao->getAllResultsByType($_SESSION["id"], "Conductivité");
          foreach ($cond as $mesure) {
            $conductivite[] = $mesure->Valeur;
            $conductivitejour[] = date("d-m", strtotime($mesure->date)); 
          }

          $eaum = $dao->getAllResultsByType($_SESSION["id"], "Eau");
          foreach ($eaum as $mesure) {
            if($mesure->Valeur <= 0){
              $eau[] = 0;
              $eaujour[] = date("d-m", strtotime($mesure->date));
            }else{
              $eau[] = $mesure->Valeur+50;
              $eaujour[] = date("d-m", strtotime($mesure->date));
            }
          }

        ?>
      }
    </script>
</head>
<body>
    
    <?php include('navbar.php');?>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i class="uil uil-database"></i>
                    <span class="text">Données du bassin (30 derniers jours)</span>
                </div>

                <div class="boxes">
                
                    <div class="box box2" style="width: 100%; height: 400px;">
                    <div id="chart"style="width: 90%; height: 900px;"></div>

                      <?php 

                        // Génération du script JavaScript pour le graphique
                        echo '<script>
                            var options = {
                                chart: {
                                  id: "area-datetime",
                                  type: "area",
                                  height: 350,
                                  zoom: {
                                    autoScaleYaxis: true
                                  }
                                },
                                dataLabels: {
                                  enabled: false
                                },
                                stroke: {
                                  curve: "straight"
                                },
                                tooltip: {
                                  x: {
                                    format: "dd MMM yyyy"
                                  }
                                },
                                fill: {
                                  type: "gradient",
                                  gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.7,
                                    opacityTo: 0.9,
                                    stops: [0, 100]
                                  }
                                },
                                markers: {
                                  size: 5,
                                  hover: {
                                    size: 9
                                  }
                                },
                                title: {
                                  text: "Température en °C",
                                },
                                
                                theme: {
                                  palette: "palette9"
                                },
                                series: [{
                                    name: "Température",
                                    data: ' . json_encode($temperature) . '
                                }],
                                xaxis: {
                                    categories: ' . json_encode($jour) . '
                                }
                            };

                            var chart = new ApexCharts(document.querySelector("#chart"), options);
                            chart.render();
                        </script>';

                      ?>
                    </div>
                    <div class="box box3" style="width: 100%; height: 400px;">
                    <div id="chart2"style="width: 90%; height: 900px;"></div>
                    <?php 

                      // Génération du script JavaScript pour le graphique
                      echo '<script>
                          var options = {
                              chart: {
                                id: "area-datetime",
                                type: "area",
                                height: 350,
                                zoom: {
                                  autoScaleYaxis: true
                                }
                              },
                              dataLabels: {
                                enabled: false
                              },
                              stroke: {
                                curve: "straight"
                              },
                              tooltip: {
                                x: {
                                  format: "dd MMM yyyy"
                                }
                              },
                              fill: {
                                type: "gradient",
                                gradient: {
                                  shadeIntensity: 1,
                                  opacityFrom: 0.7,
                                  opacityTo: 0.9,
                                  stops: [0, 100]
                                }
                              },
                              markers: {
                                size: 5,
                                hover: {
                                  size: 9
                                }
                              },
                              title: {
                                text: "Taux de pH",
                              },
                              
                              theme: {
                                palette: "palette8"
                              },
                              series: [{
                                  name: "pH",
                                  data: ' . json_encode($ph) . '
                              }],
                              xaxis: {
                                  categories: ' . json_encode($phjour) . '
                              }
                          };

                          var chart = new ApexCharts(document.querySelector("#chart2"), options);
                          chart.render();
                      </script>';

                    ?>
                    </div>
                    <div class="box box2" style="background-color: lightgrey; width: 100%; height: 400px;">
                    <div id="chart3"style="width: 90%; height: 900px;"></div>
                    <?php 

                      // Génération du script JavaScript pour le graphique
                      echo '<script>
                          var options = {
                              chart: {
                                id: "area-datetime",
                                type: "area",
                                height: 350,
                                zoom: {
                                  autoScaleYaxis: true
                                }
                              },
                              dataLabels: {
                                enabled: false
                              },
                              stroke: {
                                curve: "straight"
                              },
                              tooltip: {
                                x: {
                                  format: "dd MMM yyyy"
                                }
                              },
                              fill: {
                                type: "gradient",
                                gradient: {
                                  shadeIntensity: 1,
                                  opacityFrom: 0.7,
                                  opacityTo: 0.9,
                                  stops: [0, 100]
                                }
                              },
                              markers: {
                                size: 5,
                                hover: {
                                  size: 9
                                }
                              },
                              title: {
                                text: "Conductivité en us/cm",
                              },
                              
                              theme: {
                                palette: "palette12"
                              },
                              series: [{
                                  name: "Conductivité",
                                  data: ' . json_encode($conductivite) . '
                              }],
                              xaxis: {
                                  categories: ' . json_encode($conductivitejour) . '
                              }
                          };

                          var chart = new ApexCharts(document.querySelector("#chart3"), options);
                          chart.render();
                      </script>';

                    ?>
                    </div>
                    <div class="box box5" style="background-color: lightblue; width: 100%; height: 400px;">
                    <div id="chart4"style="width: 90%; height: 900px;"></div>
                    <?php 

                      // Génération du script JavaScript pour le graphique
                      echo '<script>
                          var options = {
                              chart: {
                                id: "area-datetime",
                                type: "area",
                                height: 350,
                                zoom: {
                                  autoScaleYaxis: true
                                }
                              },
                              dataLabels: {
                                enabled: false
                              },
                              stroke: {
                                curve: "straight"
                              },
                              tooltip: {
                                x: {
                                  format: "dd MMM yyyy"
                                }
                              },
                              fill: {
                                type: "gradient",
                                gradient: {
                                  shadeIntensity: 1,
                                  opacityFrom: 0.7,
                                  opacityTo: 0.9,
                                  stops: [0, 100]
                                }
                              },
                              markers: {
                                size: 5,
                                hover: {
                                  size: 9
                                }
                              },
                              title: {
                                text: "Niveau d\'eau",
                              },
                              
                              theme: {
                                palette: "palette6"
                              },
                              series: [{
                                  name: "Niveau d\'eau",
                                  data: ' . json_encode($eau) . '
                              }],
                              xaxis: {
                                  categories: ' . json_encode($eaujour) . '
                              }
                          };

                          var chart = new ApexCharts(document.querySelector("#chart4"), options);
                          chart.render();
                      </script>';

                    ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>
 
