/*
SQLyog Community Edition- MySQL GUI v8.14 
MySQL - 5.1.36-community : Database - openbama
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`openbama` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `openbama`;

/*Table structure for table `actions` */

DROP TABLE IF EXISTS `actions`;

CREATE TABLE `actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_type` varchar(255) DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `action_text` varchar(255) DEFAULT NULL,
  `how` varchar(255) DEFAULT NULL,
  `location` char(1) DEFAULT NULL,
  `vote_type` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `amendment_id` int(11) DEFAULT NULL,
  `roll_call_id` int(11) DEFAULT NULL,
  `roll_call_number` int(11) DEFAULT NULL,
  `alison_vote_id` int(11) DEFAULT NULL,
  `deleteddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_action_date` (`action_date`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_amendment_id` (`amendment_id`),
  KEY `IX_roll_call_id` (`roll_call_id`),
  KEY `IX_roll_call_number` (`roll_call_number`)
) ENGINE=MyISAM AUTO_INCREMENT=21651 DEFAULT CHARSET=latin1;

/*Table structure for table `addresses` */

DROP TABLE IF EXISTS `addresses`;

CREATE TABLE `addresses` (
  `address_type` varchar(50) DEFAULT NULL,
  `address_street` varchar(100) DEFAULT NULL,
  `address_city` varchar(100) DEFAULT NULL,
  `address_state` varchar(10) DEFAULT NULL,
  `address_zip` varchar(10) DEFAULT NULL,
  `phone1` varchar(25) DEFAULT NULL,
  `phone2` varchar(25) DEFAULT NULL,
  `fax1` varchar(25) DEFAULT NULL,
  `fax2` varchar(25) DEFAULT NULL,
  `toll_free` varchar(25) DEFAULT NULL,
  `ttyd` varchar(50) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  KEY `IX_person_id` (`person_id`),
  KEY `IX_candidate_id` (`candidate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bill_user_notes` */

DROP TABLE IF EXISTS `bill_user_notes`;

CREATE TABLE `bill_user_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `note` text,
  `user_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `bill_votes` */

DROP TABLE IF EXISTS `bill_votes`;

CREATE TABLE `bill_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `support` tinyint(1) DEFAULT NULL,
  `vote_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_user_id` (`user_id`),
  KEY `IX_vote_date` (`vote_date`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

/*Table structure for table `bills` */

DROP TABLE IF EXISTS `bills`;

CREATE TABLE `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_identifier` varchar(15) DEFAULT NULL,
  `bill_type` varchar(3) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `introduced` datetime DEFAULT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `last_action` int(11) DEFAULT NULL,
  `last_vote_date` datetime DEFAULT NULL,
  `last_vote_where` char(1) DEFAULT NULL,
  `last_vote_roll` int(11) DEFAULT NULL,
  `togovernor_date` datetime DEFAULT NULL,
  `description` text,
  `updated` datetime DEFAULT NULL,
  `last_action_date` datetime DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `current_alison_status` varchar(255) DEFAULT NULL,
  `current_committee_id` int(11) DEFAULT NULL,
  `disabled` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_sponsor_id` (`sponsor_id`),
  KEY `IX_current_committee_id` (`current_committee_id`),
  KEY `IX_last_action_date` (`last_action_date`),
  KEY `IX_last_vote_date` (`last_vote_date`),
  KEY `IX_introduced` (`introduced`),
  KEY `IX_session_identifier` (`session_identifier`),
  KEY `IX_bill_type_number_session` (`session_identifier`,`bill_type`,`number`),
  KEY `IX_bill_type` (`bill_type`)
) ENGINE=MyISAM AUTO_INCREMENT=2813 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_amendments` */

DROP TABLE IF EXISTS `bills_amendments`;

CREATE TABLE `bills_amendments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `amendmentidentifier` varchar(25) DEFAULT NULL,
  `amendmentdate` datetime DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_amendmentidentifier` (`amendmentidentifier`),
  KEY `IX_amendmentdate` (`amendmentdate`),
  KEY `IX_type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=679 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_committees` */

DROP TABLE IF EXISTS `bills_committees`;

CREATE TABLE `bills_committees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `committee_id` int(11) DEFAULT NULL,
  `activity` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_committee_id` (`committee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2803 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_cosponsors` */

DROP TABLE IF EXISTS `bills_cosponsors`;

CREATE TABLE `bills_cosponsors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `sponsor_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_person_id` (`person_id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_sponsor_date` (`sponsor_date`)
) ENGINE=MyISAM AUTO_INCREMENT=33306 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_relations` */

DROP TABLE IF EXISTS `bills_relations`;

CREATE TABLE `bills_relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relation` varchar(255) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `related_bill_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_related_bill_id` (`related_bill_id`),
  KEY `IX_bill_id_related_bill_id` (`bill_id`,`related_bill_id`)
) ENGINE=MyISAM AUTO_INCREMENT=396 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_subjects` */

DROP TABLE IF EXISTS `bills_subjects`;

CREATE TABLE `bills_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `dateadded` datetime DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_subject_id` (`subject_id`),
  KEY `IX_subject_id_bill_id` (`bill_id`,`subject_id`),
  KEY `IX_dateadded` (`dateadded`)
) ENGINE=MyISAM AUTO_INCREMENT=2967 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_tags` */

DROP TABLE IF EXISTS `bills_tags`;

CREATE TABLE `bills_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7015 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_text_nodes` */

DROP TABLE IF EXISTS `bills_text_nodes`;

CREATE TABLE `bills_text_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_text` varchar(255) DEFAULT NULL,
  `bills_text_versions_id` int(11) DEFAULT NULL,
  `bills_amendments_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bills_text_nodes_ix1` (`bills_text_versions_id`),
  KEY `bills_text_nodes_ix3` (`bills_amendments_id`),
  FULLTEXT KEY `bills_text_nodes_ix2` (`node_text`)
) ENGINE=MyISAM AUTO_INCREMENT=1407791 DEFAULT CHARSET=latin1;

/*Table structure for table `bills_text_versions` */

DROP TABLE IF EXISTS `bills_text_versions`;

CREATE TABLE `bills_text_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `version_type` varchar(5) DEFAULT NULL,
  `version_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_version_date` (`version_date`)
) ENGINE=MyISAM AUTO_INCREMENT=4147 DEFAULT CHARSET=latin1;

/*Table structure for table `comments` */

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comment` text,
  `user_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `title` varchar(25) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_user_id` (`user_id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_person_id` (`person_id`),
  KEY `IX_user_id_bill_id` (`user_id`,`bill_id`),
  KEY `IX_user_id_person_id` (`user_id`,`person_id`),
  KEY `IX_created_on` (`created_on`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `committee_meetings` */

DROP TABLE IF EXISTS `committee_meetings`;

CREATE TABLE `committee_meetings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_id` int(11) DEFAULT NULL,
  `meeting_date` datetime DEFAULT NULL,
  `meeting_location` varchar(255) DEFAULT NULL,
  `meeting_time` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `committee_meetings_bills` */

DROP TABLE IF EXISTS `committee_meetings_bills`;

CREATE TABLE `committee_meetings_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_meetings_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `public_hearing` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `committees` */

DROP TABLE IF EXISTS `committees`;

CREATE TABLE `committees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_name` varchar(255) DEFAULT NULL,
  `subcommittee_name` varchar(255) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `code` varchar(255) DEFAULT NULL,
  `house` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_committee_name_subcommitee_name_house` (`committee_name`,`subcommittee_name`,`house`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;

/*Table structure for table `committees_people` */

DROP TABLE IF EXISTS `committees_people`;

CREATE TABLE `committees_people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `session_identifier` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_committee_id_person_id_session` (`committee_id`,`person_id`,`session_identifier`),
  KEY `IX_committee_id` (`committee_id`),
  KEY `IX_person_id` (`person_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1569 DEFAULT CHARSET=latin1;

/*Table structure for table `countries` */

DROP TABLE IF EXISTS `countries`;

CREATE TABLE `countries` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `country` varchar(75) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=242 DEFAULT CHARSET=utf8;

/*Table structure for table `districts` */

DROP TABLE IF EXISTS `districts`;

CREATE TABLE `districts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(25) NOT NULL,
  `district_number` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=latin1;

/*Table structure for table `fiscal_notes` */

DROP TABLE IF EXISTS `fiscal_notes`;

CREATE TABLE `fiscal_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `committee` varchar(100) DEFAULT NULL,
  `note_date` datetime DEFAULT NULL,
  `analyst` varchar(50) DEFAULT NULL,
  `raw_html` mediumtext,
  `bill_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=753 DEFAULT CHARSET=latin1;

/*Table structure for table `groups` */

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Table structure for table `meta` */

DROP TABLE IF EXISTS `meta`;

CREATE TABLE `meta` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `senate_district` int(11) DEFAULT NULL,
  `house_district` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

/*Table structure for table `most_popular` */

DROP TABLE IF EXISTS `most_popular`;

CREATE TABLE `most_popular` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `rep_person_id` int(11) DEFAULT NULL,
  `sen_person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `page_view_counts` */

DROP TABLE IF EXISTS `page_view_counts`;

CREATE TABLE `page_view_counts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `committee_id` int(11) DEFAULT NULL,
  `roll_calls_id` int(11) DEFAULT NULL,
  `page_view_count` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11870 DEFAULT CHARSET=latin1;

/*Table structure for table `page_views` */

DROP TABLE IF EXISTS `page_views`;

CREATE TABLE `page_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `ip` varchar(15) NOT NULL,
  `viewed_on` datetime DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `roll_calls_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `committee_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_bill_id` (`bill_id`),
  KEY `IX_ip` (`ip`),
  KEY `IX_person_id` (`person_id`),
  KEY `IX_viewed_on` (`viewed_on`),
  KEY `IX_vote_id` (`roll_calls_id`),
  KEY `IX_subject_id` (`subject_id`),
  KEY `IX_committee_id` (`committee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26752 DEFAULT CHARSET=latin1;

/*Table structure for table `people` */

DROP TABLE IF EXISTS `people`;

CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `party` varchar(255) DEFAULT NULL,
  `osid` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_approval` double DEFAULT '5',
  `biography` text,
  `unaccented_name` varchar(255) DEFAULT NULL,
  `youtube_id` varchar(255) DEFAULT NULL,
  `votesmart_id` varchar(255) DEFAULT NULL,
  `memberid` int(11) DEFAULT NULL,
  `personid` int(11) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `wikipedia_id` varchar(255) DEFAULT NULL,
  `imsp_candidate_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_party` (`party`)
) ENGINE=MyISAM AUTO_INCREMENT=144 DEFAULT CHARSET=latin1;

/*Table structure for table `people_meta_data` */

DROP TABLE IF EXISTS `people_meta_data`;

CREATE TABLE `people_meta_data` (
  `candidate_id` int(11) DEFAULT NULL,
  `family` text,
  `home_city` varchar(50) DEFAULT NULL,
  `home_state` varchar(10) DEFAULT NULL,
  `birth_date` varchar(15) DEFAULT NULL,
  `education` text,
  `political` text,
  `profession` text,
  `religion` varchar(50) DEFAULT NULL,
  `cong_membership` text,
  `org_membership` text,
  `person_id` int(11) DEFAULT NULL,
  KEY `IX_people_meta_data_person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `person_ratings` */

DROP TABLE IF EXISTS `person_ratings`;

CREATE TABLE `person_ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IX_person_ratings_user_id` (`user_id`),
  KEY `IX_person_ratings_person_id` (`person_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) DEFAULT NULL,
  `role_type` varchar(255) DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `party` varchar(255) DEFAULT NULL,
  `district` varchar(10) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_startdate` (`startdate`),
  KEY `IX_enddate` (`enddate`),
  KEY `IX_person_id` (`person_id`),
  KEY `IX_role_type` (`role_type`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;

/*Table structure for table `roll_call_votes` */

DROP TABLE IF EXISTS `roll_call_votes`;

CREATE TABLE `roll_call_votes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vote` char(1) DEFAULT NULL,
  `roll_call_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_roll_call_votes_person_id` (`person_id`),
  KEY `IX_roll_call_votes_roll_call_id` (`roll_call_id`)
) ENGINE=MyISAM AUTO_INCREMENT=107233 DEFAULT CHARSET=latin1;

/*Table structure for table `roll_calls` */

DROP TABLE IF EXISTS `roll_calls`;

CREATE TABLE `roll_calls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) DEFAULT NULL,
  `location` char(1) DEFAULT NULL,
  `vote_date` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `roll_type` varchar(255) DEFAULT NULL,
  `question` text,
  `required` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `amendment_id` int(11) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `ayes` int(11) DEFAULT '0',
  `nays` int(11) DEFAULT '0',
  `abstains` int(11) DEFAULT '0',
  `presents` int(11) DEFAULT '0',
  `democratic_position` tinyint(1) DEFAULT NULL,
  `republican_position` tinyint(1) DEFAULT NULL,
  `is_hot` tinyint(1) DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `hot_date` datetime DEFAULT NULL,
  `alison_vote_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IX_roll_calls_bill_id` (`bill_id`),
  KEY `IX_roll_calls_number_location` (`number`,`location`),
  KEY `IX_roll_calls_vote_date` (`vote_date`)
) ENGINE=MyISAM AUTO_INCREMENT=1551 DEFAULT CHARSET=latin1;

/*Table structure for table `session` */

DROP TABLE IF EXISTS `session`;

CREATE TABLE `session` (
  `session_identifier` varchar(45) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `enabled` bit(1) DEFAULT NULL,
  `session_label` varchar(255) DEFAULT NULL,
  `bill_html_repository` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`session_identifier`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '',
  `ip_address` varchar(16) NOT NULL DEFAULT '',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Table structure for table `subjects` */

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=336 DEFAULT CHARSET=latin1;

/*Table structure for table `tags` */

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=latin1;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` mediumint(8) unsigned NOT NULL,
  `ip_address` char(16) NOT NULL,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `activation_code` varchar(40) NOT NULL DEFAULT '0',
  `forgotten_password_code` varchar(40) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `IX_users_email` (`password`),
  KEY `IX_users_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

/*Table structure for table `users_watch` */

DROP TABLE IF EXISTS `users_watch`;

CREATE TABLE `users_watch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `web_addresses` */

DROP TABLE IF EXISTS `web_addresses`;

CREATE TABLE `web_addresses` (
  `web_address_type` varchar(50) DEFAULT NULL,
  `web_address` varbinary(100) DEFAULT NULL,
  `candidate_id` int(11) DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  KEY `IX_web_addresses_person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* Trigger structure for table `bills_subjects` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trg_bills_subjects_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trg_bills_subjects_insert` AFTER INSERT ON `bills_subjects` FOR EACH ROW BEGIN
    
    DEclare v_subject varchar(255); 
    declare v_tag_id int;
    declare v_tag_count int;
    
    select s.subject from subjects s where s.id = NEW.subject_id into v_subject;
    
    select t.id from tags t where t.tag_name = v_subject into v_tag_id;
    
    if v_tag_id is null then
    
	insert into tags (tag_name) values(lower(v_subject));
	
	insert into bills_tags(bill_id,tag_id) values(NEW.bill_id,last_insert_id());
	
    else
	select count(*) from bills_tags where bill_id = NEW.bill_id and tag_id = v_tag_id into v_tag_count;
	
	if v_tag_count < 1 then
		INSERT INTO bills_tags(bill_id,tag_id) VALUES(NEW.bill_id,v_tag_id);
	end if;
    
    end if;
    
    
    END */$$


DELIMITER ;

/* Trigger structure for table `page_views` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `trg_page_views_insert` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'%' */ /*!50003 TRIGGER `trg_page_views_insert` AFTER INSERT ON `page_views` FOR EACH ROW BEGIN
    
    declare subject_count int;
    declare bill_count Int;
    declare committee_count int;
    declare roll_calls_count int;
    declare person_count int;
    
    set subject_count = 0;
    set bill_count = 0;
    set committee_count = 0;
    set roll_calls_count = 0;
    set person_count = 0;
    
    
    if NEW.bill_id IS NOT NULL THEn
    
	select Get_bill_page_view_count(NEW.bill_id) into bill_count;
	
	UPDATE page_view_counts SET page_view_count = bill_count WHERE bill_id = NEW.bill_id;
	
	IF ROW_COUNT() < 1 THEN
	
		INSERT INTO page_view_counts (bill_id, page_view_count) VALUES(NEW.bill_id,bill_count);
	
	END IF;		
    
    elseif NEW.subject_id IS NOT Null then
    
	SELECT Get_issue_page_view_count(NEW.subject_id) INTO subject_count;
	
	UPDATE page_view_counts SET page_view_count = subject_count WHERE subject_id = NEW.subject_id;
	
	IF ROW_COUNT() < 1 THEN
	
		INSERT INTO page_view_counts (subject_id, page_view_count) VALUES(NEW.subject_id,subject_count);
	
	END IF;		
    
    elseif NEW.roll_calls_id IS not null then
    
	SELECT Get_roll_call_page_view_count(NEW.roll_calls_id) INTO roll_calls_count;
	
	UPDATE page_view_counts SET page_view_count = roll_calls_count WHERE roll_calls_id = NEW.roll_calls_id;
	
	IF ROW_COUNT() < 1 THEN
	
		INSERT INTO page_view_counts (roll_calls_id, page_view_count) VALUES(NEW.roll_calls_id,roll_calls_count);
	
	END IF;	
    
    elseif NEW.committee_id is not null then
    
	SELECT Get_committee_page_view_count(NEW.committee_id) INTO committee_count;
	
	UPDATE page_view_counts SET page_view_count = committee_count WHERE committee_id = NEW.committee_id;
	
	IF ROW_COUNT() < 1 THEN
	
		INSERT INTO page_view_counts (committee_id, page_view_count) VALUES(NEW.committee_id,committee_count);
	
	END IF;
	
    elseif NEW.person_id IS NOT null then
    
	SELECT Get_person_page_view_count(NEW.person_id) INTO person_count;
	
	Update page_view_counts set page_view_count = person_count where person_id = NEW.person_id;
	
	if Row_count() < 1 then
	
		insert into page_view_counts (person_id, page_view_count) values(NEW.person_id,person_count);
	
	end if;
    
    END if;
    
    
    
    
    END */$$


DELIMITER ;

/* Function  structure for function  `Get_bill_first_action_id` */

/*!50003 DROP FUNCTION IF EXISTS `Get_bill_first_action_id` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_bill_first_action_id`(p_bill_id Integer) RETURNS int(11)
BEGIN
    Declare action_id int;
    
	SELECT a1.id FROM actions a1 WHERE a1.bill_id = p_bill_id ORDER BY a1.action_date ASC ,a1.id ASC LIMIT 1 into action_id;
		
		return action_id;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_bill_Last_action_date` */

/*!50003 DROP FUNCTION IF EXISTS `Get_bill_Last_action_date` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_bill_Last_action_date`(p_bill_id Integer) RETURNS datetime
BEGIN
    Declare action_date DateTime;
    
	SELECT a1.action_date FROM actions a1 WHERE a1.bill_id = p_bill_id ORDER BY a1.action_date desc ,a1.id desc LIMIT 1 into action_date;
		
		return action_date;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_bill_page_view_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_bill_page_view_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_bill_page_view_count`(p_bill_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE bill_id = p_bill_id) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_bill_popularity` */

/*!50003 DROP FUNCTION IF EXISTS `Get_bill_popularity` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_bill_popularity`(p_bill_id INTEGER) RETURNS int(11)
BEGIN
    DECLARE view_count INT;
    DECLARE total_actions INT;
    DECLARE comment_count INT;
    DECLARE vote_count INT;
    DECLARE sponsor_count INT;
    
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE bill_id = p_bill_id
		AND bill_id IS NOT NULL) v INTO view_count;
	
	SELECT COUNT(*)
	FROM bill_votes
	WHERE bill_id = p_bill_id INTO vote_count;
	
	SELECT COUNT(*)
	FROM actions
	WHERE bill_id = p_bill_id INTO total_actions;
	
	SELECT COUNT(*)
	FROM comments
	WHERE bill_id = p_bill_id INTO comment_count;
	
	SELECT COUNT(*)
	FROM bills_cosponsors
	WHERE bill_id = p_bill_id INTO sponsor_count;
		
	RETURN view_count + total_actions + comment_count + vote_count + sponsor_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_bill_sponsor_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_bill_sponsor_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_bill_sponsor_count`(p_bill_id INTEGER) RETURNS int(11)
BEGIN
    DECLARE sponsor_count INT;
       
		
	SELECT COUNT(*)
	FROM bills_cosponsors
	WHERE bill_id = p_bill_id INTO sponsor_count;
		
	RETURN sponsor_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_committee_page_view_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_committee_page_view_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_committee_page_view_count`(p_committee_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE committee_id = p_committee_id) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_issue_bill_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_issue_bill_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_issue_bill_count`(p_subject_id INTEGER) RETURNS int(11)
BEGIN
    DECLARE bill_count INT;
       
		
	SELECT COUNT(*)
	FROM bills_subjects
	WHERE subject_id = p_subject_id INTO bill_count;
		
	RETURN bill_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_issue_page_view_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_issue_page_view_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_issue_page_view_count`(p_subject_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE subject_id = p_subject_id) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_issue_page_view_count_7days` */

/*!50003 DROP FUNCTION IF EXISTS `Get_issue_page_view_count_7days` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_issue_page_view_count_7days`(p_subject_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE subject_id = p_subject_id
		and viewed_on >= current_date - 7) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_person_page_view_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_person_page_view_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_person_page_view_count`(p_person_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE person_id = p_person_id) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_person_popularity` */

/*!50003 DROP FUNCTION IF EXISTS `Get_person_popularity` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_person_popularity`(p_person_id INTEGER) RETURNS int(11)
BEGIN
    DECLARE view_count INT;
    DECLARE comment_count INT;
    DECLARE vote_count int;
    
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE person_id = p_person_id) v INTO view_count;
	
	SELECT COUNT(*)
	FROM comments
	WHERE person_id = p_person_id INTO comment_count;
	
	select count(*)
	from person_ratings
	where person_id = p_person_id into vote_count;
		
	RETURN view_count + comment_count + vote_count;
    END */$$
DELIMITER ;

/* Function  structure for function  `Get_roll_call_page_view_count` */

/*!50003 DROP FUNCTION IF EXISTS `Get_roll_call_page_view_count` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `Get_roll_call_page_view_count`(p_roll_calls_id Integer) RETURNS int(11)
BEGIN
    Declare view_count int;
    
	SELECT COUNT(*)
	FROM (SELECT DISTINCT ip
		FROM page_views
		WHERE roll_calls_id = p_roll_calls_id) v into view_count;
		
		return view_count;
    END */$$
DELIMITER ;

/*Table structure for table `v_bills_for_search` */

DROP TABLE IF EXISTS `v_bills_for_search`;

/*!50001 DROP VIEW IF EXISTS `v_bills_for_search` */;
/*!50001 DROP TABLE IF EXISTS `v_bills_for_search` */;

/*!50001 CREATE TABLE  `v_bills_for_search`(
 `id` int(11) NOT NULL  default '0' ,
 `description` text NULL ,
 `SUBJECT` varchar(255) NULL ,
 `bill_text` varchar(255) NULL 
)*/;

/*View structure for view v_bills_for_search */

/*!50001 DROP TABLE IF EXISTS `v_bills_for_search` */;
/*!50001 DROP VIEW IF EXISTS `v_bills_for_search` */;

/*!50001 CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_bills_for_search` AS (select `b`.`id` AS `id`,`b`.`description` AS `description`,`b`.`subject` AS `SUBJECT`,`btn`.`node_text` AS `bill_text` from ((`bills` `b` join `bills_text_versions` `btv` on((`btv`.`bill_id` = `b`.`id`))) join `bills_text_nodes` `btn` on((`btn`.`bills_text_versions_id` = `btv`.`id`))) where (`b`.`session_identifier` = '1051') group by `b`.`id`,`b`.`description`,`b`.`subject`) */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
