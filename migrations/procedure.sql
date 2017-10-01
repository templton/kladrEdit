DELIMITER $$
DROP PROCEDURE IF EXISTS `get_in_parent` $$
CREATE PROCEDURE `get_in_parent`(IN inParentId TEXT)
BEGIN
DECLARE ids TEXT DEFAULT "";
SET @parents = inParentId;
    REPEAT
        SET ids = CONCAT(ids, IF(LENGTH(ids), ',', ''), @parents);
        
        SET @stm = CONCAT(
            'SELECT GROUP_CONCAT(parent_id) INTO @parents 
             FROM class_okved 
             WHERE id IN (', @parents, ')'
        );
        PREPARE fetch_childs FROM @stm;
        EXECUTE fetch_childs;
        DROP PREPARE fetch_childs;
    UNTIL (@parents IS NULL) END REPEAT;

    SET @stm = CONCAT (
        'SELECT *
        FROM class_okved
        WHERE id IN (', ids, ')'
    );

    PREPARE statement FROM @stm;
    EXECUTE statement;
    DROP PREPARE statement;

END $$