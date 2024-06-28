<?php
  // Se connecter à la base de données
 
  include_once '../admin/dao.php';

  $request_method = $_SERVER["REQUEST_METHOD"];
  
  function getHistorique()
  {
    $dao = new Dao();
    $resultat = $dao->getAllResultsByClient($_GET['idClient']);
    header('Content-Type: application/json');
    echo json_encode($resultat, JSON_PRETTY_PRINT);
  }


  switch($request_method)
  {
    case 'GET':
        getHistorique();
        break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

?>