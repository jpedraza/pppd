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

require_once('../config/config.php');
$hash = $_REQUEST["h"];
$txn = $_REQUEST["txn"];
if (isset($hash) && isset($txn)) {
    $pppd = new pppd();
    if ($pppd->reload($hash)) {
        if (!$pppd->is_finished() && ($txn == $pppd->txn_id)) {
            if (!$item_file = $pppd->get_file()) {
                die("No hay articulo en esta compra.");
            }
            $filename = $path.$item_file;
            if (!file_exists($filename)) {
                die("El archivo no existe.");
            }
            header("Pragma: public");
            header("Expires: 0"); // set expiration time
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            header("Content-Description: File Transfer");
            header("Content-disposition: attachment; filename=".basename($filename));
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".filesize($filename));
            readfile($filename);
        } else {
            die("Tu descarga ha expirado.");
        }
    }
    die("El id de compra es erroneo.");
}
?>

