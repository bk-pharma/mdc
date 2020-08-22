DELIMITER $$
CREATE PROCEDURE `getDoctorByFormattedName2`(IN `mdName` VARCHAR(255))
BEGIN
    SET @mdName = mdName;

    SET @s = "SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode
	FROM db_sanitation2
	WHERE sanit_mdname LIKE CONCAT('%',?,'%');";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @mdName;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;