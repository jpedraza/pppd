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
* Class to generate and check fpppds
*/
class fpppd {

    /**
    * Default value for how long the code will be valid
    *
    */
    const DEFAULT_EXPIRATION = 86400;

    /**
    * Free article id from database
    *
    * @var integer
    */
    public $id;

    /**
    * email
    *
    * @var string
    */
    public $email;

    /**
    * Country Code
    *
    * @var string
    */
    public $country_code;

    /**
    * Country Name
    *
    * @var string
    */
    public $country_name;

    /**
    * City
    *
    * @var string
    */
    public $city;

    /**
    * Region Code
    *
    * @var string
    */
    public $region_code;

    /**
    * Region Name
    *
    * @var string
    */
    public $region_name;

    /**
    * Item Number
    *
    * @var string
    */
    public $item_number;

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
    public $time;

    /**
    * database object
    *
    * @var object
    */
    public $db;

    /**
    * Constructor. Initializes a fpppd.
    */
    function __construct($email='', $country_code='', $country_name='', $city='', $region_code='', $region_name='', $item_number='') {
        include_once('config.php');
        $this->id = 0;
        $this->email = $email;
        $this->country_code = $country_code;
        $this->country_name = $country_name;
        $this->city = $city;
        $this->region_code = $region_code;
        $this->region_name = $region_name;
        $this->item_number = $item_number;
        $this->mailed = 0;
        $this->hash = sha1(sha1(rand()));
        $this->time = time();
        $this->download_expiration = $this->time + fpppd::DEFAULT_EXPIRATION;
        $this->db =& new db_mysql($fhost, $fuser, $fpass, $fdatabase);
    }

    /**
    * Save pppd object on database
    *
    * @return bool
    */
    public function save() {
        if ($this->db->query("INSERT INTO fpppd VALUES ($this->id, '$this->email', '$this->country_code', '$this->country_name', '$this->city', '$this->region_code', '$this->region_name', $this->item_number, $this->mailed, '$this->hash', $this->download_expiration, $this->time)")) {
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
        if ($st = $this->db->query("SELECT * FROM fpppd WHERE hash = '$hash'", true)) {
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
        if ($st = $this->db->query("SELECT item_name FROM fitems WHERE item_number = '$this->item_number'", true)) {
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
        if ($st = $this->db->query("SELECT item_file FROM fitems WHERE item_number = '$this->item_number'", true)) {
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
        $time             = fpppd::DEFAULT_EXPIRATION / 3600;
        $mail             = new PHPMailer();
        $body             = $mail->getFile('config/fcontents.html'); // Html body
        $body             = eregi_replace("LINK", $link, $body);
        $body             = eregi_replace("PRODUCTO", $item, $body);
        $body             = eregi_replace("DEFAULT_EXPIRATION", (string) $time, $body);
        $body             = eregi_replace("[\]",'',$body);
        $txt              = $mail->getFile('config/fcontents.txt');  //Text body
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
        $mail->AddAddress($this->email);
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
        if ($this->db->query("UPDATE fpppd SET mailed = 1 WHERE hash = '$this->hash'")) {
            return true;
        } else {
            return false;
        }
    }
}
?>

