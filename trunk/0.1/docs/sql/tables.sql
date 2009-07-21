--
-- SVN INFORMATION:::
-- SVN Signature::::::::: $Id:tables.sql 23 2008-04-18 04:25:47Z crazedsanity $
-- Last Committted Date:: $Date:2008-04-17 23:25:47 -0500 (Thu, 17 Apr 2008) $
-- Last Committed Path::: $HeadURL:https://cs-battletrack.svn.sourceforge.net/svnroot/cs-battletrack/trunk/docs/sql/tables.sql $
--  


-- 
-- Contains the main character information.
-- 

CREATE TABLE csbt_character_table (
	character_id serial NOT NULL PRIMARY KEY,
	uid integer NOT NULL REFERENCES cs_authentication_table(uid),
	character_name text
);



CREATE TABLE csbt_character_attribute_table (
	character_attribute_id serial NOT NULL PRIMARY KEY,
	character_id integer NOT NULL REFERENCES csbt_character_table(character_id),
	attribute_type text NOT NULL,
	attribute_subtype text NOT NULL,
	attribute_name text NOT NULL,
	attribute_value text NOT NULL
);

/*
 * A note type, subtype, and name prefixes ("_" and "__")
 * 		A single underscore stands for an item that can be generated by addition
 * 		A double underscore stands for an item that could later be removed (i.e. "shield" could be removed; the "armor" 
 * 			value would actually be a combined value of all the "ac" values of all protective items)
 *
 *  id	||  type		|| subtype				|| name			|| value
 * -----++--------------++----------------------++--------------++---------------
 *     	|| skill		|| knowledge nature		|| _total		|| 3
 *     	|| skill		|| knowledge nature		|| _abilityname	|| int
 *     	|| skill		|| knowledge nature		|| __abilitymod	|| 1
 * 		|| skill		|| knowledge nature		|| ranks		|| 2
 * 		|| skill		|| knowledge nature		|| misc_mod		|| 0
 *     	|| skill		|| appraise				|| _total		|| 3
 *     	|| skill		|| appraise				|| _abilityname	|| wis
 *     	|| skill		|| appraise				|| __abilitymod	|| 1
 * 		|| skill		|| appraise				|| ranks		|| 2
 * 		|| skill		|| appraise				|| misc_mod		|| 0
 * 		|| ability		|| str					|| _total		|| 16
 * 		|| ability		|| str					|| _bonus		|| 3
 * 		|| ability		|| str					|| temp_total	|| (null)
 * 		|| ability		|| str					|| _temp_bonus	|| (null)
 * 		|| ac			|| _total				|| (null)		|| 15
 * 		|| ac			|| _base				|| (null)		|| 10
 * 		|| ac			|| _armor				|| (null)		|| 2
 * 		|| ac			|| __shield				|| (null)		|| 0
 * 		|| ac			|| _dex					|| (null)		|| 3
 * 		|| ac			|| _size				|| (null)		|| 0
 * 		|| weaponslot	|| name					|| (null)		|| greatsword
 * 		|| weaponslot	|| total_atk_bonus		|| (null)		|| +3
 * 		|| weaponslot	|| damage				|| (null)		|| 2d6+4
 * 		|| weaponslot	|| critical				|| (null)		|| x2
 * 		|| weaponslot	|| range				|| (null)		|| (null)
 * 		|| weaponslot	|| special_properties	|| (null)		|| (null)
 * 		|| weaponslot	|| ammunition			|| (null)		|| (null)
 * 		|| weaponslot	|| weight				|| (null)		|| (null)
 * 		|| weaponslot	|| size					|| (null)		|| medium
 * 		|| weaponslot	|| type					|| (null)		|| slashing
 */