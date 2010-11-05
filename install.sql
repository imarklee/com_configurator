CREATE TABLE IF NOT EXISTS `#__configurator` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `template_name` varchar(255) NOT NULL,
  `param_name` varchar(64) NOT NULL,
  `param_value` varchar(256) default NULL,
  `source` varchar(64) default NULL,
  `published` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `template_name` (`template_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__configurator_preferences` (
  `id` int(4) NOT NULL auto_increment,
  `pref_name` varchar(64) NOT NULL,
  `pref_value` varchar(264) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__configurator_usertable` (
  `id` int(4) NOT NULL auto_increment,
  `user_name` varchar(64) NOT NULL,
  `member_id` varchar(64) NOT NULL,
  `member_name` varchar(264) NOT NULL,
  `member_surname` varchar(264) NOT NULL,
  `member_email` varchar(264) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__configurator_customfiles` (
  `id` int(4) NOT NULL auto_increment,
  `type` varchar(255) NOT NULL,
  `parent_name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `contents` longtext NOT NULL,
  `last_edited` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO `#__configurator_customfiles` VALUES (1, 'template', 'morph', 'error.php', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">\r\n<head>\r\n	<title><?php echo $this->error->code ?> - <?php echo $this->title; ?></title>\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/morph/core/css/error.css" type="text/css" />\r\n	<script src="<?php echo $this->baseurl; ?>/templates/morph/core/js/jquery.js" language="javascript" type="text/javascript"></script>\r\n	<script src="<?php echo $this->baseurl; ?>/templates/morph/core/js/corners.js" language="javascript" type="text/javascript"></script>\r\n	<script type="text/javascript">\r\n      $(document).ready(function() {\r\n		$(''#morph'').corners("10px");\r\n		$(''#morph h1'').corners("10px top");\r\n      });\r\n    </script>\r\n</head>\r\n<body>\r\n	<div id="morph">\r\n			<h1 id="errorboxheader"><?php echo JText::_(''Houston, we have a problem!''); ?> (<?php echo $this->error->code ?>)</h1>\r\n			<p><strong><?php echo JText::_(''You may not be able to visit this page because of:''); ?></strong></p>\r\n				<ol>\r\n					<li><?php echo JText::_(''An out-of-date bookmark/favourite''); ?></li>\r\n					<li><?php echo JText::_(''A search engine that has an out-of-date listing for this site''); ?></li>\r\n					<li><?php echo JText::_(''A mis-typed address''); ?></li>\r\n					<li><?php echo JText::_(''You have no access to this page''); ?></li>\r\n					<li><?php echo JText::_(''The requested resource was not found''); ?></li>\r\n					<li><?php echo JText::_(''An error has occurred while processing your request.''); ?></li>\r\n				</ol>\r\n			<p><strong><?php echo JText::_(''Please try one of the following pages:''); ?></strong></p>\r\n			<p>\r\n				<ul>\r\n					<li><a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_(''Go to the home page''); ?>"><?php echo JText::_(''Home Page''); ?></a></li>\r\n				</ul>\r\n			</p>\r\n			<p><?php echo JText::_(''If difficulties persist, please contact the system administrator of this site.''); ?></p>\r\n\r\n			<div id="techinfo">\r\n			<p><?php echo $this->error->message; ?></p>\r\n				<?php if($this->debug) : ?>\r\n					<p><?php echo $this->renderBacktrace(); ?></p>\r\n				<?php endif; ?>\r\n			</div>\r\n	</div>\r\n</body>\r\n</html>', NOW());
INSERT IGNORE INTO `#__configurator_customfiles` VALUES (2, 'template', 'morph', 'component.php', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" id="printview">\r\n<head>\r\n	<jdoc:include type="head" />\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/print.css" type="text/css" />\r\n\r\n<?php if($this->direction == ''rtl'') : ?>\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template_rtl.css" type="text/css" />\r\n<?php endif; ?>\r\n</head>\r\n<body id="<?php echo $themelet; ?>">\r\n<div id="primary-content">\r\n	<jdoc:include type="message" />\r\n	<jdoc:include type="component" />\r\n</div>\r\n</body>\r\n</html>', NOW());
INSERT IGNORE INTO `#__configurator_customfiles` VALUES (3, 'template', 'morph', 'offline.php', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\r\n<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">\r\n<head>\r\n	<jdoc:include type="head" />\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/offline.css" type="text/css" />\r\n	<?php if($this->direction == ''rtl'') : ?>\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/offline_rtl.css" type="text/css" />\r\n	<?php endif; ?>\r\n	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />\r\n</head>\r\n<body>\r\n    <jdoc:include type="message" />\r\n	<div id="frame" class="outline">\r\n		<h1>\r\n			<?php echo $mainframe->getCfg(''sitename''); ?>\r\n		</h1>\r\n	<p>\r\n		<?php echo $mainframe->getCfg(''offline_message''); ?>\r\n	</p>\r\n	<?php if(JPluginHelper::isEnabled(''authentication'', ''openid'')) : ?>\r\n	<?php JHTML::_(''script'', ''openid.js''); ?>\r\n<?php endif; ?>\r\n	<form action="index.php" method="post" name="login" id="form-login">\r\n	<fieldset class="input">\r\n		<p id="form-login-username">\r\n			<label for="username"><?php echo JText::_(''Username'') ?></label><br />\r\n			<input name="username" id="username" type="text" class="inputbox" alt="<?php echo JText::_(''Username'') ?>" size="18" />\r\n		</p>\r\n		<p id="form-login-password">\r\n			<label for="passwd"><?php echo JText::_(''Password'') ?></label><br />\r\n			<input type="password" name="passwd" class="inputbox" size="18" alt="<?php echo JText::_(''Password'') ?>" id="passwd" />\r\n		</p>\r\n		<p id="form-login-remember">\r\n			<label for="remember"><?php echo JText::_(''Remember me'') ?></label>\r\n			<input type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_(''Remember me'') ?>" id="remember" />\r\n		</p>\r\n		<input type="submit" name="Submit" class="button" value="<?php echo JText::_(''LOGIN'') ?>" />\r\n	</fieldset>\r\n	<input type="hidden" name="option" value="com_user" />\r\n	<input type="hidden" name="task" value="login" />\r\n	<input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()) ?>" />\r\n	<?php echo JHTML::_( ''form.token'' ); ?>\r\n	</form>\r\n	</div>\r\n</body>\r\n</html>', NOW());

UPDATE `#__modules` INNER JOIN `#__templates_menu` AS `tpl` ON `tpl`.`template` = 'morph' SET `position` = 'masthead' WHERE `position` = 'top' AND `tpl`.`menuid` = 0;
UPDATE `#__modules` INNER JOIN `#__templates_menu` AS `tpl` ON `tpl`.`template` = 'morph' SET `position` = 'topshelf1' WHERE `position` = 'topshelf' AND `tpl`.`menuid` = 0;
UPDATE `#__modules` INNER JOIN `#__templates_menu` AS `tpl` ON `tpl`.`template` = 'morph' SET `position` = 'bottomshelf1' WHERE `position` = 'bottomshelf' AND `tpl`.`menuid` = 0; 