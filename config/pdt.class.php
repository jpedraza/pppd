<?php

/***************************************************************************
*
*    Author   : Dani Chaves
*    Package  : Simple PPPD Class (Simple Paypal pay per download)
*    Version  : 1.0
*    Copyright: (C) 2008 Dani Chaves
*    Email    : danichaves@gmail.com
*
*    This program is free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*    GNU General Public License for more details.
*
***************************************************************************/

/**
* Class to check pdt paypal
*/
class pdt {

    /**
    * Paypal GET vars
    *
    * @var string
    */
    public $paypal_get_vars;

    /**
    * Paypal pdt response
    *
    * @var string
    */
    public $paypal_response;

    /**
    * Email response seller
    *
    * @var string
    */
    public $error_email;

    /**
    * Constructor
    *
    * @param string
    */
    function __construct($paypal_get_vars) {
        $this->paypal_get_vars = $paypal_get_vars;
    }

    /**
    * Send response to Paypal
    *
    * @param string
    */
    function send_response() {
        include_once('config.php');
        $postFields = "cmd=".urlencode("_notify-synch").
                      "&tx=".urlencode(htmlspecialchars($this->paypal_get_vars['tx'])).
                      "&at=".urlencode($apikey);
        $ppResponseAr = Utils::PPHttpPost($paypal_env, $postFields, true);
        if (!$ppResponseAr["status"]) {
            $error = "Error ".$ppResponseAr["error_no"].": ";
            $error .= $ppResponseAr["error_msg"];
            $this->paypal_response = false;
            $this->mailing("PDT recibio un Error: " . $error , "");
        } else {
            $this->paypal_response = true;
        }
    }

    /**
    * Send mail to seller
    *
    * @param string
    * @param string
    */
    function mailing($message, $em_headers) {
        $date = date("D M j G:i:s T Y", time());
        $message .= "\n\nLos siguientes datos fueron recibidos de PayPal:\n\n";
        @reset($this->paypal_get_vars);
        while( @list($key,$value) = @each($this->paypal_get_vars)) {
            $message .= $key . ':' . " \t$value\n";
        }
        mail($this->error_email, "[$date] Notificacion paypal_pdt", $message, $em_headers);
    }
}
?>

