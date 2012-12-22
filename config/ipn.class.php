<?php

/***************************************************************************
*
*    Author   : Dani Chaves
*    Package  : Simple PPPD Class (Simple Paypal pay per download)
*    Version  : 1.0
*    Copyright: (C) 2008 Dani Chaves
*    Email    : danichaves@gmail.com
*
*    Orig Author    : Robin kohli (robin@19.5degs.com)
*    Download url   : http://www.19.5degs.com
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
* Class to check ipn paypal
*/
class ipn {

    /**
    * Default value for how long the code will be valid
    *
    */

    /**
    * Paypal POST vars
    *
    * @var string
    */
    public $paypal_post_vars;

    /**
    * Paypal ipn response
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
    function __construct($paypal_post_vars) {
        $this->paypal_post_vars = $paypal_post_vars;
    }

    /**
    * Send response to Paypal
    *
    * @param string
    */
    function send_response() {
        include_once('config.php');
        $tmpAr = array_merge($this->paypal_post_vars, array("cmd" => "_notify-validate"));
        $postFieldsAr = array();
        foreach ($tmpAr as $name => $value) {
            $postFieldsAr[] = "$name=$value";
        }
        $ppResponseAr = Utils::PPHttpPost($paypal_env, implode("&", $postFieldsAr), false);
        if(!$ppResponseAr["status"]) {
            if(0 !== $ppResponseAr["error_no"]) {
                $error = "Error ".$ppResponseAr["error_no"].": ";
            }
            $error .= $ppResponseAr["error_msg"];
            $this->mailing("IPN Listner recibio un Error: " . $error , "");
        }
        $this->paypal_response = $ppResponseAr["httpResponse"];
    }

    /**
    * Check ipn paypal
    *
    * @return bool
    */
    function is_verified() {
        if (ereg("VERIFIED", $this->paypal_response)) {
            return true;
        } else {
            return false;
        }
    }

    /**
    * Check ipn paypal status
    *
    * @return bool
    */
    function get_payment_status() {
        return $this->paypal_post_vars['payment_status'];
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
        @reset($this->paypal_post_vars);
        while( @list($key,$value) = @each($this->paypal_post_vars)) {
            $message .= $key . ':' . " \t$value\n";
        }
        mail($this->error_email, "[$date] Notificacion paypal_ipn", $message, $em_headers);
    }
}
?>

