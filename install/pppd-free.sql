CREATE TABLE IF NOT EXISTS fpppd (
  id int(11) NOT NULL auto_increment,
  email varchar(100) NOT NULL default '',
  country_code varchar(3) NOT NULL default '',
  country_name varchar(50) NOT NULL default '',
  city varchar(75) NOT NULL default '',
  region_code varchar(5) NOT NULL default '',
  region_name varchar(75) NOT NULL default '',
  item_number varchar(10) NOT NULL default '',
  mailed int(1) NOT NULL default '0',
  hash varchar(40) NOT NULL default '',
  download_expiration int(11) NOT NULL,
  time varchar(11) NOT NULL default '',  
  PRIMARY KEY (id)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS fitems (
  id int(11) NOT NULL auto_increment,
  item_number varchar(30) NOT NULL default '0',
  item_name varchar(128) NOT NULL default '',
  item_file varchar(256) NOT NULL default '',
  item_desc varchar(256) NOT NULL default '',
  PRIMARY KEY (id),
  UNIQUE KEY item_number (item_number)
) TYPE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
