DELIMITER $$
CREATE PROCEDURE `getDoctorByName3`(IN `mdName` VARCHAR(255), IN `licenseNo` VARCHAR(255))
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode, sanit_license
	FROM db_sanitation3
	WHERE sanit_name = mdName
    AND sanit_license = licenseNo;
END$$
DELIMITER ;