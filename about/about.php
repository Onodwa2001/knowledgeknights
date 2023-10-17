<?php 

	session_start();

?>

<!DOCTYPE html>
<html>
<head>

<title>About</title>
<link rel="stylesheet" type="text/css" href="CSS.css">
<link rel="stylesheet" href="../stylesheets/style.css">

</head>

<body>

	<header>
        <nav>
            <div class="logo">Logo</div>

            <ul>
                <li><a href="index.php?id=<?php echo $_GET['id']; ?>">Home</a></li>
                <li><a href="about/about.php?id=<?php echo $_GET['id']; ?>">About</a></li>

                <?php if ($_SESSION['userType'] !== 'Tutor') { ?>
                    <li><a href="search.php?id=<?php echo $_GET['id']; ?>">Find a tutor</a></li>
                <?php } ?>

                <li><a href="ContactUs/contact.php?id=<?php echo $_GET['id']; ?>">Contact</a></li>

                <?php if ($_SESSION['userType'] === 'Tutor') { ?>
                    <li><a href="invites.php?id=<?php echo $_GET['id']; ?>">Invites</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

<div>
<h1 style="text-align:center;">Knowledge Knights</h1>
</div>

<form>
<div class="formBox">

<h2>WELCOME TO KNOWLEDGE KNIGHTS!</h2>
<h3 style="text-align:center;">We are dedicated to helping high school learners achieve their academic goal and reach their full potential.<br>
We understand that each learner is unique,
with their own strengths and weaknesses,<br>
and learning styles, that is why we provide<br> personalized,
one-on-one tutoring that caters to the specific needs if each individual.</h3>
<p><img src="AboutBackground2.jpg" alt="background" style="width:300px"></p>
</div>
</form>
<br><br><br>
<form>
<div class="formBox1">
<h2 style="text-align:center;"><h2>OUR MISSION</h2>
      <h3>Our mission is to empower students with knowledge, foster critical thinking skills, and inspire a love for learning. 
	  <br>We strive to create a supportive and engaging <br>environment where students can thrive and reach their full potential.<br>
	  <br><img src="pic1.jpg" alt="background" style="width:300px"></h3>
</div>
</form>
<br><br><br>
<form>
<div class="formBox2">
<h2>WHAT WE OFFER</h2>
	  <h3>We understand the importance of convenience and flexibility in today's busy world. <br>That's why we offer flexible scheduling options, 
	  <br>allowing students to choose the tutoring sessions that fit 
	  their schedule best. <br>Whether they prefer in-person sessions or online tutoring, we have you covered.
	  <br><br><img src="pic2.jpg" alt="background" style="width:300px"></h3>
</div>
</form>
<br><br>

<h2> WANT TO KNOW MORE? YOU'RE WELCOME TO CONTACT US <a href="Contact2.html">HERE</a> </h2>

<footer>
    <p>&copy; 2023 Knowledge Knights. All rights reserved.</p>
  </footer>
</body>
</html>