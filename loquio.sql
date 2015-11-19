-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: 62.149.150.59
-- Generato il: Ago 02, 2014 alle 12:21
-- Versione del server: 5.0.92
-- Versione PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Sql150902_5`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `bookoff`
--

CREATE TABLE IF NOT EXISTS `bookoff` (
  `bookoffid` int(11) NOT NULL auto_increment,
  `did` int(11) NOT NULL,
  `datefrom` int(20) NOT NULL,
  `dateto` int(20) NOT NULL,
  PRIMARY KEY  (`bookoffid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `docenti`
--

CREATE TABLE IF NOT EXISTS `docenti` (
  `did` int(11) NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `mid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `giorniliberi` text NOT NULL,
  `orelibere` text NOT NULL,
  `attivo` int(11) NOT NULL,
  PRIMARY KEY  (`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `materie`
--

CREATE TABLE IF NOT EXISTS `materie` (
  `mid` int(11) NOT NULL auto_increment,
  `nome` varchar(255) NOT NULL,
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE IF NOT EXISTS `prenotazioni` (
  `pid` int(11) NOT NULL auto_increment,
  `creata` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `data` int(25) NOT NULL,
  `did` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `classe` text NOT NULL,
  `studente` text NOT NULL,
  `email` text NOT NULL,
  `tel` text NOT NULL,
  `codicecanc` text NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE IF NOT EXISTS `utenti` (
  `uid` int(11) NOT NULL auto_increment,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cognome` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `altramail` varchar(255) NOT NULL,
  `acl` int(11) NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`uid`, `email`, `pass`, `nome`, `cognome`, `telefono`, `altramail`, `acl`) VALUES
(1, 'admin@loquio.it', '098f6bcd4621d373cade4e832627b4f6', 'Amministratore', 'Loquio', '', 'info@retinavision.it', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Struttura della tabella `pomeridiani`
--

CREATE TABLE IF NOT EXISTS `pomeridiani` (
  `pomid` int(10) NOT NULL AUTO_INCREMENT,
  `cognome` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `classe` varchar(4) NOT NULL,
  `did` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  PRIMARY KEY (`pomid`),
  UNIQUE KEY `cognome` (`cognome`,`nome`,`classe`,`did`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

