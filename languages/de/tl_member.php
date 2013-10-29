<?php

/**
 * FrontendUserImport
 * 
 * Copyright (C) 2008-2013 Christian Barkowsky
 * 
 * @package FrontendUserImport
 * @author  Christian Barkowsky <http://christianbarkowsky.de>
 * @license LGPL
 */


$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'] = array('Quelldateien', 'Bitte wählen Sie die CSV-Dateien, die Sie importieren möchten.');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'] = array('Mitglieder importieren', 'Mitglieder aus einer CSV Datei importieren');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'] =  array('Anleitung', 'Durch den Import von Mitglieder werden diese, sofern diese noch nicht vorhaden sind, erstellt.<br/><br/>Durch die Auswahl von Newslettern wird das Mitglieder diesen zugeordnet. Sollen vorher dem Mitglieder Newsletter zugeordnet worden sein, werden diese <u>nicht</u> gelöscht bzw. gedoppelt.<br><br>Durch die Auswahl von Mitgliedergruppen wird der Mitglieder diesen zugeordnet. Sollen dem Mitglieder schon Mitgliedergruppen zugeordnet sein, werden diese <u>nicht</u> gelöscht bzw. gedoppelt. Die ausgewählten Mitgliedergruppen werden ergänzt.<br><br><b>Dateimuster</b><br>firstname;lastname;dateOfBirth (current date format);gender;company;street;postal;city;state;country (iso - e.g. de);phone;mobile;fax;email;website;language(iso - e.g. de);username (optional);password (optional)');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'] = '%s Mitglieder wurden importiert.';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'] = 'Mitglieder importieren';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'] = array('Es könnten nicht alle Mitglieder importiert werden. Fehler: E-Mail und Nachname dürfen nicht leer sein.', '');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'] = 'Es wurde kein Mitglied hinzugefügt.';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['options_headline'] = 'Optionen';
