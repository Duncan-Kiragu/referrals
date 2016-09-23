<?php

$db_host        = 'localhost';
$db_user        = 'root';
$db_pass        = 'root';
$db_database    = 'referrals';
$db_port        = '3306';

$conn = mysqli_connect($db_host,$db_user,$db_pass,$db_database,$db_port) or die(mysqli_error($db));
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  $datum = new DateTime();
$startTime = $datum->format('Y-m-d H:i:s');
$sql = "INSERT INTO referrals (user_id, referral_email, referral_amount, created_at) VALUES (".$_GET['referrer'].", '".$_GET['email']."', 100.00, '".$startTime."')";
print $sql;

if (!mysqli_query($conn,$sql))
  {
  echo("Error description: " . mysqli_error($conn));
  }
mysqli_close($conn);


?>
