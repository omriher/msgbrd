<?php

require 'dbConnect.php';
$stored_exc = null;
$user = $_POST['user'];
$msg = $_POST['mesg'];


// Define our query here
$query = $dbh->prepare("INSERT INTO messages (fbUser, Message) VALUES (:user,:msg)");



try {
    $query->execute(array(':msg'=>$msg,
                  ':user'=>$user));
} catch(PDOException $e) {
    $stored_exc = $e;
    // Handle an error
}
// "Finally" here, clean up after yourself
if ($stored_exc) {
    throw($stored_exc);
}
?>