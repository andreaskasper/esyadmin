<?php

$i = 0;
/**
 * First server
 */
$i++;
/* Server parameters */
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['port'] = 9200;


if (!empty(getenv("ESY_DEFAULT_SERVER"))) $cfg['Servers'][$i]['host'] = getenv("ESY_DEFAULT_SERVER");