{if $CAction == 'show'}
    {loadview name=cabinet/cabinet_orders_show}
{else}
	<h3 class="blue_title">Мои заявки</h3>
    <div class="table">
	    {if !$orders.account && !$orders.entity && !$orders.transport && !$orders.calcs}
            <div style="font-size: 12px;">
                У Вас нет ни одной заявки.
            </div>
	    {else}
            {if $orders.account}
                <div class="order_title">Заявки на открытие счета</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Банк и валюта счета</th>
                        <th></th>
                    </tr>
                    {foreach from=$orders.account item=row}
                        <tr>
                            <td>{$row.id}</td>
                            <td>{$row.created|date_format:'%d-%m-%Y'}</td>
                            <td>
                                {if $row.banks}
                                    {foreach from=$row.banks item=bank}
                                        {$bank.bank} - {$bank.currency}
                                    {/foreach}
                                {/if}
                            </td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/{$row.id}/type/account">Просмотреть</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            {/if}

            {if $orders.entity}
                <div class="order_title">Заявки на регистрацию юридического лица</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Юрисдикция</th>
                        <th>Название компании</th>
                        <th>Род деятельности</th>
                        <th>Стоимость</th>
                        <th></th>
                    </tr>
                    {foreach from=$orders.entity item=row}
                        <tr>
                            <td>{$row.id}</td>
                            <td>{$row.created|date_format:'%d-%m-%Y'}</td>
                            <td>{$row.jurisdiction}</td>
                            <td>{$row.company_name}</td>
                            <td>
                                {if $row.kind_activities}
                                    {foreach from=$row.kind_activities item=kind_activitie}
                                        {$kind_activitie.title}
                                    {/foreach}
                                {/if}
                            </td>
                            <td>{$row.price_final}</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/{$row.id}/type/entity">Просмотреть</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            {/if}

            {if $orders.transport}
                <div class="order_title">Комплексные заявки на транспортную логистику и таможенное оформление</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Наименование товара</th>
                        <th>Стоимость груза - валюта</th>
                        <th></th>
                    </tr>
                    {foreach from=$orders.transport item=row}
                        <tr>
                            <td>{$row.id}</td>
                            <td>{$row.created|date_format:'%d-%m-%Y'}</td>
                            <td>{$row.cargo_name}</td>
                            <td>{$row.cost|number_format:"0":" ":" "} - {$row.currency_name}</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/{$row.id}/type/transport">Просмотреть</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            {/if}

            {if $orders.calcs}
                <div class="order_title">Заявки по страхованию</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Начало страхования</th>
                        <th>Конец страхования</th>
                        <th></th>
                        <th></th>
                    </tr>
                    {foreach from=$orders.calcs key=k item=row}
                        <tr>
                            <td>{$k}</td>
                            <td>{$row.start_date|replace:'T':' '|date_format:'%d-%m-%Y'}</td>
                            <td>{$row.end_date|replace:'T':' '|date_format:'%d-%m-%Y'}</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/{$k}/type/calcs">Просмотреть</a>
                            </td>
                            <td class="buttons download_file" data-filename="{$row.link}">
                                <a href="#">Скачать</a>
                            </td>
                        </tr>
                    {/foreach}
                </table>
            {/if}
	    {/if}

    </div>
{/if}
<div id="preparing-file-modal" title="Подготовка файла..." style="display: none;">
    Подготавливается файл для скачивания, подождите...

    <div class="ui-progressbar-value ui-corner-left ui-corner-right" style="width: 100%; height:22px; margin-top: 20px;"></div>
</div>
<div id="error-modal" title="Error" style="display: none;">
    Возникли проблемы при подготовке файла, повторите попытку
</div>

{literal}
<script>
    $(document).ready(function(){
        $('.download_file').on('click', function(){
            var filename = $(this).data('filename');
            var url = '/cabinet/download_file?path='+filename;
            console.log(url);

            var preparingFileModal = $("#preparing-file-modal");
            preparingFileModal.dialog({ modal: true });
            $.fileDownload(
                url,
                {
                    successCallback: function (url) {
                        preparingFileModal.dialog('close');
                    },
                    failCallback: function (responseHtml, url) {
                        preparingFileModal.dialog('close');
                        $("#error-modal").dialog({ modal: true });
                    }
                });
            return false;
        });
    });
</script>
{/literal}