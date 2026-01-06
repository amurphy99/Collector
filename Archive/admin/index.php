<?php


define('URL_TO_ROOT', '..');
require dirname(__DIR__) . '/PHP/init.php';
require dirname(__DIR__) . '/PHP/admin/definitions.php';
require __DIR__ . '/definitions.php';

\admin\start_session();
start_main_output_buffer();

if (filter_input_array(INPUT_POST) !== null) {
    process_post();
}

echo get_link('admin/style.css');

$settings = get_moddable_settings();

$checked = $settings['admin'] ? 'checked' : '';

echo '<div><form method="post">';
echo '<table>';

echo '<tr><td>admin:</td> <td><input type="hidden" name="admin" value="false">'
   . "<input type='checkbox' name='admin' value='true' $checked></td></tr>";

foreach ($settings as $setting => $current_value) {
    if ($setting === 'admin') continue;
    
    if (is_bool($current_value)) {
        $checked = $current_value ? 'checked' : '';
        $input = "<input type='hidden' name='$setting' value='false'>"
               . "<input type='checkbox' name='$setting' value='true' $checked>";
    } else {
        $input = "<input name='$setting' value='$current_value'>";
    }
    
    echo "<tr><td>$setting:</td> <td>$input</td></tr>";
}

echo '</table>';
echo '<div class="button-container"><button type="submit">Save changes</button></div>';
echo '</form></div>';

?>

<div><form method="post">
    <input type="hidden" name="reset-settings" value="1">
    <div class="button-container">
        <button type="submit" id="reset-settings-button">Reset settings</button>
    </div>
</form></div>
