<?php
require_once("DBConnection.php");
session_start();
global $row;
if(!isset($_SESSION["sess_user"])){
  header("Location: index.php");
}
else{
?>

<?php 
  $reasonErr = $absenceErr = "";
  global $leaveApplicationValidate;
  if(isset($_POST['submit'])){
    if(empty($_POST['absence'])){
      $absenceErr = "Please select system access type";
      $leaveApplicationValidate = false;
    }
    else{
      $arr = $_POST['absence'];
      $absence = implode(",",$arr);
      $leaveApplicationValidate = true;
    }

    if(empty($_POST['fromdate'])){
      $fromdateErr = "Please Enter starting date";
      $leaveApplicationValidate = false;
    }
    else{
      $fromdate = mysqli_real_escape_string($conn,$_POST['fromdate']);
      $leaveApplicationValidate = true;
    }

    if(empty($_POST['todate'])){
      $todateErr = "Please Enter ending date";
      $leaveApplicationValidate = false;
    }
    else{
      $todate = mysqli_real_escape_string($conn,$_POST['todate']);
      $leaveApplicationValidate = true;
    }

    
    $reason = mysqli_real_escape_string($conn,$_POST['reason']);
    if(empty($reason)){
      $reasonErr = "Please give reason for the system access in detail";
      $leaveApplicationValidate = false;
    }
    else{
      $absencePlusReason = $absence." : ".$reason;
      $leaveApplicationValidate = true;
    }
    
    $status = "Pending";
    
    if($leaveApplicationValidate){
      //for eid
      $username = $_SESSION["sess_user"];
      $eid_query = mysqli_query($conn,"SELECT id FROM users WHERE name='".$username."'");
      
      $row = mysqli_fetch_array($eid_query);
      
      $query = "INSERT INTO `system` (eid, ename, descr, `from date`, `to date`, status) 
          VALUES ({$row['id']}, '{$username}', '$absencePlusReason', '$fromdate', '$todate', '$status')";

      $execute = mysqli_query($conn,$query);

      if($execute){
        echo '<script>alert("System Access Application Submitted. Please wait for approval status!")</script>';
      }
      else{
        echo "Query Error : " . $query . "<br>" . mysqli_error($conn);;
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  <link rel="stylesheet" href="css/style.css">
  <title>System Access Application ICT PKNP</title>
  <style>
    h1 {
      text-align: center;
      font-size: 2.5em;
      font-weight: bold;
      padding-top: 1em;
      margin-bottom: -0.5em;
    }

    form {
      padding: 40px;
    }

    input,
    textarea {
      margin: 5px;
      font-size: 1.1em !important;
      outline: none;
    }

    label {
      margin-top: 2em;
      font-size: 1.1em !important;
    }

    label.form-check-label {
      margin-top: 0px;
    }

    #err {
      display: none;
      padding: 1.5em;
      padding-left: 4em;
      font-size: 1.2em;
      font-weight: bold;
      margin-top: 1em;
    }

    table{
      width: 90% !important;
      margin: 1.5rem auto !important;
      font-size: 1.1em !important;
    }

    .error{
      color: #FF0000;
    }
  </style>

  <script>
    const validate = () => {

      let desc = document.getElementById('leaveDesc').value;
      let checkbox = document.getElementsByClassName("form-check-input");
      let errDiv = document.getElementById('err');

      let checkedValue = [];
      for (let i = 0; i < checkbox.length; i++) {
        if(checkbox[i].checked === true)
          checkedValue.push(checkbox[i].id);
      }

      let errMsg = [];

      if (desc === "") {
        errMsg.push("Please enter the reason and date of System Access");
      }

      if(checkedValue.length < 1){
        errMsg.push("Please select the type of System Access");
      }

      if (errMsg.length > 0) {
        errDiv.style.display = "block";
        let msgs = "";

        for (let i = 0; i < errMsg.length; i++) {
          msgs += errMsg[i] + "<br/>";
        }

        errDiv.innerHTML = msgs;
        scrollTo(0, 0);
        return;
      }
    }
  </script>

</head>

<body>
  <!--Navbar-->
  <nav class="navbar header-nav navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">System Access Application ICT PKNP</a>
      <ul class="nav justify-content-end">
           
            <li class="nav-item">
                <a class="nav-link" href="myhistory.php" style="color:white;">My System Access Status</a>
            </li>
            <li class="nav-item">
            <button id="logout" onclick="window.location.href='logout.php';">Log out</button>
            </li>
            </ul>

      
    </div>
  </nav>


  <h1>System Access Application ICT PKNP</h1>

  <div class="container">
    <div class="alert alert-danger" id="err" role="alert">
    </div>
  
    <form method="POST">
      
  
      <label><b>Select System Access Type :</b></label>
      <!-- error message if type of absence isn't selected -->
      <span class="error"><?php echo "&nbsp;".$absenceErr ?></span><br/>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="New Employee" id="New Employee">
        <label class="form-check-label" for="New Employee">
        New Employee
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="Temporary Access" id="Temporary Access">
        <label class="form-check-label" for="Temporary Access">
        Temporary Access
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="Auditing" id="Auditing">
        <label class="form-check-label" for="Auditing">
        Auditing
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="External Users" id="External Users">
        <label class="form-check-label" for="External Users">
        External Users
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="Performance Reviews" id="Performance Reviews">
        <label class="form-check-label" for="Performance Reviews">
        Performance Reviews
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="Data Analysis" id="Data Analysis">
        <label class="form-check-label" for="Data Analysis">
        Data Analysis
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="System Maintenance" id="System Maintenance">
        <label class="form-check-label" for="System Maintenance">
        System Maintenance
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" name="absence[]" type="checkbox" value="Others" id="Others">
        <label class="form-check-label" for="Others">
          Others
        </label>
      </div>
  
      <div class="mb-3 ">
        <label for="dates"><b>From -</b></label>
        <input type="date" name="fromdate">
  
        <label for="dates"><b>To -</b></label>
        <input type="date" name="todate">
      </div>
  
      <div class="mb-3">
        
        <label for="leaveDesc" class="form-label"><b>Please mention reasons for your system access :</b></label>
        <!-- error message if reason of the leave is not given -->
        <span class="error"><?php echo "&nbsp;".$reasonErr ?></span>
        <textarea class="form-control" name="reason" id="leaveDesc" rows="4" placeholder="Enter Here..."></textarea>
      </div>
  
  
      <input type="submit" name="submit" value="Submit System Access Request" class="btn btn-success">
    </form>
  
    
  </div>

  <footer class="footer navbar navbar-expand-lg navbar-light bg-light" style="color:white;">
    <div>
    <p class="text-center">&copy; <?php echo date("Y"); ?> - Pahang State Development Corporation (PKNP)</p>
      <p class="text-center">Developed by ICT Department</p>
    </div>
  </footer>

</body>

</html>

<?php
}

ini_set('display_errors', true);
error_reporting(E_ALL);
?>