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

// classes
require_once("ipn.class.php");
require_once("pdt.class.php");
require_once("utils.class.php");
require_once("pppd.class.php");
require_once("fpppd.class.php");
require_once("mysql.class.php");
require_once("class.phpmailer.php");

// pppd database settings
$host = "";
$user = "";
$pass = "";
$database = "";

// fpppd database settings
$fhost = "";
$fuser = "";
$fpass = "";
$fdatabase = "";

// default environment
$paypal_env = "https://www.sandbox.paypal.com/cgi-bin/webscr";

// PDT apikey
$apikey = "";
// paypal email
$paypal_email = "foo@bar.com";

// email address and name where script should send notifications
$error_name = "Foo Bar";
$error_email ="error@bar.com";

// unix directory
$path = "";

// host and urls (directory finish with /)
$website = "http://www.example.org/";
$download_url = $website."pppd/downloads/";
$notify_url = $website."pppd/down.php";
$cancel_url = $website."pppd/cancel.php";
$free_url = $website."pppd/downloads/free.php";

// email seller headers
$em_headers  = "From: ".$error_name." <".$error_email.">\n";
$em_headers .= "Reply-To: ".$error_email."\n";
$em_headers .= "Return-Path: ".$error_email."\n";

// smtp config
$smtp_host = "";
$smtp_port = 587;
$smtp_user = "";
$smtp_pass = "";
$smtp_from = "";
$smtp_fromName = "";
$smtp_subject  = "";
?>

