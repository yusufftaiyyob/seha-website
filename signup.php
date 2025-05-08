<?php 
require_once("DBConnection.php");
include("functions.php");
session_start();
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
  <title>Sign Up</title>
  <style>
    h1 {
      text-align: center;
      font-size: 2.5em;
      font-weight: bold;
      padding-top: 1.2em;
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

    input[type=radio],
    select {
      width: max-content;
      padding: 5px;
      margin-top: 20px;
      margin-bottom: 20px;
      margin-left: 30px;
      margin-right: 5px;
    }

    textarea {
      height: 80px;
    }

    #err {
      display: none;
      padding: 1.5em;
      padding-left: 4em;
      font-size: 1.2em;
      font-weight: bold;
      margin-top: 1em;
    }

    .error {
      color: #FF0000;
    }
  </style>

</head>

<body>
<!-- php code -->
  <?php
  $nameErr = $emailErr = $phoneErr = $passwordErr = $repasswordErr = "";
  $NOID = $username = $email = $password = $repassword = "";
  global $validate;

  if(isset($_POST['submit'])){

    if(empty($_POST['NOID'])){
      $NOIDErr = "Please Enter Employee ID";
      $validate = false;
    }
    else{
      $employee_id = mysqli_real_escape_string($conn,$_POST['NOID']);
      $validate = true;
    }

    if(empty($_POST['username'])){
      $nameErr = "Please Enter Username";
      $validate = false;
    }
    else{
      $username = mysqli_real_escape_string($conn,$_POST['username']);
      $validate = true;
    }

    if(empty($_POST['email'])){
      $emailErr = "Please Enter Email";
      $validate = false;
    }
    else{
      $email = mysqli_real_escape_string($conn,$_POST['email']);
      $validate = true;
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $emailErr = "Please Enter valid email";
        $validate = false;
      }
    }

    if(empty($_POST['password'])){
      $passwordErr = "Please Enter Password";
      $validate = false;
    }
    else{
      $password = mysqli_real_escape_string($conn,$_POST['password']);
      $validate = true;
    }
    
    if(empty($_POST['repassword'])){
      $repasswordErr = "Please Enter re-password";
      $validate = false;
    }
    else{
      $repassword = mysqli_real_escape_string($conn,$_POST['repassword']);
      $validate = true;
      if($password !== $repassword){
        $repasswordErr = "Password and Confirm Password don't match";
        $validate = false;
      }
    }

    $system = $_POST['system'];
    $dept = $_POST['department'];
    $type = 'employee';
  
 
    if($validate){
      signup($employee_id,$username,$email,$password,$repassword,$system,$dept,$type,$conn);
    }
  }

ini_set('display_errors', true);
error_reporting(E_ALL);
  ?>


  <!-- navbar -->
  <nav class="navbar header-nav navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Application Access System in ICT PKNP</a>

      <a id="register" href="index.php">Home</a>
    </div>
  </nav>

  <h1>Registration Form</h1>

  <div class="container">
    <div class="alert alert-danger" id="err" role="alert">
    </div>
  
    <!--form-->
    <form method="POST" autocomplete="off">
  
      <!--Name-->
      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="NOID" id="NOID" value="<?php echo $NOID; ?>"placeholder="NOID">
        <label for="Employee ID">Employee ID</label>
        <span class="error"><?php echo $nameErr; ?></span>
      </div>
  
      <!--username-->
      <div class="form-floating mb-3">
        <input type="text" class="form-control" name="username" id="username" value="<?php echo $username; ?>"placeholder="Username">
        <label for="username">Username</label>
        <span class="error"><?php echo $nameErr; ?></span>
      </div>
  
      <!--Email id-->
      <div class="form-floating mb-3">
        <input class="form-control" type="text" name="email" id="email" value="<?php echo $email; ?>" placeholder="Enter your email">
        <label for="email">Email address</label>
        <span class="error"><?php echo $emailErr; ?></span>
      </div>
    
      <!--Password.-->
      <div class="form-floating mb-3">
        <input class="form-control" type="password" name="password" id="password" value="<?php echo $password; ?>" placeholder="Enter your password">
        <label for="password">Password</label>
        <span class="error"><?php echo $passwordErr; ?></span>
      </div>

      <!--Confirm Password.-->
      <div class="form-floating mb-3">
        <input class="form-control" type="password" name="repassword" id="confirmPassword" value="<?php echo $repassword ?>" placeholder="Re-Enter password">
        <label for="confirmPassword">Confirm Password</label>
        <span class="error"><?php echo $repasswordErr; ?></span>
      </div>
  
      <br>
  
      <div class="row">
  
      <div class="col-5">
      <label for="system">System:</label>
      <select id="system" name="system">
      <option>-------Please Select-------</option>
        <option>Harta Sewa</option>
        <option>HR System</option>
        <option>HRMIS</option>
        <option>Kewangan (DMS)</option>
        <option>Laporan MyID</option>
        <option>MyMesyuarat</option>
        <option>Pemantauan Jualan</option>
        <option>Pembekal</option>
        <option>Pencarian Fail</option>
        <option>Pendaftaran Usahawan</option>
        <option>Pengurusan Aset (SPA/SPS)</option>
        <option>Program Usahawan (EMS)</option>
        <option>Project Management</option>
        <option>SewaIndustri</option>
        <option>Sistem Tanah (PSK)</option>
        <option>Status Bayaran DMS</option>
        <option>Stok PKNP</option>
        <option>Undi Calon MBJ</option>
      </select>
      </div>
  
      <div class="col-7">
      <label>Department : </label>
      <select name="department">
      <option>-------Please Select-------</option>
        <option>Pejabat Ketua Pegawai Eksekutif</option>
        <option>Bahagian Pembangunan Hartanah</option>
        <option>Bahagian Pentadbiran & Sumber Manusia</option>
        <option>Bahagian Khidmat Perundangan</option>
        <option>Unit Audit Dalam</option>
        <option>Bahagian Pemasaran & Pengurusan Harta</option>
        <option>Bahagian Pembangunan Komuniti & Keusahawanan</option>
        <option>Bahagian Perindustrian</option>
        <option>Bahagian Kewangan</option>
        <option>Bahagian Hal Ehwal Korporat (BHEK)</option>
        <option>Bahagian Teknik</option>
        <option>Bahagian ICT</option>
        <option>Unit Pemantauan Perniagaan (UPP)</option>
        <option>Unit Pengurusan Kualiti, Risiko & Integriti (KRI)</option>
      </select>
      </div>
  
      </div>
  
      
  
      <br>
  
      <input type="submit" name="submit" value="Submit" class="btn btn-success">
    </form>
  </div>



  <!--Footer-->
  <footer class="footer navbar navbar-expand-lg navbar-light bg-light" style="color:white;">
  <div>
    <p class="text-center">&copy; <?php echo date("Y"); ?> - Pahang State Development Corporation (PKNP)</p>
      <p class="text-center">Developed by ICT Department</p>
    </div>
  </footer>


</body>

</html>