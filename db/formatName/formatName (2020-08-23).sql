DELIMITER $$
CREATE PROCEDURE `formatName`(IN `rawId` VARCHAR(255), IN `mdName` VARCHAR(255), IN `correctedName` VARCHAR(255))
BEGIN
    SET @mdName = mdName;
    SET @correctedName = correctedName;
	SET @rawId = rawId;

    SET @s = "UPDATE sanitation_result_new
	SET raw_doctor = ?, raw_corrected_name = ?
	WHERE raw_id = ?;";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @mdName, @correctedName, @rawId;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;