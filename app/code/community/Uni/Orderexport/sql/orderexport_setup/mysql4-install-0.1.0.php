<?php

/**
 * Unicode Systems
 * @category   Uni
 * @package    Uni_Orderexport
 * @copyright  Copyright (c) 2014-2015 Unicode Systems. (http://www.unicodesystems.in)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('exporthistory')};
CREATE TABLE {$this->getTable('exporthistory')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `profile` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `filename` varchar(255) NOT NULL default '',
  `destination` varchar(255) NOT NULL default '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();
