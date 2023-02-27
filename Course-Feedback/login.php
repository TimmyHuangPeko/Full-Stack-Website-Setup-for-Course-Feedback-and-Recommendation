<?php session_start(); ?>
<?php
  $execute = true;
  $account = $password = $accountErr = $passwordErr = $valErr = "";
  require("connect.php");

  if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!empty($_POST["account"])){
      $account = $_POST["account"];
    }else{
      $accountErr = "* Account is required";
      $execute = false;
    }

    if(!empty($_POST["password"])){
      $password = $_POST["password"];
    }else{
      $passwordErr = "* Password is required";
      $execute = false;
    }

    $query = "SELECT SSOID, `name`, `identity` FROM UserInfo WHERE SSOID = '" . $account . "' AND `password` = '" . hash("sha256", $password) . "'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      $_SESSION["id"] = $row["SSOID"];
      $_SESSION["name"] = $row["name"];
      $_SESSION["identity"] = $row["identity"];
      
      header("Location: home.php");
      exit();
    }else{
      $valErr = "* failed to login:<br>unknown SSOID or wrong password";
    }
  }
?>

<!DOCTYPE html>
<html>
<head>

<title>課程回饋 登入</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>

html, body{
  height: 100%;
  min-height: 100%;
  margin: 0;
  background-color: antiquewhite;
  font-family: Arial, Helvetica, sans-serif;
}

.error{
  color: red;
}

.nav{
  overflow: hidden;
}
.nav a{
  float: left;
  display: block;
  text-align: center;
  padding: 5px 5px;
  margin: 40px 80px;
  font-size: 20px;
  color: black;
  background-color:lightblue;
  text-decoration: none;
}

.content{
  padding-top: 100px;
  padding-bottom: 50px;
  text-align: center;
}
.content fieldset{
  margin: 0px 550px;
  padding-bottom: 50px;
  background-color: white;
}
.content fieldset p{
  display: inline-block;
  text-align: left;
}
.content fieldset .input{
  display: inline-block;
  text-align: left;
  padding: 20px 100px 0px;
}

.footer{
  position: absolute;
  bottom: 0px;
  height: 75px;
  width: 100%;
  text-align: center;
  background-color: lightblue;
}
.footer hr{
  margin-top: 0px;
  margin-bottom: 10px;
}
.footer a{
  text-decoration: none;
  color: black;
}
.footer a:hover{
  color: midnightblue;
}
.footer p{
  margin: 10px;
}
</style>

</head>
<body>

<div class="nav">
  <a href="home.php">NSYSU課程回饋</a>
</div>

<div class="content">
  <form method="post" action="login.php">
    <fieldset>
      <h1>登入</h1>
      <p>
        輸入NSYSU SSO帳號以及預設密碼<br>
        預設密碼與SSO帳號相同
      </p><br>

      <div class="input">
        <label for="account">SSO帳號：</label><br>
        <input type="text" id="account" name="account" 
        value="<?php echo $account; ?>" size="30" required>
        <span class="error"><?php echo $accountErr; ?></span><br><br>

        <label for="password">密碼：</label><br>
        <input type="password" id="password" name="password" 
        value="<?php echo $password; ?>" size="30" required>
        <span class="error"><?php echo $passwordErr; ?></span><br><br>

        <input type="submit" id="submit" value="submit"><br>
        <span class="error"><?php echo $valErr; ?></span>
      </div>
    </fieldset>
  </form>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>