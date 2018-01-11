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
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
    'numero2\GroupDownloads',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
    // Elements
    'numero2\GroupDownloads\ContentGroupDownloads' => 'system/modules/group_downloads/elements/ContentGroupDownloads.php'
));