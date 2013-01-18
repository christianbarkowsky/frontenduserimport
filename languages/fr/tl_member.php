<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * FrontendUserImport
 * 
 * Copyright (C) 2008-2013 Christian Barkowsky
 * 
 * @package FrontendUserImport
 * @author  Christian Barkowsky <http://www.christianbarkowsky.de>
 * @link    http://www.christianbarkowsky.de
 * @license LGPL
 */

 
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source']['0'] = "Source";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source']['1'] = "Veuillez choisir un fichier CSV.";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import']['0'] = "Importer les membres";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import']['1'] = "Importer les membres depuis un fichier CSV";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation']['0'] = "Marche à suivre";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation']['1'] = "Ce module permet d'importer les membres via un fichier csv. Vous pouvez attribuer des groupes de membres et des abonnement aux bulletins d'informations aux membres importés. <br /><br />Format du fichier CSV: prénom;nom;dateDeNaissance(format courant);genre;société;rue;codepostal;ville;etat;pays(code iso, ex: fr);téléphone;portable;fax;email;siteInternet;language(code iso, ex:fr);nomUtilisateur(optionnel);motDePasse(optionnel)";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'] = "%s membres ont été importés";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'] = "Importer les membres";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror']['0'] = "Aucun membre n'a pu être importé. Erreur : l'e-mail et le nom ne doivent pas être vide.";
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'] = "Aucun membre importé.";
 
?>
