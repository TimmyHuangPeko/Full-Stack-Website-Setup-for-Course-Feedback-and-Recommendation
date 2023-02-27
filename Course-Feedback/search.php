<?php session_start(); ?>
<?php 
  require("connect.php");
  $query = "SELECT * FROM SearchResult";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $course[] = $row;
    }
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
.nav input {
  float: left;
  font-size: 20px;
  margin-left: 10px;
  padding: 5px 5px;
}
.nav a #userImage{
  float: right;
  width: 60px;
  height: auto;
  border-radius: 50%;
  border: transparent solid 4px;
  margin: -4px;
  margin-top: -20px;
}
.nav a:hover #userImage{
  border: thistle solid 4px;
}


.content {
  margin-left: 15%;
  width: 70%;
  padding: 50px 30px 0px;
  text-align: center;
  background-color: yellowgreen;
}
.content .column{
  width: 100%;
  padding: 10px;
  border: black solid 1px;
  margin-bottom: 30px;
}
.content .column form {
  display: flex;
  justify-content: space-between;
}
.content .column .course div {
  display: inline-block;
  width: 350px;
  text-align: left;
}
.content .column .course div label {
  padding: 0px 10px;
}
.content .column .buttons button{
  width: 70px;
  height: 60px;
  font-size: 20px;
}

.main::before {
  content: "";
  display: block;
  margin-top:80px;
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
  <form action="compute.php" method="post">
    <input type="text" id="input" name="input" size="50" maxlength="64" 
    required autocomplete="on" value="<?php echo $_GET["input"] ?>">
    <input type="submit" id="submit" value="submit">
  </form>
  <a href="user/user_intro.php" style="float: right; background-color: transparent;">
    <img id="userImage" src="/../img/<?php echo $_SESSION["id"]; ?>.jpg" onerror="this.onerror=null; this.src='/../img/default.png';" alt="User">
  </a>
</div>

<div class="main">
<div class="content">
    <?php for($i = 0; $i < count($course); $i++) { ?>
      <div class="column">
        <form method="get" action="feedback.php">
          <div class="course">
            <div>
              <label><?php echo $course[$i]["id"]; ?></label>
              <label><?php echo $course[$i]["type"]; ?></label><br>
              <label><?php echo $course[$i]["course"] ?></label>
              <label><?php echo $course[$i]["sem"] ?></label><br>
              <label><?php echo $course[$i]["prof"] ?></label>
            </div>
            
            <input type="hidden" id="courseId" name="courseId" value="<?php echo $course[$i]["id"] ?>">
            <input type="hidden" id="semester" name="semester" value="<?php echo $course[$i]["sem"] ?>">
            <input type="hidden" id="courseType" name="courseType" value="<?php echo $course[$i]["type"] ?>">
            <input type="hidden" id="input" name="input" value="<?php echo $_GET["input"]; ?>">
          </div>
          <div class="buttons">
            <button type="submit" name="action" value="submit"><?php echo ">"; ?></button>
          </div>
        </form>
      </div>
    <?php } ?>
  </div>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>