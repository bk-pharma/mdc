DELIMITER //

CREATE PROCEDURE getDoctorByRulesSanitation(
	IN mdName VARCHAR(255)
)
BEGIN
	SELECT sanit_universe, sanit_group, sanit_mdcode
	FROM db_sanitation
	WHERE sanit_mdname = mdName;
END //

DELIMITER ;