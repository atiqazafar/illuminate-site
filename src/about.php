 <!-- Illuminate About Page -->

<?php
    /*USER SESSION MAINTENANCE*/
    session_start();    

    $logged_in = 0;
    $error = 0;   
    $success =0;
    $user="";  
    
     
    //CASE1: User is already logged in -> retrieve username
    if (isset($_SESSION["username"])) {
        
        $user = $_SESSION['username'];
        $logged_in = 1;
    }

    //CASE2: User logs in -> set username and password
    else if (isset($_POST['login-username']) && isset($_POST['login-password'])) {       
        
        // store the username and password the user entered
        $getuser = $_POST['login-username'];      
        $getpassword = $_POST['login-password'];  

        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        // fetch username and password from database and authenticate
        $query = "SELECT password FROM tb_user WHERE username = '" . mysql_real_escape_string($getuser) . "'"; 
        $result = mysql_query($query) or die(mysql_error());        
        $row = mysql_fetch_assoc($result);
        if ($getpassword == $row['password']) {       
            $_SESSION['username'] = $getuser;
            $_SESSION['password'] = $getpassword;
            $logged_in = 1;            
            $user = $_SESSION['username'];
        }          
        else{
            $error=1;
        }        
    }

     //CASE3: User signs in
    else if (isset($_POST['inputUsername'])&&isset($_POST['inputPassword']) &&isset($_POST['inputEmail']) &&isset($_POST['inputDOB']) ){       
        
        // store the info the user entered
        $getuser = $_POST['inputUsername'];
        $getpass = $_POST['inputPassword'];
        $getemail = $_POST['inputEmail'];
        $getdob = $_POST['inputDOB'];           

        // connect database
        mysql_connect("localhost", "root", "") or die(mysql_error()); 
        mysql_select_db("db_illuminate") or die(mysql_error()); 

        //insert discussion
        $query = "INSERT INTO tb_user (username, password, email, dob) VALUES ('$getuser', '$getpass', '$getemail', '$getdob')";
        $success = mysql_query($query); 
        if ($success) {       
            $_SESSION['username'] = $getuser;
            $_SESSION['password'] = $getpassword;
            $logged_in = 1;            
            $user = $_SESSION['username'];
        }   
    }    

    //CASE4: User is not logged in
    else{
        session_destroy();
        $logged_in = 0;   
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Illuminate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Style Sheets -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link rel="shortcut icon" href="img/favicon.png">
  
  <!-- jQuery&JavaScripts -->
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>

   
</head>

<body>

<!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand  -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>               
                <a class="navbar-brand" href="homepage.php">
                        <img alt="" src="img/apple-touch-icon-57-precomposed.png">
                </a>            


            </div>


            <!-- Nav links -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav nav-pills pull-right">
                    
                                       
                    <!--Login Menu-->
                    <li id="menuLogin" class="dropdown" >
                        <a id="navLogin" class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Login/Sign up</a>
                        <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                            <form id="formLogin" class="form" role="form" action="homepage.php" method="POST">
                                <label>Login</label>                                
                                <input  class="form-control" id="login-username" type="text" required="" 
                                    placeholder="Username" name="login-username"></input>
                                <input  class="form-control" id="login-password" type="password" required="" 
                                    placeholder="Password" name="login-password"></input>
                                
                                <input type="submit" class="btn btn-info" Value="Login" id="btnLogin">
                                <?php if($error){ ?>
                                   <script> alert ("Invalid Username/Password! Please re-enter.")</script>
                                <?php } ?>
                                <br></br>                           
                            </form>

                           
                            
                            <form>
                                <a data-toggle="collapse" href="#formRegister" aria-expanded="false" aria-controls="formRegister">
                                New User? Sign-up...
                                </a>                             
                                                                                                
                                <br></br>
                            </form>

                            <form role="form" action="homepage.php" method="POST" 
                                  id="formRegister" class="form collapse" style="height: auto;">
                            
                                <input  class="form-control" id="inputUsername" name="inputUsername" required="" type="text" placeholder="Username"></input>
                                <input  class="form-control" id="inputPassword" name="inputPassword" type="password" required="" placeholder="Password" ></input>
                                <input  class="form-control" id="inputEmail" name="inputEmail" type="email" required="" placeholder="Email"></input>
                                <input  class="form-control" id="inputDOB" name="inputDOB" type="text" required="" placeholder="DOB"></input>

                                <input type="checkbox" name="agreement" id="agreement" value="1" required>
                                <label class="string optional" for="agreement">Agree to Terms</label>
                                
                                <input type="submit" class="btn btn-primary" value="Sign Up">
                                <br></br>
                                <br></br>   
                                
                                
                            </form>
                        </div>
                    </li><!--/Login Menu-->
                    
                    <!--User Menu > Settings/Log Out-->
                    <li id="menuUser" class="dropdown hide">
                        <a class="dropdown-toggle" title="Change your Account Settings" data-toggle="dropdown" href="#">

                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            <span id="lblUsername">tasneemkausar</span>
                            <b class="caret"></b>

                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="homepage.php">Home</a></li>
                            <li><a href="discussion-forum.php">Discussion Forum</a></li>
                            <li><a href="settings.php">Settings</a></li>
                            <li class="divider"></li>                            
                            <li><a href="logout.php">Logout</a></li>
                                                  
                        </ul>
                    </li><!--/User Menu-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>


<!-- banner -->
    <div class="banner">

        <div class="container">

            <div class="row">
                <div class="col-lg-6">
                    <h2>About Illuminate</h2>
                </div>
                <div class="col-lg-6">
                    
                </div>
            </div>

        </div>
        <!-- /.container -->

    </div>
    <!-- /.banner -->

<!-- Info Sections -->
    
    <div class="content-section-a">

        <div class="container">

            <div class="row">
                <div class="col-lg-5 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">THIS IS FOR YOU, FELLOW SEEKER!</h2>
                    <p class="lead"> Muslim teens are passing through a crisis of faith right
                        now. There are philosophical questions that
                        they struggle with every day and that go unanswered
                        because they do not have a space at home or Masjid
                        where they can ask all the weird questions comfortably
                        without being judged or labeled as an atheist. To solve
                        this problem using technology, we planned to build
                        Illuminate.
                    </p>
                </div>
                <div class="col-lg-5 col-lg-offset-2 col-sm-6">
                    <img class="img-responsive" src="img/3.png" alt="">
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">ASK QUESTIONS, SEARCH RESOURCES AND FIND YOUR ANSWERS!</h2>
                    <p class = "lead">
                        Illuminate is a community-driven question-and-answer
                        platform + a search engine that allows
                        you to search out the answers alone or together with
                        other Muslims more efficiently. <p>
                    <p class = "lead">

                        SEARCH - You post your question, we will provide you videos, 
                        articles or blogs and books from the re-known and authentic Islamic websites. <p>
                    <p class = "lead">

                        DISCUSS - Can't find your answers online? No worries. Our community of fellow 
                        seekers will help you! The discussion forum is where questions are asked, 
                        answers are searched and shared, mentor-ship is provided
                        so each of you is helped personally with your struggle.<p>
                    <p class = "lead">
                        Muslim teens just do not need speakers; they need counselors and best friends. And Illuminate
                        will provide them just that - a culture around strong friendship and mentor-ship! What are you waiting for?
                        Join the illuminate family now ^__^
                    </p>
                </div>                
            </div>

            <div class="row" id="contact">
                 <div class="col-lg-5  col-sm-6">
                    <img class="img-responsive" src="img/4.png" alt="">
                </div>

                <div class="col-lg-6 col-lg-offset-1 col-sm-6">
                    <hr class="section-heading-spacer">
                    <div class="clearfix"></div>
                    <h2 class="section-heading">WHO ARE WE?</h2>
                    <p class="lead"> Team <a href="#contact">Fellow Seekers. </a> We're just a bunch of kids. </p>
                </div>
               
            </div>


        </div>
        <!-- /.container -->

    </div>
    <!-- /.content-section-a -->
    

<!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                     <ul class="list-inline">
                        
                        <li>
                            <a href="about.php">About</a>
                        </li>
                        <li class="footer-menu-divider">&sdot;</li>
                        <li>
                            <a href="terms.php">Terms</a>
                            
                        </li>
                         <li class="footer-menu-divider">&sdot;</li>
                        <li>
                             <a href="about.php#contact">Contact</a>
                        </li>
                    </ul>
                    <p class="copyright text-muted small">Copyright &copy;Illuminate 2015. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </footer>
<!--footer-->

<script>

    //Logging in
    var logged=<?php echo json_encode($logged_in); ?>;
    var usr= <?php echo json_encode($user); ?>;
    if(logged){
        document.getElementById('menuLogin').setAttribute('class', 'dropdown hide');
        document.getElementById('menuUser').setAttribute('class', 'dropdown unhide');
        document.getElementById('lblUsername').innerHTML = usr;

    }   

</script>

</body>
</html>
