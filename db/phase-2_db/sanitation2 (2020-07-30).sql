DELIMITER $$
CREATE PROCEDURE `sanitation2`(IN `rawId` VARCHAR(255), IN `rawStatus` VARCHAR(255), IN `mdName` VARCHAR(255), IN `correctedName` VARCHAR(255), IN `universe` VARCHAR(255), IN `mDcode` VARCHAR(255))
BEGIN
	UPDATE sanitation_result_new
	SET raw_status = rawStatus, raw_doctor = mdName, raw_corrected_name = correctedName, raw_universe = universe, raw_mdcode = mdCode
	WHERE raw_id = rawId;
END$$
DELIMITER ;