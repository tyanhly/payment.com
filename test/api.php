<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', 1);
// die;
use Base\Crypto;
require __DIR__ . '/../app/library/Base/Crypto.php';
$priKey =
"-----BEGIN RSA PRIVATE KEY-----
Proc-Type: 4,ENCRYPTED
DEK-Info: AES-128-CBC,F10C8F2D380B452A701BBEC76DA26AA0

USK6kiygrkpGuDt0CUumYbE9DDyhAuxtPKGMceft7qE5QAdTngdSEgo8qriCzyTG
FYxxpmNR+iwWg53qxayBUbGKTdFGAohOrP7Ek7Ok2UBNBf+snRlt5AVzY8KJI0DS
Jja4eGgp4WuR5mgUkW1Y7FM16LVsRowHsdGkEMfTrMpNm5ug9dHM47cUzJr2NVMB
fO8S0BGPFskGWJWSLJQxqOOQIBivTlPH3F03FqdTokm1lQWd0WRdEEbvcRRtc+l+
T/YuNPO9vtCs+qmjeH1JbBAf6iLQJ2COsnbdmy6BgJqum6duwT9v5PArBqsPRqMY
3ZU7rVUI8elWzbRkDpGPdk3X+IDhawhWIxENknBs2VCXKsaXzWgy9+PJvnLyv1zR
dMQj4dWvTmRfJQpJV44H+mwjIThJRBJGn3HiUF/Upclqulll72O17OpbWAkviIb6
1ogU9xzxQHAEk+rrTXsIA5rgfW1z590URxKiHO6z0/IGDPCnVGVpQtt5ls/avncn
Hsh6YvNiY5OPd5iHZ4ttTohn1r1wmpC6QxL6sktPkr01wz+FfKR7kTr4Y/3E9C4j
bISRFZjPiVqP+5EHNpTUTQuivw/+DlrtgoKpCVmE2Xz1kBTGriFDFAfArmT6ZakP
beaCuZrN4UL1x8uGH3aIX1bGo9Ord2IG0dWkAU/wd8tlIVk2Eic7NwXK/7v/BnFG
pFR9O0N8Ib0hrpcbMG6jA4S54MPIl0RnvxwcQgVM3c6yicK2NLjnbMUZakWSfC2g
RRG7dZU2y0R6pici57DdYMkNwUYh9J8zeLv5R12MJXtaqmExR8L8BEs10DZ6Aj2a
Ab9udBwL5p/Gu7AIuX63BzBvpG+p72Z8rYop7jb3/XInl/iI3r/XC22kH4PCylb0
JPRB4C4/CEpxeau9ZQdWz20qBfB9+qXk8vzzufXeuKVTp9BOqqoVSNNLP4kA5guG
5zhAGb8TWHiaGMnEVrfZKZgpeaJ7qR1c+ufGLSC29O9OCciDjd2aapFHjyMK3l6Y
ethmwOnZ9myijV8sL+KHsvcgHgY0mPm/hkNoAYhNbRX029V2FZXpAAnEqL4toSwJ
JS67siDOuAJsq3JYr6GB24Mz7dF2gR2/t+hF6P5lSq/uw78aJjIUTKXIPXuQbHoj
k5LUD0TLQLO1BB4/gJypg+6wTfYjF6/DL2iBh17OVN6JJPsedhjJFj4PuKKnHu3y
TQoKTf6zSIOiYcJKp5NYygktAey1PoNbLw+Y9sq4oM5j/QFrz8hGIHFe4FXgE6q2
pg5kPmXHbzxUzOa5tNvjWGxJnyEG3xTfPGYBw/dQvY1mYeoPRpPhTNzrkIk8NrsM
aGzUJoDPlYdiVSPSY5KV0UvR4R6u0+IWNMpyHObNqH2G3kC2NIOSPjsKdRHUYF1M
BrgPiswDrJkUQFQPb73UQGZA0PiUzYnUytIT2lG2IHwwfU4eJRGJ8squ6cu3wgaE
E3rqYoV06W8RcfiSgsnlS8a5YOB0ipEc6pxWQjOK9kPXaEzyyuvmht+SfJ0sP2fj
3tCaMBmw0yZLtM5ZhmcsIIoYqantia2Gluwq4j1yOQqiaqJOm4IolpRkHjW/nG84
-----END RSA PRIVATE KEY-----";
$pubKey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAvnUwtsV4N9zzwel1jjwS
DrOflBCqhXyV/cxw+CCYadi/8xaqjcV0PwvLhfMPew3NNkp+AWkMhGvUsQGte3Fc
RhLQYyUtJO882g6WeYZo2aPs6yfZtyGuG1v92wl8xLsFB7JlVr9xUqi+6d0+UiNg
syHNDXkSNcCP7+z1ybkX9bU4vEudj8lHds5+nbwleB9+v9HdmQHeECRgSafNhlhh
eYAcYSSEZsf9mirndqerbqWfZPIa1w0cqCxTe2tJYPW+vOrPRFhnvhBh0bJ3pvpI
GBpr5Kjz11Uz5yt8IZinK3Rvy7HZU10EKcXSBfqi8kDSAJ7/UtgnvffRuFADUn3g
uwIDAQAB
-----END PUBLIC KEY-----";
$passphrase = "123456";
$token = Crypto::encryptBase64RSAByPriKey("sessionId", $priKey, $passphrase);
echo '<pre>';
echo "token:\n";
echo $token;
echo '<br />';


$cardInfo= array(
    'buyerId' => 3333,
    'clientTransactionId' => 'test'.uniqid(rand(),1),
     'currency'=> 'VND',
     'amount'=> 9999,
     'cardType'=> 'VISA',
     'cardName'=> 'LY THANH TUNG',
     'cardNumber'=> '44444444444444',
     'cvv'=> 444,
     'validThrough'=> '091400',
     'description'=> 'description',
);
$cardInfo = json_encode($cardInfo);
echo $cardInfo;
echo "\n";
$cardInfo = Crypto::encryptBase64AES($cardInfo, $token);
echo "card:\n";
echo $cardInfo;
echo '<br />';
echo '<br />';
echo '<br />';

die;
