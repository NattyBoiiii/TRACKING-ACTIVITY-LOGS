<?php
function getAllApplicants($pdo) {
    $sql = "SELECT * FROM searchFarmerApplicants ORDER BY first_name ASC";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if($executeQuery) {
        $response = array("status" => "200", "querySet" => $stmt -> fetchAll());
    } else {
        $response = array("status" => "400", "message" => "Failed to get informations");
    }
    return $response;
}

function getApplicantByID($pdo, $farmerID) {
    $sql = "SELECT * FROM searchFarmerApplicants WHERE farmerID =?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$farmerID]);

    if($executeQuery) {
        $response = array("status" => "200", "querySet" => $stmt -> fetch());
    } else {
        $response = array("status" => "400", "message" => "Failed to get the information " . $farmerID . "!");
    }
    return $response;
}

function searchForAApplicant($pdo, $searchInput) {
    $sql = "SELECT * FROM searchFarmerApplicants WHERE 
            CONCAT(first_name, last_name, gender, email_address, current_address, age, ideal_timeslot, last_edited, date_added) 
            LIKE ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute(["%".$searchInput."%"]);

    if($executeQuery) {
        $response = array("status" => "200", "querySet" => $stmt -> fetchAll());
    } else {
        $response = array("status" => "400", "message" => "Failed to search for applications!");
    }
    return $response;
}


function insertNewApplicant($pdo, $first_name, $last_name, $gender, $email_address, $current_address, $age, $ideal_timeslot) {

    $sql = "INSERT INTO searchFarmerApplicants
            (
                first_name,
                last_name,
                gender,
                email_address,
                current_address,
                age,
                ideal_timeslot
            )
            VALUES (?,?,?,?,?,?,?)
            ";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $email_address, $current_address, $age, $ideal_timeslot]);

    if ($executeQuery) {
        $response = array("status" => "200", "message" => "Application submitted successfully!");
    } else {
        $response = array("status" => "400", "message" => "Failed to submit application!");
    }
    return $response;
}

function editApplicant($pdo, $first_name, $last_name, $gender, $email_address, $current_address, $age, $ideal_timeslot, $farmerID) {

    $sql = "UPDATE searchFarmerApplicants
                SET first_name = ?,
                    last_name = ?,
                    gender = ?,
                    email_address = ?,
                    current_address = ?,
                    age = ?,
                    ideal_timeslot = ?
                WHERE farmerID = ?";

    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$first_name, $last_name, $gender, $email_address, $current_address, $age, $ideal_timeslot, $farmerID]);

    if ($executeQuery) {
        $response = array(
            "status" => "200",
            "message" => "Application " . $farmerID . " edited successfully!"
        );
    } else {
        $response = array(
            "status" => "400",
            "message" => "Failed to edit application " . $farmerID . "!"
        );
    }
    return $response;
}

function deleteApplicant($pdo, $farmerID) {
    $sql = "DELETE FROM searchFarmerApplicants WHERE farmerID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$farmerID]);

    if($executeQuery) {
        $response = array(
            "status" => "200",
            "message" => "Application " . $farmerID . " has been deleted!"
        );
    } else {
        $response = array(
            "status" => "400",
            "message" => "Failed to delete application " . $farmerID . "!"
        );
    }
    return $response;
}

function insertNewUser($pdo, $username, $password) {

    $checkUserSql = "SELECT * FROM farmerAdmin_entities WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {

        $sql = "INSERT INTO farmerAdmin_entities (username,password) VALUES(?,?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $password]);

        if ($executeQuery) {
            $_SESSION['message'] = "User successfully inserted";
            return true;
        }

        else {
            $_SESSION['message'] = "An error occured from the query";
        }
    }
    else {
        $_SESSION['message'] = "User already exists";
    }
}

function loginUser($pdo, $username, $password) {

    $sql = "SELECT * FROM farmerAdmin_entities WHERE username = ?";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$username])) {
        $userInfoRow = $stmt->fetch();
        $passwordFromDB = $userInfoRow['password'];

        if ($password == $passwordFromDB) {
            $_SESSION['user_id'] = $userInfoRow['user_id'];
            $_SESSION['username'] = $userInfoRow['username'];
            $_SESSION['message'] = "Login successful!";
            return true;
        }
        else {
            $_SESSION['message'] = "Username/password invalid";
        }
    }
    if ($stmt->rowCount() == 0) {
        $_SESSION['message'] = "Username/password invalid";
    }
}

function sanitizeInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function logAuditAction($pdo, $action, $username, $userId) {
    $stmt = $pdo->prepare("INSERT INTO audit_log (action, username, user_id) VALUES (?, ?, ?)");
    return $stmt->execute([$action, $username, $userId]);
}

function validatePassword($password) {
	if(strlen($password) >= 8) {
		$hasLower = false;
		$hasUpper = false;
		$hasNumber = false;

		for($i = 0; $i < strlen($password); $i++) {
			if(ctype_lower($password[$i])) {
				$hasLower = true;
			}
			if(ctype_upper($password[$i])) {
				$hasUpper = true;
			}
			if(ctype_digit($password[$i])) {
				$hasNumber = true;
			}

			if($hasLower && $hasUpper && $hasNumber) {
				return true;
			}
		}
	}
	return false;
}

?>