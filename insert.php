<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Farmer Application Database</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<h1>Inserting Applicant</h1>
	<form action="core/handleForms.php" method="POST">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" required>
            <br>

            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required>
            <br>

            <label for="gender">Gender</label>
            <input type="text" name="gender" required>
            <br>

            <label for="email_address">Email Address</label>
            <input type="text" name="email_address" required>
            <br>

            <label for="current_address">Current Address</label>
            <input type="text" name="current_address" required>
            <br>

            <label for="age">Age</label>
            <input type="number" name="age" min="0" max = "60" required>
            <br>

            <label for="ideal_timeslot">Ideal Timeslot</label>
            <input type="text" name="ideal_timeslot" required>
            <br>
            <input type="submit" name="insertApplicantBtn" value="Submit application">
	</form>
    <input type="submit" value="Return to homepage" onclick="window.location.href='index.php'">
        <br><br>
</body>
</html>