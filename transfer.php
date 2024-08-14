<!DOCTYPE html>
<html>
<head>
    <title>Transfer</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Enter Details: </h1><br><br>
    <form method="post" action="#">
        <label>Account Number to Transfer: </label>
        <input type="text" name="acct" id="acct"><br><br>
        <label>Amount to Transfer: </label>
        <input type="text" name="transfer" id="transfer"><br><br>
        <button type="submit" id="submit" name="submit" class="btn btn-secondary btn-lg">Transfer</button>
        <button type="submit" id="cancel" name="cancel" class="btn btn-secondary btn-lg">Abort</button>
    </form>
</div>
</div>
<?php
  $host="localhost";
  $username="postgres"; // Update with your PostgreSQL username
  $password="2005"; // Update with your PostgreSQL password
  $database="atm"; // Update with your PostgreSQL database name

  $conn = pg_connect("host=$host dbname=$database user=$username password=$password");
  if (!$conn) {
      echo "Failed to connect to PostgreSQL.";
  }
  if(isset($_POST['cancel']))
  {
    header('Location: index.php');
  }

  if(isset($_POST['submit']))
  {
    $cvv=(int) $_GET['cvv'];
    $amt=$_POST['transfer'];
    $acct=$_POST['acct'];
    $sql="SELECT CARD_BALANCE FROM card WHERE CARD_CVV = '$cvv'"; 
    $result = pg_query($conn, $sql);
    $x = pg_fetch_assoc($result);
    $z = $x["card_balance"];
    $sql1 = "SELECT CARD_BALANCE FROM card WHERE CARD_NO = '$acct'"; 
    $result1 = pg_query($conn, $sql1);
    $b = pg_fetch_assoc($result1);
    $c = $b["card_balance"];
    if($z > $amt)
    {
        $y = $c + $amt;
        $a = $z - $amt;
        $sql2 = "UPDATE card SET CARD_BALANCE = '$a' WHERE CARD_CVV = '$cvv'";
        pg_query($conn, $sql2);
        $sql3 = "UPDATE card SET CARD_BALANCE = '$y' WHERE CARD_NO = '$acct'";
        pg_query($conn, $sql3);
        $sql4 = "INSERT INTO transaction(TRANSACTION_NAME, TRANSACTION_STATUS, TRANSACTION_TYPE) VALUES ('transfer', 'COMPLETED', 'TRANSFER')";
        pg_query($conn, $sql4);
        $sql5 = "SELECT CARD_NO FROM card WHERE CARD_CVV='$cvv'";
        $result5 = pg_query($conn, $sql5);
        $s = pg_fetch_assoc($result5);
        $v = $s['card_no'];
        $sql6 = "INSERT INTO temp(CARD_NO, AMOUNT) VALUES ('$v', '$amt')";
        pg_query($conn, $sql6);
        $url = "receipt.php?card_no=" . $v;
        header('Location: ' . $url);
        exit();
    }
  }
    pg_close($conn);
?>
</body>
</html>
