<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
  input, select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
input[type=submit] {
  width: 100%;
  background-color: #2e2d4c;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
  </style>
</head>
<body>

<div class=" bg-primary text-white ">
  <div class="col-sm-12 " style="height:50px;">
	<h2 class="allign-start" >Logo </h2>
  </div>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a  class="nav-link" href="login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="signup.php">Signup</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">My Account</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="product.php">Membership</a>
      </li>
	  
    </ul>
  </div>
</nav>

<div style="background:#efefef; color:#000; width:500px; margin: auto; margin-top:50px; padding: 50px;">
	<h2 style="  text-align: justify;  text-justify: inter-word;">Sign Up</h2><br>
	<form method="post">
			  <label for="fname">First name:</label><br>
			  <input type="text" id="fname" name="fname" Placeholder="First Name"><br>
			  <label for="lname">Last name:</label><br>
			  <input type="text" id="lname" name="lname" placeholder="Last Name"><br>
			  <label for="phone">Phone:</label><br>
			  <input type="tel" id="phone" name="phone" Placeholder="Phone"><br>
			  <label for="email">Email:</label><br>
			  <input type="email" id="email" name="email" Placeholder="Email"><br>
			  <label for="password">Password:</label><br>
			  <input type="password" id="password" name="password" placeholder="Enter Password"><br>
			  <label for="cpassword">Confirm Password:</label><br>
			  <input type="cpassword" id="cpassword" name="cpassword" placeholder="Confirm Password"><br>
		
			  <input type="submit" id="submit" name="submit" value="Sign Up">
		</form>
</div>




<div class="mt-5 p-4 bg-dark text-white text-center">
  <p>Footer</p>
</div>

</body>
</html>
