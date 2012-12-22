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

include("config/config.php");
if(array_key_exists("txn_id", $_POST)) {
    $paypal_ipn = new ipn($_POST);
    foreach ($paypal_ipn->paypal_post_vars as $key => $value) {
        if (getType($key) == "string") {
            eval("\$$key=\$value;");
        }
    }

    $paypal_ipn->send_response();
    $paypal_ipn->error_email = $error_email;

    if (!$paypal_ipn->is_verified()) {
        $paypal_ipn->mailing("Bad order (PayPal says it's invalid)" . $paypal_ipn->paypal_response , $em_headers);
        die();
    }
    switch($paypal_ipn->get_payment_status()) {
        case 'Pending':
            $pending_reason = $paypal_ipn->paypal_post_vars['pending_reason'];
            if ($pending_reason != "intl") {
                $paypal_ipn->mailing("Pending Payment - $pending_reason", $em_headers);
                break;
            }
        case 'Completed':
            if ($paypal_ipn->paypal_post_vars['txn_type'] == "reversal") {
                $reason_code = $paypal_ipn->paypal_post_vars['reason_code'];
                $paypal_ipn->mailing("PayPal reversed an earlier transaction.", $em_headers);
                // you should mark the payment as disputed now
            } else {
                $db =& new db_mysql("$host","$user","$pass","$database");
                $config = $db->query("SELECT * FROM items as i WHERE i.item_number='$item_number'", true);
                $db->close();
                if ($config && (strtolower(trim($paypal_ipn->paypal_post_vars['business'])) == $paypal_email)) {
                    $pppd = new pppd($payer_id, $payment_date, $txn_id, $first_name, $last_name, $payer_email, $payer_status, $payment_type, $custom, $memo, $item_name, $item_number, $quantity, $shipping, $tax, $mc_gross, $mc_fee, $mc_currency, $address_name, $address_street, $address_city, $address_state, $address_zip, $address_country, $address_country_code, $address_status, $contact_phone, $business, $receiver_email, $receiver_id, $residence_country, $shipping_method, $payment_status, $pending_reason, $reason_code, $txn_type, $option_selection1, $option_selection2, $option_name1, $option_name2, $verify_sign, $notify_version);
                    if ($pppd->save()) {
                        $paypal_ipn->mailing("This was a successful transaction", $em_headers);
                        $link = $notify_url."?txn_id=".$pppd->txn_id."&item_number=".$pppd->item_number;
                        if (!$pppd->send_download_link($link, $pppd->item_name)) {
                            $paypal_ipn->mailing("Error sending download link", $em_headers);
                        }
                    } else {
                        $paypal_ipn->mailing("This was a duplicate transaction", $em_headers);
                    }
                } else {
                    $paypal_ipn->mailing("Someone attempted a sale using a manipulated URL", $em_headers);
                }
            }
            $pppd->db->close();
            break;
        case 'Failed':
            // this will only happen in case of echeck.
            $paypal_ipn->mailing("Failed Payment", $em_headers);
        break;
        case 'Denied':
            // denied payment by us
            $paypal_ipn->mailing("Denied Payment", $em_headers);
        break;
        case 'Refunded':
            // payment refunded by us
            $paypal_ipn->mailing("Refunded Payment", $em_headers);
        break;
        case 'Expired':
            // payment expired by us
            $paypal_ipn->mailing("Expired Payment", $em_headers);
        break;
        case 'Canceled':
            // reversal cancelled
            // mark the payment as dispute cancelled
            $paypal_ipn->mailing("Cancelled reversal", $em_headers);
        break;
        default:
            // order is not good
            $paypal_ipn->mailing("Unknown Payment Status - " . $paypal_ipn->get_payment_status(), $em_headers);
        break;
    }
}
?>

