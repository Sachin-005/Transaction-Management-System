<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Indian Bank</title>
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="x">

    <div class="jumbotron" >
  <h1 class="display-4 y">Welcome To MIT Bank</h1>
  <hr class="my-4">
  <form method="post" action="#">
    <label>Enter Your ATM Card Number: </label><br>
    <input type="text" name="atm_no" id="atm_no"><br>
    <label>CVV: </label><br>
    <input type="password" name="cvv" id="cvv"><br><br>
    <label>Account Type:</label>
    <select name="account_type">
      <option></option>
      <option>Current</option>
      <option>Savings</option>
      <option>Deemat</option>
    </select><br><br>
    <button type="submit" name="submit" id="submit" class="btn btn-secondary btn-lg">Submit</button>
  </form>
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
  
  if(isset($_POST['submit']))
  {
    $card_no=$_POST['atm_no'];
    $cvv=$_POST['cvv'];
    $account_type=$_POST['account_type'];
    $sql="SELECT CARD_CVV FROM card WHERE CARD_NO='$card_no'"; 
    $result = pg_query($conn, $sql);
    $row = pg_fetch_assoc($result);
    if($row['card_cvv'] == $cvv)
    {
        
        header("Location: option.php?cvv=$cvv&account_type=$account_type");
        exit();
    }
  }
  pg_close($conn);
?>

</body>
</html>
