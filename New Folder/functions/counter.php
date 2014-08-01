<?php

$condition = array(
    
    'type' => 'charopa',
    
    );

$query = DB::LimitQuery('charity', array(
        
        'select' => 'SUM(value)',
        
         'condition' => $condition,
        
        ));

$contentsp = $query[0]['sum(value)'];

$condition = array(
    
    'type' => 'charopb',
    
    );

$query = DB::LimitQuery('charity', array(
        
        'select' => 'SUM(value)',
        
         'condition' => $condition,
        
        ));

$contentso = $query[0]['sum(value)'];

$condition = array(
    
    'type' => 'charopc',
    
    );

$query = DB::LimitQuery('charity', array(
        
        'select' => 'SUM(value)',
        
         'condition' => $condition,
        
        ));

$contentsc = $query[0]['sum(value)'];

?>

