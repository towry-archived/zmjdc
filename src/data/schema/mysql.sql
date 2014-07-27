-- -------------------------------------------------
-- 
-- User table
--

CREATE TABLE `t_users` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`name` varchar(32) default NULL,
	`password` varchar(64) default NULL,
	`email` varchar(200) default NULL,
	`fakename` varchar(32) default NULL,
	`created` int(10) NOT NULL,
	`activated` int(10) unsigned default '0',
	`acl` int(10) default '0',
	`authCode` varchar(64) default NULL,
	`authKey` varchar(64) default NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name` (`name`),
	UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ------------------------------------------------
--
-- Word table
--

CREATE TABLE `t_words` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`word` varchar(64) NOT NULL,
	`updated` int(10) default '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ------------------------------------------------
--
-- Memory
--

CREATE TABLE `t_memory` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`wid` int(10) unsigned NOT NULL,
	`uid` int(10) unsigned default '0',
	`how` text,
	`updated` int(10) unsigned default '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- -------------------------------------------------
--
-- popular
--
CREATE TABLE `t_vote` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`mid` int(10) unsigned NOT NULL,
	`uid` int(10) unsigned NOT NULL,
	`vote` tinyint(1),
	`updated` int(10) unsigned default '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------------------------------
-- ignore
--
CREATE TABLE `t_ignore` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`uid` int(10) unsigned NOT NULL,
	`wid` int(10) unsigned NOT NULL,
	`updated` int(10) unsigned default '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
--
--
CREATE TABLE `t_mlist` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`uid` int(10) unsigned NOT NULL,
	`mid` int(10) unsigned NOT NULL,
	`updated` int(10) unsigned default '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
-- Logs
-- 
CREATE TABLE `logs` (
	`id` int(10) unsigned NOT NULL auto_increment,
	`ctype` varchar(32) NOT NULL,
	`target` varchar(32) NOT NULL,
	`msg` text,
	`updated` int(10) unsigned default '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

