<?php session_start(); ?>
<?php 
  if(empty($_SESSION["id"])){
    header("Location: /../login.php");
    exit();
  }

  $email = $phone = $intro = "";
  require("../connect.php");
  
  $query = "SELECT UserInfo.email, UserInfo.phone, UserInfo.introduction, StudInfo.department, StudInfo.grade, StudInfo.qualified FROM UserInfo, StudInfo WHERE UserInfo.SSOID = StudInfo.userId AND UserInfo.SSOID = '" . $_SESSION["id"] . "'";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    $row = mysqli_fetch_assoc($result);
    $email = $row["email"];
    $phone = $row["phone"];
    $intro = $row["introduction"];
    $dep = $row["department"];
    $grade = $row["grade"];
    $qual = $row["qualified"];
  }
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>

<title>個人首頁</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}
html, body {
  height: 100%;
}
body{
  font-family: Arial, Helvetica, sans-serif;
  display: flex;
  flex-direction: column;
}

.nav{
  overflow: hidden;
  position: fixed;
  width: 100%;
  top: 0px;
  padding: 30px 80px 5px;
  background-color: tomato;
}
.nav a{
  float: left;
  display: block;
  padding: 5px 5px;
  text-align: center;
  text-decoration: none;
  font-size: 20px;
  color: black;
  background-color: lightblue;
}
.nav a #userImage{
  float: right;
  width: 60px;
  height: auto;
  border-radius: 50%;
  border: transparent solid 4px;
  margin: -4px;
}
.nav a:hover #userImage{
  border: thistle solid 4px;
}

.sidebar {
  position: fixed;
  /*margin-top: 10%;*/
  width: 15%;
  height: 100%;
  text-align: left;
  padding-left: 20px;
  background-color: yellow;
}
.sidebar a{
  display: block;
  padding: 20px 30px;
  margin-bottom: -20px;
  background-color: white;
  color: black;
  text-decoration: none;
}
.sidebar a:hover {
  background-color: lightgray;
}
.sidebar #active {
  color: mediumblue;
  background-color: lightblue;
}

.content {
  margin-left: 15%;
  /*margin-top: 10%;*/
  width: 70%;
  padding: 50px 30px 0px;
  text-align: center;
  background-color: yellowgreen;
}

.content #userPic {
  width: 20%;
  height: auto;
  border-radius: 50%;
}
.content fieldset {
  width: 700px;
  padding: 30px 0px 50px;
  display: inline-block;
}
.content fieldset .label {
  float: left;
  text-align: left;
  width: 300px;
  margin-left: 40px;
}
.content fieldset .value {
  float: right;
  text-align: left;
  width: 300px;
  margin-right: 40px;
}
.content fieldset .intro {
  clear: both;
  margin: 0px 40px;
  text-align: left;
}

.main::before {
  content: "";
  display: block;
  margin-top: 95px;
}
.main {
  flex-grow: 1;
}
.main::after{
  content: "";
  display: table;
  clear: both;
}

.footer {
  clear: both;
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
  <a href="/../home.php">NSYSU課程回饋</a>
  <a href="user_intro.php" style="float: right; background-color: transparent;">
    <img id="userImage" src="/../img/<?php echo $_SESSION["id"]; ?>.jpg" onerror="this.onerror=null; this.src='/../img/default.png';" alt="User">
  </a>
</div>

<div class="main">
  <div class="sidebar">
    <a id="active" href="user_intro.php">個人首頁</a><br>
    <a href="user_course.php">課程與回饋</a><br>
    <a href="user_qa.php">回饋問答</a><br>
    <hr>
    <a href="user_logout.php">登出</a>
  </div>

  <div class="content">
    <img id="userPic" src="/../img/<?php echo $_SESSION["id"]; ?>.jpg" onerror="this.onerror=null; this.src='/../img/default.png';" alt="User">
    <h1>歡迎 <?php echo $_SESSION["name"] ?></h1>
    <fieldset>
      <div class="label">
        <label><?php echo "Name:"; ?></label><hr>
        <label><?php echo "Email:"; ?></label><hr>
        <label><?php echo "Phone Number:"; ?></label><hr>
        <label><?php echo "department:" ?></label><hr>
        <label><?php echo "grade"; ?></label><hr>
        <label style="color: midnightblue"><?php echo "qualified for viewing others' feedback:"; ?></label><hr>
        <label><?php echo "Introduction:"; ?></label><br><br>
      </div>
      <div class="value">
        <label><?php echo $_SESSION["name"]; ?></label><hr>
        <label><?php echo $email; ?></label><hr>
        <label><?php echo $phone; ?></label><hr>
        <label><?php echo $dep; ?></label><hr>
        <label><?php echo $grade; ?></label><hr>
        <label style="color: midnightblue"><?php echo $qual; ?></label><hr>
      </div>
      <div class="intro"><label><?php echo nl2br($intro); ?></label></div>
      
      
    </fieldset>
  </div>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>