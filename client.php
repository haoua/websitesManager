<?php 
    session_start();
    session_regenerate_id(); 

        /* A RETIRER */
    error_reporting(E_ALL);
    ini_set('display_errors', 1);   

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
    }else{
        if (isset($_GET['client'])) {
            var_dump($_GET['client']);
        }else{
            header("location:client.php");
        }
    }


	/* *************** DEFINTION DATA PAR PAGE *************** */
	$page_title = "Client";
	$body_id = "client";
	$code = "";



include 'inc/connexion.php';

include 'part/header.php';
include 'part/navigation.php';

$client_request = $mysqli -> query("SELECT * FROM clients WHERE statut_client = 1");
$nb_client = $client_request->num_rows;

?>


<div class="container">

    <?php echo "Il y a ".$nb_client. " clients actifs"; ?>

    <table>
        <tr>
            <td>Société</td>
        </tr>

        <?php while ($row_client = $client_request->fetch_array()) { ?>
            <tr>
                <td>
                    <?php echo $row_client['societe_client']; ?>
                </td>
                <td>
                    <a href="#"><i class="fa fa-edit" aria-hidden="true"></i></a>
                </td>
                <td>
                    <a href="client-single.php?client=<?php echo $row_client["id_client"] ?>">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
    
</div>

<?

include 'part/footer.php';


?>