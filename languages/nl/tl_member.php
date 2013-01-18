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


$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'] = array('Bron', 'Kies een CSV-bestand.');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'] = array('Importeer lid', 'Importeer leden uit een CSV-bestand');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'] =  array('Instructie', 'Door het importeren van leden worden deze, voor zover nog niet aanwezig zijn, aangemaakt.<br/><br/>Door een nieuwsbrief te selecteren wordt het lid hieraan toegevoegd. Indien het lid al is toegewezen aan een nieuwsbrief, wordt deze <u>niet</u> verwijderd of gedupliceerd.<br><br>Middels het selecteren van ledengroepen voegt u de geimporteerde leden aan deze groepen toe. Indien het lid al is toegewezen aan een ledengroep, wordt deze <u>niet</u> verwijderd of gedupliceerd. De geselecteerde ledengroepen worden aangevuld.<br><br><b>Bestandslayout</b><br>voornaam;achternaam;geboortedatum (huidige datumopmaak in TL);geslacht;bedrijf;straat;postcode;plaats;staat;land (iso - bijv. nl);telefoon;mobiel;fax;email;website;taal(iso - bijv. nl);gebruikersnaam (optioneel);wachtwoord (optioneel)');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'] = '%s leden zijn geimporteerd.';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'] = 'Importeer lid';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'] = array('Leden konden niet worden geimporteerd. Fout: e-mail en achternaam mag niet leeg zijn.', '');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'] = 'Geen leden toegevoegd.'

?>