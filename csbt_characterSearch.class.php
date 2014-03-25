<?php

class csbt_characterSearch extends csbt_character {
	
	public $characterId;
	
	
	
	//-------------------------------------------------------------------------
	public static function search(cs_phpDb $dbObj, array $criteria) {
		if(is_array($criteria) && count($criteria)) {
			$retval = array();
			
			$sql = "SELECT c.*, ca.campaign_name FROM ". csbt_character::tableName ." AS c
				LEFT OUTER JOIN ". csbt_campaign::tableName ." AS ca 
				USING (campaign_id)
				WHERE 
				(LOWER(c.character_name) LIKE :character_name OR :character_name IS NULL)
				AND 
				(LOWER(ca.campaign_name) LIKE :campaign_name OR :campaign_name IS NULL)	
			AND
				(c.campaign_id IS NULL)
				ORDER BY c.character_name, ca.campaign_name";
			//Note that the campaign_id IS NULL part is arbitrary...
			
			if(!isset($criteria['character_name'])) {
				$criteria['character_name'] = null;
			}
			else {
				$criteria['character_name'] .= '%';
			}
			if(!isset($criteria['campaign_name'])) {
				$criteria['campaign_name'] = null;
			}
			else {
				$criteria['campaign_name'] .= '%';
			}
//			if(!isset($criteria['campaign']))
			try {
				$numRows = $dbObj->run_query($sql, $criteria);

				if($numRows > 0) {
					$retval = $dbObj->farray_fieldnames(csbt_character::pkeyField);
				}
			}
			catch(Exception $e) {
				cs_debug_backtrace(1);
				throw new exception(__METHOD__ .": error while running search::: ". $e->getMessage());
			}
		}
		else {
			throw new exception(__METHOD__ .": invalid or empty search criteria");
		}
		return ($retval);
	}//end search()
	//-------------------------------------------------------------------------
	
	
	
}
