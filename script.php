<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-Type: Application/JSON'); 

if($_POST['name'] AND  $_POST['country'] AND $_POST['email'] AND $_POST['phone'] AND $_POST['message']) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "iokonkwo.lmps@loveworld360.com.com";
    $email_subject = "Radio Lambono Contact Form,";
 
    // validation expected data exists
   
    $name = $_POST['name']; // required
    $country = $_POST['country']; // required
    $email_from = $_POST['email']; // required
    $phone = $_POST['phone']; // not required
    $message = $_POST['message']; // required
 
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
    echo json_encode(['message' => $error_message]);
    return false;
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The  Name you entered does not appear to be valid.<br />';
    echo json_encode(['message' => $error_message]);
    return false;
  }

    $string_phone = "/^[0-9 +]+$/";
  if(!preg_match($string_phone, $phone)) {
    $error_message .= 'The  Phone you entered does not appear to be valid.<br />';
    echo json_encode(['message' => $error_message]);
    return false;
  }
 
  if(!preg_match($string_exp,$country)) {
    $error_message .= 'The Country you entered does not appear to be valid.<br />';
    echo json_encode(['message' => $error_message]);
    return false;
  }
 
  if(strlen($message) < 2) {
    $error_message .= 'The Message you entered do not appear to be valid.<br />';
    echo json_encode(['message' => $error_message]);
    return false;
  }
 
  if(strlen($error_message) > 0) {
    //died($error_message);
    echo json_encode(['message' => $error_message]);
    return false;
  }
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
 
    $email_message .= "Full Name: ".clean_string($name)."\n";
    $email_message .= "Country: ".clean_string($country)."\n";
    $email_message .= "Email: ".clean_string($email_from)."\n";
    $email_message .= "Telephone: ".clean_string($phone)."\n";
    $email_message .= "Message: ".clean_string($message)."\n";
 
// create email headers
$headers = 'From: '.$email_from."\r\n".
'Reply-To: '.$email_from."\r\n" .
'X-Mailer: PHP/' . phpversion();
@mail($email_to, $email_subject, $email_message, $headers);  

echo json_encode(['status'=>200,'message' => 'Thank you for contacting us we will get back to you shortly!']);

}else{
    echo json_encode(['message' => 'All fields are required!']);
}
?>
