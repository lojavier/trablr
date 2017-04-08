START TRANSACTION;

DROP DATABASE IF EXISTS `TRABLR_DB`;
CREATE DATABASE IF NOT EXISTS `TRABLR_DB`;
USE `TRABLR_DB`;

DROP TABLE IF EXISTS `USER_INFO`;
CREATE TABLE IF NOT EXISTS `USER_INFO` (
    `USER_ID`       INT(11) NOT NULL AUTO_INCREMENT,
    `EMAIL`         VARCHAR(45) NOT NULL,
    `PASSWORD`      VARCHAR(45) NOT NULL,
    `FIRST_NAME`    VARCHAR(45) NOT NULL,
    `LAST_NAME`     VARCHAR(45) DEFAULT NULL,
    `PHONE_NUM`     VARCHAR(11) DEFAULT NULL,
    PRIMARY KEY (`USER_ID`),
    UNIQUE (`EMAIL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 COMMENT='USER_INFO';

DROP TABLE IF EXISTS `TRANSIT_INFO`;
CREATE TABLE IF NOT EXISTS `TRANSIT_INFO` (
    `STOP_ID`           INT(11) NOT NULL,
    `LINE_ID`           INT(11) NOT NULL,
    `STOP_NAME`         VARCHAR(45) NOT NULL,
    `AGENCY_NAME`       VARCHAR(45) NOT NULL,
    PRIMARY KEY (`STOP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='TRANSIT_INFO';

DROP TABLE IF EXISTS `USER_FAVORITES`;
CREATE TABLE IF NOT EXISTS `USER_FAVORITES` (
    `FAVORITES_ID`      INT(11) NOT NULL AUTO_INCREMENT,
    `USER_ID`           INT(11) NOT NULL,
    `STOP_ID_START`     INT(11) NOT NULL,
    `STOP_ID_END`       INT(11) NOT NULL,
    `PRIORITY`          INT(11) NOT NULL,
    PRIMARY KEY (`FAVORITES_ID`),
    FOREIGN KEY (`USER_ID`) REFERENCES USER_INFO(`USER_ID`),
    FOREIGN KEY (`STOP_ID_START`) REFERENCES TRANSIT_INFO(`STOP_ID`),
    FOREIGN KEY (`STOP_ID_END`) REFERENCES TRANSIT_INFO(`STOP_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 COMMENT='USER_FAVORITES';

INSERT INTO `USER_INFO` (`USER_ID`,`EMAIL`,`PASSWORD`,`FIRST_NAME`,`LAST_NAME`,`PHONE_NUM`) VALUES
(1,'lorenzo.javier@sjsu.edu','password','Lorenzo','Javier','9252007284');

INSERT INTO `TRANSIT_INFO` (`STOP_ID`,`LINE_ID`,`STOP_NAME`,`AGENCY_NAME`) VALUES
(60824,60,'WINCHESTER & NEAL','VTA'),
(65397,60,'WINCHESTER TRANSIT CENTER','VTA');

INSERT INTO `USER_FAVORITES` (`FAVORITES_ID`,`USER_ID`,`STOP_ID_START`,`STOP_ID_END`,`PRIORITY`) VALUES
(1,1,60824,65397,1);