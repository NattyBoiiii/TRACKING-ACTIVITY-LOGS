<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<?php
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Farmer Application Database</title>
	<link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php if (isset($_SESSION['message'])) { ?>
        <h1 style="color: green; text-align: center; background-color: ghostwhite; border-style: solid;"> <?php echo $_SESSION['message']; ?> </h1>
    <?php } unset($_SESSION['message']); ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="GET">
        <input type="text" name="searchInput" placeholder="Search here">
        <input type="submit" name="searchBtn">
    </form>

    <p><a href="index.php">Clear Search Query</a></p>
    <p><a href="insert.php">Insert New Applicant</a></p>

    <table style="width:100%; margin-top:20px">
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Gender</th>
            <th>Email Address</th>
            <th>Current Address</th>
            <th>Age</th>
            <th>Ideal Timeslot</th>
            <th>Last Edited</th>
            <th>Date Added</th>
            <th>Action</th>
        </tr>
        <input type="submit" value="Logout" onclick="window.location.href='logout.php'">
        <input type="submit" value="Audit Logs" onclick="window.location.href='auditlog.php'">
        <?php if(isset($_GET['searchBtn'])) {
            $searchForAApplicant = searchForAApplicant($pdo, $_GET['searchInput'])['querySet'];
            foreach ($searchForAApplicant as $row) { ?>
                <tr>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['email_address']; ?></td>
                    <td><?php echo $row['current_address']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['ideal_timeslot']; ?></td>
                    <td><?php echo $row['last_edited']; ?></td>
                    <td><?php echo $row['date_added']; ?></td>
                    <td>
                        <a href="edit.php?farmerID=<?php echo $row['farmerID']; ?>">Edit</a>
                        <a href="delete.php?farmerID=<?php echo $row['farmerID']; ?>">Delete</a>
                    </td>
                </tr>
            <?php }} else {
            $getAllApplicants = getAllApplicants($pdo)['querySet'];
            foreach ($getAllApplicants as $row) { ?>
                <tr>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['email_address']; ?></td>
                    <td><?php echo $row['current_address']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['ideal_timeslot']; ?></td>
                    <td><?php echo $row['last_edited']; ?></td>
                    <td><?php echo $row['date_added']; ?></td>
                    <td>
                        <a href="edit.php?farmerID=<?php echo $row['farmerID']; ?>">Edit</a>
                        <a href="delete.php?farmerID=<?php echo $row['farmerID']; ?>">Delete</a>
                    </td>
                </tr>
            <?php }} ?>
    </table>
</body>
</html>