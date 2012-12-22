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

include("config/config.php");
if (array_key_exists("item_number", $_POST)) {
    foreach ($_POST as $key => $value) {
        if (getType($key) == "string") {
            eval("\$$key=\$value;");
        }
    }
    $db =& new db_mysql("$fhost","$fuser","$fpass","$fdatabase");
    $config = $db->query("SELECT * FROM fitems as i WHERE i.item_number='$item_number'", true);
    $db->close();
    if ($config) {
        $fpppd = new fpppd($email, $country_code, $country_name, $city, $region_code, $region_name, $item_number);
        if ($fpppd->save()) {
            $link = $free_url."?h=".$fpppd->hash."&item_number=".$fpppd->item_number;
            $fpppd->send_download_link($link, $fpppd->get_item());
        }
    }
    $fpppd->db->close();
}
?>

