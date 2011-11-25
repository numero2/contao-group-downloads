<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  2011 numero2 - Agentur für Internetdienstleistungen
 * @author     numero2 (http://www.numero2.de)
 * @package    groupdownloads
 * @license    LGPL
 */


class ContentDownloadsWithGroups extends ContentDownloads {


	/**
	 * Return if there are no files
	 * @return string
	 */
	public function generate()
	{
		$this->multiSRC = deserialize($this->multiSRC);

		// Use the home directory of the current user as file source
		if ($this->useHomeDir && FE_USER_LOGGED_IN)
		{
			$this->import('FrontendUser', 'User');
			
			if ($this->User->assignDir && is_dir(TL_ROOT . '/' . $this->User->homeDir))
			{
				$this->multiSRC = array($this->User->homeDir);
			}
		}
        
        // Add groups home directory as sources
        if( $this->useGroupDir && FE_USER_LOGGED_IN ) {
        
            $this->import('FrontendUser', 'User');

            if( count($this->User->groups) ) {
            
                $aSources = $this->multiSRC;
            
                foreach( $this->User->groups as $groupID ) {

                    $objGroup = $this->Database->prepare("SELECT * FROM tl_member_group WHERE id=?")
                                     ->execute($groupID);

                    $sGrpHomeDir = (string)$objGroup->homeDir;
                    
                    if( strlen($sGrpHomeDir) )
                        $aSources[] = $sGrpHomeDir;
                }
                
                $this->multiSRC = $aSources;

                #echo '<pre>'.print_r($aSources,1).'</pre>';
            }
        }

		// Return if there are no files
		if (!is_array($this->multiSRC) || count($this->multiSRC) < 1)
		{
			return '';
		}

		$file = $this->Input->get('file', true);

		// Send the file to the browser
		if ($file != '' && (in_array($file, $this->multiSRC) || in_array(dirname($file), $this->multiSRC)) && !preg_match('/^meta(_[a-z]{2})?\.txt$/', basename($file)))
		{
			$this->sendFileToBrowser($file);
		}

		return parent::generate();
	}
}

?>