<?php
require_once "dbConfig.php";
require_once "models.php";

if (isset($_POST['insertApplicantBtn'])) {
    if($_POST['age'] < 18) {
        $_SESSION['message'] = "Error! Age Must be 18 or above! " ;
            header('Location: ../index.php');
        }

    $insertApplicant = insertNewApplicant($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['email_address'], 
    $_POST['current_address'], $_POST['age'], $_POST['ideal_timeslot']);


    if($insertApplicant['status'] == "200") {
        $_SESSION['message'] = $insertApplicant['message'];
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = "Error " . $insertApplicant['status'] . ": " . $insertApplicant['message'];
        header('Location: ../index.php');
    }
}

if (isset($_POST['editApplicantBtn'])) {
    if($_POST['age'] < 18) {
        $_SESSION['message'] = "Error! Age Must be 18 or above! " ;
            header('Location: ../index.php');
        }

    $editApplicant = editApplicant($pdo, $_POST['first_name'], $_POST['last_name'], $_POST['gender'], $_POST['email_address'], 
    $_POST['current_address'], $_POST['age'], $_POST['ideal_timeslot'], $_GET['farmerID']);

    if($editApplicant['status'] == "200") {
        $_SESSION['message'] = $editApplicant['message'];
        header('Location: ../index.php');
    } else {
        $_SESSION['message'] = "Error " . $editApplicant['status'] . ": " . $editApplicant['message'];
        header('Location: ../index.php');
    }
}

if (isset($_POST['deleteApplicantBtn'])) {
    $deleteApplicant = deleteApplicant($pdo, $_GET['farmerID']);

    if($deleteApplicant['status'] == "200") {
        $_SESSION['message'] = $deleteApplicant['message'];
        logAuditAction($pdo, 'Deleted User', $_SESSION['username'], null); 
        header('Location: ../index.php');
        
    } else {
        $_SESSION['message'] = "Error " . $deleteApplicant['status'] . ": " . $deleteApplicant['message'];
        header('Location: ../index.php');
    }
}

if (isset($_POST['registerUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($password)) {
        if (validatePassword($password)) {
            $hashedPassword = sha1($password);
            $insertQuery = insertNewUser($pdo, $username, $hashedPassword);

            if ($insertQuery) {
                logAuditAction($pdo, 'Registered User', $username, null); 
                header("Location: ../login.php");
            } else {
                header("Location: ../register.php");
            }
        } else {
            $_SESSION['message'] = "Password must be at least 8 characters, including a lowercase letter, an uppercase letter, and a number.";
            header("Location: ../register.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
        header("Location: ../login.php");
    }
}

if (isset($_POST['loginUserBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sha1($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $loginQuery = loginUser($pdo, $username, $password);

        if ($loginQuery) {
            logAuditAction($pdo, 'User Login', $username, $_SESSION['user_id']);
            header("Location: ../index.php");
        } else {
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
        header("Location: ../login.php");
    }
}

if (isset($_GET['logoutAUser'])) {
    unset($_SESSION['username']);
    logAuditAction($pdo, 'User Logout', $_SESSION['username'], $_SESSION['user_id']);
    header('Location: ../login.php');
}
?>

