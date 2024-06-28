<?php
  include("MyPDO.php");
  
  class Dao extends MyPDO
  {
    // avec les variables contenues dans login.php
    function __construct()
    {
      include("../login.php");
  
      $login = 'root';
      $pass = 'BTSbts22';
      $base = 'bassin';
      parent::__construct('mysql:host=localhost;dbname=' . $base, $login, $pass);
    } // fin constructeur
    //---------------------------------------------------------------------
  
    public function getLastValue($type, $idclient)
    {
      $requete="SELECT * FROM mesure WHERE type = ? AND idClient = ? ORDER BY date DESC LIMIT 1";
      $getAll=$this->prepare($requete);
      $getAll->execute(array($type, $idclient));
      $reponse=$getAll->fetchAll(PDO::FETCH_OBJ);
      return $reponse;
    }

    public function getAllValue($type, $idclient)
    {
      $requete="SELECT * FROM mesure WHERE type = ? AND idClient = ? ORDER BY date";
      $getAll=$this->prepare($requete);
      $getAll->execute(array($type, $idclient));
      $reponse=$getAll->fetchAll(PDO::FETCH_OBJ);
      return $reponse;
    }
  
  //---------------------------------------------------------------------

  public function getAllResultsByClient($idclient)
  {
    $requete="SELECT * FROM mesure WHERE idClient = ? ORDER BY date DESC LIMIT 30";
    $getAll=$this->prepare($requete);
    $getAll->execute(array($idclient));
    $reponse=$getAll->fetchAll(PDO::FETCH_OBJ);
    return $reponse;
  }

  public function getAllResultsByType($idclient, $type)
    {
      $requete="SELECT *, DATE(date) AS jour FROM mesure
      WHERE idClient = ? AND type = ?
      GROUP BY jour
      ORDER BY jour ASC
      LIMIT 30";
      $getAll=$this->prepare($requete);
      $getAll->execute(array($idclient, $type));
      $reponse=$getAll->fetchAll(PDO::FETCH_OBJ);
      return $reponse;
    }

    public function getLogin($user, $pass)
    {
      $requete="SELECT username, password FROM client WHERE username = ?";
      $getAll=$this->prepare($requete);
      $getAll->execute(array($user));
      $reponse=$getAll->fetchAll(PDO::FETCH_OBJ);

      $username = $reponse[0]->username;
      $hashed_password = $reponse[0]->password;

      if ($username === $user) {
        if (password_verify($pass, $hashed_password)) {
            $response = array('success' => true, 'message' => 'Connexion reussie');
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Nom d\'utilisateur ou mot de passe incorrect');
            header('Content-Type: application/json');
            echo json_encode($response);
        }
      } else {
          $response = array('success' => false, 'message' => 'Nom d\'utilisateur ou mot de passe incorrect');
          header('Content-Type: application/json');
          echo json_encode($response);
      }
      return 0;
    }
  //---------------------------------------------------------------------

  public function addValeur($valeur, $type, $idclient)
  {
    $requete="INSERT INTO mesure (Valeur, type, idClient) VALUES ('$valeur', '$type', '$idclient')";
    $setModification=$this->prepare($requete);
    $setModification->execute();
    return "Ajout effectuee";
  }

  public function deleteMesure($idMesure)
  {
    $requete="DELETE FROM mesure WHERE idMesure = '$idMesure'";
    $setModification=$this->prepare($requete);
    $setModification->execute();
    return "Suppression effectuee";
  }
}