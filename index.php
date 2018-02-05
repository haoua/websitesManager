<?php 
    sessionsion_start();
    session_regenerate_id();   


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
        include_once 'inc/function/form_check.php';
        $message_username = vide($_POST['username'], "nom d'utilisateur");
        $message_pass = vide($_POST['password'], "mot de passe");

        if ($GLOBALS["erreur"] == false) {
            include_once 'inc/connexion.php';
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
	$body_id = "login";
	$code = "";



include 'part/header.php';

?>


<div class="container">
	<div id="login-container">
        <h1>Connexion</h1>
        <form action="#" method="post">
            <input type="text" placeholder="Nom d'utilisateur" id="username" name="username" class="db w100p p10">
             <?php if (isset($message_username)) { echo $message_username; } ?>
             <input type="password" placeholder="Mot de passe" id="password" name="password" class="db w100p p10">
              <?php if (isset($message_pass)) { echo $message_pass; } ?>
             <input type="checkbox" id="remember" name="remember"> Se souvenir de moi
             <?php if (isset($message_error)) { echo $message_error; } ?>
             <input type="submit" name="login" value="Connexion" id="login" class="btn btn-warning db w100p">

        </form>   
    </div>
</div>

<?

include 'part/footer.php';


 ?>