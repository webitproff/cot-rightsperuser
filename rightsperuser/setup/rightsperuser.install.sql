/* Custom user permissions schema */
CREATE TABLE IF NOT EXISTS `cot_rightsperuser` (
	`ru_id` INT NOT NULL AUTO_INCREMENT,						-- Rule ID
	`ru_user` INT NOT NULL REFERENCES `cot_users` (`user_id`),	-- User ID
	`ru_code` VARCHAR(255) NOT NULL,							-- Auth code
	`ru_option` VARCHAR(255) NOT NULL,							-- Auth option
	`ru_rights` TINYINT UNSIGNED NOT NULL DEFAULT '0',			-- Permissions
	PRIMARY KEY (`ru_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;