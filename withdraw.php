<!DOCTYPE html>
<html>
<head>
    <title>Withdraw</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Enter Amount To Withdraw: </h1><br><br>
    <form method="post" action="#">
        <label>Rs: </label>
        <input type="text" name="withdraw" id="withdraw"><br><br>
        <button type="submit" id="submit" name="submit" class="btn btn-secondary btn-lg">Submit</button>
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
    $amt=$_POST['withdraw'];
    $sql="SELECT CARD_BALANCE FROM card WHERE CARD_CVV = '$cvv'"; 
    $result = pg_query($conn, $sql);
    $x = pg_fetch_assoc($result);
    $z = $x["card_balance"];
    if($z > $amt)
    {
        $y = $z - $amt;
        $sql1 = "UPDATE card SET CARD_BALANCE = '$y' WHERE CARD_CVV = '$cvv'";
        pg_query($conn, $sql1);
        $sql2 = "INSERT INTO transaction(TRANSACTION_NAME, TRANSACTION_STATUS, TRANSACTION_TYPE) VALUES ('withdrawn', 'COMPLETED', 'WITHDRAW')";
        pg_query($conn, $sql2);
        $sql3 = "SELECT CARD_NO FROM card WHERE CARD_CVV='$cvv'";
        $result3 = pg_query($conn, $sql3);
        $s = pg_fetch_assoc($result3);
        $v = $s['card_no'];
        $sql4 = "INSERT INTO temp(CARD_NO, AMOUNT) VALUES ('$v', '$amt')";
        pg_query($conn, $sql4);
        $url = "receipt.php?card_no=" . $v;
        header('Location: ' . $url);
        exit();
    }   
  }
    pg_close($conn);
?>
</body>
</html>
