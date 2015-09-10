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
	
    echo '<h1>Liens Hypergrid</h1>';
    echo '<div class="clearfix"></div>';

    //******************************************************
    //  Affichage page principale
    //******************************************************
			
	//grid	secondlife://Red%20Dragon%20Nite%20Club/236/79/23
	//hg	secondlife://hg.osgrid.org:80/Red%20Dragon%20Nite%20Club/236/79/23
	//v3hg	secondlife://http|!!hg.osgrid.org|80+Red+Dragon+Nite+Club
	//Hop 	hop://hg.osgrid.org:80/Red%20Dragon%20Nite%20Club/236/79/23
	
    // *******************************************************	
    // Lecture des regions.ini et enregistrement dans Matrice
    // *******************************************************
    $db = mysql_connect($hostnameBDD, $userBDD, $passBDD);
    mysql_select_db($database,$db);
	$sql = 'SELECT * FROM moteurs';
    $req = mysql_query($sql) or die('Erreur SQL !<p>'.$sql.'</p>'.mysql_error());

		
    while ($data = mysql_fetch_assoc($req))
	{
        $hypergrid = "";
		$hypergrid = $data['hypergrid'];
        $i = 0;

        if ($hypergrid <> "")
        {
			$tableauIni = parse_ini_file($data['address']."Regions/".$FichierINIRegions, true);

            if ($tableauIni == FALSE && $data['name'] == $_SESSION['opensim_select'])
            {
                echo '<div class="alert alert-danger alert-anim" role="alert">';
                echo 'Probleme de lecture du fichier .ini <strong>'.$FichierINIRegions.'</strong> ('.$data['address'].'Regions/)';
                echo '</div>';
            }

            $cpt = 0;
            echo  '<div class="row">';

            while (list($keyi, $vali) = each($tableauIni))
            {
                $filename = $data['address'].$FichierINIOpensim;
                if (!$fp = fopen($filename, "r"))
                {
                    echo '<div class="alert alert-danger alert-anim" role="alert">';
                    echo "Echec d'ouverture du fichier <strong>".$filename."</strong>";
                    echo '</div>';
                }	
				else	
				{
					$srvOS  = RecupPortHTTP_Opensim($filename, "http_listener_port");
				}

                //Recuperation des images de regions 
        
                $ImgMap = "http://".$tableauIni[$keyi]['ExternalHostName'].":".trim($srvOS)."/index.php?method=regionImage".str_replace("-", "", $tableauIni[$keyi]['RegionUUID']);
                if (Test_Url($ImgMap) == false) {$ImgMap = "img/offline.jpg";}

                $TD_Hypergrid  = "";
                $TD_Hypergrid .= '<div class="col-sm-6 col-md-4">';
                $TD_Hypergrid .= '<div class="thumbnail">';
                $TD_Hypergrid .= '<img class=" btn3d btn btn-default img-rounded" alt="" src="'.$ImgMap.'">';
                $TD_Hypergrid .= '<div class="caption text-center">';
                $TD_Hypergrid .= '<h4>Region: <strong>'.$keyi.'</strong></h4>';
                $TD_Hypergrid .= '<p>Location: <strong>'.$tableauIni[$keyi]['Location'].'</strong></p>';
                $TD_Hypergrid .= '<div class="btn-group" role="group" aria-label="...">';
                $TD_Hypergrid .= '<a class="btn btn-primary"	href="secondlife://'.$keyi.'/128/128/25">Grid</a>';
                $TD_Hypergrid .= '<a class="btn btn-success"	href="secondlife://'.$hypergrid.'/'.$keyi.'/128/128/25">Hg</a>';
                $TD_Hypergrid .= '<a class="btn btn-warning"	href="secondlife://'.$hypergrid.'/'.$keyi.'">v3Hg</a>';
				$TD_Hypergrid .= '<a class="btn btn-danger"		href="hop://'.$hypergrid.'/'.$keyi.'/128/128/25">hop</a>';
                $TD_Hypergrid .= '</div>';
                $TD_Hypergrid .= '</div>';
                $TD_Hypergrid .= '</div>';
                $TD_Hypergrid .= '</div>';

                if ($cpt == 3)
                {
                    echo $TD_Hypergrid;
                    $cpt = 0;
                }

                else
                {
                    echo $TD_Hypergrid;
                    $cpt++;
                }
            }
            echo '</div>';
        }
    }
    mysql_close();	
	
}
?>
