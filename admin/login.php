<?php
// Initialison de la session
session_start();
 
// Vérifiez si l'utilisateur est déjà connecté si oui rediriger vers index
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Inclure le fichier de configuration
require_once "config.php";
 
// Définir les variables et les initialiser avec des valeurs vides
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Traitement des données du formulaire lorsque celui-ci est soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Vérifier si le nom d'utilisateur est vide
    if(empty(trim($_POST["username"]))){
        $username_err = "Veuillez entrer le nom d'utilisateur.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Veuillez entrer votre mot de passe.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT idClient, username, password FROM client WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                        //if($password == $hashed_password){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Nom d'utilisateur ou mot de passe invalide.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Nom d'utilisateur ou mot de passe invalide.";
                }
            } else{
                echo "Un problème est survenu. Veuillez réessayer plus tard.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Panel - Bassin carpe koi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap v5.1.3 CDNs -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- CSS File -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="login">
        <h1 class="text-center">Panel Bassin</h1>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="needs-validation">
            <div class="form-group was-validated">
                <label class="form-label" for="username">Nom d'utilisateur</label>
                <input class="form-control" name="username" type="username" id="username" value="<?php echo $username; ?>" required>
                <div class="invalid-feedback">
                <?php echo $username_err; ?>
                </div>
            </div>
            <div class="form-group was-validated">
                <label class="form-label" for="password">Mot de passe</label>
                <input class="form-control" name="password" type="password" id="password" value="<?php echo $password; ?>" required>
                <div class="invalid-feedback">
                <?php echo $password_err; ?>
                </div>
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" id="check">
                <label class="form-check-label" for="check">Se souvenir de moi</label>
            </div>
            <input class="btn btn-success w-100" type="submit" value="Connexion">
        </form>
    </div>
</body>
</html>