DELIMITER //

CREATE PROCEDURE getDoctorByFormattedName2(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode
	FROM db_sanitation2
	WHERE sanit_mdname = mdName;
END //

DELIMITER ;