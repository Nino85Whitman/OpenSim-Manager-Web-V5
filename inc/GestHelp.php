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
    
    echo '<h1>Aide</h1>';
    echo '<div class="clearfix"></div>';
    


    echo '<div class="row">';
    echo '<div class="col-xs-6">';
    echo '<a class="btn btn-default view-pdf form-control" href="http://www.fgagod.net/HELP_OSMW-fr.pdf">View PDF Fran&ccedil;ais</a>';
    echo '</div>';
    echo '<div class="col-xs-6">';
    echo '<a class="btn btn-default view-pdf form-control" href="http://www.fgagod.net/HELP_OSMW-en.pdf">View PDF English</a>';
    echo '</div>';

    echo '</div>';
    echo '<div class="clearfix"></div>';
}
else {header('Location: index.php');}
?>