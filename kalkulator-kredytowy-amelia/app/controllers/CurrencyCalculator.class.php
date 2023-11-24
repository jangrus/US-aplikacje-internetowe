<?php

namespace app\controllers;

use core\App;
use core\RoleUtils;
use core\ParamUtils;
use app\forms\calculatorForm;
use core\Utils;

class CurrencyCalculator
{
    //inicjalizacja zmiennych
    private $form;
    private $monthlyPaymentRounded;
    private $errorCount = 0;

    //stworzenie obiektu form
    public function __construct() {
        $this->form = new calculatorForm();
    }
    public function action_calculator() {

        //pobranie parametrów z szablonu
        $this->form->amount = ParamUtils::getFromRequest('amount');
        $this->form->paymentTime = ParamUtils::getFromRequest('paymentTime');
        $this->form->precent = ParamUtils::getFromRequest('precent');

        //walidacja parametrów
        $this->validateForm();
        //jeśli w walidacji nie było błędów oblicz miesięczną opłatę
        if($this->errorCount == 0){
            $this->monthlyPaymentRounded = $this->calculatePaymentAmount();
        }else {
            $this->monthlyPaymentRounded = null;
        }
        //wyświetl widok
        $this->generateView();


    }

    //generacja widoku
    public function generateView() {
        App::getSmarty()->assign('form', $this->form);
        App::getSmarty()->assign('monthlyPaymentRounded', $this->monthlyPaymentRounded);
        App::getSmarty()->display('CalculatorView.tpl');
    }

    //walidacja parametrów
    public function validateForm() {
        if ( ! (isset($this->form->amount)
            && isset($this->form->precent)
            && isset($this->form->paymentTime))) {
            //sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
            Utils::addErrorMessage('Błędne wywołanie aplikacji. Brak jednego z parametrów.');
        }

        // sprawdzenie, czy potrzebne wartości zostały przekazane
        if ( $this->form->amount == "") {
            Utils::addErrorMessage('Nie podano kwoty');
            $this->errorCount++;
        }
        if ( $this->form->precent == "") {
            Utils::addErrorMessage('Nie podano Oprocentowania');
            $this->errorCount++;
        }
        if ( $this->form->paymentTime == "") {
            Utils::addErrorMessage('Nie podano czasu spłaty');
            $this->errorCount++;
        }

        //nie ma sensu walidować dalej gdy brak parametrów
        if ($this->errorCount == 0 ) {

            // sprawdzenie, czy $amount $precent i $paymentTime są liczbami całkowitymi
            if (! is_numeric( $this->form->amount )) {
                Utils::addErrorMessage('Kwota Kredytu nie jest liczbą całkowitą');
                $this->errorCount++;
            }

            if (! is_numeric( $this->form->precent )) {
                Utils::addErrorMessage('Oprocentowanie Kredytu nie jest liczbą całkowitą');
                $this->errorCount++;
            }

            if (! is_numeric( $this->form->paymentTime )) {
                Utils::addErrorMessage('Czas Spłaty nie jest liczbą całkowitą');
                $this->errorCount++;
            }
        }
    }

    //obliczenie miesięcznej opłaty
    public function calculatePaymentAmount() {
        $amount = floatval($this->form->amount);
        $percent = floatval($this->form->precent);
        $paymentTime = floatval($this->form->paymentTime);

        $amountToPay = $amount + (($amount * 0.01 * $percent) * $paymentTime);
        $monthlyPayment = $amountToPay / ($paymentTime * 12);
        $monthlyPaymentRounded = number_format((float)$monthlyPayment, 2, '.', '');

        return $monthlyPaymentRounded;
    }
}