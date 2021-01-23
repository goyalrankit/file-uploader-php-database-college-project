<?php
    session_start();


    error_reporting(0);
    if(!isset($_SESSION['email']))
    {
        header("Location: index.html");
    }


include 'link.php';
include 'header_logout.php';

include 'dbconn.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
 if (isset($_POST['submit'])) 
    {
    $errorMsg = "";
    $fileName  = $_FILES['file_upload'];
  

    // Checks the Size of File 
    if ($_FILES['file_upload']['size'] != 0) {

        $operationType = $_POST['operation'];
        
        try{
            $operationTable = $_POST['radio'];
        }
        catch(Exception $e)
        {}
        if($operationTable != "")
        {        }
        else
        {            $errorMsg = "Operation Aborted. Please select Table Option also.";
            $operationTable=null;        }
    
        $openedFile = fopen($_FILES['file_upload']['tmp_name'], "r");

        // Checks the type of File 
        if ($_FILES['file_upload']['type'] == "text/plain") 
        {

            if($operationTable == 'jobs')
            {
            while (!feof($openedFile)) {
                $eachLine = fgets($openedFile);

                if ($eachLine != "" && $eachLine != '\n') 
                {
                    $lineSplit = explode(",", $eachLine);
                }

               
                $query = "SELECT * FROM jobs where id ='$lineSplit[0]'";
                $stt = $conn->prepare($query);
                $resultSet = $stt->execute();
                $res= $stt->rowCount();

                switch ($operationType) {

                            case "insert":

                                if ($res != 0) {
                                    $errorMsg = "Job with this Id already exsits";
                                } else {
                                    try {
                                        $query = "INSERT INTO jobs values(?,?,?,?,?,?)";
                                        $parameters = [$lineSplit[0], $lineSplit[1], $lineSplit[2], $lineSplit[3], $lineSplit[4], $lineSplit[5]];
                                        $state = $conn->prepare($query);
                                        $res = $state->execute($parameters);

                                        $rowUpdated = $state->rowCount();

                                        if ($rowUpdated != 0) {
                                            $errorMsg = "  Row(s) Inserted ";
                                        } else {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                }
                                break;


                            case "delete":

                                if ($res != 0) {
                                    try {
                                        $query = "DELETE from jobs where id= '$lineSplit[0]'";

                                        $state = $conn->prepare($query);
                                        $rows = $state->execute();

                                        $val = $state->rowCount();

                                        if ($val != 0) {
                                            $errorMsg = " Row(s) Deleted ";
                                        } else {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                } else {
                                    $errorMsg = "Job with this Id does not exsits. 0 row Deleted";
                                }

                                break;


                            case 'update':
                                if ($res != 0) {
                                    try {
                                        $query = "UPDATE jobs SET id='$lineSplit[0]',name='$lineSplit[1]',date='$lineSplit[2]',location='$lineSplit[3]',pay='$lineSplit[4]',contact='$lineSplit[5]' where id='$lineSplit[0]'";

                                        $st = $conn->prepare($query);
                                        $rw = $st->execute();

                                        $ro = $st->rowCount();

                                        if ($ro != 0) {
                                            $errorMsg = " Updated : " . $ro . " row(s)";
                                        } else {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                } else {
                                    $errorMsg = "Job with this Id does not exsits. 0 row Updated";
                                }
                                break;

                            default:
                                $errorMsg = "No operation is Performed.";
                                break;
                        }
                    }
            }

            if($operationTable == 'users')
            {
            while (!feof($openedFile)) {
                $eachLine = fgets($openedFile);

                if ($eachLine != "" && $eachLine != '\n') 
                {
                    $lineSplit = explode(",", $eachLine);
                }

                $query = "SELECT * FROM users where userid ='$lineSplit[0]'";
                
                $stt = $conn->prepare($query);
                $resultSet = $stt->execute();
                $res= $stt->rowCount();
                
            
                switch ($operationType) {

                            case "insert":
                                if ($res != 0) {
                                    $errorMsg = "Users with this Id already exsits";
                                } else {
                                    try {
                                        $query = "INSERT INTO users values(?,?,?,?,?,?,?)";
                                   
                                        $parameters = [$lineSplit[0], $lineSplit[1], $lineSplit[2], $lineSplit[3], $lineSplit[4], $lineSplit[5], $lineSplit[6]];
                                        $state = $conn->prepare($query);
                                        $res = $state->execute($parameters);

                                        $rowUpdated = $state->rowCount();

                                        if ($rowUpdated != 0) 
                                        {
                                            $errorMsg = " Row(s) Inserted ";
                                        } else 
                                        {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                }
                                break;


                            case "delete":

                                if ($res != 0) {
                                    try {
                                        $query = "DELETE from users where userid= '$lineSplit[0]'";

                                        $state = $conn->prepare($query);
                                        $rows = $state->execute();

                                        $val = $state->rowCount();

                                        if ($val != 0) {
                                            $errorMsg = "  Row(s) Deleted ";
                                        } else {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                } else {
                                    $errorMsg = "User with this Id does not exsits. 0 row Deleted";
                                }

                                break;


                            case 'update':
                                if ($res != 0) {
                                    try {
                                        $query = "UPDATE users SET userid='$lineSplit[0]',jobid='$lineSplit[1]',fname='$lineSplit[2]',lname='$lineSplit[3]',location='$lineSplit[4]',gender='$lineSplit[5]',contact='$lineSplit[6]' where userid='$lineSplit[0]'";

                                        $st = $conn->prepare($query);
                                        $rw = $st->execute();

                                        $ro = $st->rowCount();

                                        if ($ro != 0) {
                                            $errorMsg = " Row(s) Updated ";
                                        } else {
                                            $errorMsg = "Operation Denied";
                                        }
                                    } catch (PDOException $e) {
                                        $errorMsg = $e->getMessage();
                                    }
                                } else {
                                    $errorMsg = "User with this Id does not exsits. 0 row Updated";
                                }
                                break;

                            default:
                                $errorMsg = "No operation is Performed.";
                                break;
                        }
                    }
            }
            
        }
        else 
            {
                $errorMsg = "Please upload only text file with extension .txt";
            }
        fclose($openedFile);
    } else 
        {
            $errorMsg = "File is Empty. Please upload a new file.";
        }

    }

    if($errorMsg != "")
    {    echo "<script>alert('$errorMsg')</script>"; }
}
   
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/register.css">
    <style>
        body {
            margin-top: 10px;
        }

        .signup-form {
            border-bottom: 5px solid #f6b024;
            border-top: 5px solid  darkmagenta;
            border-left:5px solid  gray;
            border-right:5px solid  lightsalmon;
            margin-top: 100px;
            padding: 20px;
            width: 50%;
        }

        .signup-form .formm label {
            color: grey;
            font-size: large;
            font-family: fantasy;
            padding: 10px;
            margin: 10px;
        }


        .radio 
        {
            border-radius: 10px;
            color: #000000;
            border: 5px solid  #000000;
        }


        .radio input
        {
            margin-left: 50px;
        }

        .radio label
        {
            border-radius: 10px;
            background-color: #f6b024;
          
            color: #000000;
            border-bottom: 5px solid #f6b024;
            border-top: 5px solid  darkmagenta;
            border-left:5px solid  gray;
            border-right:5px solid  lightsalmon;
        
        }
        


        .table_design {
            font-family: Arial, Helvetica, sans-serif;
            border: 3px solid grey;
            margin-top: 100px;
            margin-left: 50px;
            margin-right: 50px;
            padding: 20px;
            margin-bottom: 20px;            
        }

        .user_design {
            font-family: Arial, Helvetica, sans-serif;
            border: 3px solid grey;
            margin-top: 50px;
            margin-left: 50px;
            margin-right: 50px;
            padding: 20px;
            margin-bottom: 20px;            
  
        }

        .table_design .jobs
        {
            margin: auto;
        }


        .user_design .jobs
        {
            margin: auto;
        }



        .combo_design {
            font-family: Arial, Helvetica, sans-serif;
            border: 3px solid grey;
            margin-top: 50px;
            margin-left: 50px;
            margin-right: 50px;
            padding: 20px;
            margin-bottom: 20px;            
        }


        
        .table_design .jobs td,
        .user_design .jobs td,
        .combo_design .all td,
        .jobs th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .jobs tr:nth-child(even) 
        {
            background-color: lightslategray;
            color: whitesmoke;

        }

        .all tr:nth-child(even) 
        {
            background-color: lightslategray;
            color: whitesmoke;

        }


        .table_design
        .jobs 
        tr:hover {
            background-color: #ddd;
            color: #000000;
        }

        .user_design 
        .jobs 
        tr:hover 
        {
            background-color: #ddd;
            color: #000000;
        }

        .combo_design
        .all 
        tr:hover 
        {
            background-color: #ddd;
        color: #000000;
        }
        
        .jobs th {
            text-align: center;
            background-color: #f6b024;
            color: white;
            padding: 20px;
        }

        .job
        {
            text-align: center;
            margin-left: 10%;
            margin-right: 10%;
        } 



        .all
        {
            text-align: center;
            margin-left: 10%;
            margin-right: 10%;
        }

        .all th {
            text-align: center;
            padding: 20px;
            background-color: #f6b024;
            color: white;
        }

        .signup-form select
        {
            margin-bottom: 10px;
            background-color: black;
            color: #f6b024;
            border-radius: 10px;
            width: 100%;
            height: 40px;
        }

        .signup-form .btn
        {
            border: none;
            outline: none;
            height: 40px;
            color: #fff;
            font-size: 16px;
            float: right;
            background-color: #000000;
            cursor: pointer;
            border-radius: 20px;

        }



    </style>
</head>

<body>
    <div class="signup-form">
        <h1>Please Select the File </h1>
        <form name="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formm" enctype="multipart/form-data">

            <div id="data">
                <label>Select the File:</label>
                <input type="file" name="file_upload" class="dis" /><br />
            </div>

           <label> Please select the Table to perform Operation....!</label> 

           <div class="radio">
                <input type="radio" id="radio" name="radio" value="jobs">
                <label for="jobs">JOBS</label>
                <input type="radio" id="radio" name="radio" value="users">
                <label for="users">USERS</label><br>
            </div>

            <label> Select the Type of Operation you want to perform.</label>
            <br>

            <select id="opertaion" name="operation">
                <option name="" value=""></option>
                <option name="INSERT" value="insert">INSERT</option>
                <option value="delete">DELETE</option>
                <option value="update">UPDATE</option>
            </select>
            &nbsp; &nbsp; &nbsp;
            &nbsp; &nbsp; &nbsp;

            <div id="buttons">
                <label>&nbsp;</label>
                <input type="submit" value="Upload" name="submit" class="btn" /><br />
            </div>
        </form>
    </div>

    <div class="table_design">
  
        <h1>Jobs</h1>

        <table class="jobs">
            <tr>
                <th>Job Id</th>
                <th>Job Name</th>
                <th>Job Date</th>
                <th>Job Location</th>
                <th>Job Pay</th>
                <th>Job Contact</th>
            </tr>
            <tr>
                <?php
                $query = "SELECT * FROM JOBS";
                $stmt = $conn->prepare($query);
                $resultSet = $stmt->execute();

                if ($resultSet != null) {
                    while ($r = $stmt->fetch()) {
                        echo
                            "<tr><td>" . $r['id'] . "</td>" .
                                "<td>" . $r['name'] . "</td>" .
                                "<td>" .  $r['date'] . "</td>" .
                                "<td>" .   $r['location'] . "</td>" .
                                "<td>" . "$ " .  $r['pay'] . "/hr" . "</td>" .
                                "<td>" .  $r['contact'] . "</td></tr>";
                    }
                }

                ?>
            </tr>
        </table>
    </div>

    <div class="user_design">
        
        <h1>Users</h1>

        <table class="jobs">
            <tr>
                <th>User Id</th>
                <th>Job Id</th>
                <th>First-Name</th>
                <th>Last-Name</th>
                <th>Location</th>
                <th>Gender</th>
                <th>Contact</th>
            </tr>
            <tr>
                <?php
                $query = "SELECT * FROM users";
                $stmt = $conn->prepare($query);
                $resultSet = $stmt->execute();

                if ($resultSet != null) {
                    while ($r = $stmt->fetch()) {
                        echo
                            "<tr><td>" . $r['userid'] . "</td>" .
                                "<td>" . $r['jobid'] . "</td>" .
                                "<td>" . $r['fname'] . "</td>" .
                                "<td>" .  $r['lname'] . "</td>" .
                                "<td>" .   $r['location'] . "</td>" .
                                "<td>" .     $r['gender'] . "</td>" .
                                "<td>" .  $r['contact'] . "</td></tr>";
                    }
                }

                ?>
            </tr>
        </table>
    </div>
    
    <div class="combo_design">        
        <h1>Applied Jobs</h1>
        <table class="all">
            <tr>
                <th>User Id</th>
                <th>Job Id</th>
                <th>UserName</th>
                <th>Contact</th>
                <th>Job Title</th>
                <th>Job Location</th>
                <th>Job Pay</th>
                <th>Job Date</th>
            </tr>
            <tr>
                <?php
                $query = "SELECT u.userid, u.jobid, CONCAT(u.fname,' ',u.lname)AS 'Username', u.contact,j.name,j.location,j.pay,j.date from users u, jobs j WHERE u.jobid = j.id";
                $stmt = $conn->prepare($query);
                $resultSet = $stmt->execute();

                if ($resultSet != null) {
                    while ($r = $stmt->fetch()) {
                        echo
                            "<tr><td>" . $r['userid'] . "</td>" .
                                "<td>" . $r['jobid'] . "</td>" .
                                "<td>" . $r['Username'] . "</td>" .
                                "<td>" . $r['contact'] . "</td>" .
                                "<td>" . $r['name'] . "</td>" .                            
                                "<td>" . $r['location'] . "</td>" .
                                "<td>" . $r['pay'] . "</td>".
                                "<td>" . $r['date'] . "</td></tr>";                       
                    }
                }
                ?>
            </tr>
        </table>
    </div>
</body>
</html>