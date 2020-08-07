DELIMITER //

CREATE PROCEDURE getDoctorByFormattedName3(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe, sanit_mdcode
	FROM db_sanitation3
	WHERE sanit_mdname = mdName;
END //

DELIMITER ;