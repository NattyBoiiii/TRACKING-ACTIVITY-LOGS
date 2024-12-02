<?php 
require_once "core/dbConfig.php";
require_once "core/models.php";
?>

<html>
    <head>
        <title>Farmer Application Database</title>
        <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    </head>
    <body>
        <h2>Farmer Applicant Information Editing Page</h2>
        <input type="submit" value="Return to homepage" onclick="window.location.href='index.php'">
        <br><br>
        <?php $applicantInformation = getApplicantByID($pdo, $_GET['farmerID'])["querySet"] ?>
        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>
        <form action="core/handleForms.php?farmerID=<?php echo $_GET['farmerID']?>" method="POST">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" value="<?php echo $applicantInformation['first_name']?>" required>
            <br>

            <label for="last_name">Last name</label>
            <input type="text" name="last_name" value="<?php echo $applicantInformation['last_name']?>" required>
            <br>

            <label for="gender">Gender</label>
            <input type="text" name="gender" value="<?php echo $applicantInformation['gender']?>" required>
            <br>

            <label for="email_address">Email Address</label>
            <input type="text" name="email_address" value="<?php echo $applicantInformation['email_address']?>" required>
            <br>

            <label for="current_address">Current Address</label>
            <input type="text" name="current_address" value="<?php echo $applicantInformation['current_address']?>" required>
            <br>

            <label for="age">Age</label>
            <input type="number" name="age" min="0" max = "60" value="<?php echo $applicantInformation['age']?>" required>
            <br>

            <label for="ideal_timeslot">Ideal Timeslot</label>
            <input type="text" name="ideal_timeslot" value="<?php echo $applicantInformation['ideal_timeslot']?>" required>
            <br>

            <input type="submit" name="editApplicantBtn" value="Edit application">
        </form>
    </body>
</html>