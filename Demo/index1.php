<?php

function encryptBase64RSAByPriKey ($data, $priKey, $passphrase) {
    openssl_private_encrypt($data, $encryptData,
    openssl_get_privatekey($priKey, $passphrase));
    $t = base64_encode($encryptData);
//     var_dump($t);die;
    return $t;
}

function encryptBase64AES($data, $token) {
    /**
     * @todo Encrypt data
     */
    $encryptData = base64_encode($data);

    return $encryptData;
}
function getToken () {
    $sessionId = 'sessionId';
    $client = 'c4ca4238a0b923820dcc509a6f75849b';
    $priKey = file_get_contents(__DIR__ . '/key/key.pem');
    $passphrase = file_get_contents(__DIR__ . '/key/passphrase');
    $token = encryptBase64RSAByPriKey($sessionId, $priKey, $passphrase);

//     var_dump($token);die;

    $url = 'http://localhost/projects/api/api/token?client=' . $client;
    $data = array('data' => $token);

    // use key 'http' even if you send the request to https://...
    $options = array(
            'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
            ),
    );
//     var_dump($options);die;
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    //execute post
//     var_dump($result);die;
    $data = json_decode($result);
    return $data->token;
}

function payment ($token) {

    $cardInfo= array(
            'buyerId' => 1111,
            'clientTransactionId' => sha1(uniqid(rand(),1)),
            'currency'=> 'VND',
            'amount'=> $_POST['amount'],
            'cardType'=> 'VISA',
            'cardName'=> $_POST['cardName'],
            'cardNumber'=> $_POST['cardNumber'],
            'cvv'=> $_POST['cvv'],
            'validThrough'=> $_POST['validThr']
    );
    $cardInfo = json_encode($cardInfo);
    $cardInfo = encryptBase64AES($cardInfo, $token);


    //     var_dump($token);die;

    $url = 'http://localhost/projects/api/api/payment?token=' . $token;
    $data = array('data' => $cardInfo);

    // use key 'http' even if you send the request to https://...
    $options = array(
            'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
            ),
    );
    //     var_dump($options);die;
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    //     echo $result;die;
    //     var_dump($result);die;
    return $result;
}


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $token = getToken();
//     echo $token;
    $payment = payment($token);
    var_dump($payment);die;
//     var_dump($token);die;
    // die();
}
?>
<html>
<head>
<link rel="stylesheet"
	href="//maxcdn.bootstrapcdn.com/bootswatch/3.2.0/united/bootstrap.min.css">
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script
	src="//maxcdn.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</head>
<body>

	<div style="margin: 20px auto; width: 1000px;">
		<form role="form" action="." method="post">

			<div class="form-group">
				<label for="amount">Amount</label> <input type="text"
					class="form-control" id="amount" placeholder="Amount" name="amount" />
			</div>



			<div class="form-group">
				<label for="cardNumber">CardNumber</label> <input type="text"
					class="form-control" id="cardNumber" placeholder="cardNumber"
					name="cardNumber" />
					<input type="hidden"
					class="form-control" id="cardType" placeholder="cardType"
					name="cardType" value='VND'/>
			</div>



			<div class="form-group">
				<label for="cardName">CardName</label> <input type="text"
					class="form-control" id="cardName" placeholder="cardName"
					name="cardName" />
			</div>



			<div class="form-group">
				<label for="validThr">ValidThr</label> <input type="text"
					class="form-control" id="validThr" placeholder="validThr"
					name="validThr" />
			</div>



			<div class="form-group">
				<label for="cvv">CVV</label> <input type="text" class="form-control"
					id="cvv" placeholder="cvv" name="cvv" />
			</div>


			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</body>
</html>