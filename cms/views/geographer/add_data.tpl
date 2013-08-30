<div id="list_data">
    <label>Вы добавляете данные к элементу "{$parent.name}", принадлежащему к типу "{$parent_meta.name}".</label><br/><br/>
    
    <label>Выберите к какому типу должны принадлежать добавляемые данные.</label><br/><br/>
    
    <form name="add_data">
        <select name="Meta" onchange="this.form.submit();">
            <option value="null" disabled>Выберите</option>
            {foreach from=$meta_select item=item key=key}
                <option {if $selected_meta && $selected_meta eq $key}selected{/if} value="{$key}">{$item.name}</option>
            {/foreach}
        </select>
        <a href="/admin/geographer/add_meta/">Или создайте свой тип.</a>
        {if $exist}
            <br/>
            <br/>
            <div style="float:left; padding-right:5em;">
                <label>можете выбрать из уже существующих значений</label>
                <br/>
                <br/>
                <select name="Data" onchange="this.form.submit();">
                    <option value="null" disabled>Выберите</option>
                    {foreach from=$exist item=item key=key}
                        <option {if $selected_data && $selected_data eq $item.id}selected{/if} value="{$item.id}">{$item.name}</option>
                    {/foreach}
                </select>
            </div>
            <div>
                <label>можете добавить своё</label>
                <br/>
                <br/>
                <input type="text" name="New">
            </div>
            <br/>
            <br/>
            <input type="submit" value="Добавить" name="Click" onclick="this.form.submit">
        {elseif $selected_meta}
            <br/>
            <br/>
            <div style="float:left; padding-right:5em;">
            	<label>Нет значений данного типа</label>
                <br/>
                <br/>
                <input type="text" style="visibility:hidden;">
            </div>
            <div>
                <label>можете добавить своё</label>
                <br/>
                <br/>
                <input type="text" name="New">
            </div>
            <br/>
            <br/>
            <input type="submit" value="Добавить" onclick="this.form.submit" name="Click">
        {/if}
    </form>
    
</div>