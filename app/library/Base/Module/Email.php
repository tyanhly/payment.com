<?php
namespace Base\Module;

use Base\Exception;
use Base\Exception\RequestException;

class Email{
    public function newPayment($paymentTransactionId, $isDebug = false) {
        $paymentTransaction = \PaymentTransaction::findFirst($paymentTransactionId);

        if ($paymentTransaction) {
        	$paymentClient   = \PaymentClient::findFirst($paymentTransaction->client_id);
        	$paymentCurrency = \PaymentCurrency::findFirst($paymentTransaction->currency_id);

            $template = \Template::getEmailTemplate('client-new-payment', 1);

            if ($template) {
                $formatNumber = new \Helper\FormatNumber();

                $variables = array(
                    '%client_name%'   => $paymentClient->client_name,
                    '%amount%'        => $formatNumber->currency($paymentTransaction->amount, $paymentCurrency->currency_code),
                    '%description%'   => $paymentTransaction->description,
                    '%date_created%'  => $paymentTransaction->date_created,
                );

                $template = $this->_insertVariables($template, $variables);
                $email    = array(
                    'to'      => $paymentClient->notify_email,
                    'subject' => $template['subject'],
                    'body'    => $template['body'],
                );
                $this->_debug($email, $isDebug);

                $sendEmail = new SendEmail();
                $sendEmail->send($email);

                return true;
            }
        }
    }













    private function _debug($email, $isDebug) {
        if ($isDebug) {
            echo '<h1>To: ' . $email['to'] . '</h1>';
            echo '<h1>' . $email['subject'] . '</h1>';
            echo $email['body'];

            die();
        }
    }

    private function _insertVariables($template, $variables) {
        $subject = $template['subject'];
        $body    = $template['body'];

        foreach ($variables as $key => $value) {
            $subject = str_replace($key, $value, $subject);
            $body    = str_replace($key, $value, $body);
        }

        return array('subject' => $subject, 'body' => $body);
    }
}