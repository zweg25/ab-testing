<?php

function get_data($array){
	?>
	
	<form action="chi.php" method="POST">
	  <fieldset>
	    <legend>Chi-squared Test:</legend>
	    <h3>Interface A:</h3>
	    <?php echo $array[2][0]; ?>:<br>
	    <input type="text" name="array[0][0]" value="<?php echo $array[0][0]; ?>"><br>
	    <?php echo $array[2][1]; ?>:<br>
	    <input type="text" name="array[0][1]" value="<?php echo $array[0][1]; ?>">
	    <br>

	    <h3>Interface B:</h3>
	    <?php echo $array[2][0]; ?>:<br>
	    <input type="text" name="array[1][0]" value="<?php echo $array[1][0]; ?>"><br>
	    <?php echo $array[2][1]; ?>:<br>
	    <input type="text" name="array[1][1]" value="<?php echo $array[1][1]; ?>">
	    <br>

	    <input type="hidden" name="array[2][0]" value="<?php echo $array[2][0]; ?>"><br>
	    <input type="hidden" name="array[2][1]" value="<?php echo $array[2][1]; ?>">
	    <input type="hidden" name="array[2][2]" value="<?php echo $array[2][2]; ?>">
	    <br>

	    <input type="submit" value="Submit">
	  </fieldset>
	</form>

	<?php
	}

// If passed an array of contents for chi-squared test
if (isset($_POST['array'])){

	// Get array of values
	$array = $_POST['array'];

	// Get Names of Headers just for displaying text
	$header1 = $array[2][0];
	$header2 = $array[2][1];
	$header3 = $array[2][2];

	// Get interface A Values
	$interfaceAVal = $array[0][0];
	$interfaceANotVal = $array[0][1];
	$interfaceATotal = $interfaceAVal + $interfaceANotVal;

	// Get interface B Values
	$interfaceBVal = $array[1][0];
	$interfaceBNotVal = $array[1][1];
	$interfaceBTotal = $interfaceBVal + $interfaceBNotVal;

	// Compute Totals
	$totalVal = $interfaceAVal + $interfaceBVal;
	$totalNotVal = $interfaceANotVal + $interfaceBNotVal;
	$entireTotal = $interfaceATotal + $interfaceBTotal;

	// Compute expected values for interface A Values
	$interfaceAExpected = ($interfaceATotal / $entireTotal) * $totalVal;
	$interfaceANotExpected = ($interfaceATotal / $entireTotal) * $totalNotVal;
	
	// Compute expected values for interface B Values
	$interfaceBExpected = ($interfaceBTotal / $entireTotal) * $totalVal;
	$interfaceBNotExpected = ($interfaceBTotal / $entireTotal) * $totalNotVal;

	//Create a 2x2 array of observed values and expected values
	$observedArray = array(array($interfaceAVal, $interfaceANotVal), array($interfaceBVal, $interfaceBNotVal));
	$expectedArray = array(array($interfaceAExpected, $interfaceANotExpected), 
		array($interfaceBExpected, $interfaceBNotExpected));
	
	//Display Values in a table
	echo '<style>
		table, th, td {
		   border: 1px solid black;
		}
	</style>';
	echo "<h1> Chi-Squared Test for {$header3}</h1>";

	echo "<h2> Observed Table </h2>
	<table style='table-layout: auto;'>
	<tr>
		<th>Observed</th>
		<th>{$header1}</th>
		<th>{$header2}</th>
		<th>Total</th>
	</tr>
	<tr>
		<th>Interface A</th>
		<td>{$interfaceAVal}</td>
		<td>{$interfaceANotVal}</td>
		<td>{$interfaceATotal}</td>
	</tr>
	<tr>
		<th>Interface B</th>
		<td>{$interfaceBVal}</td>
		<td>{$interfaceBNotVal}</td>
		<td>{$interfaceBTotal}</td>
	</tr>
	<tr>
		<th>Total</th>
		<td>{$totalVal}</td>
		<td>{$totalNotVal}</td>
		<td>{$entireTotal}</td>
	</tr>
	</table>
	";

	echo "<br>";

	echo "<h2> Expected Table </h2>
	<table>
	<tr>
		<th>Expected</th>
		<th>{$header1}</th>
		<th>{$header2}</th>
		<th>Total</th>
	</tr>
	<tr>
		<th>Interface A</th>
		<td>{$interfaceAExpected}</td>
		<td>{$interfaceANotExpected}</td>
		<td>{$interfaceATotal}</td>
	</tr>
	<tr>
		<th>Interface B</th>
		<td>{$interfaceBExpected}</td>
		<td>{$interfaceBNotExpected}</td>
		<td>{$interfaceBTotal}</td>
	</tr>
	<tr>
		<th>Total</th>
		<td>{$totalVal}</td>
		<td>{$totalNotVal}</td>
		<td>{$entireTotal}</td>
	</tr>
	</table>
	";

	//Compute Chi-Squared Value
	echo "<br><br>\r\n<h2>Compute Chi-Square Value</h2>";

	//The following computes the chi-squared value for a 2x2 input
	$chiSquared = 0;
	echo "Calculations:<br>";
	echo '<img src="chi-formula.png" alt="Chi-squared formula" height="282" width="964"><br>';
	for ($i=0; $i < 2; $i++) { 
		for ($j=0; $j < 2; $j++) { 
			$observed = $observedArray[$i][$j];
			$expected = $expectedArray[$i][$j];

			//sum all the (observed - expected)^2/expected
			$chi = (($observed - $expected)**2)/$expected;
			$chiSquared += $chi;

			//Display Calculation:
			print_r("(".$observed. " + " .$expected .")^2 / ". $expected. " = " . $chi."<br>");
		}
	}

	$pVal = 3.84;
	echo "<p> = <b>". $chiSquared . "</b></p>";
	echo "<p> Degrees of freedom (df) = (rows - 1)(columns - 1) = (2 - 1)(2 - 1) = <b>1</b></p>";
	echo "<p>Probability value for 1 degree of freedom at 0.05 is <b>".$pVal."</b></p>";

	if ($pVal < $chiSquared) {
		echo "<h3>". $chiSquared . " is greater than ".$pVal." so our data is statiscally significant! We can reject the NULL Hypothesis.</h3>";
	}
	else{
		echo "<h3>". $chiSquared . " is not greater than ".$pVal." so our data is NOT statiscally significant. We fail to reject the NULL Hypothesis.</h3>";
	}

}
else
{
	//get_data(array(array(23, 35), array(19, 31), array("Number of Clicks", "No Clicks", "Click Rate")));
}
	//Otherwise ask for data
?>