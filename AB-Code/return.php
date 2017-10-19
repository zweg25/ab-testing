<?php

/*
 COUNT NUMBER OF RETURNS
 COUNT UNIQUE CLICKS
 Compute R/C to get return rate
*/

echo "<h2>Return Time</h2>"; // Echo Header
$textFile = "a-data.csv"; // Name of file to read in

$storeValues = array(array(), array(), array("Number of Returns", "No Returns", "Return Rate"));

//===============================================
//=============Compute the metrics===============
//===============================================
for ($i=0; $i < 2; $i++) // Loop through the data for both a and b
{
    if ($i == 0)
    $textFile = "a-data.csv";
    if ($i == 1)
    $textFile = "b-data.csv";
    
    $numReturns = 0;
    $numClicks = 0;
    $name = "";
    $has_clicked = FALSE;
    $has_returned = FALSE;
    
    //Read .csv
    if (($handle = fopen($textFile, "r")) !== FALSE)
    {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
        {
            //Get the seventh column (user-id)
            //If it differs from the previous column it is a new unique user
            //(This is because of how are .csv is sorted)
            if ($data[7] != $name)
            {
                //New user
                $name = $data[7];
                $has_clicked = false;
                $has_returned = false;
            }
            
            //Get the fifth column (click-time)
            //If this is not 0 it means the user has clicked
            //If this user has not already clicked, record this click
            // possibly ? (Don't record multiple clicks for the same user)
            //(Don't record clicks that keep user on the page - i.e. navigation clicks)
            if ($data[5] != 0 && !$has_clicked && (strpos($data[6], 'cta') === false))
            {
                //First click leaving page
                $numClicks++;
                $has_clicked = true;
            }
            
            //If the user returns count as a return
            if ($data[5] == 0 && $has_clicked && !$has_returned)
            {
                //First click
                $numReturns++;
                $has_returned = true;

                //Allow users to click and return more than once
                $has_clicked = false;
                $has_returned = false;
            }
        }
        fclose($handle);
    }
    
    //Print results for each file
    echo "<h2>" . $textFile . "</h2>";
    echo "Unique clicks: " . $numClicks . "<br>";
    echo "Number of returns: " . $numReturns . "<br>";
    
    echo "Return rate: " . $numReturns / $numClicks . "<br>";

    //Store data for chi squared test
    $storeValues[$i][0] = $numReturns;
    $storeValues[$i][1] = $numClicks - $numReturns;
}

echo "<h3> Metrics Calculated. Hit Submit to calculate the chi-squared test:</h3>";
include "chi.php";
get_data($storeValues);

?>
