<div id="calculator">
    
    
    <div id="geographer">
        <form name="geographer">
            <br /><br />
            Известное пространство <a href="/admin/geographer/add_data/"><img src="/public/cms/img/icons/add.png" alt=""></a>
            <br /><br />
            {assign var="key_prev" value=0}
            {foreach from=$forms_elements.geographer item=element key=key}
                {if $element.htmltype eq 'hidden'}
                    <input type="hidden" name="changed"></input>
                {elseif $element.type eq 'text'}
                    <div style="float:left; width:35%">
                    <label>{$element.title}</label>
                    <input type="text" name="levels[{$key}]" value="{$element.value}" />
                    </div>
                <br/>
                {else}
                	<div style="float:left; width:35%; height:2em;">
                    <label for="geographer_{$key}">{$element.title}:</label> 
                    <select name="levels[{$key}]" id="{$key}">
                        <option value="">{$element.null}</option>
                        {foreach from=$element.values item=name key=id}
                            <option {if $id eq $element.value}selected{/if} value="{$id}">{$name}</option>
                        {/foreach }
                    </select>
                    {if $element.value}
                        {assign var="key_prev" value=$element.value}
                        <div style="position:relative; top:-2em; left:100%; padding-top:.5em;">
                            <a href="/admin/geographer/add_data/id/{$element.value}/pid/{$key}"><img src="/public/cms/img/icons/add.png" alt=""></a>
                            <a href="/admin/geographer/del_data/id/{$element.value}"><img src="/public/cms/img/icons/delete.png" alt=""></a>
                            <a href="/admin/geographer/mod_geo/id/{$element.value}/type/data"><img src="/public/cms/img/icons/edit.png" alt=""></a>
                        </div>
                    {/if}
                    </div>
                    {if $adds.$key}
                            <div style="float:right; width:45%;">
                        {foreach from=$adds.$key item=additionalElement key=additionalKey}
                            <div style="height:2em;">
                                <label for="geographer_{$additionalKey}" style="width:40%">{$additionalElement.title}:</label>
                                {if $additionalElement.type eq 'select'}
                                <select name="adds[{$additionalKey}]" id="geographer_{$additionalKey}" style="width:44%">
                                    <option value="">{$additionalElement.null}</option>
                                    {foreach from=$additionalElement.values item=name key=id}
                                        <option {if $id eq $additionalElement.value}selected{/if} value="{$id}">{$name}</option>
                                    {/foreach }
                                </select>
                                {elseif $additionalElement.type eq 'text'}
                                <input type="text" id="geographer_{$additionalKey}" name="adds[{$additionalKey}]" value="{$additionalElement.value}" style="width:44%"/>
                                {/if}
                                {if $additionalElement.value}
                                    {assign var="key_prev" value=$additionalElement.value}
                                <div style="position:relative; top:-1.5em; left:85%; height:2em;">
                                        <a href="/admin/geographer/add_data/id/{$additionalElement.value}/pid/{$additionalKey}"><img src="/public/cms/img/icons/add.png" alt=""></a>
                                        <a href="/admin/geographer/del_data/id/{$additionalElement.value}"><img src="/public/cms/img/icons/delete.png" alt=""></a>
                                        <a href="/admin/geographer/mod_geo/id/{$additionalElement.value}/type/data"><img src="/public/cms/img/icons/edit.png" alt=""></a>
                                </div>
                                {/if}
                            </div><br />
                        {/foreach}
                            </div>
                    {/if}
                    <br style="clear:both;"><br />
                   
                {/if}
            {/foreach}
        </form>
    </div>
</div>