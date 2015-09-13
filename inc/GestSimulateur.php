<?php 
if (isset($_SESSION['authentification']) && $_SESSION['privilege']>= 3)
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

    echo '<h1>'.$osmw_index_17.'</h1>';
    echo '<div class="clearfix"></div>';	
	

 	echo '<form class="form-group" method="post" action="">';
    echo '<input type="hidden" name="cmd" value="Ajouter" '.$btnN3.'>';
	echo '<button class="btn btn-success" type="submit" value="Ajouter un Simulateur" '.$btnN3.'><i class="glyphicon glyphicon-ok"></i> '.$osmw_btn_ajout_simu.'</button>';
	echo '</form>';
 
	//******************************************************
	// CONSTRUCTION de la commande pour ENVOI sur la console via  SSH
	//******************************************************
	if (isset($_POST['cmd']))
	{
			$db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
			mysql_select_db($database, $db);
			
		if($_POST['cmd'] == 'Ajouter')
		{
			$i = NbOpensim() + 1;
			echo '<form method=post sction="">';
			echo '<table class="table table-hover">';
			echo '<tr>';
			echo '<th>Name</th>';   
			echo '<th>Version</th>';
			echo '<th>Path</th>';
			echo '<th>HG url</th>';
			echo '<th>Database</th>';
            echo '<th>Save</th>';
			echo '</tr>';
			echo '<tr>';
            echo '<td><input class="form-control" type="text" name = "NewName" value="My Simulator '.$i.'" '.$btnN3.'"></td>';
            echo '<td><input class="form-control" type="text" name = "version" value="0.8.1.1" '.$btnN3.'"></td>';
            echo '<td><input class="form-control" type="text" name = "address" value="/home/user/simulateur'.$i.'/" '.$btnN3.'></td>';
            echo '<td><input class="form-control" type="text" name = "hypergrid" value="hg.simulator'.$i.'.com:80" '.$btnN3.'></td>';
            echo '<td><input class="form-control" type="text" name = "DB_OS" value="My Simulator '.$i.' database" '.$btnN3.'></td>';
            echo '<td><input class="btn btn-success" type="submit" value="Enregistrer" name="cmd" '.$btnN3.'></td>';
            echo '</tr></table></form>';
		}

		if ($_POST['cmd'] == 'Enregistrer')
		{	
			$sqlIns = "INSERT INTO moteurs (`osAutorise` ,`id_os` ,`name` ,`version` ,`address` , `DB_OS`, `hypergrid`)
                        VALUES (NULL , '".$_POST['NewName']."', '".$_POST['NewName']."', '".$_POST['version']."', '".$_POST['address']."', '".$_POST['DB_OS']."', '".$_POST['hypergrid']."')";
			$reqIns = mysql_query($sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error());
            
			echo "<p class='alert alert-success alert-anim'>";
            echo "<i class='glyphicon glyphicon-ok'></i>";
            echo " ".$osmw_simu." <strong>".$_POST['NewName']."</strong> ".$osmw_save_user_ok."</p>";
		} 
        
		if($_POST['cmd'] == 'Update')
		{
			$sqlIns = "
                UPDATE moteurs 
                SET 
                    id_os = '".$_POST['id_os']."',
                    name = '".$_POST['name']."',
                    version = '".$_POST['version']."',
                    address = '".$_POST['address']."',
                    DB_OS = '".$_POST['DB_OS']."',
                    hypergrid = '".$_POST['hypergrid']."'
                WHERE osAutorise = '".$_POST['osAutorise']."'
            ";
            $reqIns = mysql_query($sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error());
			echo "<p class='alert alert-success alert-anim'>";
            echo "<i class='glyphicon glyphicon-ok'></i>";
            echo " ".$osmw_simu." <strong>".$_POST['NewName']."</strong> ".$osmw_edit_user_ok."</p>";
		}

		if($_POST['cmd'] == 'Supprimer')
		{			
			$sqlIns = "DELETE FROM moteurs WHERE `moteurs`.`osAutorise` = ".$_POST['osAutorise'];
			$reqIns = mysql_query($sqlIns) or die('Erreur SQL !<p>'.$sqlIns.'</p>'.mysql_error());
			echo "<p class='alert alert-success alert-anim'>";
            echo "<i class='glyphicon glyphicon-ok'></i>";
            echo " ".$osmw_simu." <strong>".$_POST['NewName']."</strong> ".$osmw_delete_user_ok."</p>";
		}
    }

    //******************************************************
    //  Affichage page principale
    //******************************************************

    echo '<p>'.$osmw_label_totl_simulator.' <span class="badge">'.NbOpensim().'</span></p>';
	echo '<table class="table table-hover">';
	echo '<tr>';
	echo '<th>Name</th>';
	echo '<th>Version</th>';
	echo '<th>Path</th>';
	echo '<th>HG url</th>';
	echo '<th>Database</th>';
	echo '<th>Edit</th>';
    echo '<th>Delete</th>';
	echo '</tr>';
	
	$db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
	mysql_select_db($database, $db);
	// *** Lecture BDD config  ***
	$sql = 'SELECT * FROM moteurs';
	$req = mysql_query($sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysql_error());
	while($data = mysql_fetch_assoc($req))
	{
		echo '<tr>';
		echo '<form method=post action="">';
		echo '<input type="hidden" name="osAutorise" value="'.$data['osAutorise'].'" >';
		echo '<input type="hidden" name="id_os" value="'.$data['id_os'].'" >';
		echo '<tr>';
		echo '<td><input class="form-control" type="text" name="name" value="'.$data['name'].'" '.$btnN3.'></td>';
		echo '<td><input class="form-control" type="text" name="version" value="'.$data['version'].'" '.$btnN3.'></td>';
		echo '<td><input class="form-control" type="text" name="address" value="'.$data['address'].'" '.$btnN3.'></td>';
		echo '<td><input class="form-control" type="text" name="hypergrid" value="'.$data['hypergrid'].'" '.$btnN3.'></td>';
		echo '<td><input class="form-control" type="text" name="DB_OS" value="'.$data['DB_OS'].'" '.$btnN3.'></td>';
        echo '<td><button class="btn btn-success" type="submit" name="cmd" value="Update" '.$btnN3.'><i class="glyphicon glyphicon-edit"></i> '.$osmw_btn_modifier.'</button></td>';
        echo '<td><button class="btn btn-danger" type="submit" name="cmd" value="Supprimer" '.$btnN3.'><i class="glyphicon glyphicon-trash"></i> '.$osmw_btn_supprimer.'</button></td>';
		echo '</tr>';
		echo '</form>';
		echo '</tr>';
	}
	echo '</table>';
    mysql_close();
}
else {header('Location: index.php');}
?>
