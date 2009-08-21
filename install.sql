CREATE TABLE IF NOT EXISTS `jos_configurator` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `template_name` varchar(255) NOT NULL,
  `param_name` varchar(64) NOT NULL,
  `param_value` varchar(256) default NULL,
  `source` varchar(64) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `template_name` (`template_name`)
) ENGINE=MyISAM;