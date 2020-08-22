DELIMITER $$
CREATE PROCEDURE `getDoctorByRulesSanitation`(IN `mdName` VARCHAR(255))
BEGIN
    SET @mdName = mdName;

    SET @s = "SELECT SQL_CACHE sanit_id, sanit_mdname, sanit_universe, sanit_group, sanit_mdcode
	FROM db_sanitation
	WHERE sanit_mdname = ?;";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @mdName;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;