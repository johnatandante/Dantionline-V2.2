# MySQL-Front Dump 2.5
#
# Host: localhost   Database: db_sitov2_2
# --------------------------------------------------------
# Server version 3.23.47-nt


#
# Table structure for table 'accessi'
#

CREATE TABLE accessi (
  id varchar(25) NOT NULL default '',
  ip_address varchar(100) default NULL,
  browser varchar(100) default NULL,
  data date default NULL,
  ora varchar(11) default NULL,
  nome varchar(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='tabella per tener conto degli accessi';



#
# Table structure for table 'album'
#

CREATE TABLE album (
  id varchar(25) NOT NULL default '',
  gruppo varchar(31) default NULL,
  album varchar(63) default NULL,
  file varchar(255) default NULL,
  canzoni text,
  anno year(4) default NULL,
  supporto char(3) default NULL,
  extra varchar(127) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='database per tener sotto controllo i miei mp3';



#
# Table structure for table 'articoli'
#

CREATE TABLE articoli (
  id varchar(25) NOT NULL default '',
  data date default NULL,
  classe varchar(15) default NULL,
  cartella varchar(15) default NULL,
  titolo varchar(127) default NULL,
  file varchar(255) default NULL,
  link varchar(127) default NULL,
  articolo text,
  autore varchar(15) default NULL,
  extra varchar(127) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='tabella per la gestione dei profili personali, tipo blog';



#
# Table structure for table 'classi'
#

CREATE TABLE classi (
  classe varchar(15) NOT NULL default '',
  livello int(10) unsigned default NULL,
  PRIMARY KEY  (classe)
) TYPE=MyISAM COMMENT='per tener conto delle classi di utente';



#
# Table structure for table 'docs'
#

CREATE TABLE docs (
  id varchar(25) NOT NULL default '',
  file varchar(255) default NULL,
  cartella varchar(63) NOT NULL default '-home-',
  commento varchar(50) default NULL,
  classe varchar(15) default NULL,
  nome varchar(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='per la gestione dei documenti';



#
# Table structure for table 'downloads'
#

CREATE TABLE downloads (
  id varchar(25) NOT NULL default '',
  data date default NULL,
  classe varchar(15) default NULL,
  categoria varchar(127) default NULL,
  link varchar(127) default NULL,
  descrizione text,
  autore varchar(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;



#
# Table structure for table 'gruppi'
#

CREATE TABLE gruppi (
  nome varchar(63) NOT NULL default '',
  genere varchar(31) default NULL,
  file varchar(255) default NULL,
  bio text,
  extra varchar(63) default NULL,
  PRIMARY KEY  (nome)
) TYPE=MyISAM COMMENT='Tabella per i gruppi musicali';



#
# Table structure for table 'guestbook'
#

CREATE TABLE guestbook (
  id varchar(25) NOT NULL default '',
  data date default NULL,
  ip varchar(15) default NULL,
  visitatore varchar(15) default NULL,
  sitoweb varchar(255) default NULL,
  mail varchar(127) default NULL,
  luogo varchar(127) default NULL,
  messaggio text,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='tabella per la gestione del guestbook';



#
# Table structure for table 'mail'
#

CREATE TABLE mail (
  id varchar(25) NOT NULL default '',
  data date default NULL,
  mittente varchar(15) default NULL,
  destinatario varchar(15) default NULL,
  messaggio text,
  nuovo char(2) default 'sì',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='messaggistica interna per gli utenti';



#
# Table structure for table 'news'
#

CREATE TABLE news (
  id varchar(25) NOT NULL default '',
  data date default NULL,
  messaggio text,
  nome varchar(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='tabella per le news del sito';



#
# Table structure for table 'utenti'
#

CREATE TABLE utenti (
  nome varchar(15) NOT NULL default '',
  descrizione text,
  classe varchar(15) NOT NULL default '',
  mail varchar(127) default NULL,
  sitoweb varchar(127) default NULL,
  password varchar(63) default NULL,
  foto varchar(255) default NULL,
  commento text,
  last_login date default NULL,
  PRIMARY KEY  (nome)
) TYPE=MyISAM COMMENT='tabella per il monitoraggio degli utenti iscritti al sito';

