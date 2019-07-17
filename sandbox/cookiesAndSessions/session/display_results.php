<?php
require_once('../../../private/initialize.php');

session_start();
    // get the data from the form
$investment = filter_input(INPUT_POST, 'investment', FILTER_VALIDATE_FLOAT);
$interest_rate = filter_input(INPUT_POST, 'interest_rate',
    FILTER_VALIDATE_FLOAT);
$years = filter_input(INPUT_POST, 'years',
    FILTER_VALIDATE_INT);

$_SESSION["investment"] = $investment;
$_SESSION["interest_rate"] = $interest_rate;
$_SESSION["years"] = $years;




// validate investment
$error_message = "";

if ( $investment === NULL || $investment === FALSE ) {
    $error_message = 'Investment must be a valid number.'; }
else if ( $investment <= 0 ) {
    $error_message = 'Investment must be greater than zero.'; }

// validate interest rate
else if ( $interest_rate === NULL || $interest_rate === FALSE ) {
    $error_message = 'Interest rate must be a valid number.'; }
else if ( $interest_rate <= 0 ) {
    $error_message = 'Interest rate must be greater than zero.'; }
else if ($interest_rate >15){
    $error_message = 'Interest rate is too high please enter a lower rate';
}

// validate years
else if ( $years === NULL || $years === FALSE ) {
    $error_message = 'Number of years must be a valid whole number.'; }
else if ( $years <= 0  ) {
    $error_message = 'Number of years must be greater than zero.'; }
else if ( $years >31 ){
    $error_message = 'Number must be less than 31';
}

// set error message to empty string if no invalid entries
else {
    $error_message = ''; }

// if an error message exists, go to the index page
if ($error_message != '') {
    $_SESSION['error']=$error_message;
   header("Location:index.php");
}

    // calculate the future value
    $future_value = $investment;
    for ($i = 1; $i <= $years; $i++) {
        $future_value = 
            $future_value + ($future_value * $interest_rate * .01); 
    }

    // apply currency and percent formatting
    $investment_f = '$'.number_format($investment, 2);
    $yearly_rate_f = $interest_rate.'%';
    $future_value_f = '$'.number_format($future_value, 2);
?>
<?php include(SHARED_PATH."/header.php")?>

    <main>
        <h1>Future Value Calculator</h1>

        <label>Investment Amount:</label>
        <span><?php echo $investment_f; ?></span><br>

        <label>Yearly Interest Rate:</label>
        <span><?php echo $yearly_rate_f; ?></span><br>

        <label>Number of Years:</label>
        <span><?php echo $years; ?></span><br>

        <label>Future Value:</label>
        <span><?php echo $future_value_f; ?></span><br>

        <button class = 'back'><a href='index.php'>BACK</a></button>
    </main>

<?php include(SHARED_PATH.'/footer.php')?>