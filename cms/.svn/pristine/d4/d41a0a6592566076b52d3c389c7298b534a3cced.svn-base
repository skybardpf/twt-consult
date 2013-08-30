<?php
class ContentModel extends CMS_Model
{
    public $parents = array();
    public $addSQL = array();
	protected $valuesConf = array(
        'pid' => array(
            'keyField'   => 'id',
            'titleField' => 'title',
            'tableName'  => 'content',
            'cond'       => array('order' => array('pos' => 'asc'))
        ),
        'roles' => array(
        	'keyField'   => 'id',
			'titleField' => 'title',
			'tableName'  => 'siteuser_roles',
			'cond'       => array('order' => array('pos' => 'asc'))
        )
    );
    public function initValues($fields, $misc = null)
    {
    	if (in_array('categories', $fields)) {
    		$this->valuesConf['categories'] = array(
    			'keyField'   => 'id',
				'titleField' => 'title',
				'tableName'  => str_replace('?_', '', $this->conf['tables']['content']['fields']['categories']['ref_to']['table']),
				'cond'       => array()
    		);
    	}
    	parent::initValues($fields, null);
    	unset($this->values['pid'][$misc]);
    }
    private function getSubTree($pid, $show_hidden=false, $addSQL=array())
    {
    	$dir = (isset($this->conf['reverse_pos_order']) && $this->conf['reverse_pos_order']) ? 'DESC' : 'ASC';
        $fields = $this->getFieldsNames('content', 'menu');
    	if (empty($fields)) {
    		$fields = array('t1.id', 't1.pid', 't1.path', 't1.title', 't1.link');
    	} else {
	    	foreach ($fields as &$field) {
	    		$field = 't1.'.$field;
	    	}
    	}
    	
    	return $this->db->query("
    		SELECT ?lt, count(t2.pid) as count ".
    		(isset($addSQL['fields']) ? $addSQL['fields'] : '').
			" FROM ?t as t1
			LEFT OUTER JOIN ?t AS t2 ON t1.id = t2.pid ".
    		(isset($addSQL['join']) ? $addSQL['join'] : '').
			" WHERE t1.pid = ?d ".($show_hidden? "" : " AND t1.hidden = 'no' ").
    		(isset($addSQL['where']) ? $addSQL['where'] : '').
			" GROUP BY t1.id
			ORDER BY t1.pos ".$dir, $fields, $this->tables['content'], $this->tables['content'], $pid);
    }
    public function getTree($pid = 1, $level = 0, $clevel = 0, $show_hidden = false, $url = '', $addSQL = array())
    {
    	$prefix   = $this->ctrl->app->run_at;
        $file = md5((is_callable(array($this->db, 'getPrefix')) ? $this->db->getPrefix() : '').$prefix.$pid.$level.$clevel.$show_hidden.$url.var_export($addSQL, true));

        misc::create_dir('.zf_cache/content/', 0777);
    	if (is_file(".zf_cache/content/$file.cache")) {
    		include ".zf_cache/content/$file.cache";
    		debug::add("ContentModel->getTree($pid, $level, $clevel, ".($show_hidden?'true':'false').", '$url', ".var_export($addSQL, true).") from cache", 'cache');

        } else {
    		$data = $this->getTreeSQL($pid, $level, $clevel, $show_hidden, $url, $addSQL);
			if (is_callable(array('misc', 'file_safe_put'))) {
	            misc::file_safe_put('.zf_cache/content/' . $file . '.cache', '<?php $data='.var_export($data, true).';');

			} else {
    			file_put_contents(".zf_cache/content/$file.cache", '<?php $data='.var_export($data, true).';');

			}
    	}

    	return $data;
    }
	/**
     * Рекурсивная функция по получению 
     * @param integer $pid
     * @return array
     */
    public function getTreeSQL($pid = 1, $level = 0, $clevel = 0, $show_hidden = false, $url = '', $addSQL = array()) 
    {
        if ($level != 0 and $clevel >= $level) {
			return array();
		}
    	$tree = array();
   		$result = $this->getSubTree($pid, $show_hidden, $addSQL);
   		if (!$result) return array();
   		foreach ($result as $value) {
            $value = array_merge($value, array('level' => $clevel, 'url' => $url.'/'.$value['path']));
   			$branch = $value;
   			if ($value['count'] > 0) {
  				$branch['children'] = $this->getTreeSQL($value['id'], $level, $clevel + 1, $show_hidden, $branch['url']);
   			}
   			$tree[$value['id']] = $branch;
   		}
		return $tree;
    }
    
    public function getParents($id = null, $pid = null) 
    {
    	$ret = array();
    	$id ? $pid = $id : $pid;
    	while($res = $this->db->assoc('SELECT id, pid, path FROM ?t WHERE id = ?', $this->tables['content'], $pid)){
    		$pid = $res['pid'];
    		$ret[$res['id']] = $res['path'];
    		$this->parents[$res['id']] = $res['path'];
    	}
    	unset($this->parents[key($this->parents)]);
        end($this->parents);
        unset($this->parents[key($this->parents)]);
        reset($this->parents);
        array_pop($ret);
        $ret = array_reverse($ret, true);
        $id ? array_pop($ret) : null ;

        return $ret;
    }

    public function generatePathById($id) {
        $ret = array();
        while($res = $this->db->assoc('SELECT id, pid, path FROM ?t WHERE id = ?', $this->tables['content'], $id)){
            $id = $res['pid'];
            if ($res['path']) $ret[] = $res['path'];
        }
        $ret = $ret ? zf::$root_url.ltrim(implode('/',array_reverse($ret)), '/').'/' : '';
        return $ret;
    }
    
    public function getContentByPath(array $parents) 
    {
        $select = array();
    	$join = array();
    	$join_tables = array();
    	$join_tables[] = $this->tables['content'];
    	$where = array();
    	$where_arg = array();
    	
    	for ($i = 0; $i < count($parents)-1; $i++) {
    		$select[] = "t".($i+1).".path AS path".($i+1);
    		$select[] = "t".($i+1).".title AS title".($i+1);
    		$join[] = "JOIN ?t AS t".($i+2)." ON t".($i+2).".pid = t".($i+1).".id";
    		$join_tables[] = $this->tables['content'];
    		$where[] = "t".($i+1).".path = ?";
    		$where_arg[] = $parents[$i];
    	}
    	$select[] = "t".($i+1).".path AS path".($i+1);
    	$select[] = "t".($i+1).".title AS title".($i+1);
    	$where[] = "t".($i+1).".path = ?";
    	$where_arg[] = $parents[$i];
    	
    	$result = $this->db->query("SELECT * FROM ?t AS t1 "
    		.implode(" ", $join)
    		.(isset($this->addSQL['join']) ? $this->addSQL['join'] : '')
    		." WHERE ".implode(" AND ", $where)." AND t1.hidden='no' "
    		.(isset($this->addSQL['where']) ? $this->addSQL['where'] : ''), array_merge($join_tables, $where_arg));
		return count($result)>0 ? $result[0] : array();
    }
    
    public function getBreadCrumbs(array $parents, $full = '')
    {
    	$select = array();
    	$join = array();
    	$join_tables = array();
    	$join_tables[] = $this->tables['content'];
    	$where = array();
    	$where_arg = array();
    	$where_or = array();
    	$full = trim($full, "/");
    	for ($i = 0; $i < count($parents)-1; $i++) {
    		$select[] = "t".($i+1).".path AS path".($i+1);
    		$select[] = "t".($i+1).".title AS title".($i+1);
    		$join[] = "JOIN ?t AS t".($i+2)." ON t".($i+2).".pid = t".($i+1).".id";
    		$join_tables[] = $this->tables['content'];
    		$where[] = "t".($i+1).".path = ?";
    		$where_arg[] = $parents[$i];
    		$where_or[] = "t".($i+1).".path = ".$this->db->escape($full);
    	}
    	$select[] = "t".($i+1).".path AS path".($i+1);
    	$select[] = "t".($i+1).".title AS title".($i+1);
    	$where[] = "t".($i+1).".path = ?";
    	$where_arg[] = $parents[$i];
    	$where_or[] = "t".($i+1).".path = ".$this->db->escape($full);

    	$bread_crumbs = $this->db->query("SELECT ".implode(", ", $select)." FROM ?t AS t1 "
    		.implode(" ", $join)
    		." WHERE ".array_pop($where)." OR ".array_pop($where_or)." AND t1.hidden='no'", array_merge($join_tables, array(array_pop($where_arg))));
    	$bc = array();
		$ppath = '/';
    	if (count($bread_crumbs) > 0) {
            foreach($bread_crumbs as $br_c) {
                $n = 0;
                for ($i = 2, $maxi = count($br_c); $i < $maxi+2; $i+=2) {
                    if($parents[$i/2-1] == $br_c["path".($i/2)]){
                       $n+=1;
                    }
                }
                if($n == $maxi/2) {
                    for ($i = 2, $maxi = count($br_c); $i < $maxi+2; $i+=2) {
                        $bc[$ppath.$br_c["path".($i/2)].'/'] = $br_c["title".($i/2)];
                        $ppath = $ppath.$br_c["path".($i/2)].'/';
                    }
                }
            }
    	}
    	return $bc;
    }

    /**
     * По идее - улучшенная версия, которой не страшны повторы в пути (например /doc/doc/doc/)
     *
     * @param array $parents
     * @param string $full
     * @return array
     */
    public function getGoodBreadCrumbs(array $parents, $full='')
    {
        $select = array();
    	$join = array();
    	$join_tables = array();
    	$join_tables[] = $this->tables['content'];
    	$where = array();
    	$where_arg = array();
    	$where_or = array();
    	$full = trim($full, "/");
    	for ($i = 0; $i < count($parents)-1; $i++) {
    		$select[] = "t".($i+1).".path AS path".($i+1);
    		$select[] = "t".($i+1).".title AS title".($i+1);
    		$join[] = "JOIN ?t AS t".($i+2)." ON t".($i+2).".pid = t".($i+1).".id";
    		$join_tables[] = $this->tables['content'];
    		$where[] = "t".($i+1).".path = ".$this->db->escape($parents[$i]);
    		$where_arg[] = $parents[$i];
    		$where_or[] = "t".($i+1).".path = ".$this->db->escape($full);
    	}
    	$select[] = "t".($i+1).".path AS path".($i+1);
    	$select[] = "t".($i+1).".title AS title".($i+1);
    	$where[] = "t".($i+1).".path = ".$this->db->escape($parents[$i]);
    	$where_arg[] = $parents[$i];
    	$where_or[] = "t".($i+1).".path = ".$this->db->escape($full);

    	$bread_crumbs = $this->db->query("SELECT ".implode(", ", $select)." FROM ?t AS t1 "
    		.implode(" ", $join)
    		." WHERE (".implode(' AND ', $where).") OR ".array_pop($where_or)." AND t1.hidden='no'", array_merge($join_tables, array(array_pop($where_arg))));
    	$bc = array();
		$ppath = '/';
    	if (count($bread_crumbs) > 0) {
	    	for ($i = 2, $maxi = count($bread_crumbs[0]); $i < $maxi+2; $i+=2) {
    			$bc[$ppath.$bread_crumbs[0]["path".($i/2)].'/'] = $bread_crumbs[0]["title".($i/2)];
				$ppath = $ppath.$bread_crumbs[0]["path".($i/2)].'/';
    		}
    	}
    	return $bc;
    }
    
    public function spreadTree($mdTree, &$tree = array())
    {
        foreach ($mdTree as $id => $branch) {
            if (!empty($branch['children'])) {
                $children = $branch['children'];
                unset($branch['children']);
                $this->spreadTree($children, $tree);
            }
            $tree[$id] = $branch;
        }
    }
    
    /***
    * Добавил сюда чтобы сбрасывать кеш при изменении порядка страниц из админки.
    * 
    * @param mixed $tableName
    * @param mixed $id
    * @param mixed $to
    * @param mixed $cond
    * @param mixed $posFields
    */
    public function Shift($tableName, $id, $to, $cond = array(), $posFields = array('pos'))
    {
        misc::empty_dir('.zf_cache/content/');
        parent::Shift($tableName, $id, $to, $cond, $posFields);
    }

    //поиск по статическим страницам
    public function SearchStaticPage($search_static_page) {
        $s_static_page = array();
        $s_static_page = $this->model('content')->db->query(
            "SELECT content.title, content.description, content.content FROM content
                 WHERE content.title LIKE '%$search_static_page%'
                 OR content.description LIKE '%$search_static_page%'
                 OR content.content LIKE '%$search_static_page%';"
        );
        return $s_static_page;
    }
}
?>