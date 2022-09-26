<!DOCTYPE html>
<html>

<head>
    <img class="Logo" src="WebLogo2.png" alt="Personal Photo">
    <style>
    body {
        background-image: url("https://img.freepik.com/free-vector/white-background-with-blue-tech-hexagon_1017-19366.jpg?w=740&t=st=1657241247~exp=1657241847~hmac=1992f907bd08120a530ed22dd1d34cf83cb769b99331b5d4468bce486b36d754");
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
    }

    .Logo {
        position: absolute;

        top: 0;
        width: 15%;
        display: block;
        margin-left: auto;
        margin-right: auto;
        border-radius: 0 0 30px 30px;
    }

    a {
        color: rgb(20, 82, 82);
        ;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid rgb(20, 82, 82);
        ;
        border-color: rgb(20, 82, 82);
        background-color: #FFFFFF;
        ;
        color: rgb(20, 82, 82);
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button.ghost {
        color: #FFFFFF;

        background-color: transparent;
        border-color: #FFFFFF;
        cursor: pointer;
    }

    form {
        background-color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: #eee;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
        border-radius: 100px;
    }

    input[type="submit"] {
        cursor: pointer;
    }

    .classN {
        border-radius: 10px;

        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .form-classN {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .sign-in-classN {
        left: 0;
        width: 50%;
        z-index: 2;
    }




    .overlay-classN {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
    }

    .classN.right-panel-active .overlay-classN {
        transform: translateX(-100%);
    }

    .overlay {
        background: linear-gradient(to right, rgb(142, 188, 188), rgb(20, 82, 82));
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #FFFFFF;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
    }

    .classN.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .classN.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .classN.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    * {
        box-sizing: border-box;
    }
    </style>
</head>

<div class="classN" id="classN">

    <div class="form-classN sign-in-classN">

        <form method="post" action="page_upload.php">
            <h1 style="color: rgb(20, 82, 82);">Hi Doctor!</h1>
            <input type="email" placeholder="email" />
            <input type="password" placeholder="Password" />
            <a href="#">Forgot your password?</a>
            <input type="submit">
        </form>
    </div>
    <div class="overlay-classN">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
            </div>
            <div class="overlay-panel overlay-right">
                <h2>New here?</h2>
                <p>Sign up and be able to detect chemotherapy is effective in your patients or not!</p><br><br>
                <button class="ghost" id="signUp" onclick="window.location.href=' page Register.php'">Sign Up</button>
            </div>
        </div>
    </div>
</div>
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
}
?>

</html>