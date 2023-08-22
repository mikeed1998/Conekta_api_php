<!DOCTYPE html>
<html>
<head>
	<title>Conekta</title>
	<script type="text/javascript" src="https://cdn.conekta.io/js/latest/conekta.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<style>
		.expiration-date {
  display: flex;
  align-items: center;
}

.input-field {
  width: 40px; /* Ajusta el ancho según tus necesidades */
  padding: 5px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.separator {
  padding: 0 5px;
}

	</style>
</head>
<body>

	<div class="container-fluid py-5">
		<div class="row">
			<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-9 col-sm-11 col-xs-11 col-11 mx-auto">
			<form action="cobro.php" method="POST" id="card-form">
  				<span class="card-errors bg-danger text-white py-2 rounded"></span>
	  			<div class="form-group py-2 mt-2">
    				<div class="col">
						<input class="form-control" size="20" data-conekta="card[number]" type="text" style="border: 2px solid #4866E0; box-shadow: none;" placeholder="Card Number">
					</div>
  				</div>
				<div class="form-group py-4">
					<div class="row">
						<div class="col-6">
							<div class="row">
								<div class="col-6">
									<input size="2" maxlength="2" class="form-control" data-conekta="card[exp_month]" type="text" style="border: 2px solid #4866E0; box-shadow: none;" placeholder="Month">
								
								</div>
								<div class="col-6">
									
									<input  size="4" maxlength="4" class="form-control" data-conekta="card[exp_year]" type="text" style="border: 2px solid #4866E0; box-shadow: none;" placeholder="Year">
								</div>
							</div>
						</div>
						<div class="col-6">
							<input class="form-control" maxlength="4" size="4" data-conekta="card[cvc]" type="text" style="border: 2px solid #4866E0; box-shadow: none;" placeholder="CVV">
						</div>
					</div>
				</div>
				<div class="form-group py-2">
					<div class="col">
						<input class="form-control" size="20" data-conekta="card[name]" type="text" style="border: 2px solid #4866E0; box-shadow: none;" placeholder="Cardholder name">
					</div>
				</div>
				<div class="form-group py-2">
					<div class="col">
						<button class="btn w-100 fs-5" style="color: white; background-color: #4866E0;" type="submit" >Finalize</button>
					</div>
				</div>
				<div class="form-group">
					<div class="col text-center">
						<img src="conekta.png" alt="" class="img-fluid">
					</div>
				</div>
			</form>
		</div>
	</div>
		
	

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

	<script type="text/javascript" >
  		Conekta.setPublicKey('key_Nd9OEqq52Cb3jDrzzGodG1Y');

  		var conektaSuccessResponseHandler = function(token) {
    		var $form = $("#card-form");
    		//Inserta el token_id en la forma para que se envíe al servidor
     		$form.append($('<input name="conektaTokenId" id="conektaTokenId" type="hidden">').val(token.id));
    		$form.get(0).submit(); //Hace submit
  		};
  		
		var conektaErrorResponseHandler = function(response) {
    		var $form = $("#card-form");
    		$form.find(".card-errors").text(response.message_to_purchaser);
    		$form.find("button").prop("disabled", false);
  		};

  		//jQuery para que genere el token después de dar click en submit
  		$(function () {
    		$("#card-form").submit(function(event) {
      			var $form = $(this);
      			// Previene hacer submit más de una vez
      			$form.find("button").prop("disabled", true);
      			Conekta.Token.create($form, conektaSuccessResponseHandler, conektaErrorResponseHandler);
      			return false;
    		});
  		});
	</script>

</body>
</html>