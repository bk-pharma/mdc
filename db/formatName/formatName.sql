DELIMITER //

CREATE PROCEDURE formatName(
	IN rawId VARCHAR(255),
	IN mdName VARCHAR(255),
	IN correctedName VARCHAR(255)
)
BEGIN
	UPDATE sanitation_result_new
	SET raw_doctor = mdName, raw_corrected_name = correctedName
	WHERE raw_id = rawId;
END //

DELIMITER ;