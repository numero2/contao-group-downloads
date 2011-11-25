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

 
/**
 * Table tl_member_group
 */
$GLOBALS['TL_DCA']['tl_member_group']['palettes']['default'] = str_replace(
    'redirect;'
,   'redirect;{homedir_legend:hide},assignDir;'
,   $GLOBALS['TL_DCA']['tl_member_group']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_member_group']['palettes']['__selector__'][] = 'assignDir';
$GLOBALS['TL_DCA']['tl_member_group']['subpalettes']['assignDir'] = 'homeDir';

$GLOBALS['TL_DCA']['tl_member_group']['fields']['assignDir'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_member_group']['assignDir']
,   'exclude'   => true
,   'inputType' => 'checkbox'
,   'eval'      => array('submitOnChange'=>true)
);

$GLOBALS['TL_DCA']['tl_member_group']['fields']['homeDir'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_member_group']['homeDir']
,   'exclude'   => true
,   'inputType' => 'fileTree'
,   'eval'      => array('fieldType'=>'radio', 'tl_class'=>'clr')
,   'save_callback' => array( array('tl_member_group_dir','createHomeDir') )
);


class tl_member_group_dir extends Backend {


	/**
	 * Creates the home directory for the group
	 */
    public function createHomeDir( $dirName, DataContainer $dc ) {
    
        if( !empty($dirName) ) {
        
            $strGroupDir = $dirName . '/'. 'group_' . $dc->id;
            
            if( !is_dir(TL_ROOT . '/' . $strGroupDir) ) {
                new Folder($strGroupDir);

                $this->Database->prepare("UPDATE tl_member_group SET homeDir=?, assignDir=1 WHERE id=?")
                               ->execute($strGroupDir, $dc->id);
            }
        }
    
        
        return $dirName;
    }
}

?>