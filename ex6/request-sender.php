<?php

require_once 'socket.php';

$request = "GET /~makalm/icd0007/foorum/?message=deleted&username=ajveeb&key=eb138f71e1 HTTP/1.1
Host: enos.itcollege.ee
Cookie: PHPSESSID=10h5im1nf6b924u3q162aloq3d; path=/

";

// ?cmd=list&message=logged_in&key=a3ec1dee2b&username=ajveeb
// Set-Cookie: PHPSESSID=10h5im1nf6b924u3q162aloq3d; path=/
// eb138f71e1

//print urlencode("b
//c");
//exit;

//$request = "POST /~makalm/icd0007/foorum/?cmd=delete&id=6378&username=ajveeb HTTP/1.1
//Host: enos.itcollege.ee
//Content-Type: application/x-www-form-urlencoded
//Content-Length: 0
//X-Secret: 123456
//Cookie: PHPSESSID=10h5im1nf6b924u3q162aloq3d; path=/
//
//";

print makeWebRequest("enos.itcollege.ee", 443, $request);
