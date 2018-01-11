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
 * Add palettes to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['downloads'] = str_replace(
    'useHomeDir'
,   'useHomeDir,useGroupDir'
,   $GLOBALS['TL_DCA']['tl_content']['palettes']['downloads']
);


/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['useGroupDir'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['useGroupDir']
,   'exclude'   => true
,   'inputType' => 'checkbox'
,   'eval'      => array('tl_class'=>'w50')
,   'sql'       => "char(1) NOT NULL default ''"
);