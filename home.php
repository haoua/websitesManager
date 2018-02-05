<?php 
    session_start();
    session_regenerate_id();    

    if (!isset($_SESSION["authentif"])) {
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
                header("location:index.php");
            }
        }else{
        	header("location:index.php");
        }
    }


	/* *************** DEFINTION DATA PAR PAGE *************** */
	$page_title = "Dashboard";
	$body_id = "dashbord";
	$code = "";



include 'part/header.php';
include 'part/navigation.php';

?>


<div class="container">
    X ticket en cours
</div>

<?

include 'part/footer.php';


?>