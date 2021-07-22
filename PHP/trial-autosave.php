<?php

require __DIR__ . '/definitions/general.php';
require ROOT . '/PHP/definitions/experiment.php';
require ROOT . '/PHP/definitions/init.php';

define_exp_constants();
chdir(ROOT);
start_session();

if (!defined('CURR_EXP')) exit('missing exp name');

// when using js fetch api, unless data is sent with the header
// "Content-type: application/x-www-form-urlencoded", 
// $_POST will not be populated, 
// and you must read the input stream directly
$input = json_decode(trim(file_get_contents('php://input')), true);

if (!isset($input['state'])) exit('missing input: state');
if (!isset($input['data']))  exit('missing input: data');

if (!isset($_SESSION['Username'])) exit('not logged in');
if (!is_metadata_eligible($_SESSION['Metadata'])) exit('metadata ineligible');
if (is_experiment_done()) exit('experiment completed');

$saved_data = json_decode(get_autosave_data($_SESSION['Username']), true);

foreach ($input['state'] as $key => $val) {
    $saved_data['state'][$key] = $val;
}

foreach ($input['data'] as $row) {
    $saved_data['data'][] = $row;
}

save_autosave_data($_SESSION['Username'], $saved_data);

echo 'success';
