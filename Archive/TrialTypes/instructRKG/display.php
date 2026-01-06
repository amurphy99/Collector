<?php
    /**
     * This is an example of a trial type in the Experiment/ folder overwriting
     * the trial type found in the Code/ folder.  Any changes to this Instruct
     * will be used throughout the program, so if you make any modifications,
     * such as increasing font-size, you can still download the latest Code/
     * folder of the Collector without worrying about accidentally losing
     * your changes.
     */
    
    // use the `Cue` if a valid one is called and there is no `Text` set in the procedure
    if (($cue != '') AND (trim($text) == '')) { $text = $cue; }

    // ================================================================================
    // Skip trials where they answered negatively
    // ================================================================================
    // Define array of response values where we should skip the following trial
    $skipped_responses = ["no", "maybe no", "definitely no"];
    
    // Index of this trial (in the $_SESSION['Trials'] object)
    $trial_index = $_SESSION['Position'];
    
    // Get the response value and set it to all lowercase letters
    $response = strtolower($_SESSION['Trials'][$trial_index]['Response']['Response']);

    // Skip the trial if their response was in the list (make the next trial type blank)
    if (in_array($response, $skipped_responses)) {
        $_SESSION['Trials'][$trial_index]['Procedure']['Post 2 Trial Type'] = "";
    }

?>


<div style="font-size: 100%;"><?php echo $text; ?></div>

<div class="textcenter">
    <button class="collectorButton collectorAdvance" id="FormSubmitButton">Next</button>
</div>