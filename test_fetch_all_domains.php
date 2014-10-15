<?php

/* This php script will try to fetch all the domains from particualr account */
/* By Suyash Jain */

include "DnsMadeEasy.php";

define('API_KEY','xxxxxxxxxxxxxxxxxxxx');
define('SEC_KEY','xxxxxxxxxxxxxxxxxxxx');


$dme = new DnsMadeEasy(API_KEY, SEC_KEY, FALSE);

$data=$dme->domains->getALL();

$data=json_decode($data->rawBody());


print "<pre>";

print_r($data);

print "</pre>";

/* TODO

You can fetch individual domain through following way

/* Displays the First Returned Array */

print $data->list[0];

?>
