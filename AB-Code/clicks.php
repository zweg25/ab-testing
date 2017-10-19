<?php

/*
 COUNT UNIQUE SESSIONS
 COUNT UNIQUE CLICKS
 Compute u_c/u_s to get clickthrough rate
 */

echo "<h2>Click through rate</h2>"; // Echo Header
$textFile = "a-data.csv"; // Name of file to read in

$storeValues = array(array(), array(), array("Number of Clicks", "No Clicks", "Click Rate"));
//===============================================
//=============Compute the metrics===============
//===============================================
for ($i=0; $i < 2; $i++)  // Loop through the data for both a and b
{
    if ($i == 0)
    $textFile = "a-data.csv";
    if ($i == 1)
    $textFile = "b-data.csv";
    
    $unique_sessions = 0;
    $unique_clicks = 0;
    $name = "";
    $has_clicked = FALSE;
    
    //Read .csv
    if (($handle = fopen($textFile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            
            //Get the seventh column (user-id)
            //If it differs from the previous column it is a new unique user
            //(This is because of how are .csv is sorted)
            if ($data[7] != $name)
            {
                $unique_sessions++;
                $name = $data[7];
                $has_clicked = false;
            }
            
            //Get the fifth column (click-time)
            //If this is not 0 it means the user has clicked
            //If this user has not already clicked, record this click
            //(Don't record multiple clicks for the same user)
            if ($data[5] != 0 && !$has_clicked)
            {
                $unique_clicks++;
                $has_clicked = true;
            }
        }
        fclose($handle);
    }
    
    //Print results for each file
    echo "<h2>" . $textFile . "</h2>";
    echo "Unique clicks: " . $unique_clicks . "<br>";
    echo "Unique sessions: " . $unique_sessions . "<br>";
    
    echo "Clicks through percentage: " . ($unique_clicks / $unique_sessions) . "<br>";

    //Store data for chi squared test
    $storeValues[$i][0] = $unique_clicks;
    $storeValues[$i][1] = $unique_sessions - $unique_clicks;
}

echo "<h3> Metrics Calculated. Hit Submit to calculate the chi-squared test:</h3>";
include "chi.php";
get_data($storeValues);

?>
