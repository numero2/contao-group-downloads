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
 * Add palettes to tl_member_group
 */
$GLOBALS['TL_DCA']['tl_member_group']['palettes']['default'] = str_replace(
    'redirect;'
,   'redirect;{homedir_legend:hide},assignDir;'
,   $GLOBALS['TL_DCA']['tl_member_group']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_member_group']['palettes']['__selector__'][] = 'assignDir';
$GLOBALS['TL_DCA']['tl_member_group']['subpalettes']['assignDir'] = 'homeDir';


/**
 * Add fields to tl_member_group
 */
$GLOBALS['TL_DCA']['tl_member_group']['fields']['assignDir'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_member_group']['assignDir']
,   'exclude'   => true
,   'inputType' => 'checkbox'
,   'eval'      => array('submitOnChange'=>true)
,   'sql'       => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_member_group']['fields']['homeDir'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_member_group']['homeDir']
,   'exclude'   => true
,   'inputType' => 'fileTree'
,   'eval'      => array('fieldType'=>'radio', 'tl_class'=>'clr')
,   'sql'       => "binary(16) NULL"
);