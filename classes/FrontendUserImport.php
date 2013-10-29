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
 

/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


class FrontendUserImport extends \Backend
{

	protected $blnSave = true;
	
	
	/**
	 * Import
	 */
	public function importMembers(DataContainer $dc)
	{
		if (\Input::get('key') != 'frontenduserimport')
		{
			return '';
		}
		
		$this->Template = new BackendTemplate('be_frontenduserimport');
		$this->Template->hrefBack = ampersand(str_replace('&key=frontenduserimport', '', \Environment::get('request')));
		$this->Template->goBack = $GLOBALS['TL_LANG']['MSC']['goBack'];
		$this->Template->headline = $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'];
		$this->Template->request = ampersand(\Environment::get('request'), ENCODE_AMPERSANDS);
		$this->Template->submit = specialchars($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'][0]);
		$this->Template->documentation_headline = specialchars($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'][0]);
		$this->Template->documentation = $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'][1];
		$this->Template->csvSource = $this->getFileTreeWidget();
		$this->Template->csvSource_headline = $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'][0];
		$this->Template->csvSource_help = $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'][1];
		$this->Template->isMemberlistInstalled = $this->checkForMemberList();
		$this->Template->options_headline = $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['options_headline'];
		
		$_SESSION['TL_MEMBERIMPORT'] = '';
	
		if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport' && $this->blnSave)
		{
			$csvFile = \FilesModel::findOneById($this->Template->csvSource->value);
			
			if ($csvFile)
			{				
				$objFile = new \File($csvFile->path, true);
				$arrFileContent = $objFile->getContentAsArray();
				
				foreach ($arrFileContent as $line)
				{
					$arrData = explode(";", $line);
					$this->ImportProcess($arrData, \Input::post('newsletter'), \Input::post('usergroup'), \Input::post('publicFields'));
				}

				if($_SESSION['TL_MEMBERIMPORT'] > 0 && $_SESSION['TL_MEMBERIMPORT'] != null)
				{
					$_SESSION['TL_CONFIRM'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'], $_SESSION['TL_MEMBERIMPORT']);
				}
				else
				{
					$_SESSION['TL_INFO'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'], $_SESSION['TL_MEMBERIMPORT']);
				}
				
				setcookie('BE_PAGE_OFFSET', 0, 0, '/');
				$this->reload();			
			}
			else
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}
		}
		
		if(!$this->checkForMemberList())
		{
			\Message::addError('Please install the memberlist extension.');
		}
		
		$arrFields['newsletter'] = array
		(
			'name'				=> 'newsletter',
			'label'				=> &$GLOBALS['TL_LANG']['tl_member']['newsletter'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'foreignKey'		=> 'tl_newsletter_channel.title',
			'eval'				=> array('multiple'=>true, 'feEditable'=>true, 'feGroup'=>'newsletter')
		);

		$arrFields['group_field'] = array
		(
			'name'				=> 'usergroup',
			'label'				=> &$GLOBALS['TL_LANG']['tl_member']['groups'],
			'exclude'			=> true,
			'filter'			=> true,
			'inputType'			=> 'checkbox',
			'foreignKey'		=> 'tl_member_group.name',
			'eval'				=> array('multiple'=>true)
		);

		if($this->checkForMemberList())
		{
			$arrFields['publicFields'] = array
			(
				'name'				 => 'publicFields',
				'label'              => &$GLOBALS['TL_LANG']['tl_member']['publicFields'],
				'exclude'            => true,
				'inputType'          => 'checkbox',
				'options_callback'   => array('tl_member_memberlist', 'getViewableMemberProperties'),
				'eval'               => array('multiple'=>true, 'feEditable'=>true, 'feGroup'=>'profile', 'tl_class'=>'w50')
			);
		}

		$arrWidgets = array();

		foreach ($arrFields as $arrField)
		{
			$strClass = $GLOBALS['TL_FFL'][$arrField['inputType']];

			if (!class_exists($strClass))
			{
				continue;
			}

			$arrField['eval']['required'] = $arrField['eval']['mandatory'];
			$objWidget = new $strClass($strClass::getAttributesFromDca($arrField, $arrField['name'], $arrField['value']));

			// Validate the widget
			if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport')
			{
				$objWidget->validate();

				if ($objWidget->hasErrors())
				{
					$doNotSubmit = true;
				}
			}
			
			$arrWidgets[$arrField['name']] = $objWidget;
		}

		$checkbox_container_panel = '';
		foreach ($arrWidgets as $objWidget)
		{
			$checkbox_container_panel .= '<div class="widget">';
			$checkbox_container_panel .= ($objWidget instanceof FormCaptcha) ? $objWidget->generateQuestion() : $objWidget->generateLabel();
			$checkbox_container_panel .= $objWidget->generateWithError();
			$checkbox_container_panel .= '</div><br/>';
		}
		
		$this->Template->checkbox_container = $checkbox_container_panel;
		
		return $this->Template->parse();
	}


	/**
	 * Search member by email
	 */
	private function searchEmail($strEmail)
	{
		$objMember = \MemberModel::findByEmail($strEmail);
		
		if ($objMember !== null)
		{
			return true;
		}
		
		return false;
	}


	/**
	 * Import process
	 */
	private function ImportProcess($data, $newsletter, $group, $publicFields)
	{
		if($data[13] != null && $data[1] != '')
		{
			if($this->searchEmail($data[13]) == false)
			{
				$this->createNewUser($data, $publicFields);

				$userImportSession = $_SESSION['TL_MEMBERIMPORT'];
				$userImportSession++;
				$_SESSION['TL_MEMBERIMPORT'] = $userImportSession;
			}

			$this->SetNewsletter($data[13], $newsletter);
			$this->SetGroup($data[13], $group);
		}
		else
		{
			$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'][0], $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'][1]);
		}
	}


	/**
	 * Create new member
	 */
	public function createNewUser($data, $publicFields)
	{
		$member = new \MemberModel();
		$member->tstamp = time();
		$member->createdOn = time();
		$member->dateAdded = time();
		$member->firstname = $data[0];
		$member->lastname = $data[1];
		$member->dateOfBirth = $data[2];
		$member->gender = $data[3];
		$member->company = $data[4];
		$member->street = $data[5];
		$member->postal = $data[6];
		$member->city = $data[7];
		$member->state = $data[8];
		$member->country = $data[9];
		$member->phone = $data[10];
		$member->mobile = $data[11];
		$member->fax = $data[12];
		$member->email = $data[13];
		$member->website = $data[14];
		$member->language = $data[15];
		$member->publicFields = serialize($publicFields);
		
		if($data[16] != '' && $data[17] != '')
		{
			$member->username = $data[16];
			$member->password = $this->setPassword($data[17]);
			$member->login = 1;
		}
		
		$member->save();
	}


	/**
	 * Newsletter-Eintrag wird gesetzt
	 */
	private function SetNewsletter($strEmail, $arrNewsletter)
	{	
		if(empty($arrNewsletter))
			return;
	
		if (!is_array($arrNewsletter))
		{
			$this->setNewsletterRecipient($arrNewsletter, $strEmail);
		}
		else
		{
			foreach ($arrNewsletter as $intNewsletter)
			{
				if ($intNewsletter < 1)
				{
					continue;
				}
	
				if($this->SearchEmailInNewsletter($strEmail, intval($intNewsletter)) == false)
				{
					$this->setNewsletterRecipient($intNewsletter, $strEmail);
				}
			}	
		}
	}
	
	
	private function setNewsletterRecipient($intNewsletter, $strEmail)
	{
		$this->Database->prepare("INSERT INTO tl_newsletter_recipients SET pid=?, tstamp=?, email=?, active=1")->execute(intval($intNewsletter), time(), $strEmail);
	}


	/**
	 * E-Mail wird in tl_newsletter gesucht
	 */
	private function SearchEmailInNewsletter($email, $newsletterId)
	{
		$objUser = $this->Database->prepare("SELECT * FROM tl_newsletter_recipients WHERE email=? AND pid=?")->limit(1)->execute($email, intval($newsletterId));

		if ($objUser->numRows < 1)
			return false;

		return true;
	}


	/**
	 * Gruppen werden gesetzt
	 */
	private function SetGroup($email, $groups)
	{
		try
		{
			$objGroups = $this->Database->prepare("SELECT groups FROM tl_member WHERE email=? ")->execute($email);

			$groupArr = unserialize($objGroups->groups);

			if ($groupArr == false)
			{
				$this->Database->prepare("UPDATE tl_member SET groups=? WHERE email=?")->execute(serialize($groups), $email);
			}
			else
			{
				$groupArr = array_merge($groupArr, $groups);
				
				$this->Database->prepare("UPDATE tl_member SET groups=? WHERE email=?")->execute(serialize($groupArr), $email);
			}
		}
		catch (Exception $ex)
		{
			print $email."<br>";
		}
	}
	
	
	/**
	 * Set password
	 */
	private function setPassword($strPassword)
	{
		$strSalt = substr(md5(uniqid('', true)), 0, 23);

		return sha1($strSalt . $strPassword) . ':' . $strSalt;
	}
	
	
	/**
	 * Check for memberlist extension
	 */
	private function checkForMemberList()
	{
		foreach($this->Config->getActiveModules() as $moduleKey => $moduleName)
		{
			if($moduleName == 'memberlist')
				return true;
		}

		return false;
	}

		
	/**
	 * Return the file tree widget as object
	 */
	protected function getFileTreeWidget($value=null)
	{	
		$widget = new \FileTree();

		$widget->id = 'source';
		$widget->name = 'source';
		$widget->strTable = 'tl_member';
		$widget->strField = 'source';
		
		$widget->value = $value;
		
		$widget->label = $GLOBALS['TL_LANG']['tl_member']['source'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member']['source'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member']['source'][1];
		}

		if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport')
		{
			$widget->validate();

			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}

		return $widget;
	}
}
