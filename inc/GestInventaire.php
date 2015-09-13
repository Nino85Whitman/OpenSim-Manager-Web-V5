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

    echo '<h1>'.$osmw_index_4.'</h1>';
    echo '<div class="clearfix"></div>';
    //******************************************************
    //* Selon ACTION bouton => Envoi Commande via Remote Admin 
    //******************************************************
    if (isset($_POST['cmd']))
	{
		$RemotePort = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " port = ");
		$access_password2 = RecupRAdminParam_Opensim(INI_Conf_Moteur($_SESSION['opensim_select'], "address").$FichierINIOpensim, " access_password = ");
		
        $myRemoteAdmin = new RemoteAdmin(trim($hostnameSSH), trim($RemotePort), trim($access_password2));
		
		if ($_POST['cmd'] == 'Recuperer')
		{
            if (!empty($_POST['first']) && !empty($_POST['last']) && !empty($_POST['pass']))
            {
                $fullname = $_POST['first']." ".$_POST['last'];
                $parameters = array('command' => 'save iar '.$fullname.' / '.$_POST['pass'].' BackupIAR_'.$_POST['first'].'_'.$_POST['last'].'_'.date(d_m_Y_h).'.iar');
                $myRemoteAdmin->SendCommand('admin_console_command', $parameters);

                echo "<div class='alert alert-success alert-anim'>";
                echo "<i class='glyphicon glyphicon-ok'></i>";
                echo " ".$osmw_label_msg_inventaire1." <strong>".$fullname."</strong>, ".$osmw_label_msg_inventaire2." ...</div>";
            }
            
            else
            {
                echo "<div class='alert alert-danger alert-anim'>";
                echo "<i class='glyphicon glyphicon-remove'></i>";
                echo " <strong>Login</strong> or <strong>Password</strong> error ...</div>";
            }
		}  
	}

    //******************************************************
    //  Affichage page principale
    //******************************************************

	echo Select_Simulateur($_SESSION['opensim_select']);

    /* ************************************ */
	echo '<h4>Vos identifiants</h4>';
	echo '<form method="post" action="">';
    echo '<table class="table table-hover">';
    echo '<tr>';
    echo '<th>Firstname</th>';
    echo '<th>Lastname</th>';
    echo '<th>Password</th>';
    echo '<th>Action</th>';
    echo '</tr>';

	echo '<tr>';
	echo'<td><input class="form-control" type="text" name="first"></td>';
	echo'<td><input class="form-control" type="text" name="last"></td>';
	echo '<td><input class="form-control" type="password" name="pass"></td>';
	echo '<td>
			  <input type="hidden" value="" name="name_sim">
			  <button class="btn btn-success" type="submit" value="'.$osmw_btn_recuperer.'" name="cmd" '.$btnN1.'>
              <i class="glyphicon glyphicon-save"></i>  Save IAR</button>
		  </td>';
	echo '</tr>';
	echo '</table>';
	echo '</form>';

}
else {header('Location: index.php');}
?>
