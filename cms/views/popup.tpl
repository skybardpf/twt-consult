<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{$title|default:'CMS'}</title>
<!-- CSS -->
<link rel="stylesheet" type="text/css" href="/public/cms/css/style.css" />
{foreach from=$pageCSS item=item}
<link href='{$item}' rel='stylesheet' type='text/css'>
{/foreach}
<!-- JS -->
<script type="text/javascript">
var root_url = '{$root_url}';
var ctrlName = '{$ctrlName}';
</script>
{foreach from=$pageJS item=item}
<script src='{$item}' type='text/javascript'></script>
{/foreach}

<!--zf::debug:head-->

</head>


<body class="search" onLoad="window.focus();">
<div style="margin: 14px;">
{if $access_denied}
    У Вас нет прав на осуществление этой операции.
{/if}
{$content}
</div>
<div class="close"><a id="closeWin" href="#">закрыть</a></div>

<!--zf::debug:body-->
</body>
</html>