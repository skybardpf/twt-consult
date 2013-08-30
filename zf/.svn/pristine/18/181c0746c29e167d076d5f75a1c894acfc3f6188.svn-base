<?php
/**
 * This file contains class for abstract work with database
 *
 * @version 1.0, SVN: $Id: mysql.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category DataBase
 * @package zFramework
 * @subpackage DB
 */

/**
 * Class for work with MySQL database
 *
 * @category DataBase
 * @package zFramework
 * @subpackage DB
 */
class mysql extends db
{
	/**
	* Used to storing recource handle of query
	*
	* @var resource
	*/
	private $res;

	/**
	* Stores link to the database server
	*
	* @var resource
	*/
	public $link;

	/**
	* Constructor. Connects to MySQL databast with parameters passed.
	*
	* @param string $host Database host
	* @param string $port Database port
	* @param string $user Database username
	* @param string $pass Database user password
	* @param string $dbase Database name
	* @param string $dbcset Database connection character set
	* @return mysql
	*/
	public function __construct($host, $port, $user, $pass, $dbase, $dbcset, $sql_mode = null)
	{
		$this->init();
		$stime = $this->time();

		$this->link = $this->conf['use_pconnect']
		?
		mysql_pconnect($host.':'.$port, $user, $pass, 1)
		:
		mysql_connect($host.':'.$port, $user, $pass, 1);

        if (!$this->link) die("Sorry, can`t connect to database.");
		mysql_select_db($dbase);

		$this->dbName = $dbase;

		mysql_query('set CHARACTER SET '.str_replace('-', '', $dbcset), $this->link);

		$this->db_stat['tconn'] = $this->time() - $stime;
		if ($sql_mode !== null) {
			mysql_query("set sql_mode = '$sql_mode'");
		}
	}

    public function close()
    {
        return $this->link ? mysql_close($this->link) : false;
    }

	/**
	* Executes a query
	*
	* @return boolean
	*/
	public function execute()
	{
		if ($this->ret_type == 'PAGE' or $this->ret_type == 'VIRTUAL_PAGE') {
			if ($this->ret_type == 'PAGE') $this->ret_type  = '';
			$this->raw_query = substr_replace($this->raw_query, 'select sql_calc_found_rows', 0, 6)." limit {$this->from}, {$this->num}";
			$this->res       = mysql_query($this->raw_query, $this->link);
			$ret             = mysql_fetch_row(mysql_query('select found_rows()', $this->link));
			$this->total     = array_shift($ret);
		} else {
			$this->res   = mysql_query($this->raw_query, $this->link);
		}

		if (!$this->res) {
			$this->error = mysql_errno($this->link).'. '.mysql_error($this->link);
			return false;
		}
		return true;
	}

	/**
	* Performes query
	*
	* @return void
	*/
	public function perform_query()
	{
		$dont_free = 0;
		if ($this->error) {
			$this->ret = null;
			return;
		}


		switch ($this->ret_type) {
			case '':
				switch ($this->qtype) {
					case 'desc':
						$dont_free = 1;
					case 'show':
						$dont_free = 1;
					case 'select':
						$this->ret = array();
						if (mysql_num_rows($this->res)) {
							while ($row = mysql_fetch_assoc($this->res)) {
								$this->ret[] = misc::stripslashes_deep($row);
							}
						}
					break;

					case 'insert':
						$this->ret = mysql_insert_id($this->link);
						$dont_free = 1;
					break;

					case 'update':
						$this->ret = mysql_affected_rows($this->link);
						$dont_free = 1;
					break;

					case 'delete':
						$this->ret = mysql_affected_rows($this->link);
						$dont_free = 1;
					break;

					default: $this->ret = 'manual';
				}
			break;

			case 'COL':
				$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$this->ret[] = stripslashes(array_shift($row));
				}
			break;

			case 'KARR':
				$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$this->ret[stripslashes(array_shift($row))] = stripslashes(array_shift($row));
				}

			break;

			case 'FULL_KARR':
				$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$this->ret[stripslashes(array_shift($row))] = misc::stripslashes_deep($row);
				}
			break;
			case 'FULL_KARR_QUERY':
		 		$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$key = stripslashes(array_shift($row));
					//if (!empty($this->ret[$key])) $this->ret[$key] = array();
					$this->ret[$key][] = misc::stripslashes_deep($row);
				}
			break;

			case 'GROUP_KARR':
		 		$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$key = stripslashes(array_shift($row));
					//if (!empty($this->ret[$key])) $this->ret[$key] = array();
					$this->ret[$key][stripslashes(array_shift($row))] = stripslashes(array_shift($row));
				}
			break;

			case 'ARRAY':
				$this->ret = mysql_num_rows($this->res) ? misc::stripslashes_deep(mysql_fetch_row($this->res)) : array();
			break;

			case 'ASSOC':
				$this->ret = mysql_num_rows($this->res) ? misc::stripslashes_deep(mysql_fetch_assoc($this->res)) : array();
			break;

			case 'ONE':
				$row = mysql_num_rows($this->res) ? mysql_fetch_row($this->res) : '';
				$this->ret = $row ? stripslashes(array_shift($row)) : '';
			break;

			case 'VIRTUAL_FIRST':
		 		$this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					if (isset($this->ret[$row['id']])) continue;
					$retRow = misc::stripslashes_deep($row);
					$vArr   = array();
					foreach ($this->virtual_fields as $vKey => $vFields) {
						foreach ($vFields as $vFieldName) {
							$vArr[$vFieldName] = $retRow[$vKey.'_'.$vFieldName];
							unset($retRow[$vKey.'_'.$vFieldName]);
						}
					}
					$this->ret[$retRow['id']] = $retRow;
					$this->ret[$retRow['id']][$vKey] = $vArr;
				}
			break;

			case 'VIRTUAL_ONE':
                $this->ret = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$retRow = misc::stripslashes_deep($row);
					foreach ($this->virtual_fields as $vKey => $vFields) {
						$vArr   = array();
						$all_empty = 1;
						if ($vFields['key_value']) {
                            if (!empty($retRow[$vKey.'_'.$vFields['key_value']])) {
                                    $all_empty = 0;
                                }
                            $vArr = $retRow[$vKey.'_'.$vFields['key_value']];
                            unset($retRow[$vKey.'_'.$vFields['key_value']]);
                        }
                        else {
                            foreach ($vFields['fields'] as $vFieldName) {
                                if (!empty($retRow[$vKey.'_'.$vFieldName])) {
                                    $all_empty = 0;
                                }
                                $vArr[$vFieldName] = $retRow[$vKey.'_'.$vFieldName];
                                unset($retRow[$vKey.'_'.$vFieldName]);
                            }
                        }
						if (!$this->ret) $this->ret = $retRow;
						if (!$all_empty) {
                            if ($vFields['key_value']) {
                                $this->ret[$vKey][] = $vArr;
                            }
							else {
                                $this->ret[$vKey][$vArr[$vFields['fields'][0]]] = $vArr;
                            }
						} else if (!isset($this->ret[$vKey])) {
							$this->ret[$vKey] = array();
						}
					}
				}
			break;
			case 'VIRTUAL_PAGE':
			case 'VIRTUAL_LIST':
		 		$this->ret = array();
                $was = array();
				while ($row = mysql_fetch_assoc($this->res)) {
					$retRow = misc::stripslashes_deep($row);
					foreach ($this->virtual_fields as $vKey => $vFields) {
						$vArr   = array();
                        if (!isset($was[$vKey])) $was[$vKey] = array();
						foreach ($vFields['fields'] as $vFieldName) {
							if (!empty($retRow[$vKey.'_'.$vFieldName])) {
								$vArr[$vFieldName] = $retRow[$vKey.'_'.$vFieldName];
							}
							unset($retRow[$vKey.'_'.$vFieldName]);
						}
						$id = $retRow[!empty($vFields['idFieldName']) ? $vFields['idFieldName'] : 'id'];

						if (!isset($this->ret[$id])) $this->ret[$id] = $retRow;
						if (!isset($this->ret[$id][$vKey])) $this->ret[$id][$vKey] = array();
						if (empty($vArr)) continue;

                        if (!in_array($vArr[$vFields['fields'][0]], $was[$vKey]) || 1) {
                        	if (!empty($vFields['assoc'])) {
                        		$this->ret[$id][$vKey][$vArr[$vFields['fields'][0]]] = $vArr;
                        	} elseif (!is_array($this->ret[$id][$vKey])) {
                        		$this->ret[$id][$vKey] = array($vArr);
                        	} else {
						    	$this->ret[$id][$vKey][] = $vArr;
                        	}
                            $was[$vKey][] = $vArr[$vFields['fields'][0]];
                        }

					}
				}
/*                if (!in_array($vArr[$vFields['fields'][0]], $was[$vKey])) {
					$this->ret[$id][$vKey][] = $vArr;
                    $was[$vKey][] = $vArr[$vFields['fields'][0]];
                }*/

			break;
		}
		if ($this->res && !$dont_free) {
			@mysql_free_result($this->res);
		}
	}

	/**
	* put your comment there...
	*
	* @param string $str String to escape
	* @param string $tp Type of string
	* @return string
	*/
	public function escape($str, $tp = '')
	{
		if ($str === null) return 'null';
        if ($str === 'DB_NOW') {
            return 'NOW()';
        }
		switch ($tp) {
			case '': return $str === 'null' ? 'NULL' : "'".mysql_real_escape_string($str)."'";
			case 'd': return (int) $str;
			case 'f': return (float) $str;
			case 't': return strpos($str, '.') !== false ? "`".str_replace('.', "`.`", $str)."`" : "`$str`";
			case 'i': return $str === null ? 'NULL' : $str;
		}
	}

	/**
	* Convertes dates between system format and db representative
	*
	* @param string $vtype
	* @param string $dir
	* @param string $val
	* @return string
	*/
	public function convert($vtype, $dir, $val)
	{
		if ($dir == 'from') {
			switch ($vtype) {
				case 'date': return preg_match("/^\d\d\d\d-\d\d-\d\d$/", $val) ? implode('.', array_reverse(explode('-', $val))) : $val;
				case 'datetime':
					if (!$val) return '';
					$parts  = explode(' ', $val);
					$arr    = explode(':', $parts[1]);
					array_pop($arr);
					return implode('.', array_reverse(explode('-', $parts[0]))).' '.implode(':', $arr);
				break;
			}
		} else {
			switch ($vtype) {
				case 'date': return $val ? implode('-', array_reverse(explode('.', $val))) : '0000-00-00';
				case 'datetime':
					if (!$val) return '';
					$parts  = explode(' ', $val);
					$hparts = explode(':', $parts[1]);
					if (count($hparts) < 3) $hparts[] = '00';
					return implode('-', array_reverse(explode('.', $parts[0]))).' '.implode(':', $hparts);
				break;
			}
		}

	}

	public function getFieldsFromSQL($sql)
	{
		preg_match_all("/`([^`]+)`\s([^,]+)/", $sql, $out, PREG_SET_ORDER);
		$ret = array();
		foreach ($out as $o) {
			$ret[$o[1]] = $o[2];
		}
		return $ret;
	}

	public function addFields($tbl, $fields)
	{
		foreach ($fields as $fld_name => $fld) {
			$after = isset($fld['after']) ? $fld['after'] : '';
			$after ?
				$this->query("ALTER TABLE ?t ADD ?t ?i AFTER ?t", $tbl, $fld_name, $fld['creation'], $after)
				:
				$this->query("ALTER TABLE ?t ADD ?t ?i", $tbl, $fld_name, $fld['creation']);
		}
	}

	public function isTable($tbl)
	{
		return $this->one('show tables like ?', $this->add_prefix($tbl));
	}

	public function getFields($tbl)
	{
		$res = $this->query('SHOW COLUMNS FROM ?t', $tbl);
		$ret = array();
		while ($row = mysql_fetch_assoc($this->res)) {
			$ret[$row['Field']] = misc::stripslashes_deep($row);
		}
	   return $ret;
	}

    protected function joinKeyFields($fields)
    {
        $arr = array();
        foreach ($fields as $fieldName) {
            $arr[] = $this->escape($fieldName, 't');
        }
        return implode(',', $arr);
    }

	public function getTableParams($params)
	{
        $ret = array();
		foreach ($params as $key => $value) {
			switch ($key) {
				case 'PRIMARY KEY':
                    if (is_array($value)) {
					    $ret[] = "\tPRIMARY KEY (".$this->joinKeyFields($value).")";
                    } else {
                        $ret[] = "\tPRIMARY KEY (".$this->escape($value, 't').")";
                    }
				break;

				case 'KEYS':
                    foreach ($value as $keyName => $keyFields) {
                        $ret []= "\tKEY ".$this->escape($keyName, 't').'('.$this->joinKeyFields($keyFields).')';
                    }
                break;

				case 'UNIQUE':
                    foreach ($value as $keyName => $keyFields) {
                        $ret []= "\tUNIQUE KEY ".$this->escape($keyName, 't').'('.$this->joinKeyFields($keyFields).')';
                    }
				break;

                case 'FULLTEXT':
                    foreach ($value as $keyName => $keyFields) {
                        $ret []= "\tFULLTEXT KEY ".$this->escape($keyName, 't').'('.$this->joinKeyFields($keyFields).')';
                    }
                break;
			}
		}
		return implode(",\n", $ret);
	}

	public function buildJoin($modelFields, $modelTables, $tableName, $fields, $refs, &$cond, $fSQL = '?li')
	{
        $this->virtul_fields = array();
		$sql      = "SELECT $fSQL FROM ?t AS `$tableName`";
		$joins    = array();
		$args     = array($modelTables[$tableName]);
		$fieldsArr = array();
		$usedRefs  = array();
		foreach ($modelFields as $fldName => $fld) {
			if (is_array($fld)) {
				$last = 0;
				if (isset($fld['use_ref']) and !empty($refs[$fld['use_ref']]['ref'])) { // ���������� ������������ �����

				} elseif (isset($fld['use_ref']) and !empty($refs[$fld['use_ref']]['alias'])) { // ���������� �����, �������� � �������
					$alias = $refs[$fld['use_ref']]['alias'];
				} elseif (isset($fld['table'])) { // � �������� ������ ���������� ��� �������
					$alias = str_replace('?_', '', $fld['table']);
				} else {
					$alias = $tableName;
				}
				if (!empty($fld['virtual'])) {
					$this->virtual_fields[$fldName] = array(
						'fields'      => $fld['fields'],
						'idFieldName' => !empty($fld['idFieldName']) ? $fld['idFieldName'] : 'id',
                        'id'          => !empty($fld['id']) ? $fld['id'] : 'id',
						'assoc'       => !empty($fld['assoc']) ? $fld['assoc'] : 0,
                        'key_value'   => !empty($fld['key_value']) ? $fld['key_value'] : false,
					);
					foreach ($fld['fields'] as $vFieldName)  {
						$fieldsArr[] = $alias.".$vFieldName AS `{$fldName}_$vFieldName`";
					}
					if (!isset($fld['use_ref']) or in_array($fld['use_ref'], $usedRefs)) continue;
					if ($refs[$fld['use_ref']]['type'] == 'N-M' || $refs[$fld['use_ref']]['type'] == 'M-N') {
						$ref    = $refs[$fld['use_ref']];
						$vJoin  = $refs[$fld['use_ref']]['tables'];
						$last   = 1;
						$joined = array($tableName);
						foreach ($vJoin as $vJoinPart) {
							$arg2join  = array();
							foreach ($vJoinPart as $tf) {
								if (in_array($tf['table'], $joined) and empty($tf['alias'])) {
									$arg2join[] = $tf['table'].'.'.$tf['field'];
								} else {
									$joins[] = (!empty($ref['join']) ? $ref['join'] : '')." JOIN ?t AS ".(empty($tf['alias']) ? $tf['table'] : $tf['alias'])." ON ?t = ?t";
									$args    = array_merge($args, array(
										!empty($modelTables[$tf['table']]) ? $modelTables[$tf['table']] : $fld['table'],
										(empty($tf['alias']) ? $tf['table'] : $tf['alias']).'.'.$tf['field']
									));
									$joined[] = $tf['table'];
								}
								if (!empty($tf['cond'])) {
									list($innerCondField, $innerCondValue) = each($tf['cond']);
									$joins[count($joins) - 1] .= ' AND ?t = '.(strpos($innerCondValue, '.') !== false ? '?t': '?');
									$arg2join = array_merge($arg2join, array((empty($tf['alias']) ? $tf['table'] : $tf['alias']).'.'.$innerCondField, $innerCondValue));
								}
							}
							$args = array_merge($args, $arg2join);
						}
					} else {
						$vJoin = $refs[$fld['use_ref']]['tables'][$fld['table']];

						if (is_array($vJoin)) {
							$refs[$fld['use_ref']]['tables'][$fld['table']] = $vJoin[0];
							$vValue = next($vJoin);
							$vField = $alias.'.'.key($vJoin);
							if (isset($cond['where'])) {
								$cond['where'] = array_merge($cond['where'], array($vField => $vValue));
							} else {
								$cond['where'] = array($vField => $vValue);
							}
						}
					}
					//$join = !empty($refs[$fld['use_ref']]['join']) ? $refs[$fld['use_ref']]['join'] : "JOIN";
					//$joins[] = $join." ?t AS ".$alias." ON ?t = ?t";
				} else {
//					debug::dump($fld);
					$fieldsArr[] = (empty($fld['asis'])? $alias.".": '')."{$fld['field']} AS `$fldName`";
					if (!isset($fld['use_ref']) or in_array($fld['use_ref'], $usedRefs)) continue;
				}
				$join_cond = array();
				if (!empty($refs[$fld['use_ref']]['tables']['cond'])) {
					foreach ($refs[$fld['use_ref']]['tables']['cond'] as $join_cond_field => $join_cond_val) {
						$join_cond[] = $join_cond_field.' = \''.mysql_real_escape_string($join_cond_val).'\'';
					}
				}

				if (!empty($join_cond)) {
					$join_cond = ' AND '.implode(' AND ', $join_cond);
				} else {
					$join_cond = '';
				}
				if (empty($last)) {
					$join = (!empty($refs[$fld['use_ref']]['join']) ? $refs[$fld['use_ref']]['join'] : '').' join';
					$joins[] = $join." ?t AS ".$alias." ON ?t = ?t".$join_cond;
				}


				//if (!empty($refs[$fld['use_ref']]['join'])) {

				//}
				if (empty($fld['via']) && empty($last)) {
					$left = $tableName.'.'.(
						!empty($refs[$fld['use_ref']]['tables'])
							?
						$refs[$fld['use_ref']]['tables'][$tableName]
							:
						$refs[$fld['use_ref']]['self'][0]
						);
				} elseif (empty($last)) {
					if (isset($refs[$fld['use_ref']]['tables'])) {
						$left = $fld['via'].'.'.$refs[$fld['use_ref']]['tables'][$fld['via']];
					} elseif ($refs[$fld['use_ref']]['self']) {
						$left = $fld['via'].'.'.$refs[$fld['use_ref']]['self'][0];
					}
				}
				if (empty($last)) {
					$args      = array_merge($args, array(!empty($modelTables[$fld['table']]) ? $modelTables[$fld['table']] : '?_'.$fld['table'],
						$left,
						(empty($refs[$fld['use_ref']]['alias']) ? $fld['table'] : $refs[$fld['use_ref']]['alias'])
						.'.'.
							(
								!empty($refs[$fld['use_ref']]['tables'][$fld['table']])
									?
								$refs[$fld['use_ref']]['tables'][$fld['table']]
									:
								$refs[$fld['use_ref']]['self'][1]
							)
						)
					);
				}
				$usedRefs[] = $fld['use_ref'];
			} else {
				$fieldsArr[] = $this->escape(empty($fld['asis'])? $tableName.'.'.$fldName : $fldName, 't');
			}
		}
		array_unshift($args, $fieldsArr);
		$sql .= ' '.implode("\r\n", $joins);
		return array($sql, $args);
	}

	/**
	* Returns SQL creation string of a field represented by $fieldName
	*
	* @param string $fieldName
	* @param array $data
	*/
	public function getFieldCreation($fieldName, $data, $includeFieldName = 1)
	{
        if ($includeFieldName) {
        	$fld = "\t$fieldName {$data['type']}";
		} else {
			$fld = strtolower("{$data['type']}");
		}
		if (isset($data['length']) && strpos(strtolower($data['type']), 'enum') !== 0) {
			$fld .= "({$data['length']})";
		} else {
			switch ($data['type']) {
				case 'tinyint': $fld .= '(3)'; break;
				case 'smallint': $fld .= '(5)'; break;
				case 'mediumint': $fld .= empty($data['unsigned']) ? '(7)' : '(8)'; break;
				case 'int': $fld .= empty($data['unsigned']) ? '(10)' : '(11)'; break;
				case 'bigint': $fld .= empty($data['unsigned']) ? '(19)' : '(20)'; break;
			}
		}
		// тип SET идет в xyz, ибо нужно использовать N-M связи.
		if (!empty($data['unsigned'])) $fld .= " unsigned";
		if (!empty($data['zerofill'])) $fld .= " zerofill";

		if ($data['type'] == 'varchar') {
			if (empty($data['notnull']) && empty($data['default'])) {
				$fld .= " default NULL";
			} elseif (!empty($data['default']) && empty($data['notnull'])) {
				$fld .= " default '{$data['default']}'";
			} elseif (!empty($data['notnull']) && empty($data['default'])) {
				$fld .= " NOT NULL";
			} else {
				$fld .= " NOT NULL default '{$data['default']}'";
			}
		} elseif ($data['type'] == 'timestamp') {
			if (!empty($data['notnull'])) $fld .= " NOT NULL";
			if (!empty($data['default']) and $data['default'] == 'CURRENT_TIMESTAMP') {
				$fld .= " default {$data['default']}";
			} elseif (!empty($data['default'])) {
				$fld .= " default '{$data['default']}'";
			}
		} else {
			if (!empty($data['notnull'])) $fld .= " NOT NULL";
			if (!empty($data['default'])) $fld .= " default '{$data['default']}'";
		}
		if (!empty($data['auto_increment'])) $fld .= " auto_increment";
		return $fld;
	}

	/**
	* Returns SQL query needed to get table structure from DB
	*
	*/
	protected function getDescSQL()
	{
		return 'desc ?t';
	}

    /**
    * Returns table keys
    *
    * @param string $tableName
    * @return array
    */
    public function getTableKeys($tableName)
    {
        $ret = array();
        foreach ($this->query('show keys FROM ?t', $tableName, 1) as $row) {
            if (!isset($ret[$row['Key_name']])) {
                $ret[$row['Key_name']] = array(
                    'fields' => array()
                );

                if ($row['Key_name'] == 'PRIMARY') {
                    $ret[$row['Key_name']]['type'] = 'PRIMARY KEY';
                } elseif ($row['Index_type'] == 'FULLTEXT') {
                    $ret[$row['Key_name']]['type'] = 'FULLTEXT';
                } elseif ($row['Non_unique'] == 0) {
                    $ret[$row['Key_name']]['type'] = 'UNIQUE';
                } else {
                    $ret[$row['Key_name']]['type'] = '';
                }
            }
            $ret[$row['Key_name']]['fields'][$row['Seq_in_index'] - 1] = $row['Column_name'];
        }
        return $ret;
    }
}
?>
