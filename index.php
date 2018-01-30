<?php 
session_start();
    session_regenerate_id();

    error_reporting(E_ALL);
ini_set('display_errors', 1);
    if (!isset($_POST["login"])) {
        if (isset($_SESSION["authentif"])) {
            header("location:home.php");
        }else{
            if (isset($_COOKIE["websiteManager"])) {
                $key = $_COOKIE["websiteManager"];
                include_once 'inc/connexion.php';
                $key_request = $mysqli -> query("SELECT id_user FROM sessions WHERE key_session = $key");
                $nb_key = $key_request->num_rows;
                if ($nb_key == 1) {
                    $row_key_request = $key_request->fetch_array();
                    $_SESSION["authentif"] = $row_key_request["id_user"];
                    header("location:home.php");
                }else{
                    unset($_COOKIE["websiteManager"]);
                    setcookie("websiteManager", NULL, -1);
                }
            }
        }

    }else{
        include_once 'function/form_check.php';
        $message_username = vide($_POST['username'], "nom d'utilisateur");
        $message_pass = vide($_POST['password'], "mot de passe");

        if ($GLOBALS["erreur"] == false) {
            include_once 'config/connexion.php';
            $user_query = $mysqli -> query("SELECT id_manager FROM managers WHERE (username_manager = '".$_POST['username']."' OR mail_manager = '".$_POST['username']."') AND password_manager = md5('".$_POST['password']."')");
            $nb_user = $user_query->num_rows;
            if ($nb_user == 1) {
                session_regenerate_id();

                if (isset($_POST["remember"])) {
                    $crypt = cryptses();
                    $mysqli -> query("INSERT INTO sessions VALUES ('','$id','$crypt')");
                    setcookie("websiteManager",$crypt,strtotime("+1 week"));
                }

                $row_user = $user_query -> fetch_array();
                $_SESSION["authentif"] = $row_user["id_manager"];
                $id = $row_user["id_manager"];
                header("location:home.php");
            }else{
                $user = $mysqli -> query("SELECT id_manager FROM managers WHERE username_manager = '".$_POST['username']."' OR mail_manager = '".$_POST['username']."'");
                $nb_user=$user->num_rows;
                if ($nb_user == 0) {    
                    $message_error =  "Aucun utilisateur trouvé pour ce login ou cette adresse mail";
                }elseif($nb_user == 1){
                    $message_error =  "Vous avez fait une erreur sur votre mdp.";
                }
            }
        }
    }


	/* *************** DEFINTION DATA PAR PAGE *************** */
	$page_title = "Connexion";
	// $description = "Planifiez vos séries, découvrez en de nouvelles et voyez celles que regardent vos amis";
	$body_id = "login";
	$code = "";



include 'inc/header.php';

?>


<div class="container">
	<form action="#" method="post">
		<input type="text" placeholder="Nom d'utilisateur" id="username" name="username">
        <?php if (isset($message_username)) { echo $message_username; } ?>
        <input type="password" placeholder="Mot de passe" id="password" name="password">
         <?php if (isset($message_pass)) { echo $message_pass; } ?>
        <input type="checkbox" id="remember" name="remember"> Se souvenir de moi
        <?php if (isset($message_error)) { echo $message_error; } ?>
        <input type="submit" name="login" id="login">

	</form>
</div>

<?

include 'inc/footer.php';


 ?>