<div id="debugDiv">
	{foreach from=$zfDebugData item=item key=key name=frch}
		<div class="debug_item">
				<div class="debug_title_div" id="debug_div_{$key}">
					<span class="debug_type {$item.type}">{$item.type}:</span>
					<span class="debug_title">
	{if $item.type == 'sql' OR $item.type == 'sql_error'}
		{$item.body.raw_query}
	{elseif $item.type == 'sphinx' and is_array($item.body)}
		Words:
		{foreach from=$item.body.words key=k item=v name=sphinx}
			{$k}{if !$smarty.foreach.sphinx.last}, {/if}
		{/foreach}
		{if $item.body.error}Error: <span style="color:red;">{$item.body.error}</span>{/if}
		{if $item.body.warning}<span style="color:red;">{$item.body.warning}</span>{/if}
	{elseif is_array($item.body)}
		Array
	{else}
		{$item.body}
	{/if}
					</span><br />
					<span class="debug_in">in file</span>
					<span class="debug_file">{$item.caller.file}</span>
					<span class="debug_at">at line</span>
					<a class="debug_line" href="#" title="Code sniplet|{$item.code_sniplet|replace:"\n":"|"}">{$item.caller.line}</a>
				</div>
				{if !is_array($item.body)}{else}
				<div class="debug_body" id="debug_div_{$key}_body">{debug_get var=$item.body}</div>
				{/if}
		</div>
	{/foreach}
{***************************************** Smarty ******************************************}
	{assign_debug_info}
	<div class="debug_item">
	{section name=templates loop=$_debug_tpls}
	    {section name=indent loop=$_debug_tpls[templates].depth}&nbsp;&nbsp;&nbsp;{/section}
	    <font color={if $_debug_tpls[templates].type eq "template"}brown{elseif $_debug_tpls[templates].type eq "insert"}black{else}green{/if}>
	        {$_debug_tpls[templates].filename|escape:html}</font>
	    {if isset($_debug_tpls[templates].exec_time)}
	        <span class="exectime">
	        ({$_debug_tpls[templates].exec_time|string_format:"%.5f"})
	        {if %templates.index% eq 0}(total){/if}
	        </span>
	    {/if}
	    <br />
	{sectionelse}
	    no templates included in Smarty
	{/section}
	</div>
	
	{section name=vars loop=$_debug_keys}
		{if $$_debug_keys[vars] != '$zfDebugData'}
	    <div class="debug_item">
	        <div class="debug_title_div" id="debug_div_smary_vars_{$smarty.section.vars.index}">
	        <span class="debug_type">Smarty vars: </span>
	        <span class="debug_title">
	        	{ldelim}${$_debug_keys[vars]|escape:'html'}{rdelim}
	        </span>
	        </div>
	        <div class="debug_body" id="debug_div_smary_vars_{$smarty.section.vars.index}_body">
	        	<blockquote>{$_debug_vals[vars]|@debug_print_var}</blockquote>
	        </div>
	    </div>
	    {/if}
	{sectionelse}
	    <div class="debug_item">no template variables assigned in Smarty</div>
	{/section}
	
	{section name=config_vars loop=$_debug_config_keys}
	    <div class="debug_item">
	        <div class="debug_title_div" id="debug_div_smary_config_vars_{$smarty.section.config_vars.index}">
	        <span class="debug_type">Smarty config vars: </span>
	        <span class="debug_title">
	        	{ldelim}#{$_debug_config_keys[config_vars]|escape:'html'}#{rdelim}
	        </span>
	        </div>
	        <div class="debug_body" id="debug_div_smary_config_vars_{$smarty.section.config_vars.index}_body">
	        	<blockquote>{$_debug_config_vals[config_vars]|@debug_print_var}</blockquote>
	        </div>
	    </div>
	{sectionelse}
	    <div class="debug_item">no config vars assigned in Smarty</div>
	{/section}
	{***************************************** /Smarty ******************************************}
</div>