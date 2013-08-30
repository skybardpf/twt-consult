<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{$title|default:'CMS'}</title>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/public/cms/css/style2.css" />
<!--[if IE]><link href="/public/cms/css/ie1.css" rel="stylesheet" type="text/css" /><![endif]-->
<link href="/public/cms/css/print.css" rel="stylesheet" type="text/css" media="print" />
{foreach from=$pageCSS item=item}
<link href='{$item}' rel='stylesheet' type='text/css'>
{/foreach}
<!-- JS -->
{literal}
<script>
function toggle_left() {
	if(document.getElementById('left').style.display!='none')
		document.getElementById('left').style.display='none';
	else
		document.getElementById('left').style.display='table-cell';
}
</script>
{/literal}
<script type="text/javascript">
var root_url = '{$root_url}';
var ctrlName = '{$ctrlName}';
var zf_request = {$request|@json_encode};
</script>
{foreach from=$pageJS item=item}
<script src='{$item}' type='text/javascript'></script>
{/foreach}
<!--zf::debug:head-->

</head>

<body>

<div id="loading_bckg" style="display: none;"><img src="/public/zf/img/loading.gif"></div>
{if $moder_script_is_on}
<script type="text/javascript">
    moder_url = '{$moder_lock_url}';
</script>
{/if}

<table id="content">
			{$main_content}
</table>
{if !1}
<table id="mainTable">
	<tr>
		<td id="mainTd">
			{$main_content}
		</td>
	</tr>
</table>
{/if}
<!--zf::debug:body-->
</body>
</html>