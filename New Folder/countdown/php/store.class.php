<?php

/**
 * storeSubscribers
 * 
 * ----------------
 * 
 * @copyright 2010 Dinca Andrei. All rights reserved.
 * @filesource 
 * @contact andrei.webdeveloper@gmail.com
 * @telephone +04 0728.703.942
 * @release date 1.11.2010
 */

class storeSubscribers

 {
    
    
/**
     * Holds an insance of self
     * 
     * @var $instance
     */
    
    private static $instance = null;
    
    
    
    
/**
     * Holds website option config
     */
    
     private static $option = array(
        
        
        
        
/**
         * commens properties
         */
        
        'debug' => true, // if you set debug = true if error on watermark echo them
        'save_path' => '', // where saving file
        'save_name' => 'saveSubscribers', // file name
        'save_type' => '.csv', // file extension
        'valid_type' => array('.txt', '.csv'), // file extension type allow array
        'curr_row' => '',
        
         'dataArray' => array()
        
        );
    
    
    
    
    
    
/**
     * Return storeSubscribers instance or create intitial instance
     * 
     * @access public 
     * @params $custom_option (optional)
     * @return object 
     */
    
     public static function getInstance($custom_option = array())
    
    
    {
        
         if (is_null(self::$instance))
            
             {
            
            self::$instance = new storeSubscribers($custom_option);
            
             } 
        
        return self::$instance;
        
         } 
    
    
    
    
/**
     * the constructor is set to private so
     * 
     * so nobody can create a new instance using new
     */
    
    public function __construct($custom_option = array())
    
    
    {
        
         // overwrite default value with custom value
        if (count($custom_option) > 0) {
            
            self::$option = array_merge(self::$option, $custom_option);
            
             } 
        
        
        
        // var_dump(self::$option);
        
        
        // store new data
        $this->storeData();
        
         } 
    
    
    
    private function getData()
    {
        
         // javascript send: data: "name=" + $("#name").val() + "&email=" + $("#email").val() + "&sendnotifications="+ $("#sendnotifications").val()
        // htmlentities — Convert all applicable characters to HTML entities
        return self::$option['dataArray'] = array(
            
            'name' => htmlentities($_REQUEST['name']),
            
             'email' => htmlentities($_REQUEST['email']),
            
             'sendnotifications' => htmlentities($_REQUEST['sendnotifications'])
            
            );
        
         } 
    
    
    
    private function patternData()
    {
        
        
        
         if (!in_array(self::$option['save_type'], self::$option['valid_type'])) {
            
            die('invalid save data type');
            
             return false;
            
             } 
        
        
        
        // self::$option['dataArray']
        // write TXT
        if (self::$option['save_type'] == '.txt') {
            
            self::$option['curr_row'] = implode("\t", self::$option['dataArray']);
            
             } 
        
        // write CSV
        elseif (self::$option['save_type'] == '.csv') {
            
            self::$option['curr_row'] = implode(", ", self::$option['dataArray']);
            
             } 
        
        
        
        return true;
        
         } 
    
    
    
    private function writeData()
    {
        
         // Write the data to the file,
        // using the FILE_APPEND flag to append the data to the end of the file
        // and the LOCK_EX flag to prevent anyone else writing to the file at the same time
        if (trim(self::$option['curr_row']) != "") {
            
            if (file_put_contents(self::$option['save_path'] . self::$option['save_name'] . self::$option['save_type'], self::$option['curr_row'] . PHP_EOL, FILE_APPEND | LOCK_EX)) {
                
                die('save');
                
                 return true;
                
                 } 
            
            } 
        
        return false;
        
         } 
    
    
    
    private function storeData()
    {
        
         // if valid request
        if (count($this->getData()) > 0) {
            
            // if valid current data set
            if ($this->patternData()) {
                
                // Write the data to the file
                $this->writeData();
                
                 } 
            
            } 
        
        return false;
        
         } 
    
    
    
    } 

/**
 * ** end of class **
 */

include(dirname(dirname(dirname(__FILE__))) . '/config.php');

$storeSubscribers = storeSubscribers::getInstance(array(
        
        'save_path' => DIR_BACKEND . '/presubscribers/'
        
        ));
