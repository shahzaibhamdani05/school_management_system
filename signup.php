<?php
## This is a comment.


if($_SERVER["REQUEST_METHOD"]=="POST"):

  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $cpassword = $_POST["confirm_password"];

  if($password !== $cpassword){
   $msg= "<p style='color:red;'>Password does not match</p>";
  }else{

$connection = mysqli_connect("localhost","root","","ecstore");
$query ="INSERT INTO signup (name,email,password,confirm_password) VALUES('$username','$email','$password','$cpassword')";
$result = mysqli_query($connection,$query);
print_r($result);
if($result):
    echo "signup successfully";
else:
    echo "signup failed";
endif;

  }

endif;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <form action="" method="POST">
            <input type="text" name = "username" placeholder="USERNAME" required>
            <br>
            <input type="text" name = "email"placeholder="EMAIL" required>
            <br>
            <input type="password" name="password" placeholder="PASSWORD"required>
            <br>
            <input type="password" name = "confirm_password"placeholder="Confirm_PASSWORD"required>
            <br>
            <?php if(isset($msg)) echo $msg; ?>
            <input type="submit" value="Sign up">
        </form>
    </div>
</body>
</html>