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

require_once('config/config.php');
$txn_id = $_GET['txn_id'];
$item_number = $_GET['item_number'];
if (!isset($txn_id) || !isset($item_number)) {
    echo '<script>location.href="'.$website.'"</script>';
}
$pppd = new pppd();
if (!$pppd->get_item($item_number)) {
    echo '<p class="paragraph_style_4">El articulo referido no existe.</p>'.
         '<p class="paragraph_style_4">Compruebe que la url es la misma que le hemos proporcionado e int&eacute;ntelo de nuevo.'.
         '<p class="paragraph_style_4">Si tiene alguna duda, pongase en contacto con nosotros mediante '.
         'nuestro sitio web: <a href="'.$website.'">'.$website.'</a></p>';
} else {
    if ($pppd->reload_txn($txn_id)) {
        if (!$pppd->is_finished() && $item = $pppd->get_item()) {
            echo '<p class="paragraph_style_4">Gracias por comprar en nuestra tienda.</p>'.
                 '<p class="paragraph_style_4">A continuaci&oacute;n se muestra el enlace que le llevar&aacute; '.
                 'a la descarga directa del siguiente art&iacute;culo: <strong>'.$item.'</strong></p>'.
                 '<p class="paragraph_style_4"><a href="'.$download_url.'?txn='.$pppd->txn_id.'&h='.$pppd->hash.'">Descargar</a></p>'.
                 '<p class="paragraph_style_4">Nota: El enlace tiene un periodo de caducidad de '.(pppd::DEFAULT_EXPIRATION / 3600).' horas.</p>';
        } else {
            echo '<p class="paragraph_style_4">Su pedido ha expirado.</p>'.
                 '<p class="paragraph_style_4">Si tiene alguna duda, pongase en contacto con nosotros mediante '.
                 'nuestro sitio web: <a href="'.$website.'">'.$website.'</a></p>';
        }
    } else {
        echo '<p class="paragraph_style_4">Su pedido a&uacute;n no ha sido procesado.'.
             'Espere unos segundos y pruebe a recargar la p&aacute;gina.</p>'.
             '<p class="paragraph_style_4">Si ha llegado aqu&iacute; por error, visite nuestra tienda en '.
             '<a href="'.$website.'">'.$website.'</a>';
    }
}
?>

