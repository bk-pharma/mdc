DELIMITER $$
CREATE PROCEDURE `getDoctorByRuleDetails`(IN `coloumn` VARCHAR(255), IN `value` VARCHAR(255), IN `coloumn1` VARCHAR(255), IN `value1` VARCHAR(255))
BEGIN
    SET @s = CONCAT('SELECT details_id, rule_code, details_column_name FROM rules_details WHERE ', coloumn, ' = ',QUOTE(value),' AND ', coloumn1, ' = ',QUOTE(value1));
    PREPARE stmt FROM @s;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;