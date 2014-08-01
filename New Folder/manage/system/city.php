<?php

/**
 * //License information must not be removed.
 * 
 * PHP version 5.4x
 * 
 * @Category ### Gripsell ###
 * @Package ### Advanced ###
 * @Architecture ### Secured  ###
 * @Copyright (c) 2013 {@URL http://www.gripsell.com Gripsell eApps & Technologies Private Limited}
 * @License EULA License http://www.gripsell.com
 * @Author $Author: gripsell $
 * @Version $Version: 5.3.3 $
 * @Last Revision $Date: 2013-21-05 00:00:00 +0530 (Tue, 21 May 2013) $
 */

ob_start();

require_once(dirname(dirname(dirname(__FILE__))) . '/app.php');

$ob_content = ob_get_clean();

need_manager(true);

$system = Table::Fetch('system', 1);

if ($_POST) {
    
    unset($_POST['commit']);
    
    
/**
     * hot city convert
     */
    
     $cityname = preg_split('/,\s?+/', $_POST['hotcity'], -1, PREG_SPLIT_NO_EMPTY);
    
     $hotcity = array();
    
     $cities = DB::LimitQuery('cities', array(
            
            'condition' => array(
                
                'name' => $cityname,
                
                 'zone' => 'city',
                
                ),
            
            ));
    
     $oa = Utility::OptionArray($cities, 'name', 'id');
    
     $_POST['hotcity'] = array();
    
     foreach($cityname AS $one) {
        $_POST['hotcity'][] = $oa[$one];
    } 
    
    
/**
     * merget
     */
    
    $INI = Config::MergeINI($INI, $_POST);
    
     $INI = ZSystem::GetUnsetINI($INI);
    
    
/**
     * end
     */
    
    
    
     $value = Utility::ExtraEncode($INI);
    
     $table = new Table('system', array('value' => $value));
    
     if ($system) $table->SetPK('id', 1);
    
     $flag = $table->update(array('value'));
    
    
    
     Session::Set('notice', TEXT_EN_INFORMATION_IS_UPDATED_EN);
    
     Utility::Redirect(BASE_REF . '/manage/system/city.php');
    
    } 

$hotcity = Utility::GetColumn($hotcities, 'name');

$hotcity = join(', ', $hotcity);

include template('manage_system_city');

