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
        <h2>Farmer Application Deletion Page</h2>
        <input type="submit" value="Return to homepage" onclick="window.location.href='index.php'">
        <br><br>
        <?php if (isset($_SESSION['message'])) { ?>
            <h3 style="color: red;">	
                <?php echo $_SESSION['message']; ?>
            </h3>
	    <?php } unset($_SESSION['message']); ?>
        <h2 style="color: red;"> DELETE THIS APPLICATION? </h2>
        <table>
            <tr>
                <th>Farmer ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Email Address</th>
                <th>Current Address</th>
                <th>Age</th>
                <th>Ideal Timeslot</th>
                <th>Last Updated</th>
                <th>Time of Application</th>
            </tr>

            <?php $applicantInformation = getApplicantByID($pdo, $_GET['farmerID'])["querySet"]; ?>
            <tr>
                <td><?php echo $applicantInformation['farmerID']?></td>
                <td><?php echo $applicantInformation['first_name']?></td>
                <td><?php echo $applicantInformation['last_name']?></td>
                <td><?php echo $applicantInformation['gender']?></td>
                <td><?php echo $applicantInformation['email_address']?></td>
                <td><?php echo $applicantInformation['current_address']?></td>
                <td><?php echo $applicantInformation['age']?></td>
                <td><?php echo $applicantInformation['ideal_timeslot']?></td>
                <td><?php echo $applicantInformation['last_edited']?></td>
                <td><?php echo $applicantInformation['date_added']?></td>
            </tr>
        </table>

        <form action="core/handleForms.php?farmerID=<?php echo $_GET['farmerID']; ?>" method="POST">
            <input type="submit" name="deleteApplicantBtn" value="Delete applicant">
        </form>
    </body>
</html>