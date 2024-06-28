<?php
  // Se connecter à la base de données
  include_once '../admin/dao.php';
  $request_method = $_SERVER["REQUEST_METHOD"];
  
  function getConnexion()
  {
    $dao = new Dao();
    $resultat = $dao->getLogin($_GET['user'], $_GET['pass']);
    header('Content-Type: application/json');
    echo json_encode($resultat, JSON_PRETTY_PRINT);
  }

  switch($request_method)
  {
    case 'GET':
        getConnexion();
        break;
    default:
      // Requête invalide
      header("HTTP/1.0 405 Method Not Allowed");
      break;
  }

?>