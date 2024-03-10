<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
    .container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 50px;
    border: 2px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    }
</style>
</head>
<body>

<div class="container">
    <?php
    // Define variables and initialize with empty values
    $name = $email = $feedback = "";
    $name_err = $email_err = $feedback_err = "";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate name
        if (empty($_POST["name"])) {
            $name_err = "Please enter your name.";
        } else {
            $name = test_input($_POST["name"]);
        }

        // Validate email
        if (empty($_POST["email"])) {
            $email_err = "Please enter your email.";
        } else {
            $email = test_input($_POST["email"]);
            // Check if email address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format.";
            }
        }

        // Validate feedback
        if (empty($_POST["feedback"])) {
            $feedback_err = "Please provide your feedback.";
        } else {
            $feedback = test_input($_POST["feedback"]);
        }
    }

    // Function to sanitize input data
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <h2>Feedback Form</h2>
    <p>Please fill in your feedback below:</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>">
            <span><?php echo $name_err; ?></span>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            <span><?php echo $email_err; ?></span>
        </div>
        <div>
            <label for="feedback">Feedback:</label>
            <textarea id="feedback" name="feedback"><?php echo $feedback; ?></textarea>
            <span><?php echo $feedback_err; ?></span>
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>

    <?php
    // Display submitted data
    if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($name_err) && empty($email_err) && empty($feedback_err)) {
        echo "<h2>Thank you for your feedback, $name!</h2>";
        echo "<p>We have received the following information:</p>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Feedback:</strong> $feedback</p>";
    }
    ?>
</div>

</body>
</html>
