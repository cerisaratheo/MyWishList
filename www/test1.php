<?php

namespace mywishlist;

require '../src/vendor/autoload.php';

$password = '123456789';

$policy = new \PasswordPolicy\Policy;
$policy->contains('lowercase', $policy->atLeast(2));
$policy->length( 6 ) ;$js = $policy->toJavaScript() ;
echo "var policy = $js" ;
$result = $policy->check( $password ) ;

echo "<h1>$result</h1>";
