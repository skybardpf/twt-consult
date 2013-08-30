<?php
require_once 'zf/third-party/sphinx/sphinxapi.php';
class SearchModel extends Model 
{
	/**
    * Поиск по базе.
    * 
    * @param array $s - строка поиска
    * @param mixed $index - индекс таблицы при сфинксе, если LIKE то null
    * @param mixed $from
    * @param mixed $npp
    * @return mixed
    */
    public function search($s, $index = null, $from=0, $npp=20, $filter = array(), $sort = array())
	{
		if ($this->conf['engine'] == 'sphinx') {
			$conf = $this->conf[$this->conf['engine']];
			$search = new SphinxClient();
			
			if (!empty($conf['arrayResult'])) { $search->SetArrayResult($conf['arrayResult'] ? true : false); }
			if (!empty($conf['fieldWeights'])) { $search->SetFieldWeights($conf['fieldWeights']); }
			if (!empty($conf['matchMode'])) { $search->SetMatchMode(constant($conf['matchMode'])); }
			//if (!empty($conf['sortMode'])) { $search->SetSortMode(constant($conf['sortMode'])); }
			$search->SetLimits($from, $npp);
			$s = $search->EscapeString($s);
            if (!empty($filter)) {
                foreach($filter as $k => $filtr) {
                    $search->SetFilter($k, $filtr);
                }
            }
            if (!empty($sort)) {
                foreach($sort as $k => $srt) {
                    if ($srt == "ASC") {
                        $search->SetSortMode(SPH_SORT_ATTR_ASC, "{$k}");
                    } else {
                        $search->SetSortMode(SPH_SORT_ATTR_DESC, "{$k}");
                    }
                }
            }
			$res = $search->Query($s, $index);
			if (!$res) {
				debug::add($search->GetLastError(), 'sphinx');
			} else {
				debug::add($res, 'sphinx');
			}
			if ($res['total']) {
				$cond = array();
                $results_ids = array();
				for ($i = 0; $i < count($res['matches']); $i++) {
					$cond[] = '(true_id = ' . $res['matches'][$i]['attrs']['true_id']. ' AND model_id = '.$res['matches'][$i]['attrs']['model_id'].')';
                    $results_ids[$res['matches'][$i]['attrs']['model_id'].'_'.$res['matches'][$i]['attrs']['true_id']] = null;
				}
				$cond = implode(' OR ', $cond);
				if (!empty($cond)) {
					$result = $this->db->query('SELECT * FROM ?t WHERE '.$cond, $conf['table'], 1);
					if (!empty($result) and !empty($conf['buildExcerpts'])) {
						for ($i = 0; $i < count($result); $i++) {
							$str = '';
							for($j = 0; $j < count($conf['buildExcerpts']['fields']); $j++) {
								$str .= ' ' . strip_tags($result[$i][$conf['buildExcerpts']['fields'][$j]]);
							}
							$be_arr[] =  $str;
							unset($str);
						}
						
						$add = $search->BuildExcerpts($be_arr, $index, $s, array(
							"before_match"		=> $conf['buildExcerpts']['before_match'],
							"after_match"		=> $conf['buildExcerpts']['after_match'],
							"chunk_separator"	=> $conf['buildExcerpts']['chunk_separator'],
							"limit"				=> $conf['buildExcerpts']['limit'],
							"around"			=> $conf['buildExcerpts']['around'],
						));
					}
                    
					for ($i = 0; $i < count($result); $i++) {
						$result[$i]['model'] = $this->conf['links'][$result[$i]['model_id']];
						if (!empty($add)) {
							$result[$i]['excerpt'] = $add[$i];
						}
                        
                        $results_ids[$result[$i]['model_id'].'_'.$result[$i]['true_id']] = $result[$i];
					}
					return array(
						'meta' => $res,
						'data' => $results_ids
					);
				}
			}
		} else if ($this->conf['engine'] == 'like') {
			$time = microtime(true);
			$conf = $this->conf[$this->conf['engine']];
			$queries = array();
			$args = array();

			if ($conf['matchMode'] == 'ANY') {
				$s = trim($s);
				$s = explode(' ', $s);
				$l = array();
				$e = array();
				for ($i = 0; $i < count($s); $i++) {
					$l[] = "LIKE '%".mysql_escape_string($s[$i])."%'";
					$e[] = '/('.$s[$i].')/iu';
				}
			} else {
				$l = array("LIKE '%".mysql_escape_string($s)."%'");
				$e = array('/('.$s.')/iu');
			}
			
			$w = array();
			$f = array();
			$first = false;
			foreach ($this->conf['links'] as $model_id=>$link) {
				$bargs = array();
				$condition = $this->getConditions($link['tableName'], array('where' => $link['where']), true);
				$queries[] = $this->prepareBlankQuery($model_id, $link, $bargs).$condition[0];
				for ($i = 0; $i < count($link['fields']); $i++) {
					switch ($i) {
						case 0:
							$link['fields'][$i] = $link['fields'][$i] .' AS `id`';
						break;
						case 1:
							$link['fields'][$i] = $link['fields'][$i] .' AS `title`';
							for ($j = 0; $j < count($l) && !$first; $j++) {
								$w[] = "title {$l[$j]}";
								$f[] = 'title';
							}
						break;
						default:
							$link['fields'][$i] = $link['fields'][$i] .' AS `field'.($i-1).'`';
							for ($j = 0; $j < count($l) && !$first; $j++) {
								$w[] = 'field'.($i-1)." {$l[$j]}";
								$f[] = 'field'.($i-1);
							} 
						break;
					}
				}
				$args[] = array_merge($link['fields']);
				$args[] = '?_'.$link['tableName'];
				$args = array_merge($args, $bargs);
				$args = array_merge($args, $condition[1]);
				$first = true;
			}
			if (!empty($conf['order'])) {
				$order = array();
				foreach ($conf['order'] as $field => $type) {
					$order[] = "$field $type";
				}
				$args[] = $order;
			}
			$query = 'SELECT * FROM (('.implode(' )UNION( ', $queries).')) AS for_search WHERE '.implode(' OR ', $w).(isset($order) ? ' ORDER BY model_id ASC, ?li' : '');
			$total = 0;
			$result = $this->db->page($total, $from, $npp, $query, $args);
			for ($i = 0; $i < count($result); $i++) {
				$result[$i]['model'] = $this->conf['links'][$result[$i]['model_id']];
				if (isset($conf['buildExcerpts']) and !empty($s)) {
					$excerpt = array();
					for ($j = 0; $j < count($f); $j++) {
						if (!in_array($f[$j], (isset($conf['order']) ? array_keys($conf['order']) : array()))) {
							$excerpt[] = strip_tags($result[$i][$f[$j]]);
						}
					}
					$excerpt = implode(' ', $excerpt);
					preg_match('/.{0,255}'.(is_array($s) ? '('.implode('|', $s).')' : $s).'.{0,255}/iu', $excerpt, $m);
					$excerpt = isset($m[0]) ? $m[0] : $excerpt;
					$excerpt = mb_strlen($excerpt, 'utf-8') > $conf['buildExcerpts']['limit'] ? mb_substr($excerpt, 0, $conf['buildExcerpts']['limit'], 'utf-8').$conf['buildExcerpts']['chunk_separator'] : $excerpt;
					$excerpt = preg_replace($e, $conf['buildExcerpts']['before_match'].'\\1'.$conf['buildExcerpts']['after_match'], $excerpt);
					$result[$i]['excerpt'] = $excerpt;
				}
			}
			return array(
				'meta' => array(
					'total' => $total,
					'from' => $from,
					'npp' => $npp,
					'time'=> microtime(true)-$time
				),
				'data' => $result
			);
		}
		return false;
	}
	
	
	protected function prepareBlankQuery($model_id, $link, $args)
	{
		return "SELECT ?li, '$model_id' AS model_id FROM ?t".(!empty($link['where']) ? ' WHERE ' : ' ');
	}
}