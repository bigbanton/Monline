<?php

function db($variable)
{
    
     $db = array(
        
        // Database Config
        'hostname' => 'localhost',
        
         'username' => 'gripsell_cpa',
        
         'password' => 'rpnsma1980',
        
         'dbname' => 'gripsell_cp',
        
         'tablename' => 'insta'
        
        );
    
     return $db[$variable];
    
    } 

function fields($variable)
{
    
     $fields = array(
        
        // Field Mappings
        'lat' => 'lat',
        
         'lng' => 'lng',
        
         'title' => 'title',
        
         'address' => 'address',
        
         'url' => 'url',
        
         'html' => 'html',
        
         'category' => 'category',
        
         'icon' => 'marker'
        
        );
    
     return $fields[$variable];
    
    } 

?>