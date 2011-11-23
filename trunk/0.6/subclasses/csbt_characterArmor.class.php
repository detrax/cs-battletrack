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

class csbt_characterArmor extends csbt_battleTrackAbstract	 {
	
	protected $characterId;
	protected $fields;
	public $updatesByKey = array();
	
	/** Did you notice "{tableName}_{pkeyField}_seq"? PostgreSQL makes that simple, others don't.*/
	const tableName = 'csbt_character_armor_table';
	const tableSeq  = 'csbt_character_armor_table_character_armor_id_seq';
	const pkeyField = 'character_armor_id';
	const sheetIdPrefix = 'characterArmor';
	
	
	//-------------------------------------------------------------------------
	/**
	 */
	public function __construct(cs_phpDB $dbObj, $characterId) {
		if(is_null($characterId) || !is_numeric($characterId)) {
			$this->_exception_handler(__METHOD__ .":: invalid character id (". $characterId .")");
		}
		$this->characterId = $characterId;
		$this->fields = array(
			'character_id'		=> 'int',
			'armor_name'		=> 'sql',
			'armor_type'		=> 'sql',
			'ac_bonus'			=> 'int',
			'check_penalty'		=> 'int',
			'max_dex'			=> 'int',
			'special'			=> 'sql',
			'weight'			=> 'sql',
			'spell_fail'		=> 'int',
			'max_speed'			=> 'int',
			'is_worn'			=> 'bool'
		);
		//cs_phpDB $dbObj, $tableName, $seqName, $pkeyField, array $cleanStringArr
		parent::__construct($dbObj, self::tableName, self::tableSeq, self::pkeyField, $this->fields);
		$this->logger->logCategory = "Character Armor";
	}//end __construct()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_armor_by_id($armorId) {
		try {
			$data = $this->tableHandlerObj->get_record_by_id($armorId);
		}
		catch(Exception $e) {
			$this->_exception_handler(__METHOD__ .":: failed to retrieve armor with record id (". $armorId ."), DETAILS:::: ". $e->getMessage());
		}
		return($retval);
	}//end get_armor_by_id()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_character_armor($onlyWorn=false) {
		try {
			$filterArr = array(
				'character_id'	=> $this->characterId
			);
			if($onlyWorn === true) {
				$filterArr['is_worn'] = true;
			}
			$data = $this->tableHandlerObj->get_records($filterArr);
			if($data == false || !is_array($data)) {
				$data = array();
			}
		}
		catch(Exception $e) {
			$this->_exception_handler(__METHOD__ .":: failed to retrieve data, DETAILS:::: ". $e->getMessage());
		}
		
		return($data);
	}//end get_character_armor()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function create_armor($name, array $miscData=null) {
		if(is_null($miscData)) {
			$miscData = array();
		}
		$sqlArr = $miscData;
		$sqlArr['armor_name'] = $name;
		$sqlArr['character_id'] = $this->characterId;
		try {
			$newId = $this->tableHandlerObj->create_record($sqlArr);
			
			//get the record & put it into updatesByKey...
			$newRecord = $this->get_armor_by_id($newId);
			foreach($newRecord as $field=>$val) {
				$this->updatesByKey[$this->create_sheet_id(self::sheetIdPrefix, $field, $newId)] = $val;
			}
		}
		catch(Exception $e) {
			$this->_exception_handler(__METHOD__ .":: error while creating armor record, DETAILS::: ". $e->getMessage());
		}
		return($newId);
	}//end create_armor()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function update_armor($armorId, array $updates) {
		#return($this->tableHandlerObj->update_record($armorId, $updates));
		$retval = $this->tableHandlerObj->update_record($armorId, $updates);
		$data = $this->get_armor_by_id($armorId);
		foreach($data as $f=>$v) {
			$this->updatesByKey[$this->create_sheet_id(self::sheetIdPrefix, $f, $armorId)] = $v;
		}
		return($retval);
	}//end update_armor()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_sheet_data() {
		try {
			$records = $this->get_character_armor();
			
			$retval = array();
			if(count($records) > 0) {
				$makeKeysFrom = $this->get_columns_for_sheet_keys();
				
				foreach($records as $id=>$armorInfo) {
					#foreach($armorInfo as $k=>$v) {
					foreach($makeKeysFrom as $k) {
						$v = $armorInfo[$k];
						$sheetId = $this->create_sheet_id(self::sheetIdPrefix, $k);
						$retval[$id][$sheetId] = $v;
					}
				}
			}
		}
		catch(Exception $e) {
			$this->_exception_handler(__METHOD__ .":: fatal error while retrieving armor records, DETAILS::: ". $e->getMessage());
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
		if(in_array($updateBitName, array_keys($this->fields))) {
			$retval = $this->update_armor($recordId, array($updateBitName => $newValue));
		}
		else {
			$this->_exception_handler(__METHOD__ .":: invalid column name (". $updateBitName .")");
		}
		
		return($retval);
	}//end handle_update()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_ac_bonus() {
		try {
			$allArmor = $this->get_character_armor(true);
			$totalBonus = 0;
			if(is_array($allArmor) && count($allArmor) > 0) {
				foreach($allArmor as $id=>$recordInfo) {
					$totalBonus += $recordInfo['ac_bonus'];
				}
			}
		}
		catch(Exception $e) {
			$this->_exception_handler(__METHOD__ .": error while retrieving armor, DETAILS::: .". $e->getMessage());
		}
		
		return($totalBonus);
	}//end get_ac_bonus()
	//-------------------------------------------------------------------------
	
	
	
	//-------------------------------------------------------------------------
	public function get_ac_flatfooted() {
		//touch is its (full AC) - (any armor or natural armor bonus), and flatfooted is (full AC) - (any dex bonus).
		
	}//end get_ac_flatfooted()
	//-------------------------------------------------------------------------
}

?>