<?php 
if (isset($_SESSION['authentification']) && $_SESSION['privilege']>= 3)
{
//	echo Affichage_Entete($_SESSION['opensim_select']);

	$db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
    mysql_select_db($database,$db);	
	
	$sqlA = "SELECT * FROM `gestionnaire` WHERE uuid='".$_SESSION['uuid_region_npc']."'" ;
	$reqA = mysql_query($sqlA) or die('Erreur SQL !<br>'.$sqlA.'<br>'.mysql_error());
	$dataA = mysql_fetch_assoc($reqA);
	$regionName = $dataA['region'];
	$regionUUID = $_SESSION['uuid_region_npc'];
	$FILE_NPC = $regionName.".txt";	
 

	echo '<h1>'.$osmw_index_20.'</h1>';
    echo '<div class="clearfix"></div>';
 
//#####################################################################################
//#####################################################################################
 if( isset($_POST["parameter"]) && $_POST["parameter"] =="WEB" )
{
	echo '<div class="alert alert-success alert-anim" role="alert">';
	echo '<strong><center>Commande envoye. Merci de patienter avant de faire une nouvelle action.<br><br></center></strong>';
	echo '	<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"><span class="sr-only">85% Complete</span></div></div>';
	echo '</div>';
//*******************************************************************************
	if (isset($_POST["eclat"]))	
	{
		if($_POST["eclat"] == "eclat1"){EcritureFichier($FILE_NPC,"Gestion_NPC,REZ1,section2,section3,section4,".$_POST["regionUUID"]);}
		if($_POST["eclat"] == "eclat2"){EcritureFichier($FILE_NPC,"Gestion_NPC,REZ2,section2,section3,section4,".$_POST["regionUUID"]);}
		if($_POST["eclat"] == "eclat3"){EcritureFichier($FILE_NPC,"Gestion_NPC,REZ3,section2,section3,section4,".$_POST["regionUUID"]);}
	}
	
//*******************************************************************************

//*******************************************************************************
	if ($_POST["NPC"])		{EcritureFichier($FILE_NPC,"Gestion_NPC,CREATE,".$_POST["select_apparence"].",".$_POST["firstname_NPC"].";".$_POST["lastname_NPC"].",".$_POST["coordX"].";".$_POST["coordY"].";".$_POST["coordZ"].",".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["STOP_NPC"])	{
		EcritureFichier($FILE_NPC,"Gestion_NPC,STOP_ALL,section2,section3,section4,".$_POST["regionUUID"]);
		$sql ="DELETE FROM `npc` WHERE region='".$_POST["regionName"]."'";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		}
//*******************************************************************************
	if ($_POST["REMOVE_NPC"])	{
		EcritureFichier($FILE_NPC,"Gestion_NPC,REMOVE_NPC,".$_POST["select_npc"].",section3,section4,".$_POST["regionUUID"]);
		$sql ="DELETE FROM `npc` WHERE uuid_npc='".$_POST["select_npc"]."'";
		$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
		}		
//*******************************************************************************
	if ($_POST["SAY"])	{
		 $message = str_replace(" ", "_", $_POST["message"]);
		EcritureFichier($FILE_NPC,"Gestion_NPC,SAY,".$_POST["select_npc"].",".$message.",section4,".$_POST["regionUUID"]);
	}
//*******************************************************************************
	if ($_POST["SIT"])		{EcritureFichier($FILE_NPC,"Gestion_NPC,SIT,".$_POST["select_npc"].",".$_POST["uuid_objet"].",section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["STAND"])	{EcritureFichier($FILE_NPC,"Gestion_NPC,STAND,".$_POST["select_sit"].",section3,section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["ANIMATE"])	{EcritureFichier($FILE_NPC,"Gestion_NPC,".$_POST["ANIMATE"].",".$_POST["select_npc"].",".$_POST["select_animation"].",section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["APPARENCE"] == "APPARENCE_LOAD"){EcritureFichier($FILE_NPC,"Gestion_NPC,".$_POST["APPARENCE"].",".$_POST["select_npc"].",".$_POST["select_apparence"].",section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["APPARENCE"] == "APPARENCE_SAVE"){EcritureFichier($FILE_NPC,"Gestion_NPC,".$_POST["APPARENCE"].",".$_POST["select_npc"].",".$_POST["notecard_apparence"].",section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["MAJ_LISTE"]){EcritureFichier($FILE_NPC,"Gestion_NPC,LISTING,section2,section3,section4,".$_POST["regionUUID"]);}
//*******************************************************************************
	if ($_POST["RAZ_LISTE_OBJ"]){
		$sql0 = "DELETE FROM `npc` WHERE region='".$_POST["regionName"]."'" ;
		$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
		$sql0 = "DELETE FROM `inventaire` WHERE region='".$_POST["regionName"]."'" ;
		$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
		$sql0 = "DELETE FROM `gestionnaire` WHERE region='".$_POST["regionName"]."'" ;
		$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());		
		}
//*******************************************************************************
}
//#####################################################################################
//#####################################################################################


// Si le region NPC selectionne a change
	if (isset($_POST["region"])){$_SESSION['uuid_region_npc'] = trim($_POST["region"]);}
	
	$sql0 = "SELECT * FROM `gestionnaire`" ;
	$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
	$numrow0 = mysql_num_rows($req0);

	echo '<p>Nombre total de regions Inworld avec Box NPC: <span class="badge">'.$numrow0.'</span>';
	
//*******************************************************************************
	echo '<form class="form-group" method="post" action="">';	
	echo '<input type="hidden" name="parameter" value="WEB">';
//*******************************************************************************	
			echo '<div class="form-inline">';
			echo '<label for="region"></label>Choisir la région de la Box NPC a commander: ';
			echo '<select class="form-control" name="region">';
			while($data = mysql_fetch_assoc($req0))
			{
				echo '<option value="'.$data["uuid"].'">'.$data["region"].'</option> ';
			}
			echo'</select>';
			echo' <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-ok"></i> Choisir</button>';
			echo' <button type="submit" class="btn btn-info"><i class="glyphicon glyphicon-ok"></i> Raffraichir la page</button>';
			echo '</div>';
			echo'</form>';

			
			
			echo '<p class="pull-left">Box NPC selectionne: <span class="label label-info">'.$regionName.'</span></p><br>';
			echo '<u>Contenu du fichier ordre:</u><br>';
			
			echo LectureFichier($FILE_NPC);	


		echo '<form method="post" action=""><input type="hidden" name="parameter" value="WEB">';
		echo '<input type="hidden" name="regionName" value="'.$regionName.'"><input type="hidden" name="regionUUID" value="'.$regionUUID.'">';


		//*******************************************************************************
		// Creation du NPC
		//*******************************************************************************
		echo'<div class="panel panel-info"><div class="panel-heading"><h4>Creation de NPC</h4></div>';
		echo '<table class="table table-hover">';
			echo '<tr>';
			echo '<th>';
				echo 'Position X<input type="text" class="form-control" name="coordX" placeholder="3" value="3">';
			echo '</th>';
			echo '<th>';
				echo 'Position Y<input type="text" class="form-control" name="coordY" placeholder="3" value="3">';
			echo '</th>';
			echo '<th>';
				echo 'Position Z<input type="text" class="form-control" name="coordZ" placeholder="3" value="3">';
			echo '</th>';
			echo '</tr>';
			echo '<tr>';
			echo '<th>';
				echo '<input type="text" class="form-control" name="firstname_NPC" placeholder="Prenom">';
			echo '</th>';
			echo '<th>';
				echo '<input type="text" class="form-control" name="lastname_NPC" placeholder="Nom">';
			echo '</th>';
			echo '<th>';
				echo' <button type="submit" class="btn btn-default" name="NPC" value="CREER_NPC"><i class="glyphicon glyphicon-ok"></i> Créer NPC </button>';
			echo '</th>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';

		//*******************************************************************************
		echo'<div class="panel panel-info"><div class="panel-heading"><h4>Sélectionner le NPC pour le ( Supprimer / Faire parler / Assoir - PoseBall / Animer / Changer d\'apparence )</h4>';
		//*******************************************************************************


		//*******************************************************************************
		// Choix de l'avatar
		//*******************************************************************************
			echo '<div class="form-inline">';
			echo '<label for="select_npc"></label>Avatar NPC: ';
			echo '<select class="form-control" name="select_npc">';
			$sql0 = "SELECT * FROM `npc` WHERE region='".$regionName."'" ;
			$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
			$numrow0 = mysql_num_rows($req0);
			while ($data0 = mysql_fetch_assoc($req0)) 
			{
				echo '<option value="'.$data0["uuid_npc"].'">'.$data0["firstname"].' '.$data0["lastname"].'</option> ';
			}
			echo'</select>';
			echo' <button type="submit" class="btn btn-default" name="REMOVE_NPC" value="REMOVE_NPC"><i class="glyphicon glyphicon-remove-circle"></i> Supprimer NPC Sélectionné</button>';
			echo '</div>';
				
		echo'</div>';
		echo '<br>';

		echo '<div class="well">';
		//*******************************************************************************
		// Choix de l'apparence
		//*******************************************************************************
			echo '<div class="form-inline">';
			echo '<label for="select_apparence"></label>Apparence: <br>';
			echo '<select class="form-control" name="select_apparence">';
			$sql0 = "SELECT * FROM `inventaire` WHERE (type='apparence' AND uuid_parent='".$regionUUID."')" ;
			$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
			$numrow0 = mysql_num_rows($req0);
			while ($data0 = mysql_fetch_assoc($req0)) 
			{
				echo '<option value="'.$data0["nom"].'">'.$data0["nom"].'</option> ';
			}
			echo'</select>';
			echo' <button type="submit" class="btn btn-default" name="APPARENCE" value="APPARENCE_LOAD"><i class="glyphicon glyphicon-ok"></i> Choisir</button>';
			echo '</div>';
			
			echo '<br>';
			
		//*******************************************************************************
		// Faire parler l'avatar
		//*******************************************************************************
			echo '<div class="btn-group " role="group" aria-label="...">';
			echo '<div class="input-group col-xs-50">';
			echo '<input type="text" class="form-control" name="message" placeholder="Faire parler NPC">';
			echo '<span class="input-group-btn">';
			echo '<button type="submit" class="btn btn-default" value="Alerte General" name="SAY" ><i class="glyphicon glyphicon-bullhorn"></i> Faire parler NPC</button>';
			echo '</span>';
			echo '</div>';
			echo '</div>';
			
			echo '<br>';	
			echo '<br>';	
		//*******************************************************************************
		// Faire assoir ou lever l'avatar sur l'objet
		//*******************************************************************************
			echo '<div class="btn-group " role="group" aria-label="...">';
			echo '<div class="input-group col-xs-50">';
			echo '<input type="text" class="form-control" name="uuid_objet" placeholder="UUID de l\'objet to sit ">';
			echo '<span class="input-group-btn">';
			echo '<button type="submit" class="btn btn-default" name="SIT" value="SIT" ><i class="glyphicon glyphicon-play"></i> Faire assoir le NPC</button>';
			echo '<button type="submit" class="btn btn-default" name="STAND" value="STAND" ><i class="glyphicon glyphicon-eject"></i> Faire se lever le NPC</button>';
			echo '</span>';
			echo '</div>';
			echo '</div>';
			
			echo '<br>';
			echo '<br>';
			
		//*******************************************************************************
		// Animation de l'avatar
		//*******************************************************************************

			echo '<div class="form-inline">';
			echo '<label for="select_npc"></label>Animer l\'Avatar NPC: <br>';
			echo '<select class="form-control" name="select_animation">';
			$sql0 = "SELECT * FROM `inventaire` WHERE (type='animation' AND uuid_parent='".$regionUUID."')" ;
			$req0 = mysql_query($sql0) or die('Erreur SQL !<br>'.$sql0.'<br>'.mysql_error());
			$numrow0 = mysql_num_rows($req0);
			while ($data0 = mysql_fetch_assoc($req0)) 
			{
				echo '<option value="'.$data0["nom"].'">'.$data0["nom"].'</option> ';
			}
			echo'</select>';
			echo' <button type="submit" class="btn btn-default" name="ANIMATE" value="ANIMATE_START"><i class="glyphicon glyphicon-play"></i> Animer le NPC</button>';
			echo' <button type="submit" class="btn btn-default" name="ANIMATE" value="ANIMATE_STOP"><i class="glyphicon glyphicon-stop"></i> Ne plus animer le NPC</button>';
			echo '</div>';
				
			echo '<br>';

		//*******************************************************************************
		// Sauvegarder dans l'objet la notecard apparence
		//*******************************************************************************

			echo '<div class="btn-group " role="group" aria-label="...">';
			echo '<div class="input-group col-xs-50">';
			echo '<input type="text" class="form-control" name="notecard_apparence" placeholder=" Libelle de l\'apparence a sauvegarder (pas d\espace) ">';
			echo '<span class="input-group-btn">';
			echo '<button type="submit" class="btn btn-default" name="APPARENCE" value="APPARENCE_SAVE" ><i class="glyphicon glyphicon-floppy-saved"></i> Sauvegarde Apparence NPC en cours</button>';
			echo '</span>';
			echo '</div>';
			echo '</div>';

		//*******************************************************************************
			echo '</div>';
		//*******************************************************************************
		   echo '</div>';
			
		//*******************************************************************************
		// REZ d'OBJET
		//*******************************************************************************
		echo'<div class="panel panel-info"><div class="panel-heading"><h4>REZ d\'objet depuis la BOX</h4></div>';
		echo '<table class="table table-hover">';
			echo '<tr>';
				echo '<th>';
				echo' <button type="submit" class="btn btn-default" name="eclat" value="eclat1"><i class="glyphicon glyphicon-ok"></i> Particule 1 </button>';	
				echo '</th>';
				echo '<th>';
				echo' <button type="submit" class="btn btn-default" name="eclat" value="eclat2"><i class="glyphicon glyphicon-ok"></i> Particule 2 </button>';
				echo '</th>';
				echo '<th>';	
				echo' <button type="submit" class="btn btn-default" name="eclat" value="eclat3"><i class="glyphicon glyphicon-ok"></i> Particule 3 </button>';	
				echo '</th>';
				echo '</th>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
		//*******************************************************************************
		// Gestion de la BOX
		//*******************************************************************************
		echo'<div class="panel panel-info"><div class="panel-heading"><h4>Gestion de la BOX InWorld</h4></div>';
		echo '<table class="table table-hover">';
			echo '<tr>';
			echo '<th>';
			echo' <button type="submit" class="btn btn-danger" name="MAJ_LISTE" value="MAJ_LISTE"><i class="glyphicon glyphicon-wrench"></i> Lecture INWORLD </button>';
			echo '</th>';
			echo '<th>';
			echo' <button type="submit" class="btn btn-warning" name="STOP_NPC" value="STOP_NPC"><i class="glyphicon glyphicon-remove-circle"></i> STOP ALL NPC </button>';
			echo '</th>';
			echo '<th>';	
			echo' <button type="submit" class="btn btn-danger" name="RAZ_LISTE_OBJ" value="RAZ_LISTE_OBJ"><i class="glyphicon glyphicon-trash"></i> RAZ Box </button>';
			echo '</th>';
			echo '</th>';
			echo '</tr>';
		echo '</table>';
		echo '</div>';
	
//***********************************************
echo '</form>';
//***********************************************

echo'<div class="panel panel-info"><div class="panel-heading"><h4>Configuration de la BOX InWorld</h4></div>';
echo '<table class="table table-hover">';
	echo '<tr>';
	echo '<th>';
	echo '<span class="btn  btn-warning"><a href="./img/img_npc.PNG" target=_blank>Configuration Box InWorld (npc_inworld.php) before REZ</a></span> ';
	echo '</th>';
	echo '<th>';
	echo '<span class="btn  btn-warning"><a href="./docs/lsl/Script1_NPC.lsl" target=_blank>Script 1 Box InWorld</a></span> ';
	echo '</th>';
	echo '<th>';	
	echo '<span class="btn  btn-warning"><a href="./docs/lsl/Script2_NPC.lsl" target=_blank>Script 2 Box InWorld</a></span> ';
	echo '</th>';
	echo '</th>';
	echo '</tr>';
echo '</table>';
echo '</div>';





mysql_close($db);

}
else {header('Location: index.php');}

//#####################################################################################
// LES FONCTIONS
//#####################################################################################

	function LectureFichier($file)
	{
		error_reporting(0);
		$monfichier = fopen("inc/".$file, 'r+');
		$ligne = fgets($monfichier);
		fclose($monfichier);
		return '<pre>'.$ligne.'</pre>';
	}
	function EcritureFichier($file,$commande)
	{
		error_reporting(0);
		$monfichier = fopen("inc/".$file, 'w+');
		fseek($monfichier, 0); 
		fputs($monfichier, $commande); 
		fclose($monfichier);
	}

?>