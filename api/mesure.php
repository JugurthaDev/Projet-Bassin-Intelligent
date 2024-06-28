<?php
  // Se connecter à la base de données
  include_once '../admin/dao.php';
  $request_method = $_SERVER["REQUEST_METHOD"];
  
  function getValues()
  {
    $dao = new Dao();
    $resultat = $dao->getAllValue($_GET['type'], $_GET['idClient']);
    header('Content-Type: application/json');
    echo json_encode($resultat, JSON_PRETTY_PRINT);
  }

  
  function AddValue()
  {
    if($_POST["key"] == "UX82Nbnhy6v3X5"){
      $Valeur = $_POST["Valeur"];
      $type = $_POST["type"];
      $idClient = $_POST["idClient"];

      $dao = new Dao();
      $resultat = $dao->addValeur($Valeur, $type, $idClient);
      header('Content-Type: application/json');
      echo json_encode($resultat);
    }else{
      echo "Le clé n'est pas bonne";
    }
  }


  switch($request_method)
  {

    case 'POST':
        AddValue();
        break;
    case 'GET':
        getValues();
        break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

?>