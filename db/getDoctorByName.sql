DELIMITER //

CREATE PROCEDURE getDoctorByName(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_id, sanit_mdname, sanit_group, sanit_universe
	FROM db_sanitation
	WHERE sanit_namebasis LIKE CONCAT('%', mdName, '%');
<<<<<<< HEAD
END //
=======
END//
>>>>>>> ea3ef52365980f26e13fd17482a7eb14295918bd

DELIMITER ;