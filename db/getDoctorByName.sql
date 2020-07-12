DELIMITER //

CREATE PROCEDURE getDoctorByName(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe
	FROM db_sanitation
	WHERE sanit_namebasis LIKE CONCAT('%', mdName, '%');
END

DELIMITER ;