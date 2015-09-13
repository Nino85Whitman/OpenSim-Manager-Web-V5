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
	
    echo '<h1>'.$osmw_index_1.'</h1>';
    echo '<div class="clearfix"></div>';
	
    //******************************************************
    /* Selon ACTION bouton => Envoi Commande via Remote Admin sauf START */
    //******************************************************

	if (isset($_POST['cmd']))
	{
		$RemotePort = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " port = ");
		$access_password2 = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " access_password = ");
		
        $myRemoteAdmin = new RemoteAdmin(trim($hostnameSSH), trim($RemotePort), trim($access_password2));

		// *** Affichage mode debug ***
		// echo '# '.$_POST['cmd'].' #<br />';
		
		// EXECUTION COMMANDE SYSTEME
		/*
		if($_POST['cmd'] == 'Start')
		{
            // TO DO
			// $cheminWIN = str_replace('/','\\',INI_Conf_Moteur($_SESSION['opensim_select'], "address"));
			// echo $cmd= 'START "Opensimulator" "'.$cheminWIN.'"osmw.bat';
            // $cmd = 'START "Opensimulator" inc"\"osmw.bat';
            //$simulator = $_SESSION['opensim_select'];
			//$cmdline = "start \"titre\" /Dc:\programme\ lanceur.bat"; 
           //echo $cmd = 'START \"'.$simulator.'\" /D /bat/'.$simulator.'.bat';
		  // exec($cmd, $output);
 
        }
		*/
        // COMMANDE PAR REMOTE ADMIN
		/*
		if ($_POST['cmd'] == 'Region Root')
        {
            $parameters = array('command' => 'change region root');
            $myRemoteAdmin->SendCommand('admin_console_command', $parameters);
        }
		
		if ($_POST['cmd'] == 'Update Client')
        {
            $parameters = array('command' => 'force update');
            $myRemoteAdmin->SendCommand('admin_console_command', $parameters);
        }
		*/
		/*
		if ($_POST['cmd'] == 'Stop')
        {
            $parameters = array('command' => 'quit');
            $myRemoteAdmin->SendCommand('admin_console_command', $parameters);
			echo '<div class="alert alert-success alert-anim" role="alert">';
			echo '<strong> Votre region redemarre, <br> Merci de patienter 1 minute.</strong>';
			echo '</div>';

        }*/

		if ($_POST['cmd'] == 'Restart')
        {
           // $parameters = array('command' => 'restart');
          //  $myRemoteAdmin->SendCommand('admin_console_command', $parameters);
			$parameters = array('command' => 'quit');
            $myRemoteAdmin->SendCommand('admin_console_command', $parameters);
			echo '<div class="alert alert-success alert-anim" role="alert">';
			echo '<strong><center>Votre region redemarre, <br> Merci de patienter quelques minutes. <br>Consulter le fichier Log.<br><br></center></strong>';
			echo '	<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%"><span class="sr-only">85% Complete</span></div></div>';
			echo '</div>';
        }

		if ($_POST['cmd'] == 'Alerte General')
        {
            $parameters = array('message' => $_POST['msg_alert']);
            $myRemoteAdmin->SendCommand('admin_broadcast', $parameters);
			echo '<div class="alert alert-success alert-anim" role="alert">';
			echo '<strong><center>Votre message est envoye. <br>Consulter le fichier Log.<br></center></strong>';
			echo '</div>';
        }		

		if($_POST['cmd'] == 'FCache Assets')
		{
			$parameters = array('command' => 'fcache assets');
			$myRemoteAdmin->SendCommand('admin_console_command', $parameters);
			echo '<div class="alert alert-success alert-anim" role="alert">';
			echo '<strong><center>Votre commande est envoye. <br>Consulter le fichier Log.<br></center></strong>';
			echo '</div>';			
		}
		
		if($_POST['cmd'] == 'FCache Clear')
		{
			$parameters = array('command' => 'fcache clear');
			$myRemoteAdmin->SendCommand('admin_console_command', $parameters);
			echo '<div class="alert alert-success alert-anim" role="alert">';
			echo '<strong><center>Votre commande est envoye. <br>Consulter le fichier Log.<br></center></strong>';
			echo '</div>';			
		}
	}	

    //******************************************************
    //  Affichage page principale
    //******************************************************

	echo Select_Simulateur($_SESSION['opensim_select']);
	
    // *** Lecture Fichier Regions.ini ***
 	$filename2 = INI_Conf_Moteur($_SESSION['opensim_select'], "address")."Regions/".$FichierINIRegions;	 
	if (file_exists($filename2)) {$filename = $filename2;}
	$tableauIni = parse_ini_file($filename, true);
	if ($tableauIni == FALSE) {echo '<p>Error: Reading ini file '.$filename.'</p>';}
	
	// *** Recuperation du port Http du Simulateur
	$srvOS  = RecupPortHTTP_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, "http_listener_port");

	// echo '<h4>Effectuer une actions sur le simulateur</h4>';
    echo '<form class="form-group" method="post" action="">';
    echo '<div class="btn-group" role="group" aria-label="...">';

	//echo '<button type="submit" class="btn btn-default" value="Region Root" name="cmd" '.$btnN1.'>';
    //echo '<i class="glyphicon glyphicon-th-large"></i> Region Root</button>';
	
	echo '<button type="submit" class="btn btn-default" value="FCache Assets" name="cmd" '.$btnN1.'>';
    echo '<i class="glyphicon glyphicon-repeat"></i> FCache Assets</button>';
	
	echo '<button type="submit" class="btn btn-default" value="FCache Clear" name="cmd" '.$btnN1.'>';
    echo '<i class="glyphicon glyphicon-repeat"></i> FCache Clear</button>';

    //echo '<button type="submit" class="btn btn-default" value="Update Client" name="cmd" '.$btnN1.'>';
    //echo '<i class="glyphicon glyphicon-random"></i> Update Client</button>';

    echo '<button type="submit" class="btn btn-default" value="Restart" name="cmd" '.$btnN2.'>';
    echo '<i class="glyphicon glyphicon-retweet"></i> Restart</button>';

    //echo '<button type="submit" class="btn btn-default" value="Start" name="cmd" '.$btnN3.'>';
    //echo '<i class="glyphicon glyphicon-play"></i> Start</button>';

   // echo '<button type="submit" class="btn btn-default" value="Stop" name="cmd" '.$btnN3.'>';
   // echo '<i class="glyphicon glyphicon-stop"></i> Stop</button>';
	echo '</div>';
    echo '</form>';	

	// echo '<h4>Envoyer un message sur toutes les regions</h4>';
    echo '<form class="form-group" method="post" action="">';
    echo '<div class="btn-group " role="group" aria-label="...">';
	echo '<div class="input-group col-xs-50">';
	echo '<input type="text" class="form-control" name="msg_alert" placeholder="'.$osmw_label_msg_send.'">';
	echo '<span class="input-group-btn">';
    echo '<button type="submit" class="btn btn-danger" value="Alerte General" name="cmd" '.$btnN2.'><i class="glyphicon glyphicon-bullhorn"></i> '.$osmw_btn_msg_send.'</button>';
    echo '</span>';
    echo '</div>';
    echo '</div>';
    echo '</form>';

    echo '<p>Nombre total de regions <span class="badge">'.count($tableauIni).'</span>';

    echo '<table class="table table-hover">';
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Image</th>';
    echo '<th>Location</th>';
    echo '<th>Public IP/Host</th>';
    echo '<th>Port</th>';
    echo '<th>Teleport</th>';
    echo '<th>Status</th>';
    echo '</tr>';

	while (list($key, $val) = each($tableauIni))
	{
		$ImgMap = "http://".$hostnameSSH.":".trim($srvOS)."/index.php?method=regionImage".str_replace("-","",$tableauIni[$key]['RegionUUID']);
        if (Test_Url($ImgMap) == false)
        {
            $i = '<p class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></p>';
            $ImgMap = "img/offline.jpg";
        }
        
        else
        {
            $i = '<p class="btn btn-success" ><i class="glyphicon glyphicon-ok"></i></p>';
        }
		
		echo '<tr>';
        echo '<td><h5>'.$key.'</h5></td>';
        echo '<td><img style="height:45px;" class="img-thumbnail" alt="" src="'.$ImgMap.'"></td>';
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['Location'].'</span></h5></td>';
        echo '<td><h5>'.$tableauIni[$key]['ExternalHostName'].'</h5></td>';
        echo '<td><h5><span class="badge">'.$tableauIni[$key]['InternalPort'].'</span></h5></td>';
        // echo '<td><a class="btn btn-default" href="secondlife://'.$hypergrid.":".$key.'">Teleport</a></td>';
        echo '<td><a class="btn btn-default" href="secondlife://'.$key.'/128/128/25"><i class="glyphicon glyphicon-plane"></i> Teleport</a></td>';
        echo '<td>'.$i.'</td>';
        echo '</tr>';
	}
	echo '</table>';
}
else {header('Location: index.php');}
?>
