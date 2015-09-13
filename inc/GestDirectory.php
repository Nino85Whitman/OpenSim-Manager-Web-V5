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
		
    echo '<h1>'.$osmw_index_10.'</h1>';
    echo '<div class="clearfix"></div>';
	
	/* Actions des Boutons */
	if (isset($_POST['cmd']))
	{
        // Actions Telecharger fichier
		if ($_POST['cmd'] == "download")
		{ 
            echo INI_Conf_Moteur($_SESSION['opensim_select'], "address").$_POST['name_file']."<br />";
			$a = DownloadFile(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$_POST['name_file']);
        }
		
        // Actions supprimer fichier
		if ($_POST['cmd'] == "delete")
		{
			$cheminWIN = str_replace('/','\\',INI_Conf_Moteur($_SESSION['opensim_select'],"address"));
			unlink($cheminWIN.$_POST['name_file']);
            
            echo '<div class="alert alert-success alert-anim" role="alert">';
            echo 'Fichier '.$cheminWIN.$_POST['name_file'].' supprime avec succes ...';
            echo '<strong> OpenSim.log</strong>';
            echo '</div>';
		}
	}

    //******************************************************
    //  Affichage page principale
    //******************************************************

	echo Select_Simulateur($_SESSION['opensim_select']);
    ?>
    
    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?php echo $type; ?> alert-anim">
                <?php echo $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
    
    <?php
    // <!-- liste des fichiers -->
    /* Repertoire initial a lister */
    $dir = "";
    $dir = INI_Conf_Moteur($_SESSION['opensim_select'], "address");

    if ($dir) {list_file(rawurldecode($dir));}

    else
    {
        echo '<div class="alert alert-danger alert-anim" role="alert">';
        echo 'Le <strong>chemin</strong> est incorrecte ...';
        echo '</div>';
    }
}
else {header('Location: index.php');}
?>