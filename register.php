<?php
    
    $showAlert = false; 
    $showError = false; 
    $exists=false;
        
    if($_SERVER["REQUEST_METHOD"] == "POST") {
          
        // Include file which makes the Database Connection.
        include('config/constants.php');   
        
        $username = $_POST["username"]; 
        $password = $_POST["password"]; 
        $cpassword = $_POST["cpassword"];
        $customer_name=$_POST["customer_name"];
        $customer_email=$_POST["customer_email"];
        $customer_contact=$_POST["customer_contact"];
        $customer_address=$_POST["customer_address"];
        
        // Validate password length and contents
        if(strlen($password) < 8 || !preg_match('/\d/', $password)) {
            $showError = "Password must be at least 8 characters long and contain at least one number.";
        } else if($password != $cpassword) {
            $showError = "Passwords do not match";
        } else {
            // Validate email format
            if(!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
                $showError = "Invalid email format";
            } else {
                // Validate phone number length
                if(strlen($customer_contact) != 10) {
                    $showError = "Phone number must be 10 digits long";
                } else {
                    // This sql query is use to check if the username is already present or not in our Database
                    $sql = "Select * from users where username='$username'";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result); 

                    if($num == 0) {
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        
                        // Password Hashing is used here. 
                        $sql = "INSERT INTO users (username, password, customer_name, customer_email, customer_contact, customer_address) VALUES ('$username', '$hash', '$customer_name', '$customer_email', '$customer_contact', '$customer_address')";
                        
                        $result = mysqli_query($conn, $sql);
                
                        if ($result) {
                            $showAlert = true; 
                        }
                    } else {
                        $exists = "Username not available"; 
                    }
                }
            }
        }
    }
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags --> 
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS --> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
        crossorigin="anonymous">  
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="http://localhost/cakes/" title="Logo">
                    <img src="images/cakes/logo.png" alt="" class="img-responsive">
                </a>
            </div>
            <br>
            <div class="clearfix"></div>
        </div>
    </section>

    <?php
    if($showAlert) {
        echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created and you can <a href="login.php">login.</a>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">×</span> 
        </button> 
        </div>'; 
    }

    if($showError) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert"> 
        <strong>Error!</strong> '. $showError.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span> 
        </button> 
        </div>'; 
    }

    if($exists) {
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> '. $exists.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
            <span aria-hidden="true">×</span> 
        </button> 
        </div>'; 
    }
    ?>

    <div class="container my-4">
        <h2 class="text-center">Signup Here</h2> 
        <h5>*All fields are required</h5>
        <form id="signupForm" action="" method="post" onsubmit="return validateForm()">
            <div class="form-group"> 
                <label for="username">Username</label> 
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>    
            </div>
            <div class="form-group"> 
                <label for="customer_name">Full Name</label> 
                <input type="text" class="form-control" id="customer_name" name="customer_name" aria-describedby="emailHelp" required>    
            </div>
            <div class="form-group"> 
                <label for="password">Password</label> 
                <input type="password" class="form-control" id="password" name="password" required> 
            </div>
            <div class="form-group"> 
                <label for="cpassword">Confirm Password</label> 
                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                <small id="passwordHelp" class="form-text text-muted">Make sure to type the same password</small> 
            </div>  
            <div class="form-group"> 
                <label for="customer_email">Email</label> 
                <input type="email" class="form-control" id="customer_email" name="customer_email" aria-describedby="emailHelp" required>    
            </div>
            <div class="form-group"> 
                <label for="customer_contact">Phone</label> 
                <input type="number" class="form-control" id="customer_contact" name="customer_contact" aria-describedby="emailHelp" required>    
                <small id="phoneHelp" class="form-text text-muted">Please Enter a valid 10 digit mobile number</small> 
            </div>
            <div class="form-group">
                <label for="customer_address">Address</label> 
                <textarea name="customer_address" class="form-control" id="customer_address" required></textarea>
            </div>    
            <button type="submit" class="btn btn-primary">SignUp</button> 
        </form> 
    </div>

    <!-- Optional JavaScript --> 
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
        crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" 
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous">
    </script>

    <script>
        function validateForm() {
            // Validate password length
            var password = document.getElementById("password").value;
            var cpassword = document.getElementById("cpassword").value;
            if (password.length < 8) {
                alert("Password must be at least 8 characters long.");
                return false;
            }
            if (!/\d/.test(password)) {
                alert("Password must contain at least one number.");
                return false;
            }
            if (password !== cpassword) {
                alert("Passwords do not match.");
                return false;
            }

            // Validate email format
            var email = document.getElementById("customer_email").value;
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Validate phone number length
            var phone = document.getElementById("customer_contact").value;
            if (phone.length != 10) {
                alert("Phone number must be 10 digits long.");
                return false;
            }

            return true;
        }
    </script>
    <?php include('partials-front/footer.php'); ?>
</body>
</html>
