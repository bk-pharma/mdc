DELIMITER $$
CREATE PROCEDURE `getDoctorByFormattedName4`(IN `mdName` VARCHAR(255))
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode
	FROM db_sanitation4
	WHERE sanit_mdname LIKE CONCAT('%',mdName,'%');
END$$
DELIMITER ;