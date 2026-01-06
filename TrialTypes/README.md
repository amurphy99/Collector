# Collector // TrialTypes
This might break things if it just assumes everything in this folder is a trial type to be integrated into the system...

## New trial types:

| Date Modified | TrialType Name  | Description |
| ------------- | ------------- | ------------- |
| 2024-12-14 | `cued-recall-feedback-offloading`  | ... |
| 2024-12-16 | `instructJM` | ... |
| 2026-01-06 | `RKG` | ... |
| 2026-01-06 | `instructRKG` | ... |

<br>


# Information about new trial types we have created

<details closed> <summary>Recog RKG (2026-01-06)</summary>

### Recog RKG (2026-01-06)
Uses `recog` -> `instructRKG` -> `RKG`. 
* (The version of `recog` I have here is different from the actual deployed version)
* The goal is to skip `RKG` trials when the user says 'Yes' if they saw the word on a previous list or not.
* So we go from `recog` -> instruct

<hr>
</details>










<br>

## Debugging block for `*/display.php` files
```php
<!-- 
---------------------------------------------------
Debugging 
--------------------------------------------------- -->
<div>
    <h3>Session Data</h3>
    <?php
        // Wrap in the pre tag for view
        echo '<pre>';

        // Session object (trials, items, etc.)
        print_r($_SESSION);
        echo '<hr>';

        // Check individual variables
        echo $skip_trial;
        echo '<hr>';

        // Custom project functions available for use
        try {$functions = get_defined_functions();print_r($functions['user']); } 
        catch (Exception $e) { echo "Error:"; } 
    
        echo '</pre>';
    ?>
</div>

```