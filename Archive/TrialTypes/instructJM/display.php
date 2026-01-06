<?php
    /* WARNING!  Any changes you make to this Instruct trial type will not change the experiment because
     * there is another version of 'Instruct' within the '/Experiment/TrialTypes/` folder.
     * 
     * This was done as an example of how you can copy trial types from '/Code/TrialTypes/'
     * into '/Experiment/TrialTypes/' and override the default trial display. This is a
     * feature meant to keep all of your modification in one place '/Experiment/'.
     * 
     * You can also make your own new trial types inside of the '/Experiment/TrialTypes/' folder and will have
     * access to them in your experiment. The real benefit of developing experiments this way is that when new
     * versions of Collector come out with features you want you will be able to download the new version and copy
     * your /Experiment/ folder into the new version so you can take advantage of new features without having
     * to completely port your experiment to the new version.
     */
    
    // use the `Cue` if a valid one is called and there is no `Text` set in the procedure
    if (($cue != '') AND (trim($text) == '')) { $text = $cue; }


    // Skip offloaded items 
    // ---------------------------------------------------
    // For getting indicis of trials - DILLON edits these 3 numbers
    $study_start_index = 2; //This is the first STUDY row in the procedure file -1
    $number_of_words = 20; //Number of words in the list
    $number_of_instructions = 1; //The number of rows between the end of the study phase and the beginning of the test phase


    // Loop through all of the study trials
    for ($i = $study_start_index; $i <= ($study_start_index + $number_of_words - 1); $i++) {
        // Check if the item was offloaded
        $offload_response = $_SESSION['Trials'][$i]['Response']['post1_Response'];
        $offloaded = (substr($offload_response, 0, 1) === 'Y') ? true : false;

        // If it was offloaded...
        if ($offloaded) {
            // Find index of corresponding test trial
            $test_index = $i + $number_of_words + $number_of_instructions;

            // Change that trials "Max Time" and "Min Time" to 0
            $_SESSION['Trials'][$test_index]['Procedure']['Max Time'] = 0;
            $_SESSION['Trials'][$test_index]['Procedure']['Min Time'] = 0;
        }
    }

?>

<div style="font-size: 100%;"><?php echo $text; ?></div>

<div class="textright">
    <button class="collectorButton collectorAdvance" id="FormSubmitButton">Next</button>
</div>

