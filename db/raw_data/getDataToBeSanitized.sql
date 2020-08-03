DELIMITER //

CREATE PROCEDURE getDataToBeSanitized()
BEGIN
	SELECT raw_id, raw_doctor, raw_license, raw_branchcode
    FROM sanitation_result_new
    WHERE raw_status = ''
 	ORDER BY raw_date DESC
    LIMIT 0, 100;
END //

DELIMITER ;