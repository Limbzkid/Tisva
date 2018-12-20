<?php
$to      = 'customer_care@lifebytisva.com';
$subject = 'the subject';
$message = 'hello';
$headers = 'From:customer_care@lifebytisva.com' . "\r\n" .
    'Reply-To: customer_care@lifebytisva.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

$mailSent =mail($to, $subject, $message, $headers);

if($mailSent)
{
	echo "mail has sent";
}
else
{
	echo "mail sending failed";
}

?> 