<?php

/*require '../src/vendor/autoload.php';

$password = '123456789';

$policy = new \PasswordPolicy\Policy;
$policy->contains('lowercase', $policy->atLeast(2));
$policy->length( 6 ) ;$js = $policy->toJavaScript() ;
echo "var policy = $js" ;
$result = $policy->check( $password ) ;

echo "<h1>$result</h1>";
*/


$email_a = 'joe@example.com';
$email_b = 'bogus';

if (filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
    echo "L'adresse email '$email_a' est considérée comme valide.";
}
if (filter_var($email_b, FILTER_VALIDATE_EMAIL)) {
    echo "L'adresse email '$email_b' est considérée comme valide.";
} else {
    echo "L'adresse email '$email_b' est considérée comme invalide.";
}