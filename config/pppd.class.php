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
* Class to generate and check pppds
*/
class pppd {

    /**
    * Default value for how long the code will be valid
    *
    */
    const DEFAULT_EXPIRATION = 86400;

    /**
    * Article id from database
    *
    * @var integer
    */
    public $id;

    /**
    * Id user paypal
    *
    * @var string
    */
    public $payer_id;

    /**
    * Pay Date
    *
    * @var string
    */
    public $payment_date;

    /**
    * Unique id transaction
    *
    * @var string
    */
    public $txn_id;

    /**
    * Firstname paypal
    *
    * @var string
    */
    public $first_name;

    /**
    * Lastname paypal
    *
    * @var string
    */
    public $last_name;

    /**
    * email paypal
    *
    * @var string
    */
    public $payer_email;

    /**
    * Status ipn paypal
    *
    * @var string
    */
    public $payer_status;

    /**
    * Payment type
    *
    * @var string
    */
    public $payment_type;

    /**
    * Notes
    *
    * @var string
    */
    public $custom;

    /**
    * User notes
    *
    * @var string
    */
    public $memo;

    /**
    * Item name
    *
    * @var string
    */
    public $item_name;

    /**
    * Item number id
    *
    * @var integer
    */
    public $item_number;

    /**
    * Quantity items
    *
    * @var integer
    */
    public $quantity;

    /**
    * Shipping price
    *
    * @var integer
    */
    public $shipping;

    /**
    * Tax price
    *
    * @var integer
    */
    public $tax;

    /**
    * Item price
    *
    * @var integer
    */
    public $mc_gross;

    /**
    * mc_fee
    *
    * @var integer
    */
    public $mc_fee;

    /**
    * USD, EUR...
    *
    * @var string
    */
    public $mc_currency;

    /**
    * Address name
    *
    * @var string
    */
    public $address_name;

    /**
    * Address street
    *
    * @var string
    */
    public $address_street;

    /**
    * Address city
    *
    * @var string
    */
    public $address_city;

    /**
    * Address state
    *
    * @var string
    */
    public $address_state;

    /**
    * Address zip
    *
    * @var string
    */
    public $address_zip;

    /**
    * Address country
    *
    * @var string
    */
    public $address_country;

    /**
    * Address country code
    *
    * @var string
    */
    public $address_country_code;

    /**
    * Address status
    *
    * @var string
    */
    public $address_status;

    /**
    * Contact phone
    *
    * @var string
    */
    public $contact_phone;

    /**
    * Business
    *
    * @var string
    */
    public $business;

    /**
    * Receiver email
    *
    * @var string
    */
    public $receiver_email;

    /**
    * Receiver id
    *
    * @var string
    */
    public $receiver_id;

    /**
    * Residence country
    *
    * @var string
    */
    public $residence_country;

    /**
    * Shipping method
    *
    * @var string
    */
    public $shipping_method;

    /**
    * Payment status
    *
    * @var string
    */
    public $payment_status;

    /**
    * Pending reason
    *
    * @var string
    */
    public $pending_reason;

    /**
    * Reason code
    *
    * @var string
    */
    public $reason_code;

    /**
    * Transaction type
    *
    * @var string
    */
    public $txn_type;

    /**
    * First option selection
    *
    * @var string
    */
    public $option_selection1;

    /**
    * Second option selection
    *
    * @var string
    */
    public $option_selection2;

    /**
    * First option name
    *
    * @var string
    */
    public $option_name1;

    /**
    * Second option name
    *
    * @var string
    */
    public $option_name2;

    /**
    * Ipn signature
    *
    * @var string
    */
    public $verify_sign;

    /**
    * Ipn version
    *
    * @var string
    */
    public $notify_version;

    /**
    * mailed 0/1
    *
    * @var integer
    */
    public $mailed;

    /**
    * random sha1 40 bits id
    *
    * @var string
    */
    public $hash;

    /**
    * Time expiration date
    *
    * @var integer
    */
    public $download_expiration;

    /**
    * Timestamp date
    *
    * @var integer
    */
    public $payment_time;

    /**
    * database object
    *
    * @var object
    */
    public $db;

    /**
    * Constructor. Initializes a pppd.
    */
    function __construct($payer_id='', $payment_date='', $txn_id='', $first_name='', $last_name='', $payer_email='', $payer_status='', $payment_type='', $custom='', $memo='', $item_name='', $item_number='', $quantity=0, $shipping='', $tax='', $mc_gross='', $mc_fee='', $mc_currency='', $address_name='', $address_street='', $address_city='', $address_state='', $address_zip='', $address_country='', $address_country_code='', $address_status='', $contact_phone='', $business='', $receiver_email='', $receiver_id='', $residence_country='', $shipping_method='', $payment_status='', $pending_reason='', $reason_code='', $txn_type='', $option_selection1='', $option_selection2='', $option_name1='', $option_name2='', $verify_sign='', $notify_version='') {
        include_once('config.php');
        $this->id = 0;
        $this->payer_id = $payer_id;
        $this->payment_date = $payment_date;
        $this->txn_id = $txn_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->payer_email = $payer_email;
        $this->payer_status = $payer_status;
        $this->payment_type = $payment_type;
        $this->custom = $custom;
        $this->memo = $memo;
        $this->item_name = $item_name;
        $this->item_number = $item_number;
        $this->quantity = $quantity;
        $this->shipping = $shipping;
        $this->tax = $tax;
        $this->mc_gross = $mc_gross;
        $this->mc_fee = $mc_fee;
        $this->mc_currency = $mc_currency;
        $this->address_name = $address_name;
        $this->address_street = $address_street;
        $this->address_city = $address_city;
        $this->address_state = $address_state;
        $this->address_zip = $address_zip;
        $this->address_country = $address_country;
        $this->address_country_code = $address_country_code;
        $this->address_status = $address_status;
        $this->contact_phone = $contact_phone;
        $this->business = $business;
        $this->receiver_email = $receiver_email;
        $this->receiver_id = $receiver_id;
        $this->residence_country = $residence_country;
        $this->shipping_method = $shipping_method;
        $this->payment_status = $payment_status;
        $this->pending_reason = $pending_reason;
        $this->reason_code = $reason_code;
        $this->txn_type = $txn_type;
        $this->option_selection1 = $option_selection1;
        $this->option_selection2 = $option_selection2;
        $this->option_name1 = $option_name1;
        $this->option_name2 = $option_name2;
        $this->verify_sign = $verify_sign;
        $this->notify_version = $notify_version;
        $this->mailed = 0;
        $this->hash = sha1(md5($this->txn_id));
        $this->payment_time = time();
        $this->download_expiration = $this->payment_time + pppd::DEFAULT_EXPIRATION;
        $this->db =& new db_mysql($host, $user, $pass, $database);
    }

    /**
    * Save pppd object on database
    *
    * @return bool
    */
    public function save() {
        if ($this->db->query("INSERT INTO pppd VALUES ($this->id, '$this->payer_id', '$this->payment_date', '$this->txn_id', '$this->first_name', '$this->last_name', '$this->payer_email', '$this->payer_status', '$this->payment_type', '$this->custom', '$this->memo', '$this->item_name', '$this->item_number', $this->quantity, '$this->shipping', '$this->tax', '$this->mc_gross', '$this->mc_fee', '$this->mc_currency', '$this->address_name', '$this->address_street', '$this->address_city', '$this->address_state', '$this->address_zip', '$this->address_country', '$this->address_country_code', '$this->address_status', '$this->contact_phone', '$this->business', '$this->receiver_email', '$this->receiver_id', '$this->residence_country', '$this->shipping_method', '$this->payment_status', '$this->pending_reason', '$this->reason_code', '$this->txn_type', '$this->option_selection1', '$this->option_selection2', '$this->option_name1', '$this->option_name2', '$this->verify_sign', '$this->notify_version', $this->mailed, '$this->hash', $this->download_expiration, $this->payment_time)")) {
            return true;
         } else {
            return false;
         }
    }

    /**
    * Load pppd object from database
    *
    * @param string
    *
    * @return bool
    */
    public function reload($hash) {
        if ($st = $this->db->query("SELECT * FROM pppd WHERE hash = '$hash'", true)) {
            foreach ($st as $key => $value) {
                if (getType($key) == "string") {
                    eval("\$$key=\$value;");
                    $this->$key = $value;
                }
             }
             return true;
        } else {
            return false;
        }
    }

    /**
    * Load pppd object from database (by txn_id)
    *
    * @param string
    *
    * @return bool
    */
    public function reload_txn($txn) {
        if ($st = $this->db->query("SELECT * FROM pppd WHERE txn_id = '$txn'", true)) {
            foreach ($st as $key => $value) {
                if (getType($key) == "string") {
                    eval("\$$key=\$value;");
                    $this->$key = $value;
                }
             }
             return true;
        } else {
            return false;
        }
    }

    /**
    * Check expiration time for download
    *
    * @return bool
    */
    public function is_finished() {
        if (time() > $this->download_expiration) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get item name from database
     *
     * @return mixed
     */
     public function get_item($item=false) {
        if ($item) {
            $this->item_number = $item;
        }
        if ($st = $this->db->query("SELECT item_name FROM items WHERE item_number = '$this->item_number'", true)) {
            return $st['item_name'];
        } else {
            return false;
        }
    }

    /**
     * Get item file from database
     *
     * @return mixed
     */
     public function get_file() {
        if ($st = $this->db->query("SELECT item_file FROM items WHERE item_number = '$this->item_number'", true)) {
            return $st['item_file'];
        } else {
            return false;
        }
    }

    /**
    * Send mail to payer
    *
    * @param string
    *
    * @return bool
    */
    public function send_download_link($link, $item) {
        $time             = pppd::DEFAULT_EXPIRATION / 3600;
        $mail             = new PHPMailer();
        $body             = $mail->getFile('config/contents.html'); // Html body
        $body             = eregi_replace("LINK", $link, $body);
        $body             = eregi_replace("PRODUCTO", $item, $body);
        $body             = eregi_replace("DEFAULT_EXPIRATION", (string) $time, $body);
        $body             = eregi_replace("[\]",'',$body);
        $txt              = $mail->getFile('config/contents.txt');  //Text body
        $txt              = eregi_replace("LINK", $link, $txt);
        $txt              = eregi_replace("PRODUCTO", $item, $txt);
        $txt              = eregi_replace("DEFAULT_EXPIRATION", (string) $time, $body);
        $txt              = eregi_replace("[\]",'',$txt);
        $mail->SetLanguage('en');               // set Language to english
        $mail->IsSendmail();                    // Use IsSendmail on 1and1 servers.
        $mail->SMTPAuth   = true;               // enable SMTP authentication
        $mail->SMTPSecure = "ssl";              // sets the prefix to the servier
        $mail->Host       = $smtp_host;         // sets SMTP server
        $mail->Port       = $smtp_port;         // set the SMTP port
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->From       = $smtp_from;
        $mail->FromName   = $smtp_fromName;
        $mail->Subject    = $smtp_subject;
        $mail->AltBody    = $txt;
        $mail->WordWrap   = 50; // set word wrap
        $mail->MsgHTML($body);
        //$mail->AddAttachment("/path/to/file.zip");             // attachment
        //$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment
        $mail->AddAddress($this->payer_email, $this->first_name.' '.$this->last_name);
        $mail->IsHTML(true); // send as HTML
        if(!$mail->Send()) {
            return false;
        } else {
            $this->set_mailed();
            return true;
        }
    }

    /**
    * Set mailed to 1
    *
    * @return bool
    */
    private function set_mailed() {
        if ($this->db->query("UPDATE pppd SET mailed = 1 WHERE txn_id = '$this->txn_id'")) {
            return true;
        } else {
            return false;
        }
    }
}
?>

