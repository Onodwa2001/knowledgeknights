<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Assistance</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="form-container">
       
        <form action="includes/forgot.php" method="post" enctype="multipart/form-data">
            <h3>Password Assistance</h3>

            <?php
            if (isset($_GET['msg'])) { ?>
                <p class="success-message"><?php echo $_GET['msg']; ?></p>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['error'])) { ?>
                <p class="error-message"><?php echo $_GET['error']; ?></p>
            <?php
            }
            ?>

            <p>Enter the email address associated with your account.</p>
            <input type="email" name="email" placeholder="enter email" class="box" required>
            <input type="submit" name="submit" value="Send password reset link" class="btn">

        </form>

    </div>

</body>

</html>