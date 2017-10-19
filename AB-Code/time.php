<?php

/*
 GET TIME OF PAGE LOAD FOR EACH UNIQUE SESSION
 GET TIME OF PAGE CLICK FOR EACH UNIQUE SESSION
 COMPUTE CLICK TIME click - load
 Compute average click time
*/

echo "<h2>Time to Click</h2>"; // Echo header
$textFile = "a-data.csv"; // Name of file to read in

$dataValues = array(array(), array()); //Store data for stdDev
$storedValues = array(array(), array()); //Store values for other computations for each set of data

//===============================================
//=============Compute the metrics===============
//===============================================
for ($i=0; $i < 2; $i++) //Loop through the data for both a and b
{
    if ($i == 0)
    $textFile = "a-data.csv";
    if ($i == 1)
    $textFile = "b-data.csv";
    
    $first_clicks = 0;
    $name = "";
    $has_clicked = FALSE;
    $load_time = 0;
    $total_time = 0;
    
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
                $load_time = $data[4];
            }
            
            //Get the fifth column (click-time)
            //If this is not 0 it means the user has clicked
            //If this user has not already clicked, record this click
            //(Don't record multiple clicks for the same user)
            //Compute the click time
            if ($data[5] != 0 && !$has_clicked)
            {
                //First click
                $first_clicks++;
                $has_clicked = true;
                $click_time = $data[5];
                $total_time += ($click_time - $data[4]);

                //Store values for Standard Deviation
                $dataValues[$i][] = ($click_time - $data[4]);
            }
        }
        fclose($handle);
    }
    
    //Print results for each file
    echo "<h2>" . $textFile . "</h2>";
    echo "Unique clicks: " . $first_clicks . "<br>";
    echo "Time between clicks: " . $total_time . "<br>";
    
    echo "Average time-to-click: " . $total_time / $first_clicks . " milliseconds<br>";

    $storedValues[$i][0] = ($total_time / $first_clicks); //Remember avg click time
    $storedValues[$i][1] = $first_clicks; //Remember number of clicks
}

include "ttest.php";

$stdDevA = stats_standard_deviation($dataValues[0]);
$stdDevB = stats_standard_deviation($dataValues[1]);

$n1 = $storedValues[0][1];
$n2 = $storedValues[1][1];

$t = compute_t_test($storedValues[0][0], $storedValues[1][0], $n1, $n2,
    $stdDevA, $stdDevB);
echo "<p> t value = <b>".$t."</b></p>";

$df = $n1 + $n2 - 2;
echo "<p> Degrees of freedom (df) = <b>". $df . "</b></p>";

$criticalTVal = get_critval($df);
echo "<p> Critical T Value = <b>". $criticalTVal . "</b></p>";


if ($t > $criticalTVal) {
    echo "<h3>". $t . " is greater than ".$criticalTVal." so our data is statiscally significant! We can reject the NULL Hypothesis.</h3>";
}
else{
    echo "<h3>". $t . " is not greater than ".$criticalTVal." so our data is NOT statiscally significant. We fail to reject the NULL Hypothesis.</h3>";
}


?>
