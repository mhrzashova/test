<?php
//register button click gare paxi k kam garne
if(isset($_POST['register'])) // isset is click, submit vako ho ki haina check garxa
{
    //Variable declare gareko for collecting input fields from form
    $full_name=$_POST['full_name'];
    $email=$_POST['email'];
    $phone=$_POST['phone'];
    $birth_date=$_POST['birth_date'];
    $gender=$_POST['gender'];
    $batch=$_POST['batch'];
    $semester=$_POST['semester'];
    // md5 encryption for password
    $password=md5($_POST['password']);

    //Database ko Path
    $connection = new mysqli("localhost","root","", "admin");// Checking Database Connection
    if($connection->connect_errno!=0) //0 means connected
    {
        die("Database Connectivity Error");
    }

    // Insert garna SQL Query
    $sql="INSERT INTO users(full_name ,email, password, gender, birth_date, batch, semester, phoneno)
    VALUES ('$full_name','$email','$password','$gender','$birth_date','$batch','$semester','$phone')"; 
    //query execution
    $result=$connection->query($sql);
    if($result)
    {
        header("Location:login.php"); 
    }
    else
    { 
      echo("<script> alert('User Already Exists or Please Try Again');</script>");
    }

}
?>


<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="register.css" />
    <link rel="stylesheet" href="fontawesome/css/all.min.css"/>

  <!-- JS Start -->
  <script>
      document.addEventListener("DOMContentLoaded", function() {
        var password = document.querySelector('input[name="password"]');
        var confirm = document.querySelector('input[name="confirm"]');
        var form = document.querySelector("form");
        // value collect gareko password rw confirm password ko for comparision

        form.addEventListener("submit", function(event) {
          // form submit gareko action lai leko
          if (password.value !== confirm.value) {
            // Prevent form submission
            event.preventDefault(); 
            //password re confirm password match vayena vanera dekhako
            showError("Password and confirm password do not match");
            //showError ko function call vako xa
          }
        });
        
        //yesko paxi ko right ko ma xa
        function showError(message) {
          //showError vanne function banako
          var errorContainer = document.createElement("div");
          // error-message class vako div ma password match navako msg set gardeko
          errorContainer.classList.add("error-message");
          errorContainer.textContent = message;

          // Remove existing error message if any
          var existingError = document.querySelector(".error-message");
          if (existingError) {
            existingError.remove();
          }

          // Append error message to the form
          form.appendChild(errorContainer);
        }
      });
  </script>
  </head>
  <body>
    <section class="container">
      <header> User Registration Form</header>
      <a href="login.php">Already a Member?</a>
      <form action="register.php" method="post" class="form" autocomplete="off">
        <div class="input-box">
          <label>Full Name</label>
          <input type="text" placeholder="Enter full name" name="full_name" pattern="^[A-Za-z\s]+$" value="<?php if(isset($_POST['register'])) {echo $full_name;} ?>" required />
        </div>

        <div class="input-box">
          <label>Email Address</label>
          <input type="email" placeholder="Enter email address" name="email" required />
        </div>

        <div class="column">
          <div class="input-box">
            <label>Phone Number</label>
            <input type="text" placeholder="Enter phone number" pattern="^\d{10}$" name="phone" required />
          </div>
          <div class="input-box">
            <label>Birth Date</label>
            <input type="date" placeholder="Enter birth date" max="<?php echo(date("Y-m-d"));?>" name="birth_date" value="<?php if(isset($_POST['register'])) {echo $birth_date;} ?>" required />
          </div>
        </div>
        <div class="gender-box">
          <h3>Gender</h3>
          <div class="gender-option">
            <div class="gender">
              <input type="radio" id="check-male" name="gender" value="male" checked />
              <label for="check-male">male</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-female" name="gender" value="female"/>
              <label for="check-female">Female</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-other" name="gender" />
              <label for="check-other">prefer not to say</label>
            </div>
          </div>
        </div>
        <div class="input-box address">
          <label>Academic Details</label>
          
          <div class="column">
            <div class="select-box">
              <select name="batch">
                <option hidden>Batch</option>
                <option value="2075">2075 BS</option>
                <option value="2076">2076 BS</option>
                <option value="2077">2077 BS</option>
                <option value="2078">2078 BS</option>
                <option value="2079">2079 BS</option>
                <option value="2080">2080 BS</option>
              </select>
            </div>
            <div class="select-box">
              <select name="semester">
                <option hidden>Semester</option>
                <option value="First">First</option>
                <option value="Second">Second</option>
                <option value="Third">Third</option>
                <option value="Fourth">Fourth</option>
                <option value="Fith">Fith</option>
                <option value="Sixth">Sixth</option>
                <option value="Seventh">Seventh</option>
                <option value="Eigth">Eigth</option>
              </select>
            </div>
            </div>
          <div class="column">
            <input type="password" name="password" pattern="^.{8,}$" placeholder="Enter Your Password" required />
            <input type="password" name="confirm" pattern="^.{8,}$" placeholder="Confirm Password" required />
            <div class="error-message" id="password-error"></div>
            <!-- password match vayena vane js use garera msg dinxa ki password
            re comfirm password match vako xaina
            yesle garda page reload hudaina, user le feri form bharnu pardaina -->
          </div>
        </div>
        <button type="submit" name="register">Submit</button>
      </form>
    </section>
  </body>
</html>