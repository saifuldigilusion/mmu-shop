<?php

return [
    'salesEmailEnable'  => env('SALES_EMAIL_ENABLE', 0),
    'salesContact' => env('SALES_CONTACT', ''),
    'paymentChannels' => array('','CASH', 'CHEQUE', 'SENANGPAY'),
    'deliveryCostName' => array('East Malaysia' => 0.00, 'West Malaysia' => 0.00),
    'malaysiaStates' => array(
        "Johor" => "East Malaysia", 
        "Kedah" => "East Malaysia", 
        "Kelantan" => "East Malaysia", 
        "Kuala Lumpur" => "East Malaysia", 
        "Labuan" => "West Malaysia", 
        "Malacca" => "East Malaysia", 
        "Negeri Sembilan" => "East Malaysia", 
        "Pahang" => "East Malaysia", 
        "Perak" => "East Malaysia", 
        "Perlis" => "East Malaysia", 
        "Penang" => "East Malaysia", 
        "Putrajaya" => "East Malaysia", 
        "Sabah" => "West Malaysia", 
        "Sarawak" => "West Malaysia", 
        "Selangor" => "East Malaysia", 
        "Terengganu" => "East Malaysia"),

];