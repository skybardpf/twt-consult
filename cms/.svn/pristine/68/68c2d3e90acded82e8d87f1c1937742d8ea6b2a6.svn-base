<div id="transaction_div" style="margin-left: -11pt; margin-top: -11pt; margin-right: -10pt;">
    <table id="addfilmformtop" style="background-color:{if $warehouse_income && $warehouse_target}#9fa7f5{elseif $warehouse_income}#f59f9f{elseif $warehouse_target}#acec90{/if};">
        <tr>
            <td>
                <table style="margin:auto;">
                    <tr>
                        <td class="addfilmformtop_in">
                        	<span id="warehouse_income">{if $warehouse_income}"{$warehouse_income}"{/if}</span>
                        </td>
                        <td class="addfilmformtop_in center">
                        	<img src="/public/cms/img/Arrow_new.png">
                        </td>
                        <td class="addfilmformtop_in">
                        	<span id="warehouse_target">{if $warehouse_target}"{$warehouse_target}"{/if}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br />
    <div style="padding:0 20px;" id="add_film_form_outer">
        <input type="button" id="nomination_search" value="Искать по наименованию">
        {form name='Add_film_form'}
        <br /><br />
    
        <div id="bar_code_search_div">
            <div id="bc_lab">
            {label name='bar_code'}
            </div>
            <div id="bc_inp">
            {input name='bar_code'}
            </div>
        </div>
        <div id="nomination_search_div" style="display: none;">
            <div id="bc_lab">
            {label name='nomination'}
            </div>
            <div id="bc_inp">
            {input name='nomination'}
            </div>
        </div>
        <div>
            <div id="am_lab">
            {label name='amount'}
            </div>
            <div id="am_inp">
            {input name='amount'}
            </div> 
        </div>
        <div id="unit_lab">
        {$forms_elements.Add_film_form.unit.value}
        </div> 
        <hr style="clear:both;">
        <div>
            <div id="tit_lab">
            {label name='title'}
            </div>
            <div id="tit_inp">
            {input name='title'}
            </div>
        </div>
        <div>
            <div id="prod_lab">
            {label name='product'}
            </div>
            <div id="prod_inp">
            {input name='product'}
            </div>
        </div>
        <div>
            <div id="prod_lab">
            {label name='amount_on_warehouse'}
            </div>
            <div id="prod_inp">
            {input name='amount_on_warehouse'}
            </div>
        </div>
        <div>
            <div id="tbc_inp">
            {input name='true_bar_code'}
            </div>
            <div id="tbc_inp">
            {input name='id'}
            </div>
        </div>
        {loadview name="page/buttons"}
        </form>
    </div>
</div>