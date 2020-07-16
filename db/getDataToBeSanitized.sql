DELIMITER //

CREATE PROCEDURE getDataToBeSanitized()
BEGIN
	SELECT raw_id, raw_doctor, raw_license
    FROM sanitation_result_new
    WHERE raw_status = ''
    LIMIT 0, 100;
<<<<<<< HEAD
END //
=======
END//
>>>>>>> ea3ef52365980f26e13fd17482a7eb14295918bd

DELIMITER ;