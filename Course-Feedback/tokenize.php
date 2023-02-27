<?php
  ini_set("memory_limit", "1024M");
  require("segment/src/vendor/multi-array/MultiArray.php");
  require("segment/src/vendor/multi-array/Factory/MultiArrayFactory.php");
  require("segment/src/class/Jieba.php");
  require("segment/src/class/Finalseg.php");
  use Fukuball\Jieba\Jieba;
  use Fukuball\Jieba\Finalseg;
  Jieba::init();
  Finalseg::init();
  
  $punc = array("，", "。", "、", "＂", "！", "＠", "＃", "＄", "％", "︿", "＆", "＊", "（", "）", "－", "＋", "［", "］", "＼", "｜", "：", "；", "＜", "＞", "？", "／");

  require("connect.php");
  $query = "SELECT courseId, semester, courseType, outline, objective, teachMethod, evaluation FROM course";
  $result = mysqli_query($conn, $query);

  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
      $course[] = $row;
    }
  }else{
    exit("failed to fetch course information<br>");
  }

  for($i = 0; $i < count($course); $i++){
    $token_arr = Jieba::cutForSearch($course[$i]["outline"]);
    $course[$i]["outlineToken"] = arr2str($token_arr);
    //echo "<p>" . $course[$i]["outline"] . "</p>";
    //echo "<p>" . $course[$i]["outlineToken"] . "</p>";
    $token_arr = Jieba::cutForSearch($course[$i]["objective"]);
    $course[$i]["objectiveToken"] = arr2str($token_arr);
    //echo "<p>" . $course[$i]["objective"] . "</p>";
    //echo "<p>" . $course[$i]["objectiveToken"] . "</p>";
  }

  for($i = 0; $i < count($course); $i++){
    $query = "UPDATE course SET ";

    if(!is_null($course[$i]["outline"])){
      $query .= "outlineToken = '" . $course[$i]["outlineToken"] . "'";
    }
    if(!is_null($course[$i]["outline"]) && !is_null($course[$i]["objective"])){
      $query .= ", ";
    }
    if(!is_null($course[$i]["objective"])){
      $query .= "objectiveToken = '" . $course[$i]["objectiveToken"] . "'";
    }
    if(!is_null($course[$i]["outline"]) || !is_null($course[$i]["objective"])){
      $query .= " WHERE courseId = '" . $course[$i]["courseId"] . "' AND semester = '" . $course[$i]["semester"] . "' AND courseType = '" . $course[$i]["courseType"] . "'";
      //echo $query . "<br>";
      if(!mysqli_query($conn, $query)){
        echo "failed to update tuple: " . $course[$i]["courseId"] . "<br>";
      }
    }
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