<?php

function encryptBase64RSAByPriKey ($data, $priKey, $passphrase) {
    openssl_private_encrypt($data, $encryptData,
            openssl_get_privatekey($priKey, $passphrase));
    $t = base64_encode($encryptData);
    // var_dump($t);die;
    return $t;
}

function encryptBase64AES ($data, $token) {
    /**
     *
     * @todo Encrypt data
     */
    $encryptData = base64_encode($data);

    return $encryptData;
}

function getToken () {
    $sessionId  = 'sessionId';
    $client     = 'c4ca4238a0b923820dcc509a6f75849b';
    $priKey     = file_get_contents(__DIR__ . '/key/key.pem');
    $passphrase = file_get_contents(__DIR__ . '/key/passphrase');
    $token      = encryptBase64RSAByPriKey($sessionId, $priKey, $passphrase);

    // var_dump($token);die;

    $url = 'http://api.bl.kiss-concept.com/api/token?client=' . $client;
    $data = array(
        'data' => $token
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );

    // var_dump($options);die;
    $context = stream_context_create($options);
    $result  = file_get_contents($url, false, $context);

    // execute post
    // var_dump($result);die;
    $data = json_decode($result);
    return $data->token;
}

function payment ($token) {
    $cardInfo = array(
        'buyerId'      => 142,
        'clientTransactionId' => sha1(uniqid(rand(), 1)),
        'currency'     => 'USD',
        'amount'       => $_POST['amount'],
        'cardType'     => $_POST['cardType'],
        'cardName'     => $_POST['cardName'],
        'cardNumber'   => $_POST['cardNumber'],
        'cvv'          => $_POST['cvv'],
        'validThrough' => $_POST['validThrough'],
        'description'  => 'Buy ' . $_POST['quantity'] . ' Most Wanted Coats',
    );
    $cardInfo = json_encode($cardInfo);
    $cardInfo = encryptBase64AES($cardInfo, $token);

    // var_dump($token);die;

    $url = 'http://api.bl.kiss-concept.com/api/payment?token=' . $token;
    $data = array(
            'data' => $cardInfo
    );

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    // var_dump($options);die;
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    // echo $result;die;
    // var_dump($result);die;
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = getToken();

    $payment = payment($token);

    if ($payment != '') {
    	$payment = json_decode($payment, true);
    	if ($payment['transactionId']) header('Location: completed.php');
    	else{
    	    header('Location: notcompleted.php');
    	}
    }else{
        header('Location: notcompleted.php');
    }

    var_dump($payment);
    die();
    // var_dump($token);die;
    // die();
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<link href="css/style.css" rel="stylesheet">

<title>Smart MOZO</title>
<style>
</style>

</head>

<body>

	<div class="bg-fade"></div>

	<div class="header">
		<a href="list.html" title="" class="float-left"><span
			class="btn-back"></span></a> <a href="#" title=""
			class="float-right"><span class="btn-comment"></span></a> <a href="#"
			 title="" class="float-right"><span class="btn-share"></span></a>
		<a href="#"  title="" class="float-right"><span
			class="btn-heart"></span></a> <a href="#" title=""
			class="float-right"><span class="btn-bookmark disabled"></span></a>
	</div>



	<div class="content">

		<div class="product-image">
			<img src="img/products/billboard_B_4.jpg" alt=""
				class="responsive-photo">
		</div>


		<div class="ribbon-price">
			<span class="ribbon-left"></span> <span class="product-price-usually">$240</span>
			<span class="product-price-now">$72</span> <span class="ribbon-right"></span>
		</div>

		<div class="card">


			<div class="product-title">Most Wanted Coats</div>

			<div class="product-brand">by Tommy Hilfiger</div>

			<div class="product-info">
				<p>
					Jessica Simpson Women's Double-Breasted Boucle Wool Coat <span
						class="btn-more">more...</span>
				</p>
				<div class="product-detail hide">
					<p>51% Polyester/49% Wool</p>
					<p>Dry Clean Only</p>
					<p>Jetted hand pockets</p>
					<p>Back belt</p>
					<p>Double-breasted coat in boucle featuring covered buttons and
						decorative angled seaming at body that continues across to sleeve</p>
					<hr>
				</div>
			</div>
			<div class="product-statistics">
				<ul>
					<li class="product-days-left float-left"><img
						src="img/graphics/stopwatch.png" alt=""><br />5 days left</li>
					<li class="product-votes float-left"><img
						src="img/graphics/vote.png" alt=""><br />126 votes</li>
					<li class="product-likes float-left"><img
						src="img/graphics/like.png" alt=""><br />26 likes</li>
					<li class="product-views float-left"><img
						src="img/graphics/view.png" alt=""><br />40 views</li>
				</ul>
			</div>

			<br>
			<div class="product-buy">
				<a href="#" title="" class="btn-direction float-left">Direction
					<img src="img/graphics/direction.png" alt="">
				</a> <a href="#"  title="" class="btn-buy float-right">Buy now</a>
			</div>

			<div class="product-suggestion-list"></div>

		</div>
	</div>


    <form method="post" action="" id="credit-card-form">
		<div class="payment-slide hide">
			<div class="card">
				<ul>
					<li class="quantity-col "><label>Qty</label><br />
						<select id="quantity" name="quantity">
							<option value="1" selected>1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
					</select></li>

					<li class="symbol-col "><br />x</li>

					<li class="price-col "><label>Price</label><br />
					   <input type="hidden" value="50" id="price" />
					   <span>$50</span>
					</li>

					<li class="symbol-col "><br />=</li>

					<li class="total-col "><label>Total</label><br />
    					<input name="amount" id="amount" type="hidden" value="50" />
    					<span id="amountDesc">$50</span>
					</li>
				</ul>

				<div class="clear"></div>

				<hr>

				<ul>
					<li class="payment-title-col">Payment info</li>
					<li class="credit-card-col"><img src="img/graphics/credit-card.jpg" alt=""></li>
				</ul>

				<div class="clear"></div>

				<ul class="payment-form">
					<li class="card-number-col ">
						<label>Card number</label><br />
						<input type="text" id="cardNumber" name="cardNumber" value="">
					</li>

					<li class="month-col"><label>Expiration date</label><br /> <select
						id="validThrough1">
							<option value="01" selected>01</option>
							<option value="02">02</option>
							<option value="03">03</option>
							<option value="04">04</option>
							<option value="05">05</option>
							<option value="06">06</option>
							<option value="07">07</option>
							<option value="08">08</option>
							<option value="09">09</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
					</select></li>

					<li class="year-col"><label></label><br />
						<select id="validThrough2">
							<option value="2014" selected>2014</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
						</select>
					</li>

					<li class="code-col">
						<label>CVV code</label><br />
						<input type="text" name="cvv" id="cvv" maxlength="3">
					</li>

					<li class="card-number-col ">
						<label>Name as it appears on card</label><br />
						<input type="text" name="cardName" value="" id="cardName">
					</li>


					<input type="hidden" name="validThrough" id="validThrough" value="01-2014" />
					<input type="hidden" name="cardType" id="cardType" value="" />

					<li class="buy-now-col ">
						<input id="buyButton" type="submit" alt="" title="" class="btn-large-buy disabled" value="Buy now" />
					</li>
				</ul>
			</div>
		</div>
	</form>

	<div class="clear"></div>







<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	var isQuantityValid   = true,
	    isCardNumberValid = false,
	    isCardTypeValid   = false,
	    isValidThroughValid = false,
	    isCvvValid        = false,
	    isCardNameValid   = false;

	function getCardType(number){
		if (number != '') {
			result = number.match(/^4[0-9]{6,}$/gi);
		    if(result && result.length > 0){
		        return 'Visa';
		    }

		    result = number.match(/^5[1-5][0-9]{5,}$/gi);
		    if(result && result.length > 0){
		        return 'Master';
		    }

		    return 'Union';
		}
	}

	$("#quantity").change(function(){
        price    = $("#price").val();
        quantity = $(this).val();

        $("#amount").val(quantity*price);
        $("#amountDesc").text("$" + $("#amount").val());

    });

	$("#cardNumber").keyup(function(){
	    if(getCardType($(this).val())=='Master'){
	        $(this).css({
		        "background": "url(img/master.png)",
	            "background-position": "right center",
	            "background-repeat": "no-repeat",
	            "background-size": "40px 20px"
	        })
	    }

	    if(getCardType($(this).val())=='Visa'){
	        $(this).css({
		        "background": "url(img/visa.png)",
	            "background-position": "right center",
	            "background-repeat": "no-repeat",
	            "background-size": "40px 20px"
	        })
	    }
	    var cardType = getCardType($(this).val());
	    $('#cardType').val(cardType);
	});


    $("#validThrough1, #validThrough2").change(function() {
        $("#validThrough").val($("#validThrough1").val() + "-" + $("#validThrough2").val());

    });

    $("#cvv, #cardName").change(function() {
    });

	$(".btn-buy").click(function(){
		$(".payment-slide").show();
		$(".bg-fade").css("width","100%");
	});

	$(".bg-fade").click(function(){
		$(".payment-slide").hide();
		$(".bg-fade").css("width","0%");
	});

	$(".btn-more").click(function(){
		$(".product-detail ").show();
		$(".btn-more").hide();
	});

	$("#quantity, #cardNumber, #validThr1, #validThr2, #cvv, #cardName").keyup(function(){
	    if(isValidCardInfo()){
	        $("#buyButton").removeClass("disabled");
	    }else{

	        $("#buyButton").addClass("disabled");
	    }
	});
	function isValidCardInfo() {
        price      = $("#price").val();
        quantity   = $("#quantity").val();
        cardNumber = $("#cardNumber").val();
	    cardType   = $('#cardType').val();
        cardName   = $("#cardName").val();
        cvv        = $("#cvv").val();
        validThrough = $("#validThrough").val();

        if (quantity != '') {
        	isQuantityValid = true;
        } else {
        	isQuantityValid = false;
        }
        if (cardNumber != '') {
        	isCardNumberValid = true;
        } else {
        	isCardNumberValid = false;
        }
        if (cardType != '') {
        	isCardTypeValid = true;
        } else {
        	isCardTypeValid = false;
        }
        if (cardName != '') {
        	isCardNameValid = true;
        } else {
        	isCardNameValid = false;
        }
        if (cvv != '') {
        	isCvvValid = true;
        } else {
        	isCvvValid = false;
        }
        if (validThrough != '') {
        	isValidThroughValid = true;
        } else {
        	isValidThroughValid = false;
        }

        if (isQuantityValid && isCardNumberValid && isCardTypeValid && isCardNameValid && isCvvValid && isValidThroughValid) {
        	return true;
        }
        return false;
	}

	$("#credit-card-form").submit(function(){
		if (isValidCardInfo()) {
			$(this).submit();
		}else{
			return false;
		}
	});

	/* after validate credit card,  $(".btn-large-buy").removeClass("disabled")  */
</script>

</body>
</html>