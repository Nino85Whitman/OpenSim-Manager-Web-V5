<?php 
if (isset($_SESSION['authentification']))
{
	echo Affichage_Entete($_SESSION['opensim_select']);
	$moteursOK = Securite_Simulateur();
    /* ************************************ */
	//SECURITE MOTEUR
	$btnN1 = "disabled";$btnN2 = "disabled";$btnN3 = "disabled";
	if ($_SESSION['privilege'] == 4) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";} // Niv 4
	if ($_SESSION['privilege'] == 3) {$btnN1 = ""; $btnN2 = ""; $btnN3 = "";} // Niv 3
	if ($_SESSION['privilege'] == 2) {$btnN1 = ""; $btnN2 = "";}              // Niv 2
	if ($moteursOK == "OK" )
	{
		if($_SESSION['privilege'] == 1)
		{$btnN1 = "";$btnN2 = "";$btnN3 = "";}
	}
     //SECURITE MOTEUR
    /* ************************************ */

    echo '<h1>'.$osmw_index_8.'</h1>';
    echo '<div class="clearfix"></div>';
	    //******************************************************
    //  Affichage page principale
    //******************************************************
	
	$db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
	mysql_select_db($database,$db);

	if (isset($_POST['cmd']))
	{
		// ******************************************************
		// ****************** ACTION BOUTON *********************
		// ******************************************************

		// ******************************************************
		if ($_POST['cmd'] == 'Enregistrer')
		{
			//echo $_POST['id_user'];echo $_POST['firstname'];echo $_POST['lastname'];echo $_POST['password'];
			
			$db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
			mysql_select_db($database,$db);
			
			// *** Lecture BDD users  ***
			$UserSelected = explode(" ", $_SESSION['login']);
			$sql = 'SELECT * FROM users WHERE id="'.$_POST['id_user'].'"';
			$req = mysql_query($sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysql_error());
			$data = mysql_fetch_assoc($req);
			
			$_SESSION['login'] = $_POST['firstname']." ".$_POST['lastname'];
			
			if(trim($data['password']) == trim($_POST['password']))
			{
				$sqlIns = "UPDATE `users` SET `firstname`='".$_POST['firstname']."', `lastname`='".$_POST['lastname']."' WHERE `id`='".$_POST['id_user']."';";
				$reqIns = mysql_query($sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error());
			}
			else
			{
				$encryptedPassword = sha1($_POST['password']);
				$sqlIns = "UPDATE `users` SET `firstname`='".$_POST['firstname']."', `lastname`='".$_POST['lastname']."', `password`='".$encryptedPassword."' WHERE `id`='".$_POST['id_user']."';";
				$reqIns = mysql_query($sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error());
			}
			echo "<p class='alert alert-success alert-anim'>";
            echo "<i class='glyphicon glyphicon-ok'></i>";
            echo " Modification pour <strong>".$_POST['firstname']." ".$_POST['lastname']."</strong> enregistre avec succes</p>";  
			
		}
    }

	
    //******************************************************
    //  Affichage page principale
    //******************************************************
    $db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
    mysql_select_db($database,$db);
	
	// *** Lecture BDD users  ***
	$UserSelected = explode(" ", $_SESSION['login']);
	$sql = 'SELECT * FROM users WHERE (firstname="'.$UserSelected[0].'" AND lastname="'.$UserSelected[1].'")';
	$req = mysql_query($sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysql_error());
	$data = mysql_fetch_assoc($req);

		echo '<form class="form-group" method="post" action="">';
		echo '<input type="hidden" value="'.$data['id'].'" name="id_user">';
		echo '<table class="table table-hover">';
		echo '<tr>';
		echo '<td>Firstname:</td>';
		echo '<td><input class="form-control" type="text" value="'.$data['firstname'].'" name="firstname" ></td>';
		echo '</tr><tr>';
		echo '<td>Lastname:</td>';
		echo '<td><input class="form-control" type="text" value="'.$data['lastname'].'" name="lastname" ></td>';
		echo '</tr><tr>';		
		echo '<td>Password:</td>';
		echo '<td><input class="form-control" type="text" value="'.$data['password'].'" name="password" ></td>';		
		echo '</tr><tr>';
		echo '</form>';
		echo '</table>';
        echo' <button type="submit" class="btn btn-success" name="cmd" value="Enregistrer" '.$btnN3.'>';
        echo '<i class="glyphicon glyphicon-ok"></i> '.$osmw_btn_enregistrer.'</button>';
	

}
else {header('Location: index.php');}
?>