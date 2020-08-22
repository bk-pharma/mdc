DELIMITER $$
CREATE PROCEDURE `getDoctorByName`(IN `mdName` VARCHAR(255), IN `formattedName` VARCHAR(255))
BEGIN
    SET @mdName = mdName;
    SET @formattedName = formattedName;

    SET @s = "SELECT SQL_CACHE  sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode
	FROM db_sanitation
	WHERE sanit_namebasis LIKE CONCAT('%',?, '%') OR sanit_namebasis LIKE CONCAT('%',?,'%')";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @mdName, @formattedName;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;