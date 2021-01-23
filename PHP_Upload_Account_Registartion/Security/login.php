<?php

session_start();

/*
^       Start
$       End
[]      Rules that are applied 
+       Ruless will be applied to everything otherwise just single letter or digit
\s      Space 
\.      To allow decimal
{}      Will allow specified maximum limit 
{2,5}   Will allow from min 2  to max 5 

*/

include 'link.php';
include 'header.php';

$email_error = $pass_error =  "";

$email = $pass = "";


$reg_email = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z]+$/";

$reg_pass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}+$/";


$result = false;


if (isset($_POST['submit'])) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include 'dbconn.php';

        class LoginCheck
        {

            public $regEmail;
            public $regPass;

            // Getter
            function getUserEmail()
            {
                return $this->userEmailSet;
            }
            function getUserPass()
            {
                return $this->userPassSet;
            }
            function setUserEmail($regEmail)
            {
                $this->userEmailSet = $regEmail;
            }
            function setUserPass($regPass)
            {
                $this->userPassSet = $regPass;
            }
        }

        $obj = new LoginCheck();

        $userValueEmail = $_POST['email'];
        $userValuePassword = $_POST['password'];


        $obj->setUserEmail($userValueEmail);
        $obj->setUserPass($userValuePassword);

        $emailValue = $obj->getUserEmail();
        $passValue = $obj->getUserPass();

        $emailCheckQuery = "select * from registration where email = '$emailValue'";
        $statement = $conn->prepare($emailCheckQuery);
        $statement->execute();

        $emailCount = $statement->rowCount();

        if ($emailCount != 0) 
        {
                foreach ($statement as $smt)
                {
                        $email_pass = $smt['password'];
                }

            $pass_verify = password_verify($passValue, $email_pass);

            if ($pass_verify) 
            {
                $_SESSION['email'] = $obj->getUserEmail();
                $message =  "Login Successfull";
                 header('Location:main.php');
            } 
            else
            {
                $message = "Password doesnot match";
            }
        } 
        else
        {
            $message =  "Email does not match";
        }
        // if ($result) 
        // {
        //     header("Location: http://localhost:12/semester_3_php/registeration_form/register.php ");
        // } 
    }

    
    if($message != "")
    {
        echo "<script>alert('$message');</script>"; 
    }


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="assets/css/register.css">
</head>
<body>
<div class="signup-form">	
    <form name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="loginBox">
	<h2>Login</h2>
		<p class="lead"> Login to access your Account </p>
        <div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                 <input type="email" name="email" class="form-control" name="email" placeholder="Email Address" required="required" value="<?php echo $email; ?>" autocomplete="off" title="xyz@xyz.com">
			</div>
        </div>
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="<?php echo $pass; ?>" required title=" Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character ">
			</div>
        </div>
		       
		<div class="form-group">
            <button type="submit" name ="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
        </div>
		<p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>
    </form>
	<div class="text-center">Already have an account? <a href="sign_up.php">Login here</a>.</div>
</div>
</body>
</html>