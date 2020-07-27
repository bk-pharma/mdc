DELIMITER $$
CREATE PROCEDURE `getDoctorByName4`(IN `mdName` VARCHAR(255), IN `rawBranch` VARCHAR(255))
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode, sanit_license
	FROM db_sanitation3
	WHERE sanit_name = mdName
    AND sanit_branchcode = rawBranch;
END$$
DELIMITER ;