<?php
  // Se connecter à la base de données
 
  include_once '../admin/dao.php';

  $request_method = $_SERVER["REQUEST_METHOD"];
  
  function getValues()
  {
    $dao = new Dao();
    $resultat = $dao->getLastValue($_GET['type'], $_GET['idClient']);
    header('Content-Type: application/json');
    echo json_encode($resultat, JSON_PRETTY_PRINT);
  }


  switch($request_method)
  {
    case 'GET':
        getValues();
        break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

?>