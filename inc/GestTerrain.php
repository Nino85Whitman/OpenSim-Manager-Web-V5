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
		
    echo '<h1>Gestion des Terrains</h1>';
    echo '<div class="clearfix"></div>';	
    //******************************************************
    //* Selon ACTION bouton => Envoi Commande via Remote Admin 
    //******************************************************
	if (isset($_POST['cmd']))
	{
		$RemotePort = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " port = ");
		$access_password2 = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " access_password = ");
		
        $myRemoteAdmin = new RemoteAdmin(trim($hostnameSSH), trim($RemotePort), trim($access_password2));

		//*********************************
		// === Commande BACKUP ===
		//*********************************
		if ($_POST['save_terrain'])
		{
            // echo "name_sim = ".$_POST['name_sim'];

			if ($_POST['save_terrain'] == '1' && $_POST['cmd'] == 'Save BMP')
			{
				$parameters = array(
                'region_name' => $_POST['name_sim'], 
                'filename' => 'BackupMAP_'.$_POST['name_sim'].'_'.date(d_m_Y_h).'.bmp'
				);
				$myRemoteAdmin->SendCommand('admin_save_heightmap', $parameters);
			}
			if ($_POST['save_terrain'] == '1' && $_POST['cmd'] == 'Save RAW')
			{
				$parameters = array(
                'region_name' => $_POST['name_sim'], 
                'filename' => 'BackupMAP_'.$_POST['name_sim'].'_'.date(d_m_Y_h).'.raw'
				);
				$myRemoteAdmin->SendCommand('admin_save_heightmap', $parameters);
			}	
			
		echo '<div class="alert alert-success alert-anim" role="alert">';
		echo '<strong><center>Fichier en cours de creation, veuillez consulter le <strong>Log</strong> ... <br> <br></center></strong>';
		echo '	<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"><span class="sr-only">85% Complete</span></div></div>';
		echo '</div>';
		}
	}

    //******************************************************
    //  Affichage page principale
    //******************************************************

	echo Select_Simulateur($_SESSION['opensim_select']);

	// *** Lecture Fichier Region.ini ***
	$filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address")."Regions/".$FichierINIRegions;
	if (file_exists($filename2)) {$filename = $filename2 ;}

	$tableauIni = parse_ini_file($filename, true);
	if ($tableauIni == FALSE){echo '<p class="alert alert-danger">Proleme de lecture du fichier .ini <strong>$filename</strong></p>';}
	
    // *** Lecture Fichier Regions.ini ***
 	$filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address")."Regions/".$FichierINIRegions;	 
	if (file_exists($filename2)) {$filename = $filename2;}
	$tableauIni = parse_ini_file($filename, true);
	if ($tableauIni == FALSE) {echo '<p>Error: Reading ini file '.$filename.'</p>';}
	
	// *** Recuperation du port Http du Simulateur
	$srvOS  = RecupPortHTTP_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, "http_listener_port");

	echo '<p>Nombre total de regions <span class="badge">'.count($tableauIni).'</span></p>';
    
	echo '<table class="table table-hover">';

    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Image</th>';
 //   echo '<th>Uuid</th>';
    echo '<th>Location</th>';
    echo '<th>Public IP/Host</th>';
    echo '<th>Private IP/Host</th>';
    echo '<th>Port</th>';
    echo '<th>Format BMP</th>';
	echo '<th>Format RAW</th>';
    echo '</tr>';

	while (list($key, $val) = each($tableauIni))
	{
        $uuid = str_replace("-", "", $tableauIni[$key]['RegionUUID']);
		$ImgMap = "http://".$hostnameSSH.":".trim($srvOS)."/index.php?method=regionImage".$uuid;

        if (Test_Url($ImgMap) == false) {$ImgMap = "img/offline.jpg";}

        echo '<tr>';
        echo '<td><h5>'.$key.'</h5></td>';
		echo '<td><img  style="height: 45px;" class="img-thumbnail" alt="" src="'.$ImgMap.'"></td>';
     //   echo '<td><h5><span class="badge">'.$tableauIni[$key]['RegionUUID'].'</span></h5></td>';
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['Location'].'</span></h5></td>';
        echo '<td><h5>'.$tableauIni[$key]['ExternalHostName'].'</h5></td>';
        echo "<td><h5><span class='badge'>".$tableauIni[$key]['InternalAddress']."</span></h5></td>";
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['InternalPort'].'</span></h5></td>';

		echo '<td>';
		echo '<form method="post" action="">';
        echo '<input type="hidden" name="save_terrain" value="1" >';
		echo '<input type="hidden" name="name_sim" value="'.$key.'">';

		echo '<button type="submit" name="cmd" class="btn btn-success" value="Save BMP" '.$btnN2.'>';
        echo '<i class="glyphicon glyphicon-save"></i> Save BMP';
        echo '</button>';
		echo '</td>';
		echo '<td>';
		echo '<button type="submit" name="cmd" class="btn btn-success" value="Save RAW" '.$btnN2.'>';
        echo '<i class="glyphicon glyphicon-save"></i> Save RAW';
        echo '</button>';
         
		echo '</form>';
		echo '</td>';
		echo '</tr>';
	}
	echo '</table>';	
}
else {header('Location: index.php');}
?>
