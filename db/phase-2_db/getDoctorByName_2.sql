DELIMITER //

CREATE PROCEDURE getDoctorByName(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_mdname,sanit_license,sanit_group,sanit_universe,sanit_mdcode
	FROM db_sanitation2
	WHERE sanit_surname = mdName;
END //

DELIMITER ;