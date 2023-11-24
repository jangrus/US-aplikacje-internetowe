{extends file="Main.tpl"}

{block name=top}
    <form action="{$conf->action_root}" method="post" class="pure-form pure-form-aligned bottom-margin">
        <legend>Kalkulator Kredytowy</legend>
        <fieldset>
            <div class="pure-control-group">
                <label for="id_amount">Kwota Kredytu: </label>
                <input id="id_amount" type="text" name="amount" value="{$form->amount}"/>
            </div>
            <div class="pure-control-group">
                <label for="id_precent">Oprocentowanie Kredytu: </label>
                <input id="id_precent" type="text" name="precent" value="{$form->precent}"/><br />
            </div>
            <div class="pure-control-group">
                <label for="id_paymentTime">Czas Spłaty: </label>
                <input id="id_paymentTime" type="text" name="paymentTime" value="{$form->paymentTime}"/><br />
            </div>
            <div class="pure-controls">
                <input type="submit" value="zaloguj" class="pure-button pure-button-primary"/>
            </div>
        </fieldset>
    </form>
    {if !$msgs->isMessage()}
        <div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
            Miesięczna Opłata: {$monthlyPaymentRounded}PLN
        </div>
    {/if}
{/block}