<?php
header("Access-Control-Allow-Origin: *");
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $f_name = strip_tags(trim($_POST["f_name"]));
        $l_name = strip_tags(trim($_POST["l_name"]));
        $name = $f_name . ' ' . $l_name;
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = strip_tags(trim($_POST["phone"]));
        $zipcode = strip_tags(trim($_POST["zipcode"]));
        $town = strip_tags(trim($_POST["town"]));
        $number_students = strip_tags(trim($_POST["number_students"]));
        $course_cats = strip_tags(trim($_POST["course_cats"]));
 
        // Check that data was sent to the mailer.
        if ( empty($f_name) OR empty($l_name) OR empty($email) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }
 
        // Set the recipient email address.
        $recipient = "justswimsg@outlook.com";
 
        // Set the email subject.
        $subject = "$course_cats Course Registration Form From $name";
 
        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Phone: $phone\n";
        $email_content .= "Town: $town\n";
        $email_content .= "Zip Code: $zipcode\n";
        $email_content .= "Number of Students: $number_students\n";
        $email_content .= "Course: $course_cats\n";
 
        // Build the email headers.
        $email_headers = array(
            'From' => 'register@swimminglessonssingapore.com',
            'Reply-To' => $email
        );
 
        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your registration form has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your form.";
        }
 
    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
 
?>