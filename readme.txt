@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ 
Configuration requise pour OpenSim Manager Web (OSMW):
	--  Apache ou xampp ou wampp ou ngnix / Mysql 
Fonctionnement:
	-- OSMW envoi des commandes au simulateur via Remote Admin 
	-- Certains fichiers doivent avoir les droits 777 pour pouvoir etre modifier par OSMW (LINUX)
	
	-- ATTENTION aux droits d'accés aux fichiers et le format des données saisie dans vos fichiers INI 
		ex: pour remote admin pas de guillemt
		
		--> Régions.ini (droits écriture) / OpensimDefaults.ini , etc.. qui doivent etre accessible
Pour Windows:
------------
		--> pas de soucis
Pour Linux:
------------
		--> ATTENTION aux droits d'ecritures
		
Gestion des Utilisateurs:
	=> 5 Niveaux d'accés sont autorisés
	-- Administrateurs 
	-- Gestionnaires de sauvegardes
	-- Invités / Compte privé par moteur
	-- 1 compte root (super admin)
	
@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

******************************************
********* Suivi de versions **********
******************************************
-------------------------------------------------------
*** V 5.5 ***
/* NEWS 2015 by Nino85 Whitman */
-- Cleanup Code
-- Fix bugs


-------------------------------------------------------
*** V 5.0 ***
/* NEWS 2015 by djphil */
-- Cleanup Code
-- Fix bugs
-- Add Themes
-- Add bootstrap
-- Add Multilanguage
-- Add Google Recaptcha v2.0
-- Add Navbar
-- Add more actions, options, infos, ...
And more ...
-------------------------------------------------------

-------------------------------------------------------
*** V 4 Beta *** En cours
-- Mise à jours des SESSION
-- Systeme d'installation intégrés **
-- ...
-------------------------------------------------------
*** V 3.2 Final ***
-- Gestion des sauvegardes de la config des moteurs Opensim et pour chaque sim
-- Transfert des fichiers de sauvagardes vers un serveur FTP exterieur
-- Detection des fichiers de config moteurs
-------------------------------------------------------
*** V 3.0 *** MISE A JOUR MAJEUR ***
-- OSMW à sa propre base de donnée *** Nouveauté
-- Les Fichiers de config , conf moteurs et users sont en BDD ( prb de sécurité !)
-- Compte Utilisateur filtré au niveau des moteurs (choix du moteur) *** Nouveauté
-- Verifier/ Modifier/ configurer vos INIs, opensim, grid, ... *** Nouveauté
-- Connectivité AdmOSMW (Referencement sur le site Fgagod.net) 
-------------------------------------------------------
*** V 2.0 ***
-- Optimisations du code
-------------------------------------------------------
*** V 1.1 ***
-- Refonte complete de l'interface
-- Système d'installation simplifié
-- Gestion des moteurs OpenSim, des utilisateurs et de la config en .INI
-- ...
--------------------------------------------------------
*** V 1.0 ***
-- Ajout de la gestion multi-Utilisateurs dans OSMW
--------------------------------------------------------
*** V0.9.11 ***
-- Authentification multi-users via fichier texte  (pas encore intégrer à OSMW)
--------------------------------------------------------
*** V0.7.11 ***
-- Ajouts de Fonctionnaltées;
	-- Cartographie ajouté
	-- TOUS demarrer et arreter d'une seule fois
	-- Une serie de tests pour voir si tous fonctionne bien
	-- Ce fichier LOL
-- Optimisations du code
--------------------------------------------------------
*** V0.6.11 ***
-- Premiere version de OSWebManager