DELIMITER $$
CREATE PROCEDURE `applyRules`(IN `rawId` VARCHAR(255), IN `rawStatus` VARCHAR(255), IN `mdName` VARCHAR(255), IN `correctedName` VARCHAR(255), IN `universe` VARCHAR(255), IN `mdCode` VARCHAR(255), IN `sanitizedBy` VARCHAR(255))
BEGIN
    SET @rawStatus = rawStatus;
    SET @mdName = mdName;
	SET @correctedName = correctedName;
    SET @universe = universe;
    SET @mdCode = mdCode;
    SET @sanitizedBy = sanitizedBy;
 	SET @rawId = rawId;

    SET @s = "UPDATE sanitation_result_new
	SET raw_status = ?, raw_doctor = ?, raw_corrected_name = ?, raw_universe = ?, raw_mdcode = ?, sanitized_by = ?
	WHERE raw_id = ?;";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @rawStatus, @mdName, @correctedName, @universe, @mdCode, @sanitizedBy, @rawId;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;