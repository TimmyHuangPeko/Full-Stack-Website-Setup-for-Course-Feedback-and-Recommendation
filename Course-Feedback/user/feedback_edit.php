<?php session_start(); ?>
<?php
  if(empty($_SESSION["id"])){
    header("Location: /../login.php");
    exit();
  }
  
  require("../connect.php");
  
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    if($_GET["action"] != "create"){
      $query = "SELECT * FROM (Post AS P NATURAL JOIN Course AS C) NATURAL JOIN Feedback AS F WHERE P.userId = '" . $_SESSION["id"] . "' AND P.courseId = '" . $_GET["courseId"] . "' AND P.semester = '" . $_GET["semester"] . "' AND P.courseType = '" . $_GET["courseType"] . "' AND P.postId = " . $_GET["postId"] . "";
    }else{
      $query = "SELECT courseId, semester, courseType, name FROM Course WHERE courseId = '" . $_GET["courseId"] . "' AND semester = '" . $_GET["semester"] . "' AND courseType = '" . $_GET["courseType"] . "'";
    }
    $result = mysqli_query($conn, $query); 

    if(mysqli_num_rows($result) > 0){
      $feedback = mysqli_fetch_assoc($result);
    }
    $action = $_GET["action"];
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $content = addslashes($_POST["content"]);
    $aIll = addslashes($_POST["aIll"]);
    $passIll = addslashes($_POST["passIll"]);
    $comIll = addslashes($_POST["comIll"]);
    $learnIll = addslashes($_POST["learnIll"]);
    $hwIll = addslashes($_POST["hwIll"]);
    $exIll = addslashes($_POST["exIll"]);
    $teachContent = addslashes($_POST["teachContent"]);

    if($_POST["action"] == "create"){
      $query1 = "INSERT INTO Feedback(content, aScore, aIll, passScore, passIll, comScore, comIll, learnScore, learnIll, hwScore, hwIll, exScore, exIll, teachContent, courseId, semester, courseType) VALUES('" . $content . "', " . $_POST["aScore"] . ", '" . $aIll . "', " . $_POST["passScore"] . ", '" . $passIll . "', " . $_POST["comScore"] . ", '" . $comIll . "', " . $_POST["learnScore"] . ", '" . $learnIll . "', " . $_POST["hwScore"] . ", '" . $hwIll . "', " . $_POST["exScore"] . ", '" . $exIll . "', '" . $teachContent . "', '" . $_POST["courseId"] . "', '" . $_POST["semester"] . "', '" . $_POST["courseType"] . "')";
      if(mysqli_query($conn, $query1)){
        $postId = mysqli_insert_id($conn);
        $query2 = "INSERT INTO Post(userId, courseId, semester, courseType, postId) VALUES('" . $_SESSION["id"] . "', '" . $_POST["courseId"] . "', '" . $_POST["semester"] . "', '" . $_POST["courseType"] . "', " . $postId . ")";
        if(mysqli_query($conn, $query2)){
          header("Location: user_course.php");
          exit();
        }
      }
    }elseif($_POST["action"] == "update"){
      $query = "UPDATE Feedback SET content = '" . $content . "', aScore = " . $_POST["aScore"] . ", aIll = '" . $aIll . "', passScore = " . $_POST["passScore"] . ", passIll = '" . $passIll . "', comScore = " . $_POST["comScore"] . ", comIll = '" . $comIll . "', learnScore = " . $_POST["learnScore"] . ", learnIll = '" . $learnIll . "', hwScore = " . $_POST["hwScore"] . ", hwIll = '" . $hwIll . "', exScore = " . $_POST["exScore"] . ", exIll = '" . $exIll . "', teachContent = '" . $teachContent . "' WHERE postId = " . $_POST["postId"] . "";
      if(mysqli_query($conn, $query)){
        header("Location: user_course.php");
        exit();
      }
    }elseif($_POST["action"] == "delete"){
      $query1 = "DELETE FROM Post WHERE postId = " . $_POST["postId"] . "";
      if(mysqli_query($conn, $query1)){
        $query2 = "DELETE FROM Feedback WHERE postId = " . $_POST["postId"] . "";
        if(mysqli_query($conn, $query2)){
          header("Location: user_course.php");
          exit();
        }
      }
    }else{
      header("Location: user_course.php");
      exit();
    }

    $action = $_POST["action"];
    if(isset($_POST["postId"])){
      $feedback["postId"] = $_POST["postId"];
    }
    $feedback["courseId"] = $_POST["courseId"];
    $feedback["semester"] = $_POST["semester"];
    $feedback["courseType"] = $_POST["courseType"];
    $feedback["name"] = $_POST["name"];
    $feedback["content"] = $_POST["content"];
    $feedback["aScore"] = $_POST["aScore"];
    $feedback["aIll"] = $_POST["aIll"];
    $feedback["passScore"] = $_POST["passScore"];
    $feedback["passIll"] = $_POST["passIll"];
    $feedback["comScore"] = $_POST["comScore"];
    $feedback["comIll"] = $_POST["comIll"];
    $feedback["learnScore"] = $_POST["learnScore"];
    $feedback["learnIll"] = $_POST["learnIll"];
    $feedback["hwScore"] = $_POST["hwScore"];
    $feedback["hwIll"] = $_POST["hwIll"];
    $feedback["exScore"] = $_POST["exScore"];
    $feedback["exIll"] = $_POST["exIll"];
    $feedback["teachContent"] = $_POST["teachContent"];
  }
?>


<!DOCTYPE html>
<html lang="zh-Hant">
<head>

<title><?php echo $title = ($action == "create")?"回饋新增":"回饋編輯"; ?></title>
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
.content form {
  display: inline-block;
  width: 100%;
  text-align: left;
  padding: 30px 50px;
}
.content button {
  width: 80px;
  height: 40px;
  font-size: 20px;
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
    <a id="active" href="user_course.php">課程與回饋</a><br>
    <a href="user_qa.php">回饋問答</a><br>
    <hr>
    <a href="user_logout.php">登出</a>
  </div>

  <div class="content">
    <h1><?php echo $feedback["semester"] . " " . $feedback["name"]; ?></h1>

    <form id="main_form" action="feedback_edit.php" method="post">
      <label for="aScore">課程高分難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="aScore" name="aScore" min="1" max="5"
      <?php echo $value = isset($feedback["aScore"])?"value=\""  . $feedback["aScore"] . "\"":""; ?> required><br>
      <label for="aIll">課程高分難易度敘述: </label><br>
      <textarea id="aIll" name="aIll" rows="10" cols="50"><?php echo $value = isset($feedback["aIll"])?$feedback["aIll"]:""; ?></textarea>
      <hr>
      
      <label for="passScore">課程及格難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="passScore" name="passScore" min="1" max="5"
      <?php echo $value = isset($feedback["passScore"])?"value=\""  . $feedback["passScore"] . "\"":""; ?> required><br>
      <label for="passIll">課程及格難易度敘述: </label><br>
      <textarea id="passIll" name="passIll" rows="10" cols="50"><?php echo $value = isset($feedback["passIll"])?$feedback["passIll"]:""; ?></textarea>
      <hr>
      
      <label for="comScore">課程理解難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="comScore" name="comScore" min="1" max="5"
      <?php echo $value = isset($feedback["comScore"])?"value=\""  . $feedback["comScore"] . "\"":""; ?> required><br>
      <label for="comIll">課程理解難易度敘述: </label><br>
      <textarea id="comIll" name="comIll" rows="10" cols="50"><?php echo $value = isset($feedback["comIll"])?$feedback["comIll"]:""; ?></textarea>
      <hr>
      
      <label for="learnScore">課程收穫程度評分（多：5分，少：1分）: </label><br>
      <input type="range" id="learnScore" name="learnScore" min="1" max="5"
      <?php echo $value = isset($feedback["learnScore"])?"value=\""  . $feedback["learnScore"] . "\"":""; ?> required><br>
      <label for="learnIll">課程收穫程度敘述: </label><br>
      <textarea id="learnIll" name="learnIll" rows="10" cols="50"><?php echo $value = isset($feedback["learnIll"])?$feedback["learnIll"]:""; ?></textarea>
      <hr>
      
      <label for="hwScore">作業報告難度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="hwScore" name="hwScore" min="1" max="5"
      <?php echo $value = isset($feedback["hwScore"])?"value=\""  . $feedback["hwScore"] . "\"":""; ?> required><br>
      <label for="hwIll">作業報告難度敘述: </label><br>
      <textarea id="hwIll" name="hwIll" rows="10" cols="50"><?php echo $value = isset($feedback["hwIll"])?$feedback["hwIll"]:""; ?></textarea>
      <hr>
      
      <label for="exScore">考試難度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="exScore" name="exScore" min="1" max="5"
      <?php echo $value = isset($feedback["exScore"])?"value=\""  . $feedback["exScore"] . "\"":""; ?> required><br>
      <label for="exIll">考試難度敘述: </label><br>
      <textarea id="exIll" name="exIll" rows="10" cols="50"><?php echo $value = isset($feedback["exIll"])?$feedback["exIll"]:""; ?></textarea>
      <hr>

      <label for="teachContent">實際上課內容： </label><br>
      <textarea id="teachContent" name="teachContent" rows="10" cols="50"><?php echo $value = isset($feedback["teachContent"])?$feedback["teachContent"]:""; ?></textarea><br>
      <label for="content">課程回饋： </label><br>
      <textarea id="content" name="content" rows="10" cols="50" required><?php echo $value = isset($feedback["content"])?$feedback["content"]:""; ?></textarea>

      <input type="hidden" name="courseId" value="<?php echo $feedback["courseId"]; ?>">
      <input type="hidden" name="semester" value="<?php echo $feedback["semester"]; ?>">
      <input type="hidden" name="courseType" value="<?php echo $feedback["courseType"]; ?>">
      <input type="hidden" name="name" value="<?php echo $feedback["name"] ?>">
      <?php if(isset($feedback["postId"])){ ?>
      <input type="hidden" name="postId" value="<?php echo $feedback["postId"] ?>">
      <?php } ?>
    </form>
    
    <button type="submit" name="action" value="<?php echo $action; ?>" form="main_form"><?php echo $action; ?></button>
  </div>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>