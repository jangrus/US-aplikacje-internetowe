<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$amount = $_REQUEST ['amount'];
$precent = $_REQUEST ['precent'];
$paymentTime = $_REQUEST ['paymentTime'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($amount) && isset($precent) && isset($paymentTime))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $amount == "") {
	$messages [] = 'Nie podano kwoty';
}
if ( $precent == "") {
	$messages [] = 'Nie podano Oprocentowania';
}
if ( $paymentTime == "") {
	$messages [] = 'Nie podano czasu spłaty';
}

//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $amount $precent i $paymentTime są liczbami całkowitymi
	if (! is_numeric( $amount )) {
		$messages [] = 'Kwota Kredytu nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $precent )) {
		$messages [] = 'Oprocentowanie Kredytu nie jest liczbą całkowitą';
	}	

	if (! is_numeric( $paymentTime )) {
		$messages [] = 'Czas Spłaty nie jest liczbą całkowitą';
	}	

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na float
	$amount = floatval($amount);
	$precent = floatval($precent);
	$paymentTime = floatval($paymentTime);

	$amountToPay = $amount + (($amount * 0.01 * $precent) * $paymentTime);
	$monthlyPayment = $amountToPay / ($paymentTime * 12);
	$monthlyPaymentRounded = number_format((float)$monthlyPayment, 2, '.', '');
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$paymentTime,$precent,$monthlyPaymentRounded,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_view.php';