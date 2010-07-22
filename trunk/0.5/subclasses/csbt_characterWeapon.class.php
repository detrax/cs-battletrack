<?php 

/*
 *  SVN INFORMATION::::
 * --------------------------
 * $HeadURL$
 * $Id$
 * $LastChangedDate$
 * $LastChangedRevision$
 * $LastChangedBy$
 */

class csbt_characterWeapon extends csbt_battleTrackAbstract	 {
	
	protected $characterId;
	protected $fields;
	
	/** Did you notice "{tableName}_{pkeyField}_seq"? PostgreSQL makes that simple, others don't.*/
	const tableName = 'csbt_character_weapon_table';
	const tableSeq  = 'csbt_character_weapon_table_character_weapon_id_seq';
	const pkeyField = 'character_weapon_id';
	const sheetIdPrefix = 'characterWeapon';
	
	
	//-------------------------------------------------------------------------
	/**
	 */
	public function __construct(cs_phpDB $dbObj, $characterId) {
		if(is_null($characterId) || !is_numeric($characterId)) {
			throw new exception(__METHOD__ .":: invalid character id (". $characterId .")");
		}
		$this->characterId = $characterId;
		$this->fields = array(
			'character_id'			=> 'int',
			'weapon_name'			=> 'sql',
			'total_attack_bonus'	=> 'sql',
			'damage'				=> 'sql',
			'critical'				=> 'sql',
			'range'					=> 'sql',
			'special'				=> 'sql',
			'ammunition'			=> 'sql',
			'weight'				=> 'sql',
			'size'					=> 'sql',
			'weapon_type'			=> 'sql',
			'in_use'				=> 'bool'
		);
		//cs_phpDB $dbObj, $tableName, $seqName, $pkeyField, array $cleanStringArr
		parent::__construct($dbObj, self::tableName, self::tableSeq, self::pkeyField, $this->fields);
	}//end __construct()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_weapon_by_id($weaponId) {
		try {
			$data = $this->tableHandlerObj->get_record_by_id($weaponId);
		}
		catch(Exception $e) {
			throw new exception(__METHOD__ .":: failed to retrieve weapon with record id (". $weaponId ."), DETAILS:::: ". $e->getMessage());
		}
		
		if(isset($data[$weaponId])) {
			$retval = $data[$weaponId];
		}
		else {
			throw new exception(__METHOD__ .":: invalid data format returned, could not find sub-record for (". $weaponId ."), DATA:::: ". $this->gfObj->debug_var_dump($data,0));
		}
		return($retval);
	}//end get_weapon_by_id()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_all_weapons() {
		try {
			$data = $this->tableHandlerObj->get_records(array('character_id'=>$this->characterId));
			if($data == false || !is_array($data)) {
				$data = array();
			}
		}
		catch(Exception $e) {
			throw new exception(__METHOD__ .":: failed to retrieve data, DETAILS:::: ". $e->getMessage());
		}
		
		return($data);
	}//end get_all_weapons()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function create_weapon($name, array $miscData=null) {
		if(is_array($miscData) && count($miscData)) {
			$sqlArr = $miscData;
			$sqlArr['weapon_name'] = $name;
			$sqlArr['character_id'] = $this->characterId;
			try {
				$newId = $this->tableHandlerObj->create_record($sqlArr);
			}
			catch(Exception $e) {
				throw new exception(__METHOD__ .":: error while creating weapon record, DETAILS::: ". $e->getMessage());
			}
		}
		else {
			throw new exception(__METHOD__ .":: missing data");
		}
		return($newId);
	}//end create_weapon()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function update_weapon($weaponId, array $updates) {
		return($this->tableHandlerObj->update_record($weaponId, $updates));
	}//end update_weapon()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_character_weapons() {
		try {
			$retval = $this->tableHandlerObj->get_records(array('character_id'=>$this->characterId));
		
			if($retval == false || !is_array($retval)) {
				$retval = array();
			}
		}
		catch(Exception $e) {
			throw new exception(__METHOD__ .":: failed to retrieve weapons, DETAILS::: ". $e->getMessage());
		}
		return($retval);
	}//end get_character_weapon()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_sheet_data() {
		try {
			$data = $this->get_character_weapons();
			
			$retval = array();
			if(is_array($data) && count($data)) {
				$makeKeysFrom = $this->get_columns_for_sheet_keys();
				
				foreach($data as $id=>$weaponInfo) {
					foreach($makeKeysFrom as $columnName) {
						$sheetId = $this->create_sheet_id(self::sheetIdPrefix, $columnName, $id);
						$retval[$sheetId] = $weaponInfo[$columnName];
					}
				}
			}
		}
		catch(Exception $e) {
			throw new exception(__METHOD__ .":: failed to retrieve character weapons, DETAILS::: ". $e->getMessage());
		}

		return($retval);
	}//end get_sheet_data()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_character_defaults() {
		return(array());
	}//end get_character_defaults()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function handle_update($updateBitName, $recordId=null, $newValue) {
cs_debug_backtrace(1);
		try {
			$retval = $this->update_weapon($recordId, array($updateBitName=>$newValue));
		}
		catch(Exception $e) {
			throw new exception(__METHOD__ .":: failed to perform update, DETAILS::: ". $e->getMessage());
		}
		return($retval);
	}//end handle_update()
	//-------------------------------------------------------------------------
}

?>
