<?php
/**
 * Класс для работы с деревьями Nested Sets
 * @author borro
 *
 */
class NestedSets extends Model 
{
	/**
	* Объект БД
	* 
	* @var db
	*/
	protected $db;
	/**
	 * Массив опций
	 * @var array
	 */
	private $options;

	/**
	 * $table - таблица с которой будем работать
	 * $options - массив с настройками ключи:
	 * 	- id название поля ИД
	 * 	- level название поля уровня
	 * 	- left_key название левого ключа
	 * 	- right_key название правого ключа
	 * 	- lock_tables блокировать ли таблицу при внесении изменений(true/false)
	 * $db - объект db из zf
	 * @param string $table
	 * @param array $options
	 * @param db $db
	*/
	public function __construct($table, $options=null, $db=null) {
		$this->db = $db ? $db : zf::$db;
		if (is_array($options)) {
			$this->options = $options;
		}
		else {
			$this->options = array(
				'id'		=> 'id',
				'level'		=> 'level',
				'left_key'	=> 'left_key',
				'right_key'	=> 'right_key',
				'lock_tables' => true
			);
		}
		$this->options['table'] = $table;
	}

    public function getOption($option)
    {
        return $this->options[$option];
    }
    
	/**
	 * Отчищает всю БД и вставляет первычный узел
	 * Возвращает последний вставленный ИД
	 * @return integer
	 */
	public function clear() {
		$trunc = $this->db->query('TRUNCATE ?t', $this->options['table'], 1);
		if ($trunc !== false) {
			$insert = $this->db->query(
				'INSERT INTO ?t (?lt) VALUES (?l)',
				$this->options['table'],
				array(
					$this->options['left_key'],
					$this->options['right_key'],
					$this->options['level'],
				),
				array(1, 2, 0)
			);
		}
		else {
			$insert = false;
		}
		return $insert !== false ? $insert : false;
	}

	/**
	 * Возвращает параметры узла
	 * @param integer $id
	 * @return array(left_key, right_key, level)
	*/
	protected function getNodeInfo($cond) {
		if (!is_array($cond)) $cond = array($this->options['id'] => $cond);
		$cond = $this->getConditions('', array($cond), true);
		$data = $this->db->arr(
			'SELECT ?t, ?t, ?t FROM ?t AS for_read WHERE '.$cond[0],
			array_merge(
				array($this->options['left_key'], $this->options['right_key'], $this->options['level']),
				array($this->options['table']),
				$cond[1]
			)
		);
		return $data;
	}

	/**
	 * Возвращает параметры родителя
	 * @param integer $id
	 * @return array(left_key, right_key, level)
	*/
	protected function getParentInfo($id) {
		$node_info = $this->GetNodeInfo($id);
		if (!empty($node_info)) {
			list($leftId, $rightId, $level) = $node_info;
			$level--;

			$data = $this->db->arr('SELECT ?lt FROM ?t AS for_read
				WHERE
					?t < ?d
					AND
					?t > ?d
					AND
					?t = ?d
				ORDER BY ?t',
				array($this->options['left_key'], $this->options['right_key'], $this->options['level']),
				$this->options['table'],
				$this->options['left_key'], $leftId,
				$this->options['right_key'], $rightId,
				$this->options['level'], $level,
				$this->options['left_key']
			);
		}
		else {
			$data = false;
		}
		return $data;
	}


	/**
	 * Добавляет ребенка к родителю
	 * возращает вставленный ИД
	 * @param integer $parent_id
	 * @return integer
	*/
	public function add($parent_id) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		
		$node_info = $this->GetNodeInfo($parent_id);
		if (!empty($node_info)) {
			list($leftId, $rightId, $level) = $node_info;
		}
		
		$upd = $this->db->query(
			'UPDATE ?t
			SET
				?t = 
					CASE
						WHEN ?t > ?d THEN ?t + 2
						ELSE ?t
					END,
				?t =
					CASE
						WHEN ?t >= ?d THEN ?t + 2
						ELSE ?t
					END
				WHERE ?t >= ?d',
			$this->options['table'],
			
			$this->options['left_key'],
			$this->options['left_key'], $rightId, $this->options['left_key'],
			$this->options['left_key'],
			
			$this->options['right_key'],
			$this->options['right_key'], $rightId, $this->options['right_key'],
			$this->options['right_key'],
			
			$this->options['right_key'], $rightId
			
		);

		if ($upd !== false) {
			$id = $this->db->query('INSERT INTO ?t (?lt) VALUES(?l)',
				$this->options['table'],
				array(
					$this->options['left_key'],
					$this->options['right_key'],
					$this->options['level'],
				),
				array($rightId, $rightId+1, $level+1)
			);
		}
		else {
			$id = false;
		}
		
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $id;
	}

	/**
	 * Добавляет новый элемент после заданного узла
	 * возвращает вставленный ИД
	 * @param integer $id
	 * @return integer
	*/
	function addAfter($id) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		$node_info = $this->GetNodeInfo($id);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		}
		list($leftId, $rightId, $level) = $node_info;
		
		$upd = $this->db->query(
			'UPDATE ?t
			SET
				?t =
					CASE
						WHEN ?t > ?d THEN ?t + 2
						ELSE ?t
					END,
				?t =
					CASE
						WHEN ?t > ?d THEN ?t + 2
						ELSE ?t
					END
			WHERE ?t > ?d',
			$this->options['table'],
			
			$this->options['left_key'],
			$this->options['left_key'], $rightId, $this->options['left_key'],
			$this->options['left_key'],
			
			$this->options['right_key'],
			$this->options['right_key'], $rightId, $this->options['right_key'],
			$this->options['right_key'],
			$this->options['right_key'], $rightId
		);
		
		if ($upd !== false) {
			$id = $this->db->query('INSERT INTO ?t (?lt) VALUES(?l)',
				$this->options['table'],
				array(
					$this->options['left_key'],
					$this->options['right_key'],
					$this->options['level'],
				),
				array($rightId + 1, $rightId + 2, $level)
			);
		}
		else {
			$id = false;
		}
		
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		
		return $id;
	}
	/**
	 * Задает нового родителя для всей ветки.
	 * @param integer $id
	 * @param integer $newParentId
	 * @return boolean
	*/
	public function changeParent($id, $newParentId) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		
		$node_info = $this->GetNodeInfo($id);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftId, $rightId, $level) = $node_info;
		
		$node_info = $this->GetNodeInfo($newParentId);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftIdP, $rightIdP, $levelP) = $node_info;

		if ($leftIdP < $leftId && $rightIdP > $rightId && $levelP < $level - 1) {
			$upd = $this->db->query(
				'UPDATE ?t
				SET
					?t  =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ( ?d )
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							ELSE ?t
						END,
					?t  = 
						CASE 
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							ELSE ?t
						END
				WHERE ?t BETWEEN ?d AND ?d' ,
				$this->options['table'],
				
				$this->options['level'],
				$this->options['left_key'], $leftId, $rightId,
				$this->options['level'], -($level-1)+$levelP,
				$this->options['level'],
				
				$this->options['right_key'],
				$this->options['right_key'], $rightId+1, $rightIdP-1, 
				$this->options['right_key'], $rightId-$leftId+1,
				$this->options['left_key'], $leftId, $rightId,
				$this->options['right_key'], ((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1),
				$this->options['right_key'],
				
				$this->options['left_key'],
				$this->options['left_key'], $rightId+1, $rightIdP-1,
				$this->options['left_key'], $rightId-$leftId+1,
				$this->options['left_key'], $leftId, $rightId,
				$this->options['left_key'], ((($rightIdP-$rightId-$level+$levelP)/2)*2+$level-$levelP-1),
				$this->options['left_key'],
				
				$this->options['left_key'], $leftIdP+1, $rightIdP-1
			);
		} elseif ($leftIdP < $leftId) {
			$upd = $this->db->query(
				'UPDATE ?t
				SET 
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d 
							ELSE ?t
						END, 
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d
							ELSE ?t
						END
				WHERE (
					?t BETWEEN ?d AND ?d
						OR 
					?t BETWEEN ?d AND ?d
				)',
				$this->options['table'],
				
				$this->options['level'],
				$this->options['left_key'], $leftId, $rightId,
				$this->options['level'], -($level-1)+$levelP,
				$this->options['level'],
				
				$this->options['left_key'],
				$this->options['left_key'], $rightIdP, $leftId-1,
				$this->options['left_key'], $rightId-$leftId+1,
				$this->options['left_key'], $leftId, $rightId,
				$this->options['left_key'], $leftId-$rightIdP,
				$this->options['left_key'],
				
				$this->options['right_key'],
				$this->options['right_key'], $rightIdP, $leftId,
				$this->options['right_key'], $rightId-$leftId+1,
				$this->options['right_key'], $leftId, $rightId,
				$this->options['right_key'], $leftId-$rightIdP,
				$this->options['right_key'],
				
				$this->options['left_key'], $leftIdP, $rightId,
				$this->options['right_key'], $leftIdP, $rightId
			);
		} else {
			$upd = $this->db->query(
				'UPDATE ?t
				SET
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
								ELSE ?t
							END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t-?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t+?d
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t-?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t+?d
							ELSE ?t
						END
				WHERE (
					?t BETWEEN ?d AND ?d
						OR
					?t BETWEEN ?d AND ?d
				)',
				$this->options['table'],
				
				$this->options['level'],
				$this->options['left_key'], $leftId, $rightId,
				$this->options['level'], -($level-1)+$levelP,
				$this->options['level'],
				
				$this->options['left_key'],
				$this->options['left_key'], $rightId, $rightIdP,
				$this->options['left_key'], $rightId-$leftId+1,
				$this->options['left_key'], $leftId, $rightId,
				$this->options['left_key'], $rightIdP-1-$rightId,
				$this->options['left_key'],
				
				$this->options['right_key'],
				$this->options['right_key'], $rightId+1, $rightIdP-1,
				$this->options['right_key'], $rightId-$leftId+1,
				$this->options['right_key'], $leftId, $rightId,
				$this->options['right_key'], $rightIdP-1-$rightId,
				$this->options['right_key'],
				
				$this->options['left_key'], $leftId, $rightIdP,
				$this->options['right_key'], $leftId, $rightIdP
			);
		}
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $upd;
	}

	/**
	 * Меняет Только узлы, местами
	 *
	 * @param integer $id1
	 * @param integer $id2
	 * @return boolean
	 */
	public function changePosition($id1, $id2) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		$node_info = $this->GetNodeInfo($id1);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftId2, $rightId2, $level2) = $node_info;

		$upd = $this->db->query(
			'UPDATE ?t SET ?a WHERE ?t = ?d',
			$this->options['table'],
			array(
				$this->options['left_key'] => $leftId2,
				$this->options['right_key'] => $rightId2,
				$this->options['level'] => $level2,
			),
			$this->options['id'], $id1
		);
		if ($upd) {
			$upd = $this->db->query(
				'UPDATE ?t SET ?a WHERE ?t = ?d',
				$this->options['table'],
				array(
					$this->options['left_key'] => $leftId1,
					$this->options['right_key'] => $rightId1,
					$this->options['level'] =>  $level1
				),
				$this->options['id'], $id2
			);
		}
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $upd;
	}

	/**
	 * Меняет ветку($id1) местами с другой веткой($id2).
	 * Если $befor не задан, или false, то вставляет $id1 после $id2
	 * 
	 * @param integer $id1
	 * @param integer $id2
	 * @param boolean $befor
	 * @return boolean
	*/
	public function changePositionAll($id1, $id2, $befor = false) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		$node_info = $this->GetNodeInfo($id1);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftId1, $rightId1, $level1) = $node_info;
		$node_info = $this->GetNodeInfo($id2);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		} 
		list($leftId2, $rightId2, $level2) = $node_info;
		
		if ($level1 <> $level2) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		}
		
		if ($befor == true) {
			if ($leftId1 > $leftId2) {
				$upd = $this->db->query(
					'UPDATE ?t
					SET
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t +  ?d
								ELSE ?t
							END,
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t + ?d
								ELSE ?t END
					WHERE ?t BETWEEN ?d AND ?d',
					$this->options['table'],
					
					$this->options['right_key'], 
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['right_key'], $leftId1 - $leftId2,
					$this->options['left_key'], $leftId2, $leftId1 - 1,
					$this->options['right_key'], $rightId1 - $leftId1 + 1,
					$this->options['right_key'],
					
					$this->options['left_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['left_key'], $leftId1 - $leftId2,
					$this->options['left_key'], $leftId2, $leftId1 - 1,
					$this->options['left_key'], $rightId1 - $leftId1 + 1,
					$this->options['left_key'],
					
					$this->options['left_key'], $leftId2, $rightId1
				);
			} else {
				$upd = $this->db->query(
					'UPDATE ?t
					SET
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t + ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								ELSE ?t
							END,
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t + ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								ELSE ?t
							END
					WHERE ?t BETWEEN ?d AND ?d',
					$this->options['table'],
					
					$this->options['right_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['right_key'], ($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1),
					$this->options['left_key'], $rightId1 + 1, $leftId2 - 1,
					$this->options['right_key'], $rightId1 - $leftId1 + 1,
					$this->options['right_key'],
					
					$this->options['left_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['left_key'], ($leftId2 - $leftId1) - ($rightId1 - $leftId1 + 1),
					$this->options['left_key'], $rightId1 + 1, $leftId2 - 1,
					$this->options['left_key'], $rightId1 - $leftId1 + 1,
					$this->options['left_key'],
					
					$this->options['left_key'], $leftId1, $leftId2 - 1
				);
			}
		}
		if ($befor == false) {
			if ($leftId1 > $leftId2) {
				$upd = $this->db->query(
					'UPDATE ?t
					SET
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t +  ?d
								ELSE ?t
							END,
						?t =
							CASE
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t - ?d
								WHEN ?t BETWEEN ?d AND ?d
									THEN ?t + ?d
								ELSE ?t
							END
					WHERE ?t BETWEEN ?d AND ?d',
					$this->options['table'],
					
					$this->options['right_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['right_key'], $leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1),
					$this->options['left_key'], $rightId2 + 1, $leftId1 - 1,
					$this->options['right_key'], $rightId1 - $leftId1 + 1,
					$this->options['right_key'],
					
					$this->options['left_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['left_key'], $leftId1 - $leftId2 - ($rightId2 - $leftId2 + 1),
					$this->options['left_key'], $rightId2 + 1, $leftId1 - 1,
					$this->options['left_key'], $rightId1 - $leftId1 + 1,
					$this->options['left_key'],
					
					$this->options['left_key'], $rightId2 + 1, $rightId1
				);
			} else {
				$upd = $this->db->query(
					'UPDATE ?t
					SET
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t + ?d
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - ?d
							ELSE ?t
						END
					WHERE ?t BETWEEN ?d AND ?d',
					$this->options['table'],
					
					$this->options['right_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['right_key'], $rightId2 - $rightId1,
					$this->options['left_key'], $rightId1 + 1, $rightId2,
					$this->options['right_key'], $rightId1 - $leftId1 + 1,
					$this->options['right_key'],
					
					$this->options['left_key'],
					$this->options['left_key'], $leftId1, $rightId1,
					$this->options['left_key'], $rightId2 - $rightId1,
					$this->options['left_key'], $rightId1 + 1, $rightId2,
					$this->options['left_key'], $rightId1 - $leftId1 + 1,
					$this->options['left_key'],
					
					$this->options['left_key'], $leftId1, $rightId2
				);
			}
		}
		
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $upd;
	}
	
	/**
	 * Меняет данный узел местами с верхним на том же уровне 
	 * @param integer $id
	 * @return boolean
	 */
	public function up($id, $cond=null)
	{
		list($leftId, $rightId, $level) = $this->GetNodeInfo($id);
		if (!empty($cond)) {
			$cond = $this->getConditions('', array($cond), true);
		}
		$id2 = $this->db->one(
			'SELECT ?t FROM ?t WHERE ?t < ?d AND ?t = ?d '.(!empty($cond[0])?'AND ('.$cond[0].') ' : '').'ORDER BY ?t DESC LIMIT 1',
			array_merge(
				array(
					$this->options['id'],
					$this->options['table'],
					$this->options['right_key'], $leftId,
					$this->options['level'], $level,
				),
				(!empty($cond[1]) ? $cond[1] : array()),
				array($this->options['right_key'])
			)
		);
		$p1 = $this->parents($id);
		$p2 = $this->parents($id2);
		if (count($p1) == count($p2)) {
			for ($i = 0; $i < count($p1)-1; $i++) {
				if ($p1[$i][$this->options['id']] != $p2[$i][$this->options['id']]) {
					return false;
				}
			}
		} else {
			return false;
		}
		if($id2) {
			$ret = $this->changePositionAll($id2, $id);
		}
		else {
			$ret = false;
		}
		return $ret;
	}
	
	/**
	 * Меняет данный узел местами с нижним на том же уровне 
	 * @param integer $id
	 * @return boolean
	 */
	public function down($id, $cond = null){
		list($leftId, $rightId, $level) = $this->GetNodeInfo($id);
		if (!empty($cond)) {
			$cond = $this->getConditions('', array($cond), true);
		}
		$id2 = $this->db->one(
			'SELECT ?t FROM ?t WHERE ?t > ?d AND ?t = ?d '.(!empty($cond[0])?'AND ('.$cond[0].') ' : '').'ORDER BY ?t ASC LIMIT 1',
			array_merge(
				array(
					$this->options['id'],
					$this->options['table'],
					$this->options['left_key'], $rightId,
					$this->options['level'], $level,
				),
				(!empty($cond[1]) ? $cond[1] : array()),
				array($this->options['left_key'])
			)
		);
		$p1 = $this->parents($id);
		$p2 = $this->parents($id2);
		if (count($p1) == count($p2)) {
			for ($i = 0; $i < count($p1)-1; $i++) {
				if ($p1[$i][$this->options['id']] != $p2[$i][$this->options['id']]) {
					return false;
				}
			}
		} else {
			return false;
		}
		
		if($id2) {
			$ret = $this->changePositionAll($id, $id2);
		}
		else {
			$ret = false;
		}
		return $ret;
	}
	
	/**
	 * Удаляет тока узел, все потомки становятся потомками вышестоящего узла
	 * @param integer $id
	 * @return boolean
	*/
	public function delete($id) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		$node_info = $this->GetNodeInfo($id);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		}
		list($leftId, $rightId) = $node_info;
		
		$del = $this->db->query('DELETE FROM ?t WHERE ?t = ?d', $this->options['table'], $this->options['id'], $id);
		if ($del !== false) {
			$upd = $this->db->query(
				'UPDATE ?t
				SET
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - 1
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - 1
							WHEN ?t > ?d
								THEN ?t - 2
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t BETWEEN ?d AND ?d
								THEN ?t - 1
							WHEN ?t > ?d
								THEN ?t - 2
							ELSE ?t
						END
				WHERE ?t > ?d',
				$this->options['table'],
				
				$this->options['level'],
				$this->options['left_key'], $leftId, $rightId,
				$this->options['level'],
				$this->options['level'],
				
				$this->options['right_key'],
				$this->options['right_key'], $leftId, $rightId,
				$this->options['right_key'],
				$this->options['right_key'], $rightId,
				$this->options['right_key'],
				$this->options['right_key'],
				
				$this->options['left_key'],
				$this->options['left_key'], $leftId, $rightId,
				$this->options['left_key'], 
				$this->options['left_key'], $rightId,
				$this->options['left_key'],
				$this->options['left_key'],
				
				$this->options['right_key'], $leftId
			);
		}
		else {
			$upd;
		}
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $upd;
	}

	/**
	 * Удаляет узел и всех его потомков.
	 * @param integer $id
	 * @return boolean
	*/
	public function deleteAll($id) {
		if ($this->options['lock_tables']) {
			$this->db->query('LOCK TABLES ?t WRITE, ?t AS for_read READ', $this->options['table'], $this->options['table']);
		}
		$node_info = $this->GetNodeInfo($id);
		if (empty($node_info)) {
			if ($this->options['lock_tables']) {
				$this->db->query('UNLOCK TABLES');
			}
			return false;
		}
		list($leftId, $rightId) = $node_info;

		$del = $this->db->query('DELETE FROM ?t WHERE ?t BETWEEN ?d AND ?d', $this->options['table'], $this->options['left_key'], $leftId, $rightId);
		if ($del !== false) {
			$deltaId = (($rightId - $leftId) + 1);
	
			$upd = $this->db->query(
				'UPDATE ?t
				SET
					?t =
						CASE
							WHEN ?t > ?d THEN ?t - ?d
							ELSE ?t
						END,
					?t =
						CASE
							WHEN ?t > ?d THEN ?t - ?d
							ELSE ?t
						END
				WHERE ?t > ?d',
				$this->options['table'],
				
				$this->options['left_key'],
				$this->options['left_key'], $leftId, $this->options['left_key'], $deltaId,
				$this->options['left_key'],
				
				$this->options['right_key'],
				$this->options['right_key'], $leftId, $this->options['right_key'], $deltaId,
				$this->options['right_key'],
				
				$this->options['right_key'], $rightId
			);
		}
		else {
			$upd = false;
		}
		if ($this->options['lock_tables']) {
			$this->db->query('UNLOCK TABLES');
		}
		return $upd;
	}

	/**
	 * Возвращает все дерево.
	 * @return array
	*/
	public function full($cond = null) {
		if (!empty($cond)) {
			$cond = $this->getConditions('', array($cond), true);
		}
		return $this->db->query(
			'SELECT * FROM ?t '.(!empty($cond[0])?'WHERE '.$cond[0].' ' : '').'ORDER BY ?t', 
			array_merge(
				array($this->options['table']),
				(!empty($cond[1]) ? $cond[1] : array()),
				array($this->options['left_key'])
			)
		);
	}

	/**
	 * Возвращает ветку начиная с узла
	 * @param integer $id
	 * @return array
	*/
	public function branch($id) {
		return $this->db->query(
			'SELECT A.*,
				CASE
					WHEN A.?t + 1 < A.?t THEN 1 ELSE 0
				END AS nflag
			FROM ?t AS A, ?t AS B
			WHERE
				B.?t = ?d
					AND
				A.?t >= B.?t
					AND
				A.?t <= B.?t
			ORDER BY A.?t',
			$this->options['left_key'], $this->options['right_key'],
			
			$this->options['table'], $this->options['table'],
			
			$this->options['id'], $id,
			$this->options['left_key'], $this->options['left_key'],
			$this->options['right_key'], $this->options['right_key'],
			
			$this->options['left_key']
		);
	}
	
    public function branches(array $cond, array $cond_res = array()){
        $tmp_cond = array();
        foreach ($cond as $k=>$v) {
            $tmp_cond['B.'.$k] = $v;
        }
        $cond = $this->getConditions('', array($tmp_cond), true);
        
        $tmp_cond = array();
        foreach ($cond_res as $k=>$v) {
            $tmp_cond['A.'.$k] = $v;
        }
        if ($tmp_cond) {
            $cond_res = $this->getConditions('', array($tmp_cond), true);
        }
        return $this->db->query(
            'SELECT A.*,
                CASE
                    WHEN A.?t + 1 < A.?t THEN 1 ELSE 0
                END AS nflag
            FROM ?t AS A, ?t AS B
            WHERE
                ('.$cond[0].')
                    AND
                A.?t >= B.?t
                    AND
                A.?t <= B.?t
                '.(!empty($cond_res[0]) ? 'AND ('.$cond_res[0].')' : '').'
            ORDER BY A.?t',
            array_merge(
                array(
                    $this->options['left_key'], $this->options['right_key'],
                    
                    $this->options['table'], $this->options['table'],
                ),
                $cond[1],
                array(
                    $this->options['left_key'], $this->options['left_key'],
                    $this->options['right_key'], $this->options['right_key'],
                ),
                (!empty($cond_res[1]) ? $cond_res[1] : array()),
                array(
                    $this->options['left_key']
                )
            )
        );
    }

    /** Достает все элементы, отвечающие условию и их ветки без парсинга (одноуровневый массив)
     *
     * @param array $cond
     * @param array $cond_res
     * @return mixed
     */
    public function branches_2(array $cond, array $cond_res = array()){
        $tmp_cond = array();
        foreach ($cond as $k=>$v) {
            $tmp_cond['B.'.$k] = $v;
        }
        $cond = $this->getConditions('', array($tmp_cond), true);

        $tmp_cond = array();
        foreach ($cond_res as $k=>$v) {
            $tmp_cond['A.'.$k] = $v;
        }
        if ($tmp_cond) {
            $cond_res = $this->getConditions('', array($tmp_cond), true);
        }
        return $this->db->query(
            'SELECT A.*,
                CASE
                    WHEN A.?t + 1 < A.?t THEN 1 ELSE 0
                END AS nflag
            FROM ?t AS A, ?t AS B
            WHERE
                ('.$cond[0].')
                AND A.?t >= B.?t
                AND A.?t <= B.?t
                '.(!empty($cond_res[0]) ? 'AND ('.$cond_res[0].')' : '').'
            GROUP BY A.id
            ORDER BY A.?t',
            array_merge(
                array(
                    $this->options['left_key'], $this->options['right_key'],

                    $this->options['table'], $this->options['table'],
                ),
                $cond[1],
                array(
                    $this->options['left_key'], $this->options['left_key'],
                    $this->options['right_key'], $this->options['right_key'],
                ),
                (!empty($cond_res[1]) ? $cond_res[1] : array()),
                array(
                    $this->options['left_key']
                )
            )
        );
    }

	/**
	 * Возвращает детей постранично.
	 * Если указан $children_level, то возвращает детей
     * до указанного уровня включительно,
     * относительно родительского элемента.
	 * @param array $parent
     * @param array $children
     * @param array $fields
	 * @param integer &$total
	 * @param integer $from
	 * @param integer $num
	 * @param integer $children_level
	 * @return array
	 */
	public function children(array $parent, array $children, array $fields, &$total, $from, $num, $children_level=null) {
		if ($children_level) {
			list($leftId, $rightId, $level) = $this->getNodeInfo($parent);
		}
		$tmp_cond = array();
		foreach ($parent as $k=>$v) {
			$tmp_cond['B.'.$k] = $v;
		}
		
		$parent = $this->getConditions('', array($tmp_cond), true);

		$tmp_cond = array();
		foreach ($children as $k=>$v) {
			$tmp_cond['A.'.$k] = $v;
		}

		foreach ($fields as &$v) {
			$v = 'A.'.$v;
		}
		$fields = implode(', ', $fields);

		$children = $this->getConditions('', array($tmp_cond), true);

		return $this->db->page(
			$total, $from, $num,
			'SELECT '.$fields.',
				CASE
					WHEN A.?t + 1 < A.?t THEN 1 ELSE 0
				END AS nflag
			FROM ?t AS A, ?t AS B
			WHERE
				('.$parent[0].')
					'.(!empty($children[0]) ? 'AND
				('.$children[0].')' : '').'
					AND
				'.( $children_level ? 'A.?t <= ?d' : 'A.?t > ?d' ).'
					AND
				A.?t > ?d
					AND
				A.?t >= B.?t
					AND
				A.?t <= B.?t
			ORDER BY A.?t',
			array_merge(
				array(
					$this->options['left_key'], $this->options['right_key'],
					$this->options['table'], $this->options['table']
				),
				$parent[1],
				$children[1],
				array(
					$this->options['level'], (isset($level) ? $level : 0) + $children_level,
					$this->options['level'], isset($level) ? $level : 0,
					$this->options['left_key'], $this->options['left_key'],
					$this->options['right_key'], $this->options['right_key'],
					$this->options['left_key']
				)
			)
		);
	}
	/**
	 * Возвращает всех родителей узла
	 * @param integer $id
	 * @return array
	 */
	public function parents($cond) {
		
		$tmp_cond = array();
		if (is_array($cond)) {
			foreach ($cond as $k=>$v) {
				$tmp_cond['B.'.$k] = $v;
			}
		}
		else {
			$tmp_cond = array('B.id' => $cond);
		}
		
		$cond = $this->getConditions('', array($tmp_cond), true);
		
		return $this->db->query(
			'SELECT A.*,
				CASE
					WHEN A.?t + 1 < A.?t THEN 1 ELSE 0
				END AS nflag
			FROM
				?t AS A, ?t AS B
			WHERE
				'.$cond[0].'
					AND
				B.?t BETWEEN A.?t AND A.?t
			ORDER BY A.?t',
			array_merge(
				array(
					$this->options['left_key'], $this->options['right_key'],
					$this->options['table'], $this->options['table'],
				),
				$cond[1],
				array(
					$this->options['left_key'], $this->options['left_key'], $this->options['right_key'],
					$this->options['left_key']
				)
			)
		);
	}
}
?>