<?php

/*
 GET TIME OF SECOND PAGE LOAD FOR EACH UNIQUE SESSION
 GET TIME OF FIRST PAGE CLICK FOR EACH UNIQUE SESSION
 COMPUTE DWELL TIME load - click
 Compute average dwell time
*/

echo "<h2>Dwell Time</h2>"; // Echo Header
$textFile = "a-data.csv"; // Name of file to read in

$dataValues = array(array(), array()); //Store data for stdDev
$storedValues = array(array(), array()); //Store values for other computations for each set of data

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
    $name = "";
    $loadTime = 0;
    $clickTime = 0;
    $totalTime = 0;
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
                
                $clickTime = 0;
                $loadTime = 0;
            }
            
            //Get the fifth column (click-time)
            //If this is not 0 it means the user has clicked
            //If this user has not already clicked, record this click
            //(Don't record multiple clicks for the same user)
            //(Don't record clicks that keep user on the page - i.e. navigation clicks)
            if ($data[5] != 0 && !$has_clicked && (strpos($data[6], 'cta') === false))
            {
                //First click
                $has_clicked = true;
                $clickTime = $data[5];
            }
            
            //If the user returns compute the dwell time
            if ($data[5] == 0 && $has_clicked && !$has_returned)
            {
                //First click
                $numReturns++;
                $has_returned = true;
                $loadTime = $data[4];
                $totalTime += ($loadTime - $clickTime);

                //Store values for Standard Deviation
                $dataValues[$i][] = ($loadTime - $clickTime);
                
                //Users can dwell more than once
                $has_clicked = false;
                $has_returned = false;
            }
        }
        fclose($handle);
    }
    
    //Print results for each file
    echo "<h2>" . $textFile . "</h2>";
    echo "Total dwell time: " . $totalTime . "<br>";
    echo "Number of returns: " . $numReturns . "<br>";
    
    echo "Average dwell time: " . ($totalTime / $numReturns) . " milliseconds<br>";

    $storedValues[$i][0] = ($totalTime / $numReturns); //Remember avg dwell time
    $storedValues[$i][1] = $numReturns; //Remember number of returns
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
