DELIMITER $$
CREATE PROCEDURE `getDoctorByName2`(IN `mdName` VARCHAR(255), IN `clauseCols` VARCHAR(255))
BEGIN
    SET @s = CONCAT('SELECT sanit_id, sanit_mdname, sanit_license, sanit_group, sanit_universe, sanit_mdcode FROM db_sanitation2 WHERE ', clauseCols, '= ',QUOTE(mdName));
    PREPARE stmt FROM @s;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;