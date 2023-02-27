<?php
  session_start();

  ini_set("memory_limit", "1024M");
  require("segment/src/vendor/multi-array/MultiArray.php");
  require("segment/src/vendor/multi-array/Factory/MultiArrayFactory.php");
  require("segment/src/class/Jieba.php");
  require("segment/src/class/Finalseg.php");
  require("connect.php");
  
  use Fukuball\Jieba\Jieba;
  use Fukuball\Jieba\Finalseg;
  Jieba::init();
  Finalseg::init();

  /**set professor name array */
  if(!isset($_SESSION["profArray"])){
    $_SESSION["profArray"] = array();
    echo "hi<br>";
    
    $query = "SELECT DISTINCT `name` FROM UserInfo WHERE `identity` = 'professor'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        $_SESSION["profArray"][] = $row["name"];
      }
    }
  }
  /**set course type array*/
  if(!isset($_SESSION["typeArray"])){
    $_SESSION["typeArray"] = array();
    

    $query = "SELECT DISTINCT courseType FROM course";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        $_SESSION["typeArray"][] = $row["courseType"];
      }
    }
  }
  /**set course name array */
  if(!isset($_SESSION["courseArray"])){
    $_SESSION["courseArray"] = array();
    

    $query = "SELECT DISTINCT `name` FROM course";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_assoc($result)){
        $_SESSION["courseArray"][] = $row["name"];
      }
    }
  }
  

  
  $_SESSION["view"] = "SearchResult";
  $drop = "DROP VIEW " . $_SESSION["view"];
  if(mysqli_query($conn, $drop)){
    echo "success<br>";
  }
  else{
    echo "failed<br>";
  }
    
  
  
  $punc = array("，", "。", "、", "＂", "！", "＠", "＃", "＄", "％", "︿", "＆", "＊", "（", "）", "－", "＋", "［", "］", "＼", "｜", "：", "；", "＜", "＞", "？", "／");
  $prof = array();
  $type = array();
  $course = array();
  $profMatch = "";
  $typeMatch = "";
  $courseMatch = "";
  $input = $_POST["input"];

  /**check which keyword fit in the array */
  $tok = strtok($input, " ");
  while($tok !== false){
    $pattern = "/" . $tok . "/i";
    for($i = 0; $i < count($_SESSION["profArray"]); $i++){
      if(preg_match($pattern, $_SESSION["profArray"][$i])){
        $prof[] = $tok;
      }
    }
    for($i = 0; $i < count($_SESSION["typeArray"]); $i++){
      if(preg_match($pattern, $_SESSION["typeArray"][$i])){
        $type[] = $tok;
      }
    }
    for($i = 0; $i < count($_SESSION["courseArray"]); $i++){
      if(preg_match($pattern, $_SESSION["courseArray"][$i])){
        $course[] = $tok;
      }
    }

    $tok = strtok(" ");
  }

  /**construct match condition (used in WHERE clause) */
  for($i = 0; $i < count($prof); $i++){
    $profMatch .= "U.name LIKE '%" . $prof[$i] . "%' ";
    if($i != count($prof) - 1){
      $profMatch .= "OR ";
    }
  }
  for($i = 0; $i < count($type); $i++){
    $typeMatch .= "S.courseType LIKE '%" . $type[$i] . "%' ";
    if($i != count($type) - 1){
      $typeMatch .= "OR ";
    }
  }
  for($i = 0; $i < count($course); $i++){
    $courseMatch .= "S.name LIKE '%" . $course[$i] . "%' ";
    if($i != count($course) - 1){
      $courseMatch .= "OR ";
    }
  }
  
  $Match = $profMatch;
  if($Match != "" && $typeMatch){
    $Match .= "OR ";
  }
  $Match .= $typeMatch;
  if($Match != "" && $courseMatch){
    $Match .= "OR ";
  }
  $Match .= $courseMatch;
  if($Match != ""){
    $Match .= "OR ";
  }
  $Match .= "S.score > 0";

  $Case = "";
  if($profMatch != "" || $typeMatch != "" || $courseMatch != ""){
    $Case .= "(CASE ";
  }

  if($profMatch != "" && $typeMatch != "" && $courseMatch != ""){
    $Case .= "WHEN (" . $profMatch . ") AND (" . $typeMatch . ") AND (" . $courseMatch . ") THEN U.name, S.courseType ";
  }
  if($profMatch != "" && $typeMatch != "" && $courseMatch == ""){
    $Case .= "WHEN (" . $profMatch . ") AND (" . $typeMatch . ") THEN U.name, S.courseType ";
  }
  if($profMatch != "" && $typeMatch == "" && $courseMatch != ""){
    $Case .= "WHEN (" . $profMatch . ") AND (" . $courseMatch . ") THEN U.name ";
  }
  if($profMatch == "" && $typeMatch != "" && $courseMatch != ""){
    $Case .= "WHEN (" . $typeMatch . ") AND (" . $courseMatch . ") THEN S.courseType ";
  }
  if($profMatch == "" && $typeMatch == "" && $courseMatch != ""){
    $Case .= "WHEN (" . $courseMatch . ") THEN S.courseType ";
  }
  if($profMatch != "" && $typeMatch == "" && $courseMatch == ""){
    $Case .= "WHEN (" . $profMatch . ") THEN U.name ";
  }
  if($profMatch == "" && $typeMatch != "" && $courseMatch == ""){
    $Case .= "WHEN (" . $typeMatch . ") THEN S.courseType ";
  }

  if($profMatch != "" || $typeMatch != "" || $courseMatch != ""){
    $Case .= "END) DESC, ";
  }
  $Case .= "S.score DESC";

  /**segment search string */
  $keyArray = Jieba::cutForSearch($input);
  $keyword = arr2str($keyArray);

  $searchKey = "SELECT courseId, semester, courseType, `name`, MATCH (`outlineToken`, `objectiveToken`) AGAINST ('" . $keyword . "' IN BOOLEAN MODE) AS score
                FROM course
                WHERE MATCH (`outlineToken`, `objectiveToken`) AGAINST ('" . $keyword . "' IN BOOLEAN MODE) >= 0";
  
  $query = "SELECT S.courseId AS id, S.semester AS sem, S.courseType AS `type`, S.score AS score, S.name AS course, U.name AS prof
            FROM (" .  $searchKey . ") AS S, ProfInfo AS P, Teach T, UserInfo AS U
            WHERE (T.courseId = S.courseId) AND (T.semester = S.semester) AND (T.courseType = S.courseType) AND (P.userId = T.userId) AND (U.SSOID = P.userId) AND (" . $Match . ")
            ORDER BY " . $Case . ""; echo $query . "<br><br>";


  $view = "CREATE VIEW searchResult AS $query";
  echo $view;
  if(mysqli_query($conn, $view)){
    header("Location: search.php?input=". $_POST["input"]);
    exit();
  }else{
    header("Location: home.php");
    exit();
  }

  /**show sql result */
  $result = mysqli_query($conn, $query);
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $r[] = $row;
    }
  }else{
    echo "failed to search keyword<br>";
  }
  for($i = 0; $i < count($r); $i++){
    echo $r[$i]["id"] . "  " . $r[$i]["sem"] . "  " . $r[$i]["type"] . "  " . $r[$i]["score"] . $r[$i]["course"] . $r[$i]["prof"] . "<br>";
  }

  
  function arr2str(array $arr) {
    $str = "";
    global $punc;
    for($i = 0; $i < count($arr); $i++){
      if(!in_array($arr[$i], $punc) && !ctype_punct($arr[$i])){
        $str .= ($arr[$i] . " ");
        
      }
    }
    return $str;
  }
?>