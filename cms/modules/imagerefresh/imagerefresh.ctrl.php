<?php

class ImagerefreshController extends Controller
{
	private $progress;
	private $timers = array();
	private $restrictedModels = array(); 
	private $timelimit;

	public function __construct($ctrlName, $app)
	{
		$this->timers['start_construction'] = time();
		$this->timelimit = ini_get('max_execution_time');
		parent::__construct($ctrlName, $app);
	}

	public function run()
	{
		$this->progress = $this->model()->getTask();
		parent::run();
	}

	public function actionDefault()
	{
		if (!empty($_POST) && !$this->progress) {
			return $this->ExecTask($this->AddTask());
		}
		if (!$this->progress)
			return $this->WaitTask();
		else
			return $this->ExecTask();
	}

	private function WaitTask()
	{
		$this->page->models = $this->getModels();
		$this->page->content = $this->renderView('imagerefresh', 'imagerefresh');
	}

	private function getModels()
	{
		$models = array();
		$dir = opendir('site/conf') or die("Не могу открыть папку");
		$file = readdir($dir);
		while ($file) {
			if (strpos($file, '.') === FALSE && !in_array($file, $this->restrictedModels)) {
				$models[] = $file;
			}
			$file = readdir($dir);
		}
		return $models;
	}

	private function ExecTask($task=false)
	{
		if ($task) {
			$this->model('imagerefresh', 'imagerefresh')->SaveTask($task);
			$this->progress = $this->model()->getTask();
		}
		$this->timers['start_executing'] = time();
		$this->redir('start_construction', 'start_executing');
		$this->dropFolders();
		$this->timers['start_creation'] = time();
		$this->redir('start_construction', 'start_creation');
		foreach ($this->progress as $dir => $arr) {
			foreach ($arr as $key => $sub) {
			$filenames = $this->getFileNames($dir);
				$params = json_decode($sub['paramstr'], true);
				foreach ($filenames as $id => $fname) {
					image::img_resize(
						'public/userfiles/'.$dir.'/original/'.$fname, 
						'public/userfiles/'.$dir.'/'.$sub['folder'].'/'.$fname, 
						isset($params['w'])?$params['w']:false, 
						isset($params['h'])?$params['h']:false,
						0777,
						$params['ratio'],
						!empty($params['cut']) ? $params['cut'] : 0,
						!empty($params['q']) ? $params['q'] : 80,
						!empty($params['colormode']) ? $params['colormode']: 'color'
					);
					if ($this->model()->detachOperation($id, $sub['fid'], $sub['tblid'], $sub['tid'])) {
						header('Location: /admin/imagerefresh');
						echo 'all_complete';
						exit;
					}
					$this->timers['processing_step'] = time();
					$this->redir('start_construction', 'processing_step');
				}
			}
		}
	}
	
	private function getFileNames($dirName)
	{
		$ret = $this->model()->getFileOperations($dirName);
		if (!$ret) {
			$dir = opendir('public/userfiles/'.$dirName.'/original') or die("Не могу открыть папку");
			$file = readdir($dir);
			while ($file) {
				if (preg_match('/.+\..+/', $file) && $file!='Thumbs.db') {
					$newid = $this->model('imagerefresh', 'imagerefresh')->attachOperations($file, $dirName);
					$ret[$newid] = $file;
				}
				$file = readdir($dir);
			}
			closedir($dir);
		} 
		return $ret;
	}
	
	private function redir($tname1, $tname2)
	{
		$id = ($this->app->request->id)?$this->app->request->id:1;
		$id++;
		if (($this->timers[$tname2]-$this->timers[$tname1])>$this->timelimit-10) {
			header('Location: /admin/imagerefresh/id/'.$id);
			exit;
		}
	}
	
	private function dropFolders()
	{
		foreach ($this->progress as $dir => $arr) {
			foreach ($arr as $sub) {
				if ($sub['task_complete']==0)
				misc::empty_dir('public/userfiles/'.$dir.'/'.$sub['folder']);
			}
		}
	}
	
	private function AddTask()
	{
		return $this->model('imagerefresh', 'imagerefresh')->AddTask(array_keys($_POST));
	}
}