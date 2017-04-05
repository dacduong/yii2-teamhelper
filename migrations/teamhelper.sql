-- MySQL Workbench Synchronization
-- Generated: 2017-03-18 07:52
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: Dennis

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_project` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `desc` VARCHAR(2048) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `customer_id` BIGINT(20) NULL DEFAULT NULL,
  `external_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_project_team_idx` (`team_id` ASC),
  INDEX `fk_project_customer_idx` (`customer_id` ASC),
  CONSTRAINT `fk_project_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_project_customer`
    FOREIGN KEY (`customer_id`)
    REFERENCES `teamhelper`.`it_customer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_phase` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `desc` VARCHAR(255) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_phase_team_idx` (`team_id` ASC),
  CONSTRAINT `fk_phase_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_ticket` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `external_id` BIGINT(20) NULL DEFAULT NULL,
  `desc` VARCHAR(4096) NULL DEFAULT NULL,
  `type` TINYINT(1) NULL DEFAULT NULL,
  `priority` TINYINT(1) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  `reporter_id` BIGINT(20) NULL DEFAULT NULL,
  `reporter` VARCHAR(255) NULL DEFAULT NULL,
  `assignee_id` BIGINT(20) NULL DEFAULT NULL,
  `assignee` VARCHAR(255) NULL DEFAULT NULL,
  `start` DATETIME NULL DEFAULT NULL,
  `end` DATETIME NULL DEFAULT NULL,
  `estimated` BIGINT(20) NULL DEFAULT NULL,
  `phase_id` BIGINT(20) NULL DEFAULT NULL,
  `module_id` BIGINT(20) NULL DEFAULT NULL,
  `project_id` BIGINT(20) NOT NULL,
  `team_id` BIGINT(20) NOT NULL,
  `url` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_task_phase_idx` (`phase_id` ASC),
  INDEX `fk_task_project_idx` (`project_id` ASC),
  INDEX `fk_task_team_idx` (`team_id` ASC),
  INDEX `fk_ticket_module_idx` (`module_id` ASC),
  CONSTRAINT `fk_ticket_phase`
    FOREIGN KEY (`phase_id`)
    REFERENCES `teamhelper`.`it_phase` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ticket_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `teamhelper`.`it_project` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ticket_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_ticket_module`
    FOREIGN KEY (`module_id`)
    REFERENCES `teamhelper`.`it_module` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_team` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `desc` VARCHAR(2048) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_timetable` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `type` TINYINT(1) NULL DEFAULT NULL,
  `user_id` BIGINT(20) NOT NULL,
  `ticket_id` BIGINT(20) NULL DEFAULT 0,
  `team_id` BIGINT(20) NULL DEFAULT 0,
  `week` INT(11) NOT NULL,
  `day0` DECIMAL(4,2) NULL DEFAULT 0,
  `day1` DECIMAL(4,2) NULL DEFAULT 0,
  `day2` DECIMAL(4,2) NULL DEFAULT 0,
  `day3` DECIMAL(4,2) NULL DEFAULT 0,
  `day4` DECIMAL(4,2) NULL DEFAULT 0,
  `day5` DECIMAL(4,2) NULL DEFAULT 0,
  `day6` DECIMAL(4,2) NULL DEFAULT 0,
  `remark` VARCHAR(255) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 0,
  `approver` BIGINT(20) NULL DEFAULT 0,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tt_team_idx` (`team_id` ASC),
  INDEX `fk_tt_ticket_idx` (`ticket_id` ASC),
  INDEX `week_idx` (`week` ASC),
  CONSTRAINT `fk_tt_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tt_ticket`
    FOREIGN KEY (`ticket_id`)
    REFERENCES `teamhelper`.`it_ticket` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_customer` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `desc` VARCHAR(1024) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT 1,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_customer_team_idx` (`team_id` ASC),
  CONSTRAINT `fk_customer_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_module` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `project_id` BIGINT(20) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `external_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_module_team_idx` (`team_id` ASC),
  INDEX `fk_module_project_idx` (`project_id` ASC),
  CONSTRAINT `fk_module_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_module_project`
    FOREIGN KEY (`project_id`)
    REFERENCES `teamhelper`.`it_project` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_testscenario` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `desc` VARCHAR(1024) NULL DEFAULT NULL,
  `priority` INT(11) NULL DEFAULT NULL,
  `ticket_id` BIGINT(20) NULL DEFAULT NULL,
  `module_id` BIGINT(20) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ts_team_idx` (`team_id` ASC),
  INDEX `fk_ts_module_idx` (`module_id` ASC),
  INDEX `fk_ts_ticket_idx` (`ticket_id` ASC),
  CONSTRAINT `fk_ts_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ts_module`
    FOREIGN KEY (`module_id`)
    REFERENCES `teamhelper`.`it_module` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ts_ticket`
    FOREIGN KEY (`ticket_id`)
    REFERENCES `teamhelper`.`it_ticket` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_testcase` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `code` VARCHAR(255) NULL DEFAULT NULL,
  `desc` VARCHAR(1025) NULL DEFAULT NULL,
  `precondition` VARCHAR(1024) NULL DEFAULT NULL,
  `postcondition` VARCHAR(1024) NULL DEFAULT NULL,
  `dependencies` VARCHAR(1024) NULL DEFAULT NULL,
  `testscenario_id` BIGINT(20) NOT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tc_team_idx` (`team_id` ASC),
  INDEX `fk_tc_ts_idx` (`testscenario_id` ASC),
  CONSTRAINT `fk_tc_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tc_ts`
    FOREIGN KEY (`testscenario_id`)
    REFERENCES `teamhelper`.`it_testscenario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_teststep` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `desc` VARCHAR(1024) NULL DEFAULT NULL,
  `sequence` TINYINT(1) NULL DEFAULT NULL,
  `testcase_id` BIGINT(20) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_teststep_team_idx` (`team_id` ASC),
  INDEX `fk_teststep_tc_idx` (`testcase_id` ASC),
  UNIQUE INDEX `index_seq_testcaseid_unq` (`sequence` ASC, `testcase_id` ASC),
  CONSTRAINT `fk_teststep_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_teststep_tc`
    FOREIGN KEY (`testcase_id`)
    REFERENCES `teamhelper`.`it_testcase` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_testexecutedetail` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `teststep_id` BIGINT(20) NULL DEFAULT NULL,
  `testdata` VARCHAR(2048) NULL DEFAULT NULL,
  `expectedresult` VARCHAR(2048) NULL DEFAULT NULL,
  `postcondition` VARCHAR(2048) NULL DEFAULT NULL,
  `actualresult` VARCHAR(2048) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT NULL,
  `notes` VARCHAR(2048) NULL DEFAULT NULL,
  `testexecute_id` BIGINT(20) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_ted_team_idx` (`team_id` ASC),
  INDEX `fk_ted_te_idx` (`testexecute_id` ASC),
  INDEX `fk_ted_ts_idx` (`teststep_id` ASC),
  CONSTRAINT `fk_ted_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ted_te`
    FOREIGN KEY (`testexecute_id`)
    REFERENCES `teamhelper`.`it_testexecute` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ted_ts`
    FOREIGN KEY (`teststep_id`)
    REFERENCES `teamhelper`.`it_teststep` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

CREATE TABLE IF NOT EXISTS `teamhelper`.`it_testexecute` (
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `testcase_id` BIGINT(20) NULL DEFAULT NULL,  
  `targetmodule` VARCHAR(255) NULL DEFAULT NULL,
  `targetversion` VARCHAR(20) NULL DEFAULT NULL,
  `status` TINYINT(1) NULL DEFAULT NULL,
  `summary` VARCHAR(2048) NULL DEFAULT NULL,
  `testscenario_id` BIGINT(20) NULL DEFAULT NULL,
  `ticket_id` BIGINT(20) NULL DEFAULT NULL,
  `team_id` BIGINT(20) NULL DEFAULT NULL,
  `created_at` INT(11) NULL DEFAULT NULL,
  `created_by` INT(11) NULL DEFAULT NULL,
  `updated_at` INT(11) NULL DEFAULT NULL,
  `updated_by` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_te_tc_idx` (`testcase_id` ASC),
  INDEX `fk_te_team_idx` (`team_id` ASC),
  INDEX `fk_te_ts_idx` (`testscenario_id` ASC),
  CONSTRAINT `fk_te_tc`
    FOREIGN KEY (`testcase_id`)
    REFERENCES `teamhelper`.`it_testcase` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_te_team`
    FOREIGN KEY (`team_id`)
    REFERENCES `teamhelper`.`it_team` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_te_ticket`
   FOREIGN KEY (`ticket_id`)
   REFERENCES `teamhelper`.`it_ticket` (`id`)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION,
  CONSTRAINT `fk_te_ts`
    FOREIGN KEY (`testscenario_id`)
    REFERENCES `teamhelper`.`it_testscenario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

ALTER TABLE `teamhelper`.`it_project` 
ADD UNIQUE INDEX `code_UNIQUE` (`code` ASC);

ALTER TABLE `teamhelper`.`it_ticket` 
ADD UNIQUE INDEX `code_UNIQUE` (`code` ASC),
ADD UNIQUE INDEX `external_id_UNIQUE` (`external_id` ASC);

ALTER TABLE `teamhelper`.`it_testscenario` 
ADD UNIQUE INDEX `code_UNIQUE` (`code` ASC);

ALTER TABLE `teamhelper`.`it_testcase` 
ADD UNIQUE INDEX `code_UNIQUE` (`code` ASC);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
