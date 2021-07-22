<?php

define('GENERAL_CONFIG_MOD_FILENAME', ROOT . '/Experiments/config-mod.json');

function process_post() {
    $inputs = filter_input_array(INPUT_POST);
    $inputs = format_settings_inputs($inputs);
    
    if (isset($inputs['reset-settings'])) {
        remove_setting_mods();
    } else {
        set_config_mod(extract_subarray($inputs, ['admin']));
        // do something else with other added settings
    }
    
    header('Location: .');
    exit();
}

function format_settings_inputs($settings) {
    foreach ($settings as $setting => $value) {
        if (is_numeric($value)) {
            $settings[$setting] = (float) $value;
            continue;
        }
        
        $str_val = strtolower($value);
        
        if ($str_val === 'true' or $str_val === 'false') {
            $settings[$setting] = $str_val === 'true';
        }
    }
    
    return $settings;
}

function remove_setting_mods() {
    unlink(GENERAL_CONFIG_MOD_FILENAME);
}

function extract_subarray(&$array, $keys) {
    $extracted = [];
    
    foreach ($keys as $key) {
        $extracted[$key] = $array[$key];
        unset($array[$key]);
    }
    
    return $extracted;
}

function write_mod_file($filename, $settings) {
    file_put_contents($filename, json_encode($settings));
}

function set_config_mod($settings) {
    write_mod_file(GENERAL_CONFIG_MOD_FILENAME, $settings);
}

function get_moddable_settings() {
    $settings = [];
    $admin_settings = read_config_file(ROOT . '/Experiments/Config.ini');
    $settings['admin'] = $admin_settings['admin'];
    return $settings;
}
