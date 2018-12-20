// Jquery validation file, for client side data checking and validating

$(document).ready(function() {
	//alert("test");
	$("form").attr('autocomplete', 'off'); // Switching form autocomplete attribute to off
	$('form').on('submit', function (e) {
		e.preventDefault(); // Prevent default action of the form that is submission
		$( "div.errorFeedback" ).remove();
		var submitForm = true;

		//Regexes for name, email, mobile and unique code in case some one tried to put illegal characters
		var check_name = /^[A-Za-z0-9.' ]{3,50}$/;
		var check_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
		var check_mobile = /^[1-9][0-9]{9}$/;
		var check_unqiue_code = /^[A-Za-z0-9]/;
		$("#frmFeedback input[type=text],input[type=email],input[type=file],textarea").each(function() {
			// Looping through elements of type text, email and file for checking their emptiness and valid data
			if($.trim($(this).val()) == "" || $.trim($(this).val()) == $(this).attr('placeholder'))
			{
				if($(this).attr('type') == "file")
				{
					$(this).after('<div class="errorfile">This field is required</div>');
				}
				else
				{
					$(this).after('<div class="errorFeedback">This field is required</div>');
				}
				$(this).focus();
				submitForm = false;
				return false;
			}

			// Validating customer name
			if($(this).attr("id") == "user_name")
			{
				if(!check_name.test($(this).val()))
				{
					$(this).after('<div class="errorFeedback">Please enter appropriate name</div>');
					$(this).focus();
					submitForm = false;
					return false;
				}
			}

			// Validating customer email
			if($(this).attr("id") == "user_email")
			{
				if(!check_email.test($(this).val()))
				{
					$(this).after('<div class="errorFeedback">Please enter appropriate email</div>');
					$(this).focus();
					submitForm = false;
					return false;
				}
			}


			// Validating customer address
			if($(this).attr("id") == "user_suggestion")
			{
				if(checkAttemptOfTag($(this).val()))
				{
					$(this).after('<div class="errorFeedback">Please enter appropriate suggestion</div>');
					$(this).focus();
					submitForm = false;
					return false;
				}
			}

		
		});
		if(submitForm == false)
		{
			return false;
		}
		else
		{
			//return true;
			

			// Appending something uique to this form which can be done only using javascript, it's the key to run this form without javascript
			$('#frmFeedback').append("<input type='hidden' name='ajaxVal' value='ajax' />");
			//var form_data = new FormData(); // Instantiating form object
			
			//form_data.append('file', file_data); // Appending file object to post
			/*$("#frmFeedback input[type=text],input[type=email],input[type=hidden],textarea").each(function() {
				//Appending every elements within form to post
				form_data.append($(this).attr("name"), $(this).val() )
				
			});*/
			//alert(form_data);
			//$(".loader").show();
			//$(".inner-form-content").hide();
			var form_data = $('#frmFeedback').serialize();
			$( "div.errorFeedback" ).remove();
			$.ajax({
				url: base_url+'/offer/procesUserRequest.php', // point to server-side PHP script
				dataType: 'json',  // what to expect back from the PHP script, if anything it's in Json format so parsing will be easy
				cache: false,
				data: form_data,
				type: 'post',
				success: function(php_script_response){
					// Response from server
					$( "div.errorFeedback" ).remove();
					//$(".loader").hide();
					
					if(php_script_response.error_type == "exception")
					{
						// Displaying errors which are exceptional
						alert(php_script_response.message);
						$(".inner-form-content").show();
					}
					else if(php_script_response.error_type == "success")
					{
						//alert("Success");
						// Displaying success message
						var heightOfFormContainer =$( ".feedbackFormContainer" ).outerHeight(true);
						$(".feedbackFormContainer").hide();
						$('.feedbackThankYou').css({minHeight: heightOfFormContainer});
						$(".feedbackThankYou").show();
						$("#frmFeedback input[type=text],input[type=email],input[type=hidden],input[type=file],textarea").each(function() {
							$(this).val(" ");
						});
					}

					// Emptying code hidden field and putting new token from server there
					$("#code").val(" ");
					$("#code").val(php_script_response.csrf_token);

					// Emptying all textboxes, if something wrong happens
					

				}
			});
		}
	});

	$('#cmbRegions').on('change', function () {

		var selectedValueInMumeric = $("#cmbRegions option:selected").attr("data-rel");
		var actionType = "getCityList";
		var selectedCity = $("#txtSelectedCity").val();
		var city = "";
		$(".errorSearch").css("visibility","hidden");
		$("#cmbCities").parent().find('.selectedvalue').text("Please Select");
		$("#txtSelectedRegion").val(selectedValueInMumeric);
		if(selectedCity != ""){
			$("#txtSelectedCity").val(" ");

		}
		//$("#txtSelectedCity").val(" ");
		$.ajax({
				url: base_url+'/offer/getDealersList.php', // point to server-side PHP script
				dataType: 'json',  // what to expect back from the PHP script, if anything it's in Json format so parsing will be easy
				cache: false,
				data:  {
					selectedValueInMumeric:selectedValueInMumeric,
					actionType:actionType
				},
				type: 'post',
				success: function(cityLists){
					//console.log(cityLists);
					$("#cmbCities").html(" ");
					var cityCounter =0;
					$("#cmbCities").append('<option value="Please select city">Please select city</option>')
					for( city in cityLists)
					{
						var objOfCity = cityLists[city];
						if(cityCounter == 0)
						{
							//$("#txtSelectedCity").val(objOfCity.city);
						}
						
						$("#cmbCities").append('<option value="'+objOfCity.city+'">'+objOfCity.city+'</option>')
						cityCounter++;
					}
					

				}
			});
	});

	$('#cmbCities').on('change', function () {
		var thisComboId=$(this).attr("id");
		var selectedCityText =$("#"+thisComboId+" option:selected").text();
		if($(this).val() == "Please select city"){
			$("#txtSelectedCity").val("");
		}
		else
		{
			$("#txtSelectedCity").val(selectedCityText);
		}
		
	});

	
	$('.searchLink').on('click', function () {
		var regionIdForSearch = $.trim($("#txtSelectedRegion").val());
		var cityNameForSearch = $.trim($("#txtSelectedCity").val());
		if(regionIdForSearch == "" && cityNameForSearch == "" )
		{
			//alert("Please select at least region for results");
			//$(".delearLocaterAddress ul").append('<li><div class="addressContainer"><h2>Please select at least state for dealer</h2></div></li>');
			//$("#cmbRegions").parent().after('<div class="errorSearch">Please at least select state for dealer</div>');
			$(".errorSearch").css("visibility","visible");
			return false;
		}
		var actionType = "getDealersList";
		var city = "";
		//$("#txtSelectedRegion").val(selectedValueInMumeric);
		$.ajax({
				url: base_url+'/offer/getDealersList.php', // point to server-side PHP script
				dataType: 'json',  // what to expect back from the PHP script, if anything it's in Json format so parsing will be easy
				cache: false,
				data:  {
					regionIdForSearch:regionIdForSearch,
					cityNameForSearch:cityNameForSearch,
					actionType:actionType
				},
				type: 'post',
				success: function(dealersLists){
					//alert("test");
					//console.log(dealersLists);
					//alert(dealersLists);
					//$("#cmbCities").html(" ");
					var cityCounter =0;
					$(".delearLocaterAddress ul").html(" ");
					for( dealer in dealersLists)
					{
						var objOfDealer = dealersLists[dealer];
					
						//$(".delearLocaterAddress ul").append(objOfDealer.city);
						//$(".delearLocaterAddress ul").append('<li><div><h2>S.P. DISTRIBUTORS</h2><p> Godown Address:- P/60,Industria Area, Kokar...</p><p>	Mailing Address:- A C Market,GEL Church Complex,main Rd,Jharkhand, Ranchi</p><p>9431107268 / 0651-2330044</p></div></li>');
						$(".delearLocaterAddress ul").append('<li><div class="addressContainer"><h2>'+objOfDealer.dealer_name+'</h2><p> Godown Address:- NA</p><p>Mailing Address:- '+objOfDealer.dealer_address+', '+objOfDealer.dealer_street1+'</p><p>'+objOfDealer.dealer_mobile+' / '+objOfDealer.dealer_telephone+'</p></div></li>');
						//alert(objOfDealer);
						//$("#cmbCities").append('<option value="'+objOfCity.city+'">'+objOfCity.city+'</option>')
						cityCounter++;
					}
					

				}
			});
	});
});

/**
 * [checkAttemptOfTag Check if someone attempts to put wrong characters]
 * @param  [string] inputVal [Value entered by user]
 * @return [boolean] [True if we found any suspecting elements, False we don't find any]
 */
function checkAttemptOfTag(inputVal)
{
	if(inputVal.indexOf("<") > 0 || inputVal.indexOf(">") > 0 )
	{
		return true;
	}
	else
	{
		return false;
	}
}
