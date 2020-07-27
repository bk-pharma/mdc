DELIMITER $$
CREATE PROCEDURE `getDoctorByName4`(IN `mdName` VARCHAR(255), IN `clauseCols` VARCHAR(255))
BEGIN
    SET @s = CONCAT('SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode, sanit_branch FROM db_sanitation4 WHERE ', clauseCols, '= ',QUOTE(mdName));
    PREPARE stmt FROM @s;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;