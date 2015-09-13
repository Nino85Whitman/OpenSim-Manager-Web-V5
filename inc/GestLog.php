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
	
    echo '<h1>'.$osmw_index_7.'</h1>';
    echo '<div class="clearfix"></div>';
	
	
    /* CONSTRUCTION de la commande pour ENVOI sur la console via  SSH */
	if (isset($_POST['cmd']))
	{
        // *** Affichage mode debug ***
        // echo '# '.$_POST['cmd'].' #<br />';
		
        if (isset($_POST['versionLog']))
		{ 
			$cheminWIN = "";
			$OS = trim(php_uname("s"));
			
			if($OS = "Windows NT")
			{
				$cheminWIN = str_replace('/','\\', INI_Conf_Moteur($_SESSION['opensim_select'], "address"));
			}
			unlink($cheminWIN."OpenSim.log");
		}  
	}

    //******************************************************
    //  Affichage page principale
    //******************************************************

	echo Select_Simulateur($_SESSION['opensim_select']);
	
	$fichierLog = INI_Conf_Moteur($_SESSION['opensim_select'], "address").'OpenSim.log';
	
    if (file_exists(INI_Conf_Moteur($_SESSION['opensim_select'], "address").'OpenSim.log'))
    {
        echo '<div class="alert alert-success alert-anim" role="alert">';
        echo "File exist: <strong>" .$fichierLog.'</strong>';
        echo '</div>';
    }
    else if ($_POST['cmd'])
    {
        echo '<div class="alert alert-danger alert-anim" role="alert">';
        echo "File not exist: <strong>" .$fichierLog.'</strong>';
        echo '</div>';
    }
	
    $taille_fichier = filesize($fichierLog);

    if ($taille_fichier >= 1073741824) {$taille_fichier = round($taille_fichier / 1073741824 * 100) / 100 . " Go";}
    else if ($taille_fichier >= 1048576) {$taille_fichier = round($taille_fichier / 1048576 * 100) / 100 . " Mo";}
    else if ($taille_fichier >= 1024) {$taille_fichier = round($taille_fichier / 1024 * 100) / 100 . " Ko";}
    else {$taille_fichier = $taille_fichier . " o";}

	
	if (isset($_SESSION['authentification']) && $_SESSION['privilege']>= 3)
	{		
		echo '<form class="form-group" method="post" action="">';
		echo '<input type="hidden" value="'.$versionlog.'" name="versionLog">';
		echo '<button type="submit" class="btn btn-danger" name="cmd" '.$btnN3.'><i class="glyphicon glyphicon-trash"></i> Delete <strong>Log</strong></button>';
		echo '</form>';
	}	
	echo '<p>'.$osmw_label_file_size.' <span class="badge">'.$taille_fichier.'</span></p>';
	
	$fcontents = file($fichierLog);
	$i = sizeof($fcontents) - 30;
    $aff = "";

	while ($fcontents[$i] != "")
	{
	    $aff .= $fcontents[$i];
		$i++;
	}

	if (!$aff)
    {
        if (!$logfile) $aff = "File not exist...";
        else $aff = "File Log ".$logfile." is empty ...";
    }
    echo '<pre>'.$aff.'</pre>';

	echo '</td>';
	echo '</tr>';
	echo '</table>';
}
else {header('Location: index.php');}
?>
