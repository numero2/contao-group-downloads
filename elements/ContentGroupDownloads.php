<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @package   Group Downloads
 * @author    Benny Born <benny.born@numero2.de>
 * @license   LGPL
 * @copyright 2018 numero2 - Agentur für digitales Marketing GbR
 */


/**
 * Namespace
 */
namespace numero2\GroupDownloads;


class ContentGroupDownloads extends \ContentDownloads {


    /**
     * Return if there are no files
     *
     * @return string
     */
    public function generate() {

        $this->multiSRC = deserialize($this->multiSRC);

        // Use the home directory of the current users groups as file source
        if( $this->useGroupDir && FE_USER_LOGGED_IN ) {

            $this->import('FrontendUser', 'User');

            if( count($this->User->groups) ) {

                $aSources = array();

                foreach( $this->User->groups as $groupID ) {

                    $oGroup = NULL;
                    $oGroup = \MemberGroupModel::findById( $groupID );

                    if( !empty($oGroup->homeDir) ) {
                        $aSources[] = $oGroup->homeDir;
                    }
                }

                $this->multiSRC = $aSources;
            }
        }

        // Return if there are no files
        if( !is_array($this->multiSRC) || empty($this->multiSRC) ) {
            return '';
        }

        // Get the file entries from the database
        $this->objFiles = \FilesModel::findMultipleByUuids($this->multiSRC);

        if( $this->objFiles === null ) {

            if( !\Validator::isUuid($this->multiSRC[0]) ) {
                return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
            }

            return '';
        }

        $file = \Input::get('file', true);

        // Send the file to the browser and do not send a 404 header (see #4632)
        if( $file != '' && !preg_match('/^meta(_[a-z]{2})?\.txt$/', basename($file)) ) {

            while( $this->objFiles->next() ) {

                if( $file == $this->objFiles->path || dirname($file) == $this->objFiles->path ) {
                    \Controller::sendFileToBrowser($file);
                }
            }

            $this->objFiles->reset();
        }

        return parent::generate();
    }
}