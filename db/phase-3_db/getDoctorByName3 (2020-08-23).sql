DELIMITER $$
CREATE PROCEDURE `getDoctorByName3`(IN `mdName` VARCHAR(255), IN `licenseNo` VARCHAR(255))
BEGIN
    SET @mdName = mdName;
    SET @licenseNo = licenseNo;

    SET @s = "SELECT SQL_CACHE sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode, sanit_license
	FROM db_sanitation3
	WHERE sanit_name = ?
    AND sanit_license = ?;";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @mdName, @licenseNo;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;