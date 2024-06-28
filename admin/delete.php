<?php
session_start();

include_once 'dao.php';

$request_method = $_SERVER["REQUEST_METHOD"];


function AddValue()
{
    $dao = new Dao();
    if (isset($_POST['id'])) {
        $idMesure = $_POST['id'];
        $result = $dao->deleteMesure($idMesure);
    
        if($result){
            header("location: index.php");
        }else{
            header("location: data.php");
        }
        
    } else {
        echo "Error: idMesure non spécifié";
    }
}

switch($request_method)
{

  case 'POST':
      AddValue();
      break;
  default:
    // Requête invalide
    header("HTTP/1.0 405 Method Not Allowed");
    break;
}

?>
