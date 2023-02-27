<?php session_start(); ?>
<?php
  if(empty($_SESSION["id"])){
    header("Location: /../login.php");
    exit();
  }

  require("../connect.php");
  $query = "SELECT U.name AS user, Q.question, Q.answer, Q.leaveTime, C.name AS course, C.semester, C.courseId, C.courseType FROM QA AS Q, StudInfo AS S, UserInfo AS U, Feedback AS F, Course AS C, Post AS P 
            WHERE Q.postId = F.postId AND Q.userId = S.userId AND S.userId = U.SSOID AND F.courseId = C.courseId AND F.semester = C.semester AND F.courseType = C.courseType AND F.postId = P.postId AND P.userId = '" . $_SESSION["id"] . "'";
  $result = mysqli_query($conn, $query);
  
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $qa[] = $row;
    }
  }
?>


<!DOCTYPE html>
<html lang="zh-Hant">
<head>

<title>回饋問答</title>
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
  width: 70%;
  padding: 50px 30px 30px;
  text-align: center;
  background-color: yellowgreen;
}
.content .column{
  width: 100%;
  padding: 10px;
  border: black solid 1px;
  margin-bottom: 10px;
}
.content .column form {
  display: flex;
  justify-content: space-between;
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
.main::after {
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
    <a href="user_intro.php">個人首頁</a><br>
    <a href="user_course.php">課程與回饋</a><br>
    <a id="active" href="user_qa.php">回饋問答</a><br>
    <hr>
    <a href="user_logout.php">登出</a>
  </div>

  <div class="content">
    <?php for($i = 0; $i < count($qa); $i++) { ?>
      <div class="column">
        <form method="get" action="feedback_edit.php">
          <div class="qa">
            <label><?php echo $qa[$i]["course"] . " " . $qa[$i]["semester"] . " " . $qa[$i]["courseId"]; ?></label><br>
            <label>來自： <?php echo $qa[$i]["user"]; ?></label><br>
            <label>問題： <?php echo nl2br($qa[$i]["question"]) . " - " . $qa[$i]["leaveTime"]; ?></label><br>
            <textarea id="answer" name="answer" rows="5" cols="100" placeholder="你的回覆" required></textarea>
            <input type="submit" id="submit" value="submit">
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