<?php session_start(); ?>
<?php 
  require("connect.php");
  $query1 = "SELECT U.name, S.department, S.grade, F.postId FROM Post AS P, Feedback AS F, StudInfo AS S, UserInfo AS U 
             WHERE P.userId = S.userId AND P.courseId = '" . $_GET["courseId"] . "' AND P.semester = '" . $_GET["semester"] . "' AND P.courseType = '" . $_GET["courseType"] . "' AND P.postId = F.postId AND S.userId = U.SSOID";
  $result = mysqli_query($conn, $query1);
  

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $feedback[] = $row;
    }
  } 

  $query2 = "SELECT * FROM SearchResult WHERE id = '" . $_GET["courseId"] . "' AND sem = '" . $_GET["semester"] . "' AND type = '" . $_GET["courseType"] . "'";
  $result = mysqli_query($conn, $query2); echo $query2;
  if(mysqli_num_rows($result) > 0){
    $course = mysqli_fetch_assoc($result);
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
.content .info {
  width: 100%;
  padding: 10px;
  border: black solid 1px;
  margin-bottom: 30px;
}
.content .info form {
  display: flex;
  justify-content: space-between;
  margin: 0px;
  text-align: left;
}
.content .info .course div {
  display: inline-block;
  width: 350px;
  text-align: left;
}
.content .info .course div label {
  padding: 0px 10px;
}
.content .info .buttons button {
  width: 70px;
  height: 60px;
  font-size: 20px;
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
  margin: 0px;
  text-align: left;
}
.content .column .feecback div {
  display: inline-block;
  width: 350px;
  text-align: left;
}
.content .column .feecback div label {
  padding: 0px 10px;
}
.content .column .buttons button {
  width: 40px;
  height: 40px;
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
    <div class="info">
      <form method="get" action="course_content.php">
        <div class="course">
          <label><?php echo $course["id"]; ?></label>
          <label><?php echo $course["type"]; ?></label><br>
          <label><?php echo $course["course"] ?></label>
          <label><?php echo $course["sem"] ?></label><br>
          <label><?php echo $course["prof"] ?></label>
        </div>
        <input type="hidden" id="courseId" name="courseId" value="<?php echo $course["id"]; ?>">
        <input type="hidden" id="semester" name="semester" value="<?php echo $course["sem"]; ?>">
        <input type="hidden" id="courseType" name="courseType" value="<?php echo $course["type"]; ?>">
        <input type="hidden" id="input" name="input" value="<?php echo $_GET["input"] ?>">
        <div class="buttons">
          <button type="submit" name="action" value="submit"><?php echo "<"; ?></button>
        </div>
      </form>
    </div>
    <?php if(isset($feedback)){ for($i = 0; $i < count($feedback); $i++) { ?>
      <div class="column">
        <form method="get" action="feedback_content.php">
          <div class="feedback">
            <div>
              <label><?php echo $feedback[$i]["department"]; ?></label>
              <label><?php echo $feedback[$i]["grade"]; ?></label><br>
              <label><?php echo $feedback[$i]["name"] ?></label>
            </div>
            <input type="hidden" id="postId" name="postId" value="<?php echo $feedback[$i]["postId"] ?>">
            <input type="hidden" id="input" name="input" value="<?php echo $_GET["input"]; ?>">
          </div>
          <div class="buttons">
            <button type="submit" name="action" value="submit"><?php echo ">"; ?></button>
          </div>
        </form>
      </div>
    <?php } } ?>
</div>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>