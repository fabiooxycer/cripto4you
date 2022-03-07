<?php

$valor       = '1.000,00';
$valor_trade = str_replace(',', '.', str_replace('.', '', $valor));
$valor_fim   = str_replace('.00', '', $valor_trade);
$percentual  = '10';
$taxa        = ($valor_fim / 100) * $percentual;
echo $taxa;