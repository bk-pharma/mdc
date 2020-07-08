DELIMITER //

CREATE PROCEDURE getDoctorByName(
	IN mdname VARCHAR(255)
)
BEGIN
	SELECT sanit_mdname, sanit_namebasis, sanit_group, sanit_universe, sanit_mdcode
 	FROM db_sanitation
	WHERE sanit_namebasis LIKE '%mdname%';
END

DELIMITER ;