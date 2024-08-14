<!DOCTYPE html>
<html>
<head>
    <title>Balance Enquiry</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<?php
$host="localhost";
$username="postgres"; // Update with your PostgreSQL username
$password="2005"; // Update with your PostgreSQL password
$database="atm"; // Update with your PostgreSQL database name

$conn = pg_connect("host=$host dbname=$database user=$username password=$password");
if (!$conn) {
    echo "Failed to connect to PostgreSQL.";
}
$cvv=(int) $_GET['cvv'];
$sql = "SELECT CARD_BALANCE FROM card WHERE CARD_CVV='$cvv'";
$result = pg_query($conn, $sql);
$x = pg_fetch_assoc($result);
$y = $x['card_balance'];
 
?>
<div class="jumbotron">
  <h1 class="display-3 y">Your Current Balance is: </h1>
  <hr class="my-4">
  <h1 class="display-4 y">Rs: <?php echo "$y";?></h1><br>
  <form method="post" action="#">
    <button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Continue</button>
  </form>
</div>
<?php
if(isset($_POST['submit']))
{
    $sql4="INSERT INTO transaction(TRANSACTION_NAME, TRANSACTION_STATUS, TRANSACTION_TYPE) VALUES ('', 'COMPLETED', 'BALANCE ENQUIRY')";
    pg_query($conn, $sql4);
    $sql5="SELECT CARD_NO FROM card WHERE CARD_CVV='$cvv'";
    $result5=pg_query($conn, $sql5);
    $s=pg_fetch_assoc($result5);
    $v=$s['card_no'];
    $sql6="INSERT INTO temp(TRANSACTION_ID, CARD_NO, AMOUNT) VALUES ('', '$v', '0')";
    pg_query($conn, $sql6);
    $url = "receipt.php?card_no=" . $v;
    header('Location: ' . $url);
    exit();
}
?>
</body>
</html>
