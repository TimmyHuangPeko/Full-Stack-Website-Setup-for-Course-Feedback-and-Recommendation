<?php  session_start(); ?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>

<title>NSYSU課程回饋</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
html, body {
    height: 100%;
    margin: 0;
}
body{
    display: flex;
    flex-direction: column;
    background-color: antiquewhite;
    font-family: Arial, Helvetica, sans-serif;
}

.header{
    overflow: hidden;
}

ul{
    list-style-type: none;
    margin: 0;
    padding: 0;
}

li{float: right;}

li a{
    display: block;
    text-align: center;
    margin: 20px 40px;
}

#introNav {float: left;}
#introNav a:link{
    color: black;
    text-decoration: none;
}
#introNav a:hover{
    color: red;
    text-decoration: underline;
}
#introNav a:visited{
    color: black;
    text-decoration: none;
}

#loginNav a{
    margin: 14px 34px;
    padding: 6px 6px;
    background-color:skyblue;
    border: slategray solid 1px;
    border-radius: 5px;
}
#loginNav a:link{
    color: black;
    text-decoration: none;
}
#loginNav a:hover{
    background-color:powderblue;
    text-decoration: none;
}
#loginNav a:visited{
    color: black;
    text-decoration: none;
}

#userNav a{margin: 14px 34px;}
#userNav img{
    border-radius: 50%;
    width: 50px;
    height: auto;
    float: right;
    border: transparent solid 4px;
}
#userNav:hover #userImage{
    border: thistle solid 4px;
}

.article{
    clear: both;
    padding: 30px;
    margin-top: 100px;
    text-align: center;
    flex-grow: 1;
}
.article h1{font-size: 50px;}
.article p{font-size: 15px;}
.article #input{
    height: 40px;
    font-size: 20px;
    margin: 20px;
}
.article #submit{
    height: 40px;
    width: auto;
    font-size: 20px;
}


.footer{
    height: 75px;
    background-color:lightblue;
    text-align: center;
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

<div class="header">
  <nav>
    <ul>
      <li id="introNav">
        <a href="intro.php">關於 課程回饋</a>
      </li>
      <li id="loginNav" style=" <?php echo $islogin = isset($_SESSION["id"])?"display: none":""; ?>">
        <a href="login.php">使用者登入</a>
      </li>
      <li id="userNav" style="<?php echo $islogin = isset($_SESSION["id"])?"":"display: none" ?>">
        <a href="/user/user_intro.php" title="Hi! <?php echo $_SESSION["name"] ?>">
          <img id="userImage" src="/img/<?php echo $_SESSION["id"]; ?>.jpg" onerror="this.onerror=null; this.src='/img/default.png';" alt="User">
        </a>
      </li>
    </ul>
  </nav>
</div>

<div class="article">
  <h1>NSYSU 課程回饋</h1>
  <p>
    Courses' Outline that students really need<br>
    Caution! We are here to discuss, not to complain!
  </p>
  

  <form method="post" action="compute.php">
    <input type="text" id="input" name="input" size="75" maxlength="128"
    placeholder="the description of the course" required><br>
    <input type="submit" id="submit" value="submit">
  </form>
</div>

<div class="footer">
  <hr>
  <a href="mailto: yles.94214@gmail.com">Contact Developer</a>
  <p>
    Copyright &copy; 2021 Timmy Peko. All rights reserved.
  </p>
</div>
</body>
</html>