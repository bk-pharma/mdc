DELIMITER $$
CREATE PROCEDURE `getDataToBeSanitized`(IN `rowStart` INT, IN `rowCount` INT)
BEGIN
    SET @rowStart = rowStart;
    SET @rowCount = rowCount;

    SET @s = "SELECT SQL_CACHE raw_id, raw_doctor, raw_license, raw_branchcode, raw_branchname, raw_lburebate, raw_address FROM sanitation_result_new WHERE sanitized_by = '' ORDER BY raw_id ASC LIMIT ?, ?";
    PREPARE stmt FROM @s;
    EXECUTE stmt USING @rowStart, @rowCount;
    DEALLOCATE PREPARE stmt;
END$$
DELIMITER ;