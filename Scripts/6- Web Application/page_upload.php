<?php 
$servername = "localhost";
$username = "root";
$password = "usbw";
$dbname = "project1";

$conn=new mysqli($servername, $username, $password, $dbname);
$printResult="";

if($conn->connect_error)
{
    die("Connection error: " . $conn->connect_error);
}
else
{
  
    DB_insert($conn);
    DB_select($conn);
    $conn->close();
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
    body {
        background-image: url("https://img.freepik.com/free-vector/white-background-with-blue-tech-hexagon_1017-19366.jpg?w=740&t=st=1657241247~exp=1657241847~hmac=1992f907bd08120a530ed22dd1d34cf83cb769b99331b5d4468bce486b36d754");
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

    input[type="text"],
    input[type="number"] {
        text-align: center;
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

    input[type="button"] {
        background-color: #a61e4d;
        color: #eee;
        padding: 15px 25px;
        border: none;
    }

    input[type="button"]:hover {
        background-color: #d6336c;
    }

    input[type=email] {
        width: 25%;
    }

    input[name="addrs"] {
        width: 50%;
    }

    fieldset {
        margin-left: auto;
        margin-right: auto;
        display: inline-flexbox;
        align-content: center;
        width: 50vh;
        padding: 20px;
        margin-top: 50px;
    }

    legend {
        color: rgb(20, 82, 82);
        font-size: 50;
        text-align: center;
        padding: 0px 15px;
        margin-bottom: 10px;
    }

    form {
        align-content: center;
    }

    .Result {
        font-size: 100px;
        margin: 0;
        font-weight: bold;
    }

    .Accuracy {
        font-size: 22px;
    }
    </style>



    <fieldset style="width: 100vh;">

        <legend>Patient Form</legend>

        <form name="MyF" method="post" onsubmit="return validationMAxlingth()">
            <center>
                <label for="PID">Patient ID</label>
                <br>
                <input type="text" id="PID" name="PID" required>
                <br><br>

                <label for="Page">Patient Age</label>
                <br>
                <input type="number" id="Page" name="Page">
                <br><br>

                <label for="tumorstage">Stages of Treatment</label>
                <br>
                <input type="number" id="tumorstage" name="tumorstage">
                <br><br>

                <label for="UI">User ID</label>
                <br>
                <input type="text" id="UI" name="UI" required>
                <br><br>

                <label for="stagedate">Date of First Stage</label>
                <br>
                <input type="date" id="stagedate" name="stagedate">
                <br><br>

                <label for="folder">Select Folder</label>
                <br>
                <input type="text" id="folder" name="folder" placeholder="path//to//folder" style="width: 70%" />
            </center>


            <center>
                <br><br>
                <input type="submit" name="Submit">
                <br>
                <input type="submit" name="show" value="Show Result">
                

            </center>

        </form>
    </fieldset>

    <?php echo $printResult?>


    <script>
    function validationMAxlingth() {
        var x = document.forms["MyF"]["tumorstage"].value;
        if (x < 2) {
            alert(" Tumor Stage not valid")
            //return false;
        }
    }
    </script>

    </body>

    <?php
exit();
$printResult = "";

function DB_insert($conn)
{
  $printResult = "";
    if(isset($_POST["Submit"]))
    {
      
          $PatientID= $_POST['PID'];
          $PatientAge = $_POST['Page'];
          $StagesOfTreatment= $_POST['tumorstage'];
          $UserID = $_POST['UI'];
          $StageData= $_POST['stagedate'];
          $path= $_POST['folder'];
          $output=shell_exec("python Predict.py $path");
          //print_r (explode(" ",$Result));
          if($output != ""){
            $finalResult= explode(" ",$output);
            $Result= $finalResult[10];
            $Accuracy= $finalResult[14];
          }
        else{
            $Result= "";
            $Accuracy= "";
            $GLOBALS["printResult"] .= "<center><br><br><br>Something wrong happend!</center>";
        }
          
          
      if(!(empty($PatientID) && empty($PatientAge) && empty($StagesOfTreatment)&& empty($UserID)))
        {
          $sql="INSERT INTO patient(PatientID, PatientAge, StagesOfTreatment, UserID, StageData, Result, Accuracy)
                VALUES('$PatientID', '$PatientAge' , '$StagesOfTreatment','$UserID','$StageData','$Result', '$Accuracy')";
              
            
          if($conn->query($sql) === TRUE )
            {
              $GLOBALS["printResult"] .= "<center><br><br><br>New record from input form created successfully<br></center>";
          }
          else
          {
            $GLOBALS["printResult"] .= "<center><br><br><br>Error in insert</center>";
          }

        }
    }
}

function DB_select($conn)
{
  
  if(isset($_POST["show"]))
    {
      
          $PatientID= $_POST['PID'];
          $UserID = $_POST['UI'];
          
          
      if(!(empty($PatientID) && empty($UserID)))
        {
          $sql2="SELECT * FROM patient;";
          $result=$conn->query($sql2);
            
          if($result->num_rows > 0)
          {
            while($row = $result->fetch_assoc()) {
              if($row["PatientID"]== $PatientID){
                $GLOBALS["printResult"] .= "<fieldset>
                <legend>Result</legend>
                <center>
                <p class= \"Result\">" . $row["Result"]. "</p>
                <p class= \"Accuracy\">With Accuracy " . $row["Accuracy"]. "%</p><br/>
                </center>
                </fieldset>
                ";
              }
            }
          }
          else
          {
            $GLOBALS["printResult"] .= "<center>Error in select from database<br></center>";
          }
        }
      }
}

?>

</html>