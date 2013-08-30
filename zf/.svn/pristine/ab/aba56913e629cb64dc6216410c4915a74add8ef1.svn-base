<?php
$options = array();
for ($i = 0; $i < $argc; $i++) {
	switch (strtolower($argv[$i])) {
		case '-dsn':
			$options['dsn'] = $argv[++$i];
		break;
		case '-table':
		case '-t':
			$options['table'] = $argv[++$i];
		break;
		case '-f':
		case '-field':
			$options['field'] = $argv[++$i];
		break;
		case '-v':
		case '-value':
			$options['value'] = $argv[++$i];
		break;
		case '-w':
		case '-where':
			$options['where'] = $argv[++$i];
		break;
		default:
			;
		break;
	}
}
$conf = parse_url($options['dsn']);
$db_h = mysql_connect($conf['host'], $conf['user'], $conf['pass']);
mysql_select_db(trim($conf['path'], '/'), $db_h);
$res = mysql_query("UPDATE `{$options['table']}` SET `{$options['field']}` = '{$options['value']}' WHERE {$options['where']}", $db_h);
echo "UPDATE `{$options['table']}` SET `{$options['field']}` = '{$options['value']}' WHERE {$options['where']}\r\n";
echo mysql_errno() ? mysql_error() : "Updated $res row(s)";
return mysql_errno();