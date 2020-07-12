DELIMITER //

CREATE PROCEDURE sanitation1(
	IN raw_id VARCHAR(255),
	IN raw_status VARCHAR(255),
	IN raw_doctor VARCHAR(255),
	IN raw_universe VARCHAR(255),
	IN raw_mdcode VARCHAR(255)
)
BEGIN
	UPDATE sanitation_result_new
	SET raw_status = raw_status, raw_doctor = raw_doctor, raw_universe = raw_universe, raw_mdcode = raw_mdcode
	WHERE raw_id = raw_id;
END //

DELIMITER ;