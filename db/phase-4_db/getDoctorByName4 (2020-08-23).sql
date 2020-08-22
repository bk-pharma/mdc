DELIMITER $$
CREATE PROCEDURE `getDoctorByName4`(IN `mdName` VARCHAR(255), IN `clauseCols` VARCHAR(255), IN `rawBranch` VARCHAR(20))
BEGIN
    SET @s = CONCAT('SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode, sanit_branch FROM db_sanitation4 WHERE ', clauseCols, '= ',QUOTE(mdName),' AND sanit_branch LIKE',QUOTE(CONCAT('%',rawBranch,'%')));
    PREPARE stmt FROM @s;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;