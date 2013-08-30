<?php
function smarty_block_out($params, $content, &$smarty)
{
	if ($content) {
		if (strpos($content, '[dir]') !== false) {
			return '<img src="'.str_replace('[dir]', 'icon', $content).'" />';
		}
	}
	return $content;
}
?>
