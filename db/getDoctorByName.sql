DELIMITER //

CREATE PROCEDURE getDoctorByName(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_id
	FROM db_sanitation
	WHERE sanit_namebasis LIKE CONCAT('%', mdName, '%');
END

DELIMITER ;