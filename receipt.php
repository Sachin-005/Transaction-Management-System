<!DOCTYPE html>
<html>
<head>
    <title>Receipt</title>
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
    $v = (int) $_GET['card_no'];
    $sql = "SELECT TRANSACTION_ID, AMOUNT FROM temp WHERE CARD_NO='$v' ORDER BY TRANSACTION_ID DESC";
    $result = pg_query($conn, $sql);
    $x = pg_fetch_assoc($result);
    $y = $x['transaction_id'];
    $amt = $x['amount'];
    $sql1 = "SELECT TRANSACTION_NAME, TRANSACTION_TYPE, TRANSACTION_STATUS FROM transaction WHERE TRANSACTION_ID='$y'";
    $result1 = pg_query($conn, $sql1);
    $z = pg_fetch_assoc($result1);
    $n = $z['transaction_name'];
    $w = $z['transaction_type'];
    $t = $z['transaction_status'];
    $sql2 = "SELECT CARD_BALANCE FROM card WHERE CARD_NO='$v'";
    $result2 = pg_query($conn, $sql2);
    $ava = pg_fetch_assoc($result2);
    $avail = $ava['card_balance'];
    $vs = (string) $v;
?>
<div class="jumbotron" >
  <h1 class="display-3 y">Indian Bank</h1>
  <hr class="my-4">
  <h3>Card No: ************<?php echo substr($vs, -4);?></h3>
 <h3>Transaction Id: <?php echo "$y";?></h3>
  <h3>Transaction type: <?php echo "$w";?></h3>
  <h3>Transaction status: Completed Sucessfully</h3>
  <h3>Amount <?php echo ": $amt";?></h3>
  <h3>Availabe Amount: <?php echo "$avail";?></h3>
  <form method="post" action="#">
      <button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Exit</button>
  </form>
</div>
<?php
if(isset($_POST['submit']))
{
    header('Location:index.php');
}
?>
</body>
</html>
