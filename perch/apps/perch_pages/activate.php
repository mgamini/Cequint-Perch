<?php
    // Prevent running directly:
    if (!defined('PERCH_DB_PREFIX')) exit;

    // Let's go
    $sql = "
    CREATE TABLE IF NOT EXISTS `__PREFIX__pages` (
      `pageID` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `pagePath` varchar(255) NOT NULL DEFAULT '/',
      `pageTitle` varchar(255) NOT NULL DEFAULT 'Untitled Page',
      `pageNew` tinyint(1) unsigned NOT NULL DEFAULT '1',
      `navgroupID` int(10) unsigned NOT NULL DEFAULT '1',
      `templateID` int(10) unsigned NOT NULL DEFAULT '1',
      `pageSection` varchar(255) NOT NULL DEFAULT '',
      `pageImported` tinyint(1) unsigned NOT NULL DEFAULT '0',
      `pageOrder` varchar(64) DEFAULT NULL,
      `pageDepth` int(10) unsigned NOT NULL DEFAULT '0',
      PRIMARY KEY (`pageID`),
      KEY `idx_nav` (`navgroupID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    CREATE TABLE IF NOT EXISTS `__PREFIX__pages_navgroups` (
      `navgroupID` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `navgroupTitle` varchar(255) NOT NULL DEFAULT 'Untitled',
      `navgroupSlug` varchar(255) NOT NULL DEFAULT 'untitled',
      PRIMARY KEY (`navgroupID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    CREATE TABLE IF NOT EXISTS `__PREFIX__pages_templates` (
      `templateID` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `templateTitle` varchar(255) NOT NULL DEFAULT '',
      `templatePath` varchar(255) NOT NULL DEFAULT '',
      `optionsPageID` int(10) unsigned NOT NULL,
      `templateReference` tinyint(1) unsigned NOT NULL DEFAULT '1',
      PRIMARY KEY (`templateID`)
    ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    INSERT INTO `__PREFIX__pages_navgroups` (`navgroupID`,`navgroupTitle`,`navgroupSlug`)
    VALUES (1,'Default','default');";
    
    $sql = str_replace('__PREFIX__', PERCH_DB_PREFIX, $sql);
    
    $statements = explode(';', $sql);
    foreach($statements as $statement) {
        $statement = trim($statement);
        if ($statement!='') $this->db->execute($statement);
    }
        
    $sql = 'SHOW TABLES LIKE "'.$this->table.'"';
    $result = $this->db->get_value($sql);
    
    return $result;
?>