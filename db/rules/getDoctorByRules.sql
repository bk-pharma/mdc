DELIMITER //

CREATE PROCEDURE getDoctorByRules(
	IN ruleCode VARCHAR(255)
)
BEGIN
	SELECT rule_id, rule_code, rule_assign_to
	FROM rules_tbl
	WHERE rule_code = ruleCode
	AND status = 1;
END //

DELIMITER ;