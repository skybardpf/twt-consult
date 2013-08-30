<?php
class ImagerefreshModel extends CMS_Model
{
	public function getTask()
	{
		return $this->db->fullKarrQuery("
			SELECT b.tblname, c.folder, c.paramstr, c.task_start, c.task_complete, a.modelname, c.id as fid, b.id as tblid, a.id as tid   
			FROM ?t as a
			INNER JOIN ?t as b on a.id=b.pid
			LEFT OUTER JOIN ?t as c on b.id = c.tbl_pid
			WHERE a.task_complete IS NULL
			ORDER BY c.id ASC
			",
			$this->tables['imagerefresh'],
			$this->tables['imagerefreshtbls'],
			$this->tables['imagerefreshfolders']
		);
	}
	
	public function AddTask($models) 
	{
		$tasks = array();
		foreach ($models as $modName) {
			if (isset($this->model($modName, $modName)->conf['tables'])) {
				foreach ($this->model($modName, $modName)->conf['tables'] as $tblname=>$tblconf) {
					if (!isset($tblconf['images'])) continue;
					$fields = array_keys($tblconf['images']);
					foreach ($fields as $fld) {
						$tasks[$modName][$tblname][$fld] = $tblconf['images'][$fld];
					}
				}
			}
		}
		return $tasks;
	}
	
	public function SaveTask($task)
	{
		$ret = array();
		foreach ($task as $modelname => $tables) {
			$newid = $this->db->query("INSERT INTO ?t (?lt) VALUES (?l)", 
				$this->tables['imagerefresh'], 
				array('task_start', 'task_complete', 'modelname'),
				array(date('Y-m-d H:i:s'), NULL, $modelname)
			);
			foreach ($tables as $tblName => $fields) {
				$newtblid = $this->db->query("INSERT INTO ?t (?lt) VALUES (?l)",
				$this->tables['imagerefreshtbls'],
				array('pid', 'task_start', 'task_complete', 'tblname'),
				array($newid, date('Y-m-d H:i:s'), NULL, $tblName)
				);
				foreach ($fields as $dirs) {
					$files = $this->getCntFiles(array('topfolder'=>$tblName, 'folder'=>array_keys($dirs)));
					foreach ($dirs as $dirname => $dir) {
						$this->db->query("INSERT INTO ?t (?lt) VALUES (?l)",
						$this->tables['imagerefreshfolders'],
						array('pid', 'tbl_pid', 'task_start', 'task_complete', 'folder', 'paramstr'),
						array($newid, $newtblid, $files[$tblName][$dirname], 0, $dirname, json_encode($dir))
						);
					}
				}
			} 
		}
	}
	
	public function getCntFiles($params)
	{
		$ret = array();
		$cntall = 0;
		foreach ($params['folder'] as $k => $subdir) {
		$cnt = 0;
			$dir = opendir('public/userfiles/'.$params['topfolder'].'/original') or die("Не могу открыть папку");
			$file = readdir($dir);
			while ($file) {
				if (preg_match('/.+\..+/', $file) && $file!='Thumbs.db') {
					$cnt++;
				}
				$file = readdir($dir);
			}
			closedir($dir);
			$ret[$params['topfolder']][$subdir] = $cnt;
		}
		return $ret;
	}
	
	public function attachOperations($file, $dir)
	{
		$ret = $this->db->query("INSERT INTO ?t (?lt) VALUES (?l)",
		$this->tables['imagerefreshfiles'],
		array('file', 'tbl'),
		array($file, $dir)
		);
		return $ret;
	}
	
	public function getFileOperations($dir)
	{
		return $this->db->karr('SELECT id, file FROM ?t WHERE tbl = ?',
		$this->tables['imagerefreshfiles'],
		$dir
		);
	}
	
	public function detachOperation($id, $folderid, $tblid, $taskid)
	{
		$this->db->query("DELETE FROM ?t WHERE id = ?",
		$this->tables['imagerefreshfiles'],
		$id
		);
		$curtbltask = $this->db->query("SELECT tbl_pid, task_start, task_complete FROM ?t WHERE id=?",
		$this->tables['imagerefreshfolders'],
		$folderid
		);
		if ($curtbltask) {
			$curtbltask = $curtbltask[0];
			$this->db->query("UPDATE ?t SET task_complete=? WHERE id=?", 
			$this->tables['imagerefreshfolders'], 
			$curtbltask['task_complete']+1,
			$folderid);
			if ($curtbltask['task_start'] < $curtbltask['task_complete']+2) {
				$this->db->query("DELETE FROM ?t WHERE id = ?",
					$this->tables['imagerefreshfolders'], 
					$folderid
				);
				$cnt = $this->db->one("SELECT count(*) as cnt FROM ?t WHERE tbl_pid = ?",
					$this->tables['imagerefreshfolders'], 
					$curtbltask['tbl_pid']
				);
				if (!$cnt) {
					$this->db->query("DELETE FROM ?t WHERE id = ?", 
					$this->tables['imagerefreshtbls'],
					$curtbltask['tbl_pid']
					);
					$cnt2 = $this->db->one("SELECT count(*) as cnt FROM ?t WHERE pid = ?",
						$this->tables['imagerefreshtbls'],
						$taskid
					);
					if (!$cnt2) {
						$this->db->query("DELETE FROM ?t WHERE id = ?",
							$this->tables['imagerefresh'],
							$taskid
						);
						$cnt3 = $this->db->one("SELECT count(*) as cnt FROM ?t",
							$this->tables['imagerefresh'],
							$taskid
						);
						if (!$cnt3) return true;
					}
				}
			}
		}
		return false;
	}
}