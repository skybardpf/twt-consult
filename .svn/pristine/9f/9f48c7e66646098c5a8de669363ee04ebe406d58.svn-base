<table>
    <tr>
        <td style="width: 85px;"><label>Страна</label></td>
        <td>
            <select name="order[route][{$field}]{if $iteration}[{$iteration}]{/if}[Country]" data-route_input="1" data-country_input="1"{if $iteration == '__iteration__'} disabled="disabled"{/if}>
                <option value="">Не выбрана</option>
                {foreach from=$countries item=cr}
                    <option value="{$cr->id}"{if $point.Country == $cr->id} selected="selected"{/if}>{$cr->name}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Город</label></td>
        <td>
            <select name="order[route][{$field}]{if $iteration}[{$iteration}]{/if}[City]" data-route_input="1" data-city_input="1"{if $iteration == '__iteration__'} disabled="disabled"{/if}>
                <option value="">Не выбрана</option>
                {foreach from=$cities key=k item=c}
                    <option value="{$k}"{if $point.City == $k} selected="selected" {/if}>{$c}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Транспорт</label></td>
        <td>
            <select name="order[route][{$field}]{if $iteration}[{$iteration}]{/if}[Transport]" data-route_input="1"{if $iteration == '__iteration__'} disabled="disabled"{/if}>
                {foreach from=$transport key=k item=v}
                    <option value="{$k}"{if $point.Transport == $k} selected="selected" {/if}>{$v}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td><label>Номер транспорт. средства</label></td>
        <td><input type="text" name="order[route][{$field}]{if $iteration}[{$iteration}]{/if}[RegistrationNumber]" data-route_input="1" value="{if $point.RegistrationNumber}{$point.RegistrationNumber}{/if}"{if $iteration == '__iteration__'} disabled="disabled"{/if}/></td>
    </tr>
</table>