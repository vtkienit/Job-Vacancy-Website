<?php
session_start();
require 'settings.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    function clean_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $jobRef = isset($_POST['Job_reference_number']) ? clean_input($_POST['Job_reference_number']) : '';
    $firstName = isset($_POST['First_Name']) ? clean_input($_POST['First_Name']) : '';
    $lastName = isset($_POST['Last_Name']) ? clean_input($_POST['Last_Name']) : '';
    $dob = isset($_POST['Date_of_birth']) ? clean_input($_POST['Date_of_birth']) : '';
    $gender = isset($_POST['Gender']) ? clean_input($_POST['Gender']) : '';
    $address = isset($_POST['Street_Address']) ? clean_input($_POST['Street_Address']) : '';
    $suburb = isset($_POST['Suburb/town']) ? clean_input($_POST['Suburb/town']) : '';
    $state = isset($_POST['State']) ? clean_input($_POST['State']) : '';
    $postcode = isset($_POST['Postcode']) ? clean_input($_POST['Postcode']) : '';
    $email = isset($_POST['Email']) ? clean_input($_POST['Email']) : '';
    $phone = isset($_POST['Phone_number']) ? clean_input($_POST['Phone_number']) : '';
    $skills = isset($_POST['Skills']) ? implode(", ", $_POST['Skills']) : '';
    $otherSkills = isset($_POST['Other_Skills']) ? clean_input($_POST['Other_Skills']) : '';

    if (empty($jobRef) || empty($firstName) || empty($lastName) || empty($dob) || empty($gender) || empty($address) || 
        empty($suburb) || empty($state) || empty($postcode) || empty($email) || empty($phone) || empty($skills)) {
        $_SESSION['message'] = "Please fill in all required fields!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!preg_match('/^[A-Za-z0-9]{5}$/', $jobRef)) {
        $_SESSION['message'] = "Invalid job reference number!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!preg_match('/^[A-Za-z]{1,20}$/', $firstName)) {
        $_SESSION['message'] = "Invalid first name! Max 20 alphabetic characters.";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!preg_match('/^[A-Za-z]{1,20}$/', $lastName)) {
        $_SESSION['message'] = "Invalid last name! Max 20 alphabetic characters.";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dob)) {
        $_SESSION['message'] = "Invalid date of birth! Format must be dd/mm/yyyy.";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (strlen($address) > 40) {
        $_SESSION['message'] = "Street address cannot exceed 40 characters.";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (strlen($suburb) > 40) {
        $_SESSION['message'] = "Suburb/Town cannot exceed 40 characters.";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    $statePostcodes = [
        "NSW" => [["1000", "1999"], ["2000", "2599"], ["2619", "2899"], ["2921", "2999"]],
        "ACT" => [["0200", "0229"], ["2600", "2618"], ["2900", "2920"]],
        "VIC" => [["3000", "3996"], ["8000", "8999"]],
        "QLD" => [["4000", "4999"], ["9000", "9999"]],
        "SA"  => [["5000", "5799"], ["5800", "5999"]],
        "WA"  => [["6000", "6797"], ["6800", "6999"]],
        "TAS" => [["7000", "7799"], ["7800", "7999"]],
        "NT"  => [["0800", "0899"], ["0900", "0999"]],
    ];
    
    if (!isset($statePostcodes[$state])) {
        $_SESSION['message'] = "Invalid state selection!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }
    
    if (!preg_match('/^\d{4}$/', $postcode)) {
        $_SESSION['message'] = "Postcode must be exactly 4 digits!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }
    
    $isValidPostcode = false;
    foreach ($statePostcodes[$state] as $range) {
        if ($postcode >= $range[0] && $postcode <= $range[1]) {
            $isValidPostcode = true;
            break;
        }
    }
    
    if (!$isValidPostcode) {
        $_SESSION['message'] = "Postcode does not match the selected state!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email address!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (!preg_match('/^[0-9 ]{8,12}$/', $phone)) {
        $_SESSION['message'] = "Invalid phone number!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    if (strpos($skills, 'Others') !== false && empty($otherSkills)) {
        $_SESSION['message'] = "Other skills cannot be empty if 'Others' is selected!";
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    $createTableQuery = "CREATE TABLE IF NOT EXISTS EOI (
        EOInumber INT AUTO_INCREMENT PRIMARY KEY,
        jobRef CHAR(5) NOT NULL,
        firstName VARCHAR(20) NOT NULL,
        lastName VARCHAR(20) NOT NULL,
        dob VARCHAR(10) NOT NULL,
        gender ENUM('Male', 'Female') NOT NULL,
        address VARCHAR(40) NOT NULL,
        suburb VARCHAR(40) NOT NULL,
        state VARCHAR(10) NOT NULL,
        postcode CHAR(4) NOT NULL CHECK (postcode REGEXP '^[0-9]{4}$'),
        email VARCHAR(50) NOT NULL,
        phone VARCHAR(12) NOT NULL CHECK (phone REGEXP '^[0-9 ]{8,12}$'),
        skills TEXT,
        otherSkills TEXT,
        status ENUM('New', 'Current', 'Final') NOT NULL DEFAULT 'New'
    )";

    if (!mysqli_query($conn, $createTableQuery)) {
        $_SESSION['message'] = "Error creating table: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
        header("Location: apply.php");
        exit();
    }

    $insertQuery = "INSERT INTO EOI (jobRef, firstName, lastName, dob, gender, address, suburb, state, postcode, email, phone, skills, otherSkills) 
    VALUES ('$jobRef', '$firstName', '$lastName', '$dob', '$gender', '$address', '$suburb', '$state', '$postcode', '$email', '$phone', '$skills', '$otherSkills')";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['message'] = "Application submitted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error submitting application: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
    }

    mysqli_close($conn);
    header("Location: apply.php");
    exit();
} else {
    header("Location: apply.php");
    exit();
}
