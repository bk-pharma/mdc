DELIMITER //

CREATE PROCEDURE getDataToBeSanitized()
BEGIN
	SELECT raw_id, raw_doctor, raw_license
    FROM sanitation_result_new
    WHERE raw_status = ''
    LIMIT 0, 100;
END //

DELIMITER ;