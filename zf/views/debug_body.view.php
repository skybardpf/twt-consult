<?php
/**
* View for output debug information
* 
* @category CMS
* @package zSMS
* @subpackage zSMS_core
* @version SVN: $Id: debug.view.inc 9 2009-04-21 12:04:32Z ZaVteR $ 
*/
?>
<div id="debugDiv">
<?
$i = 1;
foreach ($this->get('data') as $item) {
?>
	<div class="debug_item">
			<div class="debug_title_div" id="debug_div_<?=$i?>">
				<span class="debug_type <?=$item['type']?>"><?=$item['type']?>:</span>
<?
if ($item['type'] == 'sql' || $item['type'] == 'sql_error') {
	$title = $item['body']['raw_query'];
	$body = debug::get_dump($item['body']);
} else {
	if(is_array($item['body'])) {
		$title = 'Array';
		$body  = debug::get_dump($item['body']);		
	} else {
		$title = $item['body'];
		$body  = '';		
	}
}
?>
				<span class="debug_title"><?=$title?></span><br />
				<span class="debug_in">in file</span>
				<span class="debug_file"><?=$item['caller']['file']?></span>
				<span class="debug_at">at line</span>
				<a class="debug_line" href="#" title="Code sniplet|<?=str_replace("\n", '|',$item['code_sniplet'])?>"><?=$item['caller']['line']?></a>
			</div>
			<?if ($body) {?>
			<div class="debug_body" id="debug_div_<?=$i?>_body"><?=$body?></div>
			<?}?>
	</div>
<?
	$i++;
}
?>
</div>