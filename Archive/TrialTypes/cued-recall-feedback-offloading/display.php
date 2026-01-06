<?php
    // Starts by checking this $feedbackItem argument, and calculates a $feedbackPosition from that
    // ($feedbackPostion is the index of the trial that this will be getting the responses/scores from)
    // -- Not currently actually using either of these variables, just using hardcoded index values -- 
    if (!isset($feedbackItem)) {$feedbackItem = ''; }
    if (substr($feedbackItem, 0, 1) === 'r') { $feedbackPosition = $currentPos-substr($feedbackItem, 1); } 
    elseif (!is_numeric($feedbackItem))      { $feedbackPosition = $currentPos-1;                        } 
    else                                     { $feedbackPosition = (int) $feedbackItem - 1;              }

    // Hardcoded -> indicis of the trials that are to be included in the scoring
    //DILLON - All you need to do is change these 3 numbers. 
    $response_start_index   = 418; //This is the first TEST row in the procedure file -1 
    $number_of_words        = 20; //Number of words in the list
    $number_of_instructions = 11; //The number of rows between the end of the study phase and the beginning of the test phase

    // Loop to add up the scores of the trials
    $total = 0;
    for ($i = $response_start_index; $i <= ($response_start_index + $number_of_words - 1); $i++) {
        // Get the offloaded response (will use a different index)
        $offloaded_index  = $i - ($number_of_words + $number_of_instructions);
        $offload_response = $_SESSION['Trials'][$offloaded_index]['Response']['post1_Response'];

        // Find wether or not this was offloaded
        $offloaded = (substr($offload_response, 0, 1) === 'Y') ? true : false;

        // Find wether or not this word was answered correctly
        $recalled = $_SESSION['Trials'][$i]['Response']['lenientAcc'];

 
        // If it was offloaded, get points, if it was not offloaded, but it was recalled correctly, add points
        if ($offloaded) { $total += 5;              }
        else            { $total += $recalled * 10; }

    }

    // $targets => list of all of the response values recorded
    $targets = array('$lenientVal', '$strictVal', '$lenientAcc', '$strictAcc', '$possibleVal', '$possibleAcc');
    $replace = array($total, $total, $total, $total, $total, $total,);

    // $text => this is the text column of the procedure.csv file
    // This line replaces the $variables with the correspinding values above
    // (right now, each of the different response scores are all just replaced with the samevalue, $total)
    $text = str_ireplace($targets, $replace, $text);

/*
<div>
    <h3>Session Data</h3>
    <?php
        echo '<pre>';
        print_r($_SESSION);
        echo '</pre>';
    ?>
</div>
*/

?>
    <div><?php echo $text; ?></div>

	<!-- include form to collect RT and advance page -->
    <div class="textcenter">
        <button class="collectorButton collectorAdvance" id="FormSubmitButton">Next</button>
    </div>

    