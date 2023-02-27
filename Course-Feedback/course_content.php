<?php session_start(); ?>
<?php 
  require("connect.php");
  $query = "SELECT * FROM Course AS C, SearchResult AS R WHERE C.courseId = '" . $_GET["courseId"] . "' AND C.semester = '" . $_GET["semester"] . "' AND C.courseType = '" . $_GET["courseType"] . "' AND C.courseId = R.id AND C.semester = R.sem AND C.courseType = R.type";
  $result = mysqli_query($conn, $query);
  echo $query;
  if(mysqli_num_rows($result) > 0){
    $info = mysqli_fetch_assoc($result);
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
  margin: 0px;
}
.content .info fieldset {
  display: block;
  width: 100%;
  text-align: left;
  padding: 15px 50px;
  margin-bottom: 30px;
}
.content .info .buttons button {
  width: 40px;
  height: 40px;
  font-size: 20px;
  float: right;
}
.buttons::after{
  content: "";
  display: table;
  clear: both;
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
      <form method="get" action="feedback.php">
        <div class="buttons">
          <button type="submit" name="action" value="submit"><?php echo ">"; ?></button>
        </div>
        <h1><?php echo $info["name"] . " " . $info["semester"]; ?></h1>
        <h2><?php echo $info["courseId"] . " " . $info["courseType"]; ?></h2>
        <fieldset>
          <div>
            <legend>課程資訊</legend>
            <label>教授： <?php echo $info["prof"]; ?></label><br>
            <label>上課日期： <?php echo $info["courseDate"]; ?></label><br>
            <label>上課時間： <?php echo $info["courseStartTime"] . " - " . $info["courseEndTime"]; ?></label><br>
            <label>上課地點： <?php echo $info["classroom"]; ?></label><br>
            <label>必/選修： <?php echo $output = ($info["courseRequired"]?'必修':'選修'); ?></label><br>
            <label>學分： <?php echo $info["credit"]; ?></label><br>
          </div>
        </fieldset>
        <fieldset>
          <div>
            <legend>課程大綱</legend>
            <label><?php echo nl2br($info["outline"]); ?></label>
          </div>
        </fieldset>
        <fieldset>
          <div>
            <legend>課程目標</legend>
            <label><?php echo nl2br($info["objective"]); ?></label>
          </div>
        </fieldset>
        <fieldset>
          <div>
            <legend>授課方式</legend>
            <label><?php echo nl2br($info["teachMethod"]); ?></label>
          </div>
        </fieldset>
        <fieldset>
          <div>
            <legend>評分方式</legend>
            <label><?php echo nl2br($info["evaluation"]); ?></label>
          </div>
        </fieldset>
        <input type="hidden" id="courseId" name="courseId" value="<?php echo $info["id"] ?>">
        <input type="hidden" id="semester" name="semester" value="<?php echo $info["sem"] ?>">
        <input type="hidden" id="courseType" name="courseType" value="<?php echo $info["type"] ?>">
        <input type="hidden" id="input" name="input" value="<?php echo $_GET["input"]; ?>">
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