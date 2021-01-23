<?php

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
include 'dbconn.php';

$email_error = $pass_error = $cpass_error = $fname_error = $phone_error =  $all_error_msg = "" ;

$email = $pass = $cpass = $fname = $phone = "";


$reg_email = "/^[a-zA-Z\d\._]+@[a-zA-Z\d\._]+\.[a-zA-Z]+$/";

$reg_pass = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}+$/";

$reg_fName = "/^[a-z\sA-Z\s]{2,20}+$/";

$reg_lName = "/^[a-zA-Z]{2,20}+$/";


$reg_address = "/^[\d\s]{1,6}[a-zA-Z\s]{2,30}+$/";

$reg_city = "/^[a-zA-Z]{2,20}+$/";

$reg_state = "/^[a-zA-Z]{2,20}+$/";

$reg_zipcode = "/^[a-zA-Z\d]{3}[ ][a-zA-Z\d]{3}+$/";

$reg_phone = "/^[\d]{10}+$/";

$reg_cardNumber = "/^[\d]{4}[-][\d]{4}[-][\d]{4}[-][\d]{4}+$/";

$reg_cardDate = "/^[\d]{2}[-][\d]{4}$/";

$result = false;


if (isset($_POST['submit'])) {
    // Class 
    class Registration
    {
        public $regEmail;
        public $regPass;
        public $regCpass;
        public $regName;
        public $regPhone;

        // Getter
        function getUserEmail()
        {
            return $this->userEmailSet;
        }
        function getUserPass()
        {
            return $this->userPassSet;
        }
        function getUserConfirmPass()
        {
            return $this->userCPassSet;
        }
        function getUserName()
        {
            return $this->userNameSet;
        }
        function getUserPhone()
        {
            return $this->userPhoneSet;
        }


        // Setter
        function setUserEmail($regEmail)
        {
            $this->userEmailSet = $regEmail;
        }
        function setUserPass($regPass)
        {
            $this->userPassSet = $regPass;
        }
        function setUserCpass($regCpass)
        {
            $this->userCPassSet = $regCpass;
        }

        function setUserName($regName)
        {
            $this->userNameSet = $regName;
        }
        function setUserPhone($regName)
        {
            $this->userPhoneSet = $regName;
        }
    }

    // Value from the user Input 
    $userValueEmail = $_POST['email'];
    $userValueName = $_POST['fName'];
    $userValuePassword = $_POST['password'];
    $userValueConPassword = $_POST['cpassword'];
    $userValuePhone = $_POST['phone_number'];

    // Creating the Object of Username Class
    $obj = new Registration();

    // Setting the Value into the Object
    $obj->setUserEmail($userValueEmail);
    $obj->setUserPass($userValuePassword);
    $obj->setUserCpass($userValueConPassword);
    $obj->setUserName($userValueName);
    $obj->setUserPhone($userValuePhone);


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
        // Email
        if (preg_match($reg_email, $obj->getUserEmail())) {
            $email_error =  "Email address is valid";
            $email = $_POST['email'];
            $result = true;
        } else {
            $email_error = "ERROR: Email address is INVALID";
            $result = false;
        }

        // Password
        if (preg_match($reg_pass, $obj->getUserPass())) {
            $pass_error = "Password is valid";
            $pass = $obj->getUserPass();
            $result = true;
        } else {
            $pass_error = "ERROR: Password is INVALID";
            $result = false;
        }

        if ($obj->getUserConfirmPass() === $pass) {
            $cpass_error = "Password matched.";
            $cpass = $obj->getUserConfirmPass();
            $result = true;
        } else {
            $cpass_error = "ERROR: Password does not matches";
            $result = false;
        }


        // First Name
        if (preg_match($reg_fName, $_POST['fName'])) {
            $fname_error =  "Enter Name is in Correct format";
            $fname = $_POST['fName'];
            $result = true;
        } else {
            $fname_error =  "Enter Name is in INCORRECT format";
            $result = false;
        }


        // Phone
        if (preg_match($reg_phone, $_POST['phone_number'])) {
            $phone_error = "Phone number is Valid";
            $phone = $_POST['phone_number'];
        } else {
            $phone_error = "ERROR: Phone number is Invalid format";
            $result = false;
        }



        // ONLY WORKS when all the regular expression will be matched
        if ($result) {
            // Will now perform Database query

            // Inserting the Values Now
            try {
                $statement = $conn->prepare("INSERT INTO registration(email,password,cpassword,username,phone) 
                        VALUES(:email,:password,:cpassword,:username,:phone)");

                $insertEmail = $obj->getUserEmail();
                $insertPass = $obj->getUserPass();
                $insertCPass = $obj->getUserConfirmPass();
                $insertUserName = $obj->getUserName();
                $insertPhone = $obj->getUserPhone();

                // Password is encrypted here 
                $encrytPass = password_hash($insertPass, PASSWORD_BCRYPT);
                $encrytCPass = password_hash($insertCPass, PASSWORD_BCRYPT);

                $statement->bindParam(':email', $insertEmail);
                $statement->bindParam(':password', $encrytPass);
                $statement->bindParam(':cpassword', $encrytCPass);
                $statement->bindParam(':username', $insertUserName);
                $statement->bindParam(':phone', $insertPhone);


                // Checks if email already exists or not
                $emailCheckQuery = "select * from registration where email = '$insertEmail'";
                $stmtEmail = $conn->prepare($emailCheckQuery);
                $stmtEmail->execute();
                $value = $stmtEmail->rowCount();

                if ($value != 0) 
                {
                    $email = $pass = $cpass = $fname = $phone = "";
                    $all_error_msg ="This email is already registered. Try signing with different Email";
                } 
                else
                 {
                    $statement->execute();
                    $email = $pass = $cpass = $fname = $phone = "";
                    $all_error_msg = "Account Successfully Registered. Please Login Now...!";
                    
                }
            } 
             catch (PDOException $e) 
                    {
                        $all_error_msg = "Error: " . $e->getMessage();
                    }
                        
       }
    }

}
    if($all_error_msg != "")
    {
        echo "<script>alert('$all_error_msg');</script>"; 
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
            <h2>Create Account</h2>
            <p class="lead">It's free and hardly takes more than 30 seconds.</p>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                    <input type="email" name="email" class="form-control" name="email" placeholder="Email Address" required="required" value="<?php echo $email; ?>" autocomplete="off" title="xyz@xyz.com">
                </div>
                <span class="error_message"><?php echo $email_error; ?></span> </br>
   
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" value="<?php echo $pass; ?>" required title=" Minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character ">
                </div>
                <span class="error_message"><?php echo $pass_error; ?></span> </br>

            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i> <i class="fa fa-check"></i></span>
                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Re-enter your Password" required value="<?php echo $cpass; ?>">
                </div>
                <span class="error_message"><?php echo $cpass_error; ?></span> </br>


            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="fName" id="fname" placeholder="Enter Full Name" required value="<?php echo $fname; ?>">
                </div>
                <span class="error_message"><?php echo $fname_error; ?></span> </br>


            </div>

            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number" required title="Must be in this format 1231231234" value="<?php echo $phone; ?>">
                </div>
                <span class="error_message"><?php echo $phone_error; ?></span> </br>


            </div>


            <div class="form-group">
                <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Sign Up</button>
            </div>
            <p class="small text-center">By clicking the Sign Up button, you agree to our <br><a href="#">Terms &amp; Conditions</a>, and <a href="#">Privacy Policy</a>.</p>
        </form>
        <div class="text-center">Already have an account? <a href="login.php">Login here</a>.</div>
    </div>
</body>

</html>