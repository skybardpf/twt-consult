<?php
/**
 * This file contains Model class
 *
 * @version 1.0, SVN: $Id: model.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * The base class for all models in zFramework
 *
 * @category DataBase
 * @package zFramework
 * @subpackage Core
 */
class Model extends ConfLoader
{
	/**
	 * Stores DB object
	 *
	 * @var db
	 */
	protected $db;

	/**
	 * Stores configuration array
	 *
	 * @var array
	 */
	public $conf;

	/**
	 * Stores model tables
	 *
	 * @var array
	 */
	public $tables;

	/**
	 * Stores processed fields of model tables
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Stores processed refereces between model tables
	 *
	 * @var array
	 */
	protected $refs   = array();

	/**
	 * Stores name of the model
	 *
	 * @var string
	 */
	public $modName;

	/**
	 * Stores name of the controller which loaded the model
	 *
	 * @var string
	 */
	public $ctrlName;


	/**
	 * Stores object of Controller class
	 *
	 * @var Controller
	 */
	protected $ctrl = null;

	/**
	 * Stores data returned by Get method
	 *
	 * @var array
	 */
	public $data;

	/**
	 * Directory where model file situated
	 *
	 * @var string
	 */
	public $directory = '';

	public $virtual_fields = array();

	protected $dont_install = 0;

	/**
	 * Loads configuration. Initializes model.
	 *
	 * @param mixed $ctrlName
	 * @param mixed $modName
	 * @return Model
	 */
	public function __construct($ctrlName, $modName, $ctrl, $db = null, $directory = '')
	{
		$this->ctrlName  = $ctrlName;
		$this->modName   = $modName;
		$this->directory = $directory;
		$this->ctrl      = $ctrl;
		$this->db        = $db !== null ? $db : zf::$db;
		$this->loadConfig();
		$this->init();
		if ($this->has_been_compiled && !$this->dont_install) {
			$this->install();
		}
	}

	/**
	 * Loads models's configuration file.
	 *
	 * @return void
	 */
	protected function loadConfig($fileName = '')
	{
		if (!$fileName) {

			$fileName = $this->directory
			?
			    "{$this->directory}/{$this->modName}.conf.yml"
			:
			$this->ctrl->app->getModelConfFileName($this->modName, $this->ctrlName);
		}
		if (!file_exists($fileName)) return;
		$this->conf = parent::loadConf($fileName);
	}

	/**
	 * Returns placeholded basing on field type of $fieldName and its value ($value)
	 *
	 * @param string $tableName
	 * @param string $fieldName
	 * @param mixed $value
	 * @return string
	 */
	protected function getExpr($tableName, $fieldName, $value)
	{
		if ($value === null) return '?t IS ?i';
		$sign = '=';
		if (is_array($value)) {
			$sign        = $value[0];
			$placeholder = misc::get($value, 2, '?');
			//$value       = $value[1];
		} else {
			$placeholder = '?';
		}

		return $sign == 'IN' ? "?t $sign ".(isset($value[2]) ? $placeholder : '?i') : "?t $sign $placeholder";
		/*		if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['type'])) {
			return
			strpos($this->conf['tables'][$tableName]['fields'][$fieldName]['type'], 'int') !== false
			?
			"?t $sign ?d"
			:
			"?t $sign ?";
			} else {
			return "?t $sign ?";
			}*/
	}

	protected function sortCond($a, $b)
	{
		if ($a == 'where') return -1;
		if ($b == 'where') return 1;
		if ($a == 'group' && $b == 'having') return -1;
		if ($a == 'group' && $b == 'order') return -1;
		if ($a == 'having' && $b == 'order') return -1;
		return 1;
	}

	/**
	 * Returns conditions suitable to execute by DB server.
	 *
	 * @param string $tableName
	 * @param mixed $cond
	 * @return array(string, array)
	 */
	protected function getConditions($tableName, $cond, $noWhere = false)
	{
		if (!$cond) return array('', array());
		if (!is_array($cond) && is_numeric($cond)) {
			return array(($noWhere ? '' : ' WHERE' ).' ?t = ?d', array('id', $cond));
		}
		$key = key($cond);
		if (!isset($cond['where']) && empty($cond['order']) && empty($cond['group']) && count($cond) == count($cond, COUNT_RECURSIVE)) {
			return $this->getConditions($tableName, array('where' => $cond), $noWhere);
		} else {
			$sql  = '';
			$args = array();
			uksort($cond, array($this, 'sortCond'));
			foreach ($cond as $condType => $condData) {
				switch ($condType) {
					case 'where': // or numeric }:->
						if ($condData) {
							$sql .= $noWhere ? '' : ' WHERE ';
						} else {
							$sql = '';
						}
						if (!empty($condData)) {
							$s    = array();
							foreach ($condData as $fieldName => $value) {
								if (strlen($fieldName) >= 4 && substr($fieldName,0,4) == '!raw') {
									$s[] = $value;
									continue;
								}
								$s[]  = $this->getExpr($tableName, $fieldName, $value);
								$args = array_merge($args, array($fieldName, is_array($value) ? $value[1] : $value));
							}
							$sql .= implode(' AND ', $s);
						}
						break;

					case 'order':
						$sql .= ' ORDER BY ';
						$s    = array();
						foreach ($condData as $fieldName => $dir) {
							if ($fieldName == 'rand') {
								$s[]    = "RAND()";
							} else {
								$s[]    = "?t $dir";
								$args[] = $fieldName;
							}
						}
						$sql .= implode(', ', $s);
						break;

					case 'group':
						$sql .= ' GROUP BY ';
						$s    = array();
						foreach ($condData as $fieldName) {
							$s[]    = "?t";
							$args[] = $fieldName;
						}
						$sql .= implode(', ', $s);
						break;

					case 'having':
						$sql .= ' HAVING ';
						$s    = array();
						foreach ($condData as $fieldName => $value) {
							if ($fieldName == '!raw') {
								$s[] = $value;
								continue;
							}
							$s[]  = $this->getExpr($tableName, $fieldName, $value);
							$args = array_merge($args, array($fieldName, is_array($value) ? $value[1] : $value));
						}
						$sql .= implode(' AND ', $s);
						break;

                    case 'limit':
                        $sql .= ' LIMIT '.$condData;
				}
			}
		}
		return array($sql, $args);
	}

	/**
	 * Returs list of the requested orecords.
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   'where' => array('Manager_ID' => 10, 'Client_ID' => 14),
	 *   'group' => array('Region_ID', 'Date'),
	 *   'order' => array('Manager_ID' => 'ASC', 'Client_ID' => 'DESC')
	 * )
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14 GROUP BY Region_ID, Date ORDER BY Manager_ID ASC, Client_ID DESC
	 *
	 * @param string $tableName Name of the table.
	 * @param array $fields Something like array('ID', 'Name', ...)
	 * @param mixed $cond
	 */
	public function getList($tableName, $fields, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '')
	{
		$this->initFields($tableName, $fields);
		if (!empty($this->refs)) {
			return $this->getListJoined($tableName, $fields, $cond, $additionalSql, $additionalArgs, $fSQL ? $fSQL : '?li');
		}
		if (!$fSQL) $fSQL = '?lt';
		if (!$fields) $fields = array_keys($this->fields[$tableName]);
		list($cSql, $cArgs) = $this->getConditions($tableName, $cond);

		if ($additionalArgs) {
			if ($cArgs) {
				$cArgs = array_merge($additionalArgs, $cArgs);
			} else {
				$cArgs = $additionalArgs;
			}
		}
		$args = $cArgs ? array_merge(array($fields), array($this->tables[$tableName], $tableName), $cArgs)
		: array_merge(array($fields), array($this->tables[$tableName], $tableName));
		return $this->db->query("SELECT $fSQL FROM ?t AS ?t".$additionalSql.$cSql, $args);
        }


	/**
	 * Returs list of the requested orecords.
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   'where' => array('Manager_ID' => 10, 'Client_ID' => 14),
	 *   'group' => array('Region_ID', 'Date'),
	 *   'order' => array('Manager_ID' => 'ASC', 'Client_ID' => 'DESC')
	 * )
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14 GROUP BY Region_ID, Date ORDER BY Manager_ID ASC, Client_ID DESC
	 *
	 * @param string $tableName Name of the table.
	 * @param array $fields Something like array('ID', 'Name', ...)
	 * @param mixed $cond
	 */
	public function getListJoined($tableName, $fields, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '?li')
	{
        $this->initFields($tableName, $fields);
		if (empty($this->refs))
            return $this->getList($tableName, $fields, $cond, $additionalSql, $additionalArgs);
		list($sql, $args) = $this->db->buildJoin(
		    $this->fields[$tableName], $this->tables, $tableName, $fields, $this->refs, $cond, $fSQL
		);
		$sql .= $additionalSql;

		list($cSql, $cArgs) = $this->getConditions($tableName, $cond);

		if ($additionalArgs) {
			if ($cArgs) {
				$cArgs = array_merge($additionalArgs, $cArgs);
			} else {
				$cArgs = $additionalArgs;
			}
		}

		if ($cArgs) $args = array_merge($args, $cArgs);

		return $this->virtual_fields ? $this->db->getVirtual('list',  $sql.$cSql, $args) : $this->db->query($sql.$cSql, $args);
	}

	public function getPage($tableName, $fields, &$total, $from, $npp, $cond = array(), $additionalSql = '', $additionalArgs = array())
	{
		$this->initFields($tableName, $fields);

		list($sql, $args) = $this->db->buildJoin(
		$this->fields[$tableName], $this->tables, $tableName, $fields, $this->refs, $cond
		);
		list($cSql, $cArgs) = $this->getConditions($tableName, $cond);

		if ($cArgs) $args = array_merge($args, $cArgs);
		return $this->db->page($total, $from, $npp, $sql.$cSql, $args);
	}

	public function getPageJoined($tableName, $fields, &$total, $from, $npp, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '?li')
	{
		$this->initFields($tableName, $fields);
		if (empty($this->refs))
		return $this->getPage($tableName, $fields, $total, $from, $npp, $cond, $additionalSql, $additionalArgs);
		list($sql, $args) = $this->db->buildJoin(
		$this->fields[$tableName], $this->tables, $tableName, $fields, $this->refs, $cond, $fSQL
		);

		$sql .= $additionalSql;

		list($cSql, $cArgs) = $this->getConditions($tableName, $cond);

		if ($additionalArgs) {
			if ($cArgs) {
				$cArgs = array_merge($additionalArgs, $cArgs);
			} else {
				$cArgs = $additionalArgs;
			}
		}

		if ($cArgs) $args = array_merge($args, $cArgs);
		return $this->virtual_fields ? $this->db->getVirtualPage($total, $from, $npp, $sql.$cSql, $args) : $this->db->page($total, $from, $npp, $sql.$cSql, $args);
	}

	public function getPageWithVirtual($tableName, $fields, &$total, $from, $npp, $cond = array()) {
		$ids = misc::array_extract_field(
	    	$this->getPage(
	        	$tableName, array('id'), $total,
	            	$from,
	                $npp,
	                $cond
	            ), 'id'
	        );
	    if (!isset($cond['where'])) {
	    	$cond['where'] = array($tableName . '.' . 'id' => array('IN', $ids, '(?l)'));
	    }
	    else {
	    	$cond['where'] = array_merge($cond['where'], array($tableName . '.' . 'id' => array('IN', $ids, '(?l)')));
	    }
	    $ret = $ids ? $this->getList(
			$tableName,
			$fields,
			$cond
		) : array();
		return $ret;
	}

	public function getFieldsNames($tableName, $action, $with_foreign = 0)
	{
		if ($action == 'all') {
			$ret = array_keys(array_filter($this->conf['tables'][$tableName]['fields'], array($this, 'filter_all_fields')));
			return $with_foreign ? array_merge($ret, array_keys($this->conf['tables'][$tableName]['foreign'])) : $ret;
		}
        else if($action == 'all_with_foreigns'){
            $ret = array_keys(array_filter($this->conf['tables'][$tableName]['fields'], array($this, 'filter_all_fields')));
            return array_merge($ret, array_keys($this->conf['tables'][$tableName]['foreign']));
        } else {
			if (isset($this->actions[$tableName][$action])) return $this->actions[$tableName][$action];
		}
		return array();
	}

	public function filter_all_fields($field)
	{
		if (empty($field['type']) && empty($field['virtual']) && empty($field['foreign'])) return 0;
		return 1;
	}

	public function getCount($tableName, $cond = array())
	{
		list($sql, $args) = $this->getConditions($tableName, $cond);
		return $this->db->one('SELECT count(*) FROM ?t '.$sql, array_merge(array($this->tables[$tableName]), $args));
	}

	/**
	 * Initializes fields. This method initializes fields and refs if needed acourding to $fields passed.
	 *
	 * @param string $tableName
	 * @param array $fields
	 */
	protected function initFields($tableName, $fields = array())
	{
		if (!empty($this->fields[$tableName]) && array_keys($this->fields[$tableName]) == $fields) {
			return;
		} elseif (!$fields) {
			$fields = $this->getFieldsNames($tableName, 'all');
		}
		$this->virtual_fields = array();
		$this->fields[$tableName] = array();
		foreach ($fields as $fieldName) {
			if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]) || !empty($this->conf['tables'][$tableName]['foreign'][$fieldName])){ //условие, необходимое, чтобы не инициализировались незаданные поля
				$fld = !empty($this->conf['tables'][$tableName]['fields'][$fieldName])
				? $this->conf['tables'][$tableName]['fields'][$fieldName]
				: $this->conf['tables'][$tableName]['foreign'][$fieldName];
				if (
				empty($fld['foreign']) && empty($this->conf['tables'][$tableName]['foreign'][$fieldName])
				&&
				empty($fld['virtual'])
				) {
					$this->fields[$tableName][$fieldName] = 1;
				} elseif (!empty($fld['virtual'])) {
					$this->fields[$tableName][$fieldName]       = $fld['ref_to'];
					$this->virtual_fields[$fieldName] = array(
						'fields'      => $fld['ref_to']['fields'],
						'idFieldName' => !empty($fld['ref_to']['idFieldName']) ? $fld['ref_to']['idFieldName'] : 'id',
                        'id'          => !empty($fld['ref_to']['id']) ? $fld['ref_to']['id'] : 'id',
						'field_type'  => isset($fld['am']['type'])?$fld['am']['type']:null
					);
					$this->refs[$fld['ref_to']['use_ref']]      = $this->conf['refs'][$fld['ref_to']['use_ref']];
				} else {
					if (empty($this->conf['tables'][$tableName]['foreign'][$fieldName])) {
						$this->fields[$tableName][$fieldName] = $fld['ref_to'];
						if (empty($this->refs[$fld['ref_to']['use_ref']])) {
							$this->refs[$fld['ref_to']['use_ref']] = $this->conf['refs'][$fld['ref_to']['use_ref']];
						}
					} else {
						$this->fields[$tableName][$fieldName] = $this->conf['tables'][$tableName]['foreign'][$fieldName];
						if (isset($this->conf['tables'][$tableName]['foreign'][$fieldName]['use_ref']) and
						empty($this->refs[$this->conf['tables'][$tableName]['foreign'][$fieldName]['use_ref']])) {
							$this->refs[$this->conf['tables'][$tableName]['foreign'][$fieldName]['use_ref']]
							= $this->conf['refs'][$this->conf['tables'][$tableName]['foreign'][$fieldName]['use_ref']];
						}
					}
				}
			}
		}
	}

	/**
	 * Initialises model
	 *
	 */
	protected function init()
	{
		if (isset($this->conf['tables'])) {
            //no_prefix for table list
            //no_prefix: photogalleries, photo
            if(!empty($this->conf['no_prefix'])&&$this->conf['no_prefix']!='1') {
                $nopref = explode(",", $this->conf['no_prefix']);
                foreach($nopref as $key=>$val)
                    $nopref[$key] = trim($val);
                foreach (array_keys($this->conf['tables']) as $tableName) {
					$this->tables[$tableName] = (in_array($tableName, $nopref) ? '' : '?_' ).$tableName;
		        }
            } else{
                foreach (array_keys($this->conf['tables']) as $tableName) {
                    $this->tables[$tableName] = (empty($this->conf['no_prefix']) ? '?_' : '' ).$tableName;
                }
            }
		}
	}

	/**
	 * Returns SQL creation string for model Tables
	 * @todo implement one creation returning
	 * @param string $tblName Table name which creation will be returned. If not set returns creation of all defined tables
	 */
	public function getCreation($tblName = '', $byFields = 0, $includeFieldName = 1)
	{
		$creation = array();
		foreach ($this->conf['tables'] as $tableName => $table) {
			if ($tblName && $tblName != $tableName) continue;
			$fields = array();
			foreach ($table['fields'] as $field => $data) {
				if (!empty($data['virtual']) || empty($data['type'])) continue;
				if ($byFields) {
					$fields[$field] = trim($this->db->getFieldCreation($field, $data, $includeFieldName));
				} else {
					$fields[] = $this->db->getFieldCreation($field, $data, $includeFieldName);
				}
			}
			$params = !empty($table['table']) ? ",\n".$this->db->getTableParams($table['table']) : '';
			if ($byFields) {
				$creation[$tableName] = $fields;
			} else {
				$creation[$tableName] = "CREATE TABLE ?t (\n".implode(",\n", $fields).$params."\n)";
			}
		}
		return $tblName ? $creation[$tblName] : $creation;
	}

	/**
	 * Saves row in table. Basing on $cond calls Add() or Update() method
	 *
	 * @param string $tableName
	 * @param array $data
	 * @param array $cond
	 */
	public function Save($tableName, $data, $cond = null)
	{
		$this->initFields($tableName, array_keys($data));
        if (($data = $this->prepareData($tableName, $data)) === null) return null;
        $ret = ( !empty($cond) )
			? $this->Update($tableName, $data, $cond)
			: $this->Add($tableName, $data);

		$this->afterSave($tableName, $data, $cond, $ret);

		if ($ret !== null && !empty($this->virtual_fields)) {
			if ($ret == 0
			&& !empty($this->conf['tables'][$tableName]['table']['PRIMARY KEY'])
			&& !empty($data[$this->conf['tables'][$tableName]['table']['PRIMARY KEY']])) {
				$ret = $data[$this->conf['tables'][$tableName]['table']['PRIMARY KEY']];
			}
            $virtual_pid = '';
            if ($cond && is_array($cond)) {
                if (count($cond) == 1) $virtual_pid = current($cond);
                elseif (isset($cond['id'])) $virtual_pid = $cond['id'];
            }
            elseif($cond) $virtual_pid = $cond;
            else $virtual_pid = $ret;
			foreach ($this->virtual_fields as $fieldName => $field) {
				if (misc::get($field, 'field_type') == 'images') {
					$this->SaveVirtualImages($tableName, $field['data'], $virtual_pid);
				} elseif (misc::get($field, 'field_type') == 'files') {
					$this->SaveVirtualFiles($tableName, $field['data'], $virtual_pid);
				} elseif (misc::get($field, 'field_type') == 'mfiles') {
                    $this->SaveVirtualMfiles($field['tablename'], $tableName, $field['data'], $virtual_pid);
                } else {
					$this->SaveVirtual($tableName, $field, $virtual_pid, $fieldName);
				}
			}
		}
		return $ret;
	}

	protected function prepareData($tableName, $data)
	{
		$fields = $this->conf['tables'][$tableName]['fields'];
		foreach ($data as $fieldName => &$value) {
			if (!empty($fields[$fieldName]['virtual'])) {
				$this->virtual_fields[$fieldName] = array(
					'field' => $fields[$fieldName],
					'data'  => $value
				);
				unset($data[$fieldName]);
				continue;
			}
			if (empty($fields[$fieldName]['type'])) {
				continue;
			}
			switch (strtolower($fields[$fieldName]['type'])) {
				case 'date': $value = db::date_to_db($this->db, $value); break;
				case 'datetime': $value = db::datetime_to_db($this->db, $value); break;
			}
		}
		$this->initFields($tableName);
		return $data;
	}
	protected function afterSave($tableName, $data, $cond, $ret)
	{
	}
	protected function SaveVirtual($tableName, $field, $id, $fieldName = '')
	{
        if ($field['ref']['type'] == 'M-N' || $field['ref']['type'] == 'N-M') {
			$refTable  = '';
			$refField  = '';
			$refFieldF = '';
			$del_cond  = array();
			foreach ($field['ref']['tables'] as $tablesCollection) {
				for ($i = 0; $i < 2; $i++) {
					if ($tablesCollection[$i]['table'] == $tableName && !$refTable) {
						$refTable = $tablesCollection[1 - $i]['table'];
						$refField = $tablesCollection[1 - $i]['field'];
					}
					if ($refTable && $tablesCollection[$i]['table'] != $refTable) {
						$refFieldF = !empty($tablesCollection[1 - $i]['editfield']) ? $tablesCollection[1 - $i]['editfield'] : $tablesCollection[1 - $i]['field'];
					}
					if ($refTable && $tablesCollection[$i]['table'] == $refTable && isset($tablesCollection[$i]['cond'])){
						$del_cond = $tablesCollection[$i]['cond'];
					}
				}
			}

			$fields = array($refField);
			if (is_array($id)) {
				if (isset($id['where'])) {
					$id = current(current($id));

				} else {
					$id = current($id);
				}
			}
			$values = array($id);

			if ($del_cond) {
				$fields = array_merge($fields, array_keys($del_cond));
				$values = array_merge($values, array_values($del_cond));
			}

			$del_cond[$refField] = $id;
			$this->Delete($refTable, $del_cond);

			// $this->db->query('DELETE FROM ?t WHERE ?t = ?d', $this->tables[$refTable], $refField, $id);

			if (empty($field['data'])) return;
	        foreach ($field['data'] as $lid) {
				$this->db->query('INSERT INTO ?t (?lt, ?t) values(?l, ?)', $this->tables[$refTable], $fields, $refFieldF, $values, $lid);
			}
		} else {

			foreach ($field['ref']['tables'] as $refTable => $refField) {
				if ($refTable == $tableName) continue;
				$del_cond  = array($refField => $id);
				break;
			}
			$this->Delete($refTable, $del_cond);
			if (empty($field['data'])) return;
			$fields = $this->conf['tables'][$tableName]['fields'][$fieldName]['ref_to']['insert_fields'];
			foreach ($field['data'] as $lid) {
				if (!empty($field['a_data'])) {
					$values = array_merge(array($lid), array_values($field['a_data']));
				} else {
					$values = array($lid);
				}
				$this->db->query('INSERT INTO ?t (?lt, ?t) values(?l, ?)', $this->tables[$refTable], $fields, $refField, $values, $id);
			}
		}
	}

	protected function SaveVirtualImages($tableName, $data, $pid)
	{
		foreach ($data as $image) {
			if (!empty($image['tmp_name']))
			$this->Save('images', array('image' => $image, 'model' => $tableName, 'pid' => $pid));
		}
	}

	protected function SaveVirtualFiles($tableName, $data, $pid)
	{
		foreach ($data as $file) {
			if (!empty($file['tmp_name'])) {
                $this->Save('files', array('file' => $file, 'model' => $tableName, 'pid' => $pid));
            }
		}
	}

    protected function SaveVirtualMfiles($tableName, $model, $data, $pid)
    {
        foreach ($data as $file) {
            if (!empty($file['name']))
            $this->Save($tableName, array('file' => $file, 'model' => $model, 'pid' => $pid));
        }
    }


	/**
	 * Inserts row into table.
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   array('Manager_ID' => 10, 'Client_ID' => 14),
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14
	 * @param string $tableName
	 * @param array $data
	 */
	public function Add($tableName, $data, $last = 0)
	{
        if (!empty($this->conf['tables'][$tableName]['on_create']) && is_array($this->conf['tables'][$tableName]['on_create'])) {
            $data[key($this->conf['tables'][$tableName]['on_create'])] = date(current($this->conf['tables'][$tableName]['on_create']));
        }
        $ret = $this->db->query('INSERT INTO ?t (?lt) VALUES(?l)',
		$this->tables[$tableName], array_keys($data), array_values($data)
		);
		if ($ret === null && !$last) {
			$error = $this->db->last_error();
			if (strpos($error, "doesn't exist") !== false && strpos($error, $tableName) !== false) {
				$this->install();
				return $this->Add($tableName, $data, 1);
			}
		}
		return $ret;
	}

	/**
	 * Updates row in table.
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   array('Manager_ID' => 10, 'Client_ID' => 14),
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14
	 * @param string $tableName
	 * @param array $data
	 */
	public function Update($tableName, $data, $cond)
	{
		if (!is_array($cond)) {
			return $this->db->query('UPDATE ?t SET ?a WHERE ?t = ?d',
			$this->tables[$tableName], $data, 'id', $cond
			);
		} else {
			list($sql, $args) = $this->getConditions($tableName, array('where' => $cond));
			return $this->db->query('UPDATE ?t SET ?a '.$sql,
			array_merge(array($this->tables[$tableName]), array($data), $args));
		}
	}
    /**
     * Increases $field value in $tableName by $count
     * @param $tableName
     * @param $field
     * @param $cond
     * @param int $count
     * @return mixed
     */
    public function Increment($tableName, $field, $cond, $count = 1){
        list($sql, $args) = $this->getConditions($tableName, $cond);
        return $this->db->query('UPDATE ?t SET ?i = ?i + ?d '.$sql,
			array_merge(array($this->tables[$tableName]), array($field, $field), array($count), $args));
    }

	/**
	 * Deletes row from table
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   array('Manager_ID' => 10, 'Client_ID' => 14),
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14
	 * @param string $tableName
	 * @param array $cond
	 */
	public function Delete($tableName, $cond)
	{
		if (!is_array($cond)) {
			return $this->db->query('DELETE FROM ?t WHERE ?t = ?d',
			$this->tables[$tableName], 'id', $cond
			);
		} else {
			list($sql, $args) = $this->getConditions($tableName, array('where' => $cond));
			return $this->db->query('DELETE FROM ?t'.$sql,
			array_merge(array($this->tables[$tableName]), $args)
			);
		}
	}

	/**
	 * Deletes row from table
	 * Condition can be represented by following:
	 * 1. Simple numeric value - in this case it will be interpreted like this " WHERE id = $cond"
	 * 2. Simple array('Department_ID' => 3) - in this case it will be interpreted like " WHERE ID = 3"
	 * 3. Or more complex array:
	 * <code>
	 * array(
	 *   array('Manager_ID' => 10, 'Client_ID' => 14),
	 * </code>
	 * above will be converted to:
	 * WHERE Manager_ID = 10 AND Client_ID = 14
	 * @param string $tableName
	 * @param array $cond
	 */
	public function DeleteRecursively($tableName, $id, $parentFieldName)
	{
		$ret    = 1;
		$childs = $this->db->col('SELECT id FROM ?t WHERE ?t = ?d', $this->tables[$tableName], $parentFieldName, $id);
		$ret    = $this->Delete($tableName, array('id' => $id));
		foreach ($childs as $child)
		{
			if ($this->DeleteRecursively($tableName, $child, $parentFieldName) === null) $ret = 0;
		}
		return $ret;
	}

	/**
	 * Returns one row from table
	 *
	 * @param integer $id
	 * @param string $tableName
	 * @param array $fields
	 * @return array
	 */
	public function Get($id, $tableName, $fields = array())
	{
		$this->initFields($tableName, $fields);
		if ($id === null or $id === false) {
			$this->data = array();
			return $this->data;
		}
		if ($this->virtual_fields) {
			if (empty($this->fields[$tableName])) $this->initFields($tableName, $fields);
			$cond = array('where' => array("$tableName.id" => $id));
			list($sql, $args) = $this->db->buildJoin(
			$this->fields[$tableName], $this->tables, $tableName, $fields, $this->refs, $cond
			);
			list($cSql, $cArgs) = $this->getConditions($tableName, $cond);

			if ($cArgs) $args = array_merge($args, $cArgs);
			$this->data = $this->db->getVirtual('one', $sql.$cSql, $args);

			/*debug::dump(array_diff($fields, array_keys($this->virtual_fields)));
			 $this->data = $this->db->getVirtual(array('one', $this->virtual_fields));*/

		} else {
			$this->data =
			$fields
			?
			$this->db->assoc('SELECT ?lt FROM ?t WHERE id = ?d', $fields, $this->tables[$tableName], $id)
			:
			$this->db->assoc('SELECT * FROM ?t WHERE id = ?d', $this->tables[$tableName], $id);
		}
		return $this->data;
	}

	protected function prepareToOutput($tableName, $fields)
	{
		return;
	}

	/**
	 * Returns one row from table by cond
	 *
	 * @param string $tableName
	 * @param array $fields
	 * @param array $cond
	 * @return array
	 */
	public function GetByCond($tableName, $fields = array(), $cond = array(), $force = 0)
	{
		if ($this->data && !$force) return $this->data;
		$this->initFields($tableName, $fields);
		list($sql, $args) = $this->db->buildJoin(
		$this->fields[$tableName], $this->tables, $tableName, $fields, $this->refs, $cond
		);
		list($cSql, $cArgs) = $this->getConditions($tableName, $cond);
		if ($cArgs) $args = array_merge($args, $cArgs);

		if ($this->virtual_fields) {
			$this->data = $this->db->getVirtual('one', $sql.$cSql, $args);
		} else {
			$this->data =
			$fields
			?
			$this->data = $this->db->assoc($sql.$cSql, $args)
			:
			$this->data = $this->db->assoc($sql.$cSql, $args);
		}
		return $this->data;
	}

	/**
	 * Retuns current max pos in table
	 *
	 * @param string $tableName
	 * @param array $cond Condition
	 */
	public function getPos($tableName, $cond = array(), $field = 'pos')
	{
		if (empty($cond)) {
			$sql = '';
			$args = array();
		} else {
			list($sql, $args) = $this->getConditions($tableName, array('where' => $cond));
		}
		if ( !empty($this->conf['tables'][$tableName]['add2head']) ) {
			$num = $this->db->one('SELECT MIN(?t) FROM ?t '.$sql, array_merge(array($field, $this->tables[$tableName]), $args));
			$this->db->query('UPDATE ?t SET ?t = ?t + 1 '.$sql, array_merge(array($this->tables[$tableName], $field, $field), $args));
		} else {
			$num = ($this->db->one('SELECT MAX(?t) FROM ?t '.$sql,
			array_merge(array($field, $this->tables[$tableName]), $args)
			) + 1);
		}
		return $num;
	}

	/**
	 * Determines whether has field specified
	 *
	 * @param string $tableName
	 * @param string $fieldName
	 * @return boolean
	 */
	public function hasField($tableName, $fieldName)
	{
		if (empty($this->fields[$tableName])) {
			$this->initFields($tableName, array($fieldName));
			$ret = isset($this->fields[$tableName][$fieldName]);
			$this->fields[$tableName] = array();
			return $ret;
		} else {
			return isset($this->fields[$tableName][$fieldName]);
		}
	}

	/**
	 * Shifts row in table up or down
	 *
	 * @param mixed $tableName
	 * @param mixed $id
	 * @param mixed $pos
	 */
	public function Shift($tableName, $id, $to, $cond = array(), $posFields = array('pos'))
	{
		list($sign, $dir) = $to == 'up' ? array ('<', 'desc') : array ('>', 'asc');
		$posArr = $this->db->assoc('select ?lt from ?t where id = ?d', $posFields, $this->tables[$tableName], $id);
		$pos    = $posArr[$posFields[0]];
		if ($pos == 0) {
			$this->db->query('UPDATE ?t SET ?t = id', $this->tables[$tableName], $posFields[0]);
			$pos = $id;
		}
		unset($posArr[$posFields[0]]);

		if (count($posFields) > 1 && empty($posArr[$posFields[1]]) && empty($this->conf['tables'][$tableName]['fields'][$posArr[$posFields[1]]]['notnull'])) {
			$args[1]  = ' IS NULL';
			$posArr[$posFields[1]] = null;
		}
		list($sql, $args) = $this->getConditions($tableName, array('where' => array_merge($cond, $posArr)));
		if (!$sql) $sql = 'WHERE 1 = 1';

		$y = $this->db->assoc(
			"select id, ?t from ?t $sql and ?t ?i ?d order by ?t ?i limit 1",
		    array_merge(
		        array(
                    $posFields[0], $this->tables[$tableName]),$args,
		            array($posFields[0], $sign, $pos, $posFields[0], $dir
                )
            )
        );
		if (!$y) return;
		$this->db->query('update ?t set ?t = ?d where id = ?d', $this->tables[$tableName], $posFields[0], $pos, $y['id']);
		$this->db->query('update ?t set ?t = ?d where id = ?d', $this->tables[$tableName], $posFields[0], $y[$posFields[0]], $id);
	}

	public function getValues($keyField, $titleField, $tableName, $cond, $modName = '', $ctrlName = '', $group = array(), $additionalFields = array())
	{
		if ($modName) return $this->model($modName, $ctrlName)->getValues($keyField, $titleField, $tableName, $cond, '', '', $group, $additionalFields);
		if (!$group) {
			list($cSql, $cArgs) = $this->getConditions($tableName, $cond);
			$ret   = $this->db->karr('SELECT ?t AS ?t, ?t AS ?t FROM ?t '.$cSql,
			array_merge(array($keyField, ( $keyField == $titleField ? 'id' : $keyField ) ), array($titleField, ( $keyField == $titleField ? 'title' : $titleField )), array($this->tables[$tableName]), $cArgs));
		} else {
			if (!empty($cond['order'])) {
				$cond['order'] = array_merge($group['order'], $cond['order']);
			} else {
				$cond['order'] = $group['order'];
			}
			$fields = array($keyField, $titleField, $group['keyField'], $group['titleField']);
			if ($additionalFields) $fields = array_merge($fields, $additionalFields);
			list($cSql, $cArgs) = $this->getConditions($tableName, $cond);
			$items = $this->getList($tableName, $fields, $cond);

			$ret = array('by_groups' => 1);
			foreach ($items as $item) {
				if (!isset($ret[$item[$group['keyField']]])) {
					$ret[$item[$group['keyField']]] = array(
						'title' => $item[$group['titleField']],
						'items' => array()
					);
				}
				$ret[$item[$group['keyField']]]['items'][$item[$keyField]] = $item[$titleField];
			}
		}
		return $ret;
	}

	protected function getTableStructure($tableName)
	{
		$struct = $this->db->getTableStructure($this->tables[$tableName]);
		$ret    = array();
		foreach ($struct as $fieldName => $field) {
			$row = strtolower($field['Type']);
			if ($field['Null'] == 'NO') $row .= ' NOT NULL';
			if ($field['Null'] == 'YES' && strpos($row, 'varchar') === 0 && empty($field['Default'])) $row .= ' default NULL';
			if (!empty($field['Default'])) $row .= " default '{$field['Default']}'";
			if ($field['Extra']) $row .= strtolower(" {$field['Extra']}");
			$ret[$fieldName] = $row;
		}
		return $ret;
	}

	protected function alterTable($tableName, $in_conf, $in_db, $count = 0)
	{
		if ($count > 3) return;
		foreach (array_diff_assoc($in_conf, $in_db) as $fieldName => $fieldDecl) {
			if (array_key_exists($fieldName, $in_db) && $in_conf[$fieldName] != $in_db[$fieldName]) { // change
				$this->db->query('ALTER TABLE ?t CHANGE ?t ?t ?i', $this->tables[$tableName], $fieldName,
				$fieldName, $fieldDecl);
			} elseif (!array_key_exists($fieldName, $in_db)) { // add
				$after = '';
				foreach (array_keys($in_conf) as $in_confName) {
					if (array_key_exists($in_confName, $in_db)) {
						$after = $in_confName;
					} else {
						break;
					}
				}

				if ($after) {
					$this->db->query('ALTER TABLE ?t ADD ?t ?i AFTER ?t',
					$this->tables[$tableName], $fieldName, $fieldDecl, $after);
				} else {
					$this->db->query('ALTER TABLE ?t ADD ?t ?i FIRST', $this->tables[$tableName], $fieldName, $fieldDecl);
				}
			}
		}
		$in_db = $this->getTableStructure($tableName, 0);
		foreach (array_diff_assoc($in_db, $in_conf) as $fieldName => $fieldDecl) {
			if (!array_key_exists($fieldName, $in_conf)) { // delete
				$this->db->query('ALTER TABLE ?t DROP ?t', $this->tables[$tableName], $fieldName);
			}
		}
		$this->alterKeys($tableName);
	}

	protected function getInConfKeys($tableName)
	{
		if (empty($this->conf['tables'][$tableName]['table'])) return array();
		$ret = array();
		foreach ($this->conf['tables'][$tableName]['table'] as $keyType => $keys) {
			if (!is_array($keys) || is_numeric(key($keys))) {
				$ret['PRIMARY'] = array(
                    'type'   => $keyType,
                    'fields' => is_array($keys) ? $keys : array($keys)
				);
				continue;
			}
			foreach ($keys as $keyName => $keyFields)
			$ret[$keyName] = array(
                'type'   => $keyType == 'KEYS' ? '' : $keyType,
                'fields' => $keyFields
			);
		}
		return $ret;
	}

	protected function getTableKeys($tableName)
	{
		return $this->db->getTableKeys($this->tables[$tableName]);
	}

	protected function compare_keys($one, $two)
	{
		$ret = array();
		foreach ($one as $key => $value) {
			if (!array_key_exists($key, $two)) {
				$ret[$key] = $value;
			} elseif ($value['type'] != $two[$key]['type'] || $value['fields'] != $two[$key]['fields']) {
				$ret[$key] = $value;
			}
		}
		return $ret;
	}

	protected function alterKeys($tableName)
	{
		$in_conf = $this->getInConfKeys($tableName);
		$in_db   = $this->getTableKeys($tableName);
		foreach ($this->compare_keys($in_conf, $in_db) as $keyName => $key) { // changing and adding
			if (array_key_exists($keyName, $in_db) && $in_conf[$keyName] != $in_db[$keyName]) { // changing
				$keyName == 'PRIMARY'
				?
				$this->db->query('ALTER TABLE ?t DROP PRIMARY KEY', $this->tables[$tableName], 1)
				:
				$this->db->query('ALTER TABLE ?t DROP INDEX ?t', $this->tables[$tableName], $keyName);
			}

			$keyName == 'PRIMARY'
			?
			$this->db->query('ALTER TABLE ?t ADD PRIMARY KEY (?lt)',  $this->tables[$tableName], $key['fields'])
			:
			$this->db->query('ALTER TABLE ?t ADD ?i INDEX ?t (?lt)',
			$this->tables[$tableName], $key['type'], $keyName, $key['fields']
			);
		}

		/*foreach (array_diff_assoc($in_db, $in_conf) as $keyName => $key) { // dropping
			if ($keyName == 'PRIMARY') {
				$this->db->query('ALTER TABLE ?t DROP PRIMARY KEY', $this->tables[$tableName], 1);
			} else {
				$this->db->query('ALTER TABLE ?t DROP INDEX ?t', $this->tables[$tableName], $keyName);
			}
		} */
		// Forgon: array to string conversion is suxx.
		foreach ($in_db as $k_name => $key_sett) { // dropping
			if (!isset($in_conf[$k_name])) {
				if ($keyName == 'PRIMARY') {
					$this->db->query('ALTER TABLE ?t DROP PRIMARY KEY', $this->tables[$tableName], 1);
				} else {
					$this->db->query('ALTER TABLE ?t DROP INDEX ?t', $this->tables[$tableName], $keyName);
				}
			}
		}
	}

	protected function install()
	{
		if (isset($this->conf['tables'])) {
			foreach ($this->conf['tables'] as $tableName => $table) {
				if (!empty($table['dont_install'])) continue;
				if (!$this->db->tableExists($this->tables[$tableName])) {
					$this->db->query($this->getCreation($tableName), $this->tables[$tableName], 1);
					if (!empty($this->conf['tables'][$tableName]['data'])) {
                        foreach($this->conf['tables'][$tableName]['data'] as $install_data) {
	                        $this->db->query(
                                'INSERT INTO ?t (?lt) VALUES(?li)',
                                $this->tables[$tableName], array_keys($install_data), $install_data
                            );
                        }
					}
                    /* Forgon Вроде не должно ломаться

                    if (!empty($this->conf['tables'][$tableName]['data'])) {
						$this->db->query('INSERT INTO ?t VALUES(?i)',
						$this->tables[$tableName], $this->conf['tables'][$tableName]['data']);
					}*/
				} else {
					$in_conf = $this->getCreation($tableName, 1, 0);
					$in_db = $this->getTableStructure($tableName, 0);
					$this->alterTable($tableName, $in_conf, $in_db);
				}
			}
		}
	}

	/**
	 * Loads Model represented by $modName and $ctrlName
	 *
	 * @param string $modName
	 * @param string $ctrlName
	 * @return void
	 */
	protected function loadModel($modName, $ctrlName = '')
	{
		if (!$ctrlName) $ctrlName = $this->ctrlName;
		return $this->ctrl->loadModel($modName, $ctrlName);
	}

	/**
	 * Returns loaded Model object represented by $modName and $ctrlName
	 *
	 * @param string $modName
	 * @param string $ctrlName
	 * @return Model
	 */
	protected function model($modName, $ctrlName = '')
	{
		if (!$ctrlName) $ctrlName = $this->ctrlName;
		return $this->ctrl->model($modName, $ctrlName);
	}

	protected function getTableNameForUniqueChecking()
	{
		return null;
	}

	public function validatorIs_unique($fieldName, $fieldValue, $param, $data)
	{
		$tableName = $this->getTableNameForUniqueChecking();

		if ($tableName == null) $tableName = $this->modName;
		return !(
			$this->ctrl->app->request->id ?
				$this->db->one('SELECT id FROM ?t WHERE ?t = ? AND id != ?d', $this->tables[$tableName], $fieldName, $fieldValue, $this->ctrl->app->request->id) :
				$this->db->one('SELECT id FROM ?t WHERE ?t = ?', $this->tables[$tableName], $fieldName, $fieldValue)
		);
	}
}
?>
