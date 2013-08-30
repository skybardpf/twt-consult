<?php
function upMeta($i, $o)
{
	switch (strtolower(pathinfo($o, PATHINFO_EXTENSION))) {
		case 'flv':
			$i = escapeshellarg($i);
			$o = escapeshellarg($o);
			if (substr(php_uname(), 0, 7) == "Windows"){
				exec("c:\\bin\\yamdi -i $i -o $o 2>&1");
			} else {
				exec("/usr/local/bin/yamdi -i $i -o $o 2>&1", $output, $ret_exec);
				echo "Comand: yamdi -i $i -o $o 2>&1\n";
				echo "\n======\nOutput: "; print_r($output);
				echo "\n======\nRet: "; print_r($ret_exec); echo "\n";
			}
		break;
		case 'mp4':
			$i = escapeshellarg($i);
			$o = escapeshellarg($o);
			if (substr(php_uname(), 0, 7) == "Windows"){
				exec("c:\\bin\\MP4Box.exe -add $i $o 2>&1");
			} else {
				exec("/usr/local/bin/qt-faststart $i $o 2>&1", $output, $ret_exec);
				echo "Comand: qt-faststart $i $o 2>&1\n";
				echo "\n======\nOutput: "; print_r($output);
				echo "\n======\nRet: "; print_r($ret_exec); echo "\n";
			}
		break;
		default:
			copy($i, $o);
		break;
	}
}
$isWin = (substr(php_uname(), 0, 7) == "Windows");
for ($i = 0; $i < $argc; $i++) {
	if (in_array($argv[$i], array('-h', '--help', '/?', '/h'))) {
		echo iconv('utf-8', $isWin ? 'cp866' : 'koi8-r', <<<HELPDELEMITERASDASD
╔════════════════╗
║Опции скрипта:  ║
║Нет             ║
╚════════════════╝
Все параметры передаются кодеру ffmpeg
──────────────────────────────────────────────────\n
HELPDELEMITERASDASD
		);
		exit;
	}
	if ($argv[$i] == '-i') {
		$argv[$i+1] = escapeshellarg($argv[$i+1]);
	}
}
unset($argv[0]);
$argv == array_merge($argv);
$argc = count($argv);
$file = array_pop($argv);
$tmp_name = pathinfo($file, PATHINFO_DIRNAME).'/tmp_t'.time().'_r'.rand().'.'.pathinfo($file, PATHINFO_EXTENSION);
$argv[] = escapeshellarg($tmp_name);

//конвертим видео/аудио
if (substr(php_uname(), 0, 7) == "Windows"){
	exec('c:\\bin\\ffmpeg.exe '.implode(' ', $argv).' 2>&1', $output, $ret_exec);
} else {
	exec('/usr/local/bin/ffmpeg '.implode(' ', $argv).' 2>&1', $output, $ret_exec);
	echo "Comand: ffmpeg ".implode(' ', $argv).' 2>&1';
	echo "\n======\nOutput: "; print_r($output);
	echo "\n======\nRet: "; print_r($ret_exec); echo "\n=====\n";
}
if ($ret_exec == 0) {
	//переносим мету в начало файла
	upMeta($tmp_name, $file);
}
if (is_file($tmp_name)) {
	unlink($tmp_name);
}
return $ret_exec;