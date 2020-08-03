DELIMITER $$
CREATE PROCEDURE `getDoctorByRuleDetailsTriple`(IN `coloumn` VARCHAR(255), IN `value` VARCHAR(255), IN `coloumn1` VARCHAR(255), IN `value1` VARCHAR(255), IN `coloumn2` VARCHAR(255), IN `value2` VARCHAR(255))
BEGIN
    SET @s = CONCAT('SELECT details_id, rule_code, details_column_name, details_value FROM rules_details WHERE ', coloumn, ' = ',QUOTE(value),' AND ', coloumn1, ' = ',QUOTE(value1),' AND ', coloumn2, ' = ',QUOTE(value2));
    PREPARE stmt FROM @s;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;