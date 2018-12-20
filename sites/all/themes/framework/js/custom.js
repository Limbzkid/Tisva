$(function() {
	
	$(".mobileNo").keydown(function(e) {
		var key = e.charCode || e.keyCode || 0;
		var curchr = $(this).val().length;
		return (((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16 || key == 37 || key == 39)) && (curchr <= 9 || (curchr > 9 && (key == 8 || key == 46 || key == 16 || key == 37 || key == 39))));
	});
	
	$(".readMore").live('click', function() {
		if($(".fullDesc").hasClass("dnone")) {
			$(".fullDesc").removeClass("dnone");
			$(".shortDesc").addClass("dnone");
			$(this).text("Read Less");
		} else if($(".shortDesc").hasClass("dnone")) {
			$(".fullDesc").addClass("dnone");
			$(".shortDesc").removeClass("dnone");
			$(this).text("Read More");
		}
	});
	  
  $(".loadMore").click(function() {
    var tnid = $(".product-slide").children().last().attr("rel");
    $.ajax({
      type: "POST",
      dataType: 'json',
      url: '/load-more-products-ajax',
      data: { tnid: tnid },
      success: function(rec) {
        if(rec.output == '') {
          $(".loadMore").remove();
        } else {
          $(".product-slide").append(rec.output);
					if(rec.load_more == 0) {
						$(".loadMore").remove();
					}
        }
      }
    });
  });
  
  
  $(".nodeProduct").change(function() {
    var temp = $('option:selected').attr("rel").split('-');
		if(temp[0] == 'n') {
			var nid = temp[1];
			var tid = 0;
		} else {
			var nid = 0;
			var tid = temp[1];
			var pid = temp[0];
		}
		if(nid != 0) {
			$.ajax({
				type: "POST",
				dataType : "json",
				url: '/get-products-nid-ajax',
				data:{nid : nid},
				success: function(data) {
					$(".breadcrumb").find("li:last").find("span").html(data.title);
					$(".item_code").html('Item code ' + data.model);
					//$(".lmpInfolhs").html(data.body);
					$(".mrp").html('MRP: <span class="rupees">` </span>'+ data.price);
					$(".lmpInforhs").find("img").attr("src", data.image);
					$(".tabContent").first().html(data.features);
					$(".tabContent").last().html(data.tech_specs);
				}
			});
		} else {
			$.ajax({
				type: "POST",
				dataType : "json",
				url: '/get-products-tid-ajax',
				data:{tid : tid, pid : pid},
				success: function(data) {
					console.log(data);
					$(".item_code").html('Item code ' + data.model);
					$(".mrp").html('MRP: <span class="rupees">` </span>'+ data.price);
					$(".lmpInforhs").find("img").attr("src", data.image);
					$(".tabContent").first().html(data.features);
					$(".prdctTabsWrap").find("table").find("tbody").html(data.tech_specs);
				}
			});
			
		}
  });
	
	$(".prodFormSubmit").click(function() {
		var error = false;
		var model = $(".item_code").html();
		var mobile = $(".mobileNo").val();
		var state = $(".formWrap .selectedvalue").html();
		if(mobile == '' && state == 'Select State') {
			error = true;
			$(".mobErr").removeClass("dnone");
			$(".cityErr").removeClass("dnone");
		}
		if (mobile == '') {
			$(".mobErr").removeClass("dnone");
			error = true;
		}
		if (state == 'Select State') {
			$(".cityErr").removeClass("dnone");
			error = true;
		}
		if(!error) {
			$.ajax({
				type: "POST",
				dataType : "json",
				url: '/product-notify-ajax',
				data:{model : model, mobile: mobile, state: state},
				success: function(data) {
					console.log(data.error);
					if(data.error == 1) {
						for(var x in data.msg) {
							var resp = data.msg[x].split("-");
							var elemClass = resp[0];
							var elemMsg = resp[1];
							$("."+elemClass).removeClass("dnone").text(elemMsg);
						}

					} else {
						if(!$(".mobErr").hasClass("dnone")) {
							$(".mobErr").addClass("dnone")
						}
						if(!$(".cityErr").hasClass("dnone")) {
							$(".cityErr").addClass("dnone")
						}
						$(".mobileNo").val('');
						$(".selectedvalue").html('Select State');
						$(".thankYouMsg").removeClass("dnone").text(data.msg);
					}
				}
			});
		}

	});

});