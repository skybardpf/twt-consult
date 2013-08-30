<h3>Заявка № {$data.id}</h3>
<table class="striped">
    {if $request.type == 'calcs'}
        <tr>
            <td>Наименование компании:</td>
            <td>{$data.contractor}</td>
        </tr>
        <tr>
            <td>Выгодоприобретатель:</td>
            <td>{$data.beneficiary}</td>
        </tr>
        <tr>
            <td>Груз (товары через запятую):</td>
            <td>{$data.number_of_seat}</td>
        </tr>
        <tr>
            <td>Количество мест:</td>
            <td>{$data.consignment}</td>
        </tr>
        <tr>
            <td>Единица измерения мест:</td>
            <td>
                {assign var=measure value=$data.number_of_seat_measure}
                {$NumberOfSeatMeasure.$measure}
            </td>
        </tr>
        <tr>
            <td>Общий вес:</td>
            <td>{$data.weight}</td>
        </tr>
        <tr>
            <td>Список документов:</td>
            <td>{$data.documents}</td>
        </tr>
        <tr>
            <td>Начало страхования:</td>
            <td>{$data.start_date|date_format:'%d-%m-%Y'}</td>
        </tr>
        <tr>
            <td>Конец страхования:</td>
            <td>{$data.end_date|date_format:'%d-%m-%Y'}</td>
        </tr>
        {if $data.transports}
            <tr>
                <td colspan="2">Маршрут:</td>
            </tr>
            {foreach from=$data.transports item=trans name=i}
                <tr class="nostriped">
                    {if $smarty.foreach.i.first}
                        <td>Начальная точка маршрута:</td>
                    {elseif !$smarty.foreach.i.last}
                        <td>Промежуточная точка маршрута:</td>
                    {else}
                        <td>Конечная точка маршрута:</td>
                    {/if}
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 130px;">Страна:</td>
                                <td>
                                    {assign value=$trans.country var=country}
                                    {$countries.$country}
                                </td>
                            </tr>
                            <tr>
                                <td>Город:</td>
                                <td>{$trans.city}</td>
                            </tr>
                            <tr>
                                <td>Транспорт:</td>
                                <td>{$trans.transport}</td>
                            </tr>
                            <tr>
                                <td>Номер транспортного средства:</td>
                                <td>{$trans.registration_number}</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            {/foreach}
        {/if}
    {else}
        {foreach from=$titles key=field item=value}
            {if $field != 'id'}
                {if (is_array($data.$field) && $data.$field) || $data.$field}
                    <tr>
                        <td>{$value}</td>
                        <td>
                            {if is_array($data.$field) && $data.$field}
                                {foreach from=$data.$field item=row name=i}
                                    {$row.title}{if !$smarty.foreach.i.last}, {/if}
                                {/foreach}
                            {else}
                                {if $fields.$field.type == 'float'}
                                    {$data.$field|number_format:"0":" ":" "}
                                {else}
                                    {$data.$field}
                                {/if}
                            {/if}
                        </td>
                    </tr>
                {/if}
            {/if}
        {/foreach}
        {if $data.banks}
            {foreach from=$data.banks item=bank name=i}
                <tr>
                    <td>Банк{$smarty.foreach.i.iteration}</td>
                    <td>{$bank.bank} - {$bank.currency}</td>
                </tr>
            {/foreach}
        {/if}
    {/if}
</table>
<div><a style="font-size: 12px;" href="/cabinet/orders">назад</a></div>