<?php require_once dirname(__FILE__) .'/../config.php';?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
<meta charset="utf-8" />
<title>Kalkulator</title>
</head>
<body>

<form action="<?php print(_APP_URL);?>/app/calc.php" method="get">
	<label for="id_amount">Kwota Kredytu: </label>
	<input id="id_amount" type="text" name="amount" value="<?php print($amount); ?>" />PLN<br />
	<label for="id_precent">Oprocentowanie Kredytu: </label>
	<input id="id_precent" type="text" name="precent" value="<?php print($precent); ?>" />%<br />
	<label for="id_paymentTime">Czas Spłaty: </label>
	<input id="id_paymentTime" type="text" name="paymentTime" value="<?php print($paymentTime); ?>" />Lat<br />
	<input type="submit" value="Oblicz" />
</form>	

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($messages)) {
	if (count ( $messages ) > 0) {
		echo '<ol style="margin: 20px; padding: 10px 10px 10px 30px; border-radius: 5px; background-color: #f88; width:300px;">';
		foreach ( $messages as $key => $msg ) {
			echo '<li>'.$msg.'</li>';
		}
		echo '</ol>';
	}
}
?>

<?php if (isset($monthlyPaymentRounded)){ ?>
<div style="margin: 20px; padding: 10px; border-radius: 5px; background-color: #ff0; width:300px;">
<?php echo 'Miesięczna Opłata: '.$monthlyPaymentRounded; ?>PLN
</div>
<?php } ?>

</body>
</html>