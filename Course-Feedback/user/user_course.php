<?php session_start(); ?>
<?php
  if(empty($_SESSION["id"])){
    header("Location: /../login.php");
    exit();
  }
  
  
  require("../connect.php");
  $query = "SELECT C.courseId, C.semester, C.courseType, C.name, P.postId FROM (Attend AS A NATURAL JOIN Course AS C) LEFT OUTER JOIN Post AS P ON (C.courseId = P.courseId AND C.semester = P.semester AND C.courseType = P.courseType) WHERE A.userId = '" . $_SESSION["id"] . "' ORDER BY A.semester DESC, A.courseId ASC";
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

<title>課程與回饋</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
* {
  box-sizing: border-box;
}

html, body{
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
  padding: 50px 100px 0px;
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
  height: 30px;
  font-size: 15px;
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
    <a href="user_intro.php">個人首頁</a><br>
    <a id="active" href="user_course.php">課程與回饋</a><br>
    <a href="user_qa.php">回饋問答</a><br>
    <hr>
    <a href="user_logout.php">登出</a>
  </div>

  <div class="content">
    <?php for($i = 0; $i < count($course); $i++) { ?>
      <div class="column">
        <form method="get" action="feedback_edit.php">
          <div class="course">
            <div>
              <label><?php echo $course[$i]["semester"]; ?></label>
              <label><?php echo $course[$i]["name"]; ?></label>
            </div>
            <label><?php echo $course[$i]["courseType"] ?></label>
            
            <input type="hidden" id="courseId" name="courseId" value="<?php echo $course[$i]["courseId"] ?>">
            <input type="hidden" id="semester" name="semester" value="<?php echo $course[$i]["semester"] ?>">
            <input type="hidden" id="courseType" name="courseType" value="<?php echo $course[$i]["courseType"] ?>">
            <input type="hidden" id="postId" name="postId" value="<?php echo $course[$i]["postId"] ?>">
          </div>
          <div class="buttons">
            <?php if(!is_null($course[$i]["postId"])){ ?>
              <button type="submit" name="action" value="update"><?php echo "update"; ?></button>
              <button type="submit" name="action" value="delete"><?php echo "delete" ?></button>
            <?php }else{ ?>
              <button type="submit" name="action" value="create"><?php echo "create" ?></button>
            <?php } ?>
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