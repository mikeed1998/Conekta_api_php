<?php
  	require_once("lib/Conekta.php");
  	\Conekta\Conekta::setApiKey("key_smGi4GNG7dXpoUlMExZ0Vfg");
	\Conekta\Conekta::setApiVersion("2.0.0");

	$token_id=$_POST["conektaTokenId"];

	echo $token_id;

	try {
  		$customer = \Conekta\Customer::create(
    		array(
      			"name" => "Fulanito Pérez",
      			"email" => "fulanito@conekta.com",
      			"phone" => "+52181818181",
      			"payment_sources" => array(
        			array(
            			"type" => "card",
            			"token_id" => $token_id
        			)
      			)//payment_sources
    		)//customer
  		);
	} catch (\Conekta\ProccessingError $error){
  		echo $error->getMesage();
	} catch (\Conekta\ParameterValidationError $error){
  		echo $error->getMessage();
	} catch (\Conekta\Handler $error){
  		echo $error->getMessage();
	}

	try{
  		$order = \Conekta\Order::create(
    		array(
      			"line_items" => array(
        			array(
          				"name" => "Tacos",
          				"unit_price" => 1000,
          				"quantity" => 12
        			)//first line_item
      			), //line_items
      			"shipping_lines" => array(
        			array(
          				"amount" => 1500,
           				"carrier" => "FEDEX"
        			)
      			), //shipping_lines - physical goods only
      			"currency" => "MXN",
      			"customer_info" => array(
        			"customer_id" => $customer->id
      			), //customer_info
      			"shipping_contact" => array(
        			"address" => array(
          			"street1" => "Calle 123, int 2",
          			"postal_code" => "06100",
          			"country" => "MX"
        		)//address
      		), //shipping_contact - required only for physical goods
      		"metadata" => array("reference" => "12987324097", "more_info" => "lalalalala"),
      		"charges" => array(
          		array(
              		"payment_method" => array(
                      	"type" => "default"
              		) //payment_method - use customer's default - a card
                	//to charge a card, different from the default,
                	//you can indicate the card's source_id as shown in the Retry Card Section
          		) //first charge
      		) //charges
    	)//order
  	);
	} catch (\Conekta\ProcessingError $error){
  		echo $error->getMessage();
	} catch (\Conekta\ParameterValidationError $error){
  		echo $error->getMessage();
	} catch (\Conekta\Handler $error){
  		echo $error->getMessage();
	}

	echo "ID: ". $order->id;
	echo "<br>Status: ". $order->payment_status;
	echo "<br>$". $order->amount/100 . $order->currency;
	echo "<br>Order";
	echo $order->line_items[0]->quantity ."-". 
		$order->line_items[0]->name ."- $". 
		$order->line_items[0]->unit_price/100;
	echo "<br>Payment info";
	echo "<br>CODE:". $order->charges[0]->payment_method->auth_code;
	echo "<br>Card info:" .
      	"- ". $order->charges[0]->payment_method->name .
      	"- ". $order->charges[0]->payment_method->last4 .
      	"- ". $order->charges[0]->payment_method->brand .
      	"- ". $order->charges[0]->payment_method->type;

	// Response
	// ID: ord_2fsQdMUmsFNP2WjqS
	// $ 135.0 MXN
	// Order
	// 12 - Tacos - $10.0
	// Payment info
	// CODE: 035315
	// Card info: 4242 - visa - banco - credit

?>