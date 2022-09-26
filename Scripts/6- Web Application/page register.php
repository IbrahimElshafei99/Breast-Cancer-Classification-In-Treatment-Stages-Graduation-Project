<?php 
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "project1";

$conn=new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error)
{
    die("Connection error: " . $conn->connect_error);
}
else
{
    //echo $dbname . "DB Connected successfully<br>";
    
    DB_insert($conn);
    //$action = $_POST["db"];
 // echo $action;
  /*if(isset($_POST["Register"]) && $action == 'insert' )
  {
      echo "submited and insert";
  DB_insert($conn);
  }*/
  
 
    $conn->close();
}
?>
<!-- saved from url=(0062)file:///E:/Fourth%20Level%20Term%202/Bioserver/Untitled-2.html -->
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
    body {
        background-image: url("https://img.freepik.com/free-vector/white-background-with-blue-tech-hexagon_1017-19366.jpg?w=740&t=st=1657241247~exp=1657241847~hmac=1992f907bd08120a530ed22dd1d34cf83cb769b99331b5d4468bce486b36d754");
        /*background-repeat: no-repeat;*/
        background-size: cover;
        font-family: 'Montserrat', sans-serif;
    }

    input,
    select {

        padding: 10px 15px;
        border: 3px solid rgb(20, 82, 82);
        border-radius: 100px;
    }



    label,
    select {
        color: rgb(20, 82, 82);
        font-weight: bold;
        font-size: 17;


    }


    input[type=submit] {
        width: 25%;
        height: 5%;
        background-color: rgb(20, 82, 82);
        color: white;
        padding: 7px 10px;
        margin: 8px 180;
        border: none;
        border-radius: 1000px;
        cursor: pointer;
    }

    input[type=email] {
        width: 25%;
    }

    input[name="addrs"] {
        width: 50%;
    }

    input[type="text"],
    input[type="number"],
    input[type="password"] {
        text-align: center;
    }




    fieldset {
        margin-left: auto;
        margin-right: auto;
        display: inline-flexbox;
        width: 100vh;
    }

    legend {
        color: rgb(20, 82, 82);
        font-size: 50;
        text-align: center;
        padding: 0px 15px;
        margin-bottom: 10px;
    }
    </style>






    <fieldset>

        <legend> User Information </legend>




        <form name="MyForm" method="post" onsubmit="return validationn()">
            <center>
                <label for="fname">First Name</label>
                <br>
                <input type="text" id="fname" name="fname">
                <br>
                <br>
                <label for="mname">Middle Name</label>
                <br>
                <input type="text" id="mname" name="mname">
                <br>
                <br>
                <label for="lname">Last Name</label>
                <br>
                <input type="text" id="lname" name="lname">
                <br>
                <br>
                <label for="UI">User ID:</label>
                <br>
                <input type="text" id="UI" name="UI">
                <br>
                <br>
                <label for="age">Age</label>
                <br>
                <input type="number" id="age" name="age">
                <br>
                <br>
                <label for="phone">Phone Number</label>
                <br>
                <input type="number" id="phone" name="phone">
                <br>
                <br>
                <label for="em">Email</label>
                <br>
                <input type="email" id="em" name="em" required="">
                <br>
                <br>
                <label for="pass">Password</label>
                <br>
                <input type="password" id="pass" name="pass">
                <br>
                <br>
                <h2 style="color: rgb(20, 82, 82); font-weight: bold; font-size: 17; ">Gender</h2>
                &nbsp; <input type="radio" id="male" name="e" value="Male">
                &nbsp; <label for="male">Male</label>
                &nbsp; <input type="radio" id="female" name="e" value="Female">
                &nbsp; <label for="female">Female</label>
                <br>
                <br>
            </center>
            <center>
                <br>
                <input type="submit" name="Register" id="db">
            </center>
        </form>
    </fieldset>


    <script>
    function validationn() {
        var x = document.forms["MyForm"]["fname"].value;
        var y = document.forms["MyForm"]["mname"].value;
        var z = document.forms["MyForm"]["lname"].value;
        var kk = k.length;
        var j = document.forms["MyForm"]["phone"].value;
        var jj = j.length;
        if (x == "") {
            alert("The firs name must be filled out")
            return false;
        } else if (y == "") {
            alert("The middle name must be filled out")
            return false;
        } else if (z == "") {
            alert("The last name must be filled out")
            return false;
        } else if (jj < 11 || jj >= 12) {
            alert("The phone number not valid")
            return false;
        }
    }
    </script>
    </body>
    <?php



function DB_insert($conn)
{
    //echo "Insert Query from Input form!<br>";
    
    if(isset($_POST["Register"]))
    {
      
      $FirstName = $_POST['fname'];
      $MiddleName = $_POST['mname'];
      $LastName= $_POST['lname'];
      $UserID = $_POST['UI'];
      $Age = $_POST['age'];
      $PhoneNumbber	= $_POST['phone'];
      $Email = $_POST['em'];
      $Password = $_POST['pass'];
      
      if(!(empty($FirstName) && empty($MiddleName) && empty($LastName)&& empty($UserID)&& empty($Age)&& empty($PhoneNumbber)&& empty($Email)&& empty($Password)))
        {
          
          $Gender = $_POST['e'];
          $sql="INSERT INTO user(FirstName, MiddleName, LastName,UserID,Age,PhoneNumbber,Email,Password,Gender) VALUES('$FirstName' , '$MiddleName' , '$LastName','$UserID','$Age','$PhoneNumbber','$Email','$Password','$Gender')";
          
          

            if($conn->query($sql) === TRUE )
            {
              
                echo "New record from input form created successfully<br>";
                header("location:page_upload.php");
            }
            else
            {
                echo "Error in insert: ";
            }

            
        }
    }
}




?>

</html>