<?php session_start(); ?>
<?php 
  require("connect.php");
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $question = addslashes($_POST["question"]);
    $query = "INSERT INTO QA(question, userId, postId) VALUES('" . $question . "', '" . $_SESSION["id"] . "', " . $_POST["postId"] . ")";
    if(mysqli_query($conn, $query)){
      echo "<script type='text/javascript'>alert('提問成功');</script>";
    }
    $postId = $_POST["postId"];
    $input = $_POST["input"];
  }
  if($_SERVER["REQUEST_METHOD"] == "GET"){
    $postId = $_GET["postId"];
    $input = $_GET["input"];
  }
  $query = "SELECT F.postId, F.content, F.aScore, F.aIll, F.passScore, F.passIll, F.comScore, F.comIll, F.learnScore, F.learnIll, F.hwScore, F.hwIll, F.exScore, F.exIll, F.teachContent, U.name AS user, S.department AS dep, S.grade AS grade, C.name AS course, C.semester AS semester FROM Feedback AS F, Post AS P, StudInfo AS S, UserInfo AS U, Course AS C WHERE F.postId = " . $postId . " AND P.userId = S.userId AND S.userId = U.SSOID AND P.courseId = C.courseId AND P.semester = C.semester AND P.courseType = C.courseType";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    $feedback = mysqli_fetch_assoc($result);
  }

  $query2 = "SELECT Q.question, Q.answer, Q.leaveTime, U.name FROM QA AS Q, StudInfo AS S, UserInfo AS U WHERE Q.postId = " . $feedback["postId"] . " AND Q.userId = S.userId AND S.userId = U.SSOID AND Q.reveal = 1";
  $result = mysqli_query($conn, $query2);

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $qa[] = $row;
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
  padding: 50px 30px 30px;
  text-align: center;
  background-color: yellowgreen;
}
.content form {
  display: inline-block;
  width: 100%;
  text-align: left;
  padding: 10px 50px;
}
.content fieldset {
  display: block;
  width: 100%;
  text-align: left;
  padding: 15px 50px;
  margin-bottom: 30px;
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
    required autocomplete="on" value="<?php echo $input ?>">
    <input type="submit" id="submit" value="submit">
  </form>
  <a href="user/user_intro.php" style="float: right; background-color: transparent;">
    <img id="userImage" src="/../img/<?php echo $_SESSION["id"]; ?>.jpg" onerror="this.onerror=null; this.src='/../img/default.png';" alt="User">
  </a>
</div>

<div class="main">
<div class="content">
    <h1><?php echo $feedback["semester"] . " " . $feedback["course"]; ?></h1>
    <h2><?php echo $feedback["user"] . " " . $feedback["dep"] . " grade " . $feedback["grade"] ?></h2>
    <form id="main_form" action="feedback_edit.php" method="post">
      <label for="aScore">課程高分難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="aScore" name="aScore" min="1" max="5"
      <?php echo $value = isset($feedback["aScore"])?"value=\""  . $feedback["aScore"] . "\"":""; ?> disabled><br>
      <label for="aIll">課程高分難易度敘述: </label><br>
      <textarea id="aIll" name="aIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["aIll"])?$feedback["aIll"]:""; ?></textarea>
      <hr>
      
      <label for="passScore">課程及格難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="passScore" name="passScore" min="1" max="5"
      <?php echo $value = isset($feedback["passScore"])?"value=\""  . $feedback["passScore"] . "\"":""; ?> disabled><br>
      <label for="passIll">課程及格難易度敘述: </label><br>
      <textarea id="passIll" name="passIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["passIll"])?$feedback["passIll"]:""; ?></textarea>
      <hr>
      
      <label for="comScore">課程理解難易度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="comScore" name="comScore" min="1" max="5"
      <?php echo $value = isset($feedback["comScore"])?"value=\""  . $feedback["comScore"] . "\"":""; ?> disabled><br>
      <label for="comIll">課程理解難易度敘述: </label><br>
      <textarea id="comIll" name="comIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["comIll"])?$feedback["comIll"]:""; ?></textarea>
      <hr>
      
      <label for="learnScore">課程收穫程度評分（多：5分，少：1分）: </label><br>
      <input type="range" id="learnScore" name="learnScore" min="1" max="5"
      <?php echo $value = isset($feedback["learnScore"])?"value=\""  . $feedback["learnScore"] . "\"":""; ?> disabled><br>
      <label for="learnIll">課程收穫程度敘述: </label><br>
      <textarea id="learnIll" name="learnIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["learnIll"])?$feedback["learnIll"]:""; ?></textarea>
      <hr>
      
      <label for="hwScore">作業報告難度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="hwScore" name="hwScore" min="1" max="5"
      <?php echo $value = isset($feedback["hwScore"])?"value=\""  . $feedback["hwScore"] . "\"":""; ?> disabled><br>
      <label for="hwIll">作業報告難度敘述: </label><br>
      <textarea id="hwIll" name="hwIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["hwIll"])?$feedback["hwIll"]:""; ?></textarea>
      <hr>
      
      <label for="exScore">考試難度評分（難：5分，易：1分）: </label><br>
      <input type="range" id="exScore" name="exScore" min="1" max="5"
      <?php echo $value = isset($feedback["exScore"])?"value=\""  . $feedback["exScore"] . "\"":""; ?> disabled><br>
      <label for="exIll">考試難度敘述: </label><br>
      <textarea id="exIll" name="exIll" rows="10" cols="100" disabled><?php echo $value = isset($feedback["exIll"])?$feedback["exIll"]:""; ?></textarea>
      <hr>

      <label for="teachContent">實際上課內容： </label><br>
      <textarea id="teachContent" name="teachContent" rows="10" cols="100" disabled><?php echo $value = isset($feedback["teachContent"])?$feedback["teachContent"]:""; ?></textarea><br>
      <label for="content">課程回饋： </label><br>
      <textarea id="content" name="content" rows="10" cols="100" disabled><?php echo $value = isset($feedback["content"])?$feedback["content"]:""; ?></textarea>
      <hr>
    </form>
    <form method="POST" action="feedback_content.php">
      <h1>QA</h1>
      <textarea id="question" name="question" rows="10" cols="100" placeholder="還有疑問嗎？在此留下讓作者知道吧"></textarea>
      <input type="hidden" id="input" name="input" value="<?php echo $input; ?>">
      <input type="hidden" id="postId" name="postId" value="<?php echo $postId; ?>"><br>
      <input type="submit" id="submit" value="submit">
    </form>
    <form>
      <?php if(isset($qa)){ for($i = 0; $i < count($qa); $i++){ ?>
        <fieldset>
          <div>
            <legend><?php echo $qa["name"]; ?></legend>
            <label><?php nl2br($qa["question"]); ?></label>
            <hr>
            <label><?php echo nl2br($qa["answer"]); ?></label>
            <div>
              <label><?php echo $qa["leaveTime"]; ?></label>
            </div>
          </div>
        </fieldset>
      <?php } } ?>
    </form>
  </div>
</div>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>Copyright &copy; 2021 Timmy Peko. All rights reserved.</p>
</div>

</body>
</html>