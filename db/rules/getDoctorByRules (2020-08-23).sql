DELIMITER $$
CREATE PROCEDURE `getDoctorByRules`(IN `ruleCode` VARCHAR(255))
BEGIN
    SET @ruleCode = ruleCode;

    SET @s = "SELECT SQL_CACHE rule_id, rule_code, rule_assign_to
	FROM rules_tbl
	WHERE rule_code = ?
	AND status = 1;";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @ruleCode;
    DEALLOCATE PREPARE stmt;
 END$$
DELIMITER ;