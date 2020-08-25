CREATE INDEX rawData ON sanitation_result_new (raw_status, raw_corrected_name, raw_date, sanitized_by);
CREATE INDEX rawId ON sanitation_result_new (raw_id);
CREATE INDEX mdName ON db_sanitation (sanit_mdname);
CREATE INDEX mdName ON db_sanitation2 (sanit_surname, sanit_firstname, sanit_middlename);
CREATE INDEX mdName ON db_sanitation3 (sanit_name, sanit_license);
CREATE INDEX mdName ON db_sanitation4 (sanit_surname, sanit_firstname, sanit_middlename, sanit_branch);
CREATE INDEX mdName ON rules_details (details_column_name, details_value, rule_code);
CREATE INDEX mdName ON rules_tbl (rule_code);