DELIMITER $$
CREATE PROCEDURE `getDataToBeSanitized`(IN `rowStart` INT, IN `rowCount` INT)
BEGIN
    DECLARE LocRowStart INT;
    DECLARE LocRowCount INT;
    SET LocRowStart = rowStart;
	SET LocRowCount = rowCount;

	SELECT SQL_CACHE raw_id, raw_doctor, raw_license, raw_branchcode, raw_branchname, raw_lburebate, raw_address
    FROM sanitation_result_new
    WHERE raw_status = ''
    AND raw_corrected_name = ''
   	ORDER BY raw_date DESC
    LIMIT LocRowStart, LocRowCount;
END$$
DELIMITER ;;