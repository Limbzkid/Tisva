<pre><?php print_r($node); exit; ?></pre>

<?php if($node->type == "product" && $view_mode == 'full'): ?>
	<?php
		$nid = $node->nid;
		$title = $node->title;
		$status = $node->status;
		$model = $node->model;
		$price = number_format($node->list_price, 2, '.', '');
		$desc = $node->body['und'][0]['value'];
		$category = $node->taxonomy_catalog['und'][0]['taxonomy_term']->name;
		$tid = $node->taxonomy_catalog['und'][0]['taxonomy_term']->tid;
		$vid = $node->taxonomy_catalog['und'][0]['taxonomy_term']->vid;
		$image_uri = $node->uc_product_image['und'][0]['uri'];
		$image_path = file_create_url($image_uri);
		$material = $node->field_material['und'][0]['value'];
		$color = $node->field_color['und'][0]['value'];
		$installation = $node->field_installation['und'][0]['value'];
		$features = $node->field_features['und'][0]['value'];
		$tech_specs = $node->field_techincal_spec['und'][0]['value'];
		$spec_img = file_create_url($node->field_specification_image['und'][0]['uri']);
	?>
	
	<div class="wrapper">
		<div class="prodctDetailsWrap">
			<ul class="breadcrumb">
				<?php
					$term = taxonomy_term_load($tid);
					$term_uri = taxonomy_term_uri($term); // get array with path
					$term_title = taxonomy_term_title($term);
					$term_path = $term_uri['path'];
					$link = l($term_title,$term_path);
				?>
				<li><?php print $link?> - </li>
				<li><span><?php print $title; ?></span></li>
			</ul>
			<?php
				$sel_prod = '';
				$query = db_select('node', 'n');
				$query->leftJoin('field_data_field_color', 'fc', 'fc.entity_id = n.nid');
				$query->leftJoin('field_data_field_no_of_lamps', 'nl', 'nl.entity_id = n.nid');
				$query->leftJoin('taxonomy_term_data', 'td', 'td.tid = nl.field_no_of_lamps_tid');
				$query->fields('n', array('nid', 'title', 'created'))
				      ->fields('td', array('name'))
							->fields('fc', array('field_color_value'))
							->condition('n.type', array('product'), 'IN')
							->condition('n.title', $title, '=');
				$result = $query->execute();
				$prod_active = '';
				foreach($result as $row) {
					$option_val = $row->name .' '. $row->field_color_value;
					if($row->nid == $nid) {
						$sel_prod .= '<option value="'. $option_val. '" selected="selected" rel="'.$row->nid.'">'. $option_val .'</option>';
						$prod_active = $option_val;
					} else {
						$sel_prod .= '<option value="'. $option_val. '" rel="'.$row->nid.'">'. $option_val .'</option>';	
					}
				}
			?>
			
			<span class="item_code">Item code <?php print $model; ?></span>
			<div class="selectBox">
				<div class="selectedvalue"><?php print $prod_active; ?></div>
				<select class="nodeProduct" id="state" name="state"><?php print $sel_prod; ?></select>
			</div>
			<div class="lmpInfolhs">
				<?php print $desc; ?>
				<a class="readMore" href="javascript:;">Read More</a>
				<p class="mrp">MRP: <span class="rupees">`</span><?php print $price; ?></p>
			</div>
			
			
			<div class="lmpInforhs">
				<a href="javascript:;" class="magnifyBtn">
					<!--<img src="<?php //print image_style_url('thumbnail', $image_path) ?>" alt=""><span class="magnifier"></span>-->
					<img src="<?php print $image_path; ?>" alt=""><span class="magnifier"></span>
				</a>
			</div>
		</div> <!-- prodctDetailsWrap -->
		<div class="prdctTabsWrap">
			<ul class="tabs">
				<li><a href="javascript:;">Design &amp;<br> Features</a></li>
				<li><a href="javascript:;" class="singleLine">Interested?</a></li>
				<li><a href="javascript:;" class="singleLine">Features</a></li>
			</ul>
			<div class="tabContent">
				<ul>
					<li>Material<br><?php print $material; ?></li>
					<li>Color<br><?php print $color; ?></li>
					<li>Installation<br><?php print $installation; ?></li>
					<?php print strip_tags($features, '<li>'); ?>
				</ul>
				<p class="title">Suitable for</p>
				<ul class="suitableFor">
					<?php
						foreach($node->field_spaces_applicable['und'] as $suit) {
							$suitable_for = $suit['taxonomy_term']->name;
							$suit_image = file_create_url($suit['taxonomy_term']->field_icon['und'][0]['uri']);
							print '<li><span><img src="'.$suit_image.'" alt=""></span><span>'.$suitable_for.'</span></li>';
						}
					?>
				</ul>
			</div>
			<div class="tabContent">
				<form name='prdfrm<?php print $i;?>' id='prdfrm<?php print $i;?>' action='' method="POST">
					<input type="hidden" name="modelName" value="<?php print $product->model;?>">
					<div class="left_bottom_section">
						<p class="title">Check availability, price!</p>
						<div class="fld">
							<input type="number" max="9999999999" autocomplete="off" maxlength="10" id="mobile1<?php print $i;?>" name="mobile1" onfocus="myFocus(this)" onblur="myBlur(this)" value="Enter Your mobile" placeholder="Enter Your mobile">
							<label class="error" id="error1<?php print $i;?>">Please enter only digits.</label>
						</div>
						<div class="fld">
							<div class="selectBox">
								<div id="box" class="box">Select City</div>
								<select onChange="this.parentNode.getElementsByTagName('div')[0].innerHTML=this.options[this.selectedIndex].text" id="city<?php print $i;?>" name="city">
									<option value="" class="primero">Select City</option>
									<?php 
										$vid = taxonomy_vocabulary_machine_name_load("store_location")->vid;
										$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=2);
										$selected = "";
										foreach($terms as $term){
											$selected = "";
										}
									?>
									<option value="<?php echo $term->name?>" <?php echo $selected?> ><?php echo $term->name?> </option>
								<?php //} ?>
								</select>
							</div>
							<label class="error" id="error2<?php print $i;?>">Please select city.</label>
						</div>
						<p class="antispam">Leave this empty:
						<br /><input name="url" /></p>
						<a href="javascript:;" class="link_btn" id="submitfrm<?php print $i;?>">Have us call you</a>
						<h2 id="successMsg<?php print $i;?>" class="successMsg" style="display:none;">We will contact you shortly</h2>
					</div>
				</form>
				
				
				
				
				
				<p class="title">Check availability, price!</p>
				<div class="formWrap">
					<div class="fieldWrap">
						<div class="inputWrap">
							<input name="" type="text" onblur="clearText(this)" onfocus="clearText(this)" value="Enter Your Mobile">
						</div>
					</div>
					<div class="selectBox">
						<div class="selectedvalue">Select State</div>
						<select id="state" name="state">
							<option class="primero" value="Select State">Select State</option>
							<option value="Haryana">Haryana</option>
							<option value="Telangana">Telangana</option>
							<option value="Chandigarh">Chandigarh</option>
							<option value="Maharashtra">Maharashtra</option>
							<option value="Uttar Pradesh">Uttar Pradesh</option>
							<option value="Punjab">Punjab</option>
							<option value="Delhi">Delhi</option>
							<option value="Tamil Nadu">Tamil Nadu</option>
							<option value="Gujarat">Gujarat</option>
						</select>
					</div>
					<div class="formBtns">
						<input name="" type="button" value="Have us call you">
					</div>
				</div>
			</div>
			<!-- 				Tech Specs and Related Products 				-->
			<div class="tabContent">
					<?php if(empty($node->field_sub_category)):?>
						<p class="title">The Specifications</p>
						<?php if(!empty($node->field_specification_image)): ?>
							<div class="imgBox"><img src="<?php print $spec_img; ?>" alt=""></div>
						<?php endif; ?>
						<?php print str_replace('<ul>', '<ul class="specifications">',$tech_specs); ?>
					<?php else: ?>
						<table class="responsive" width="100%" border="0" cellspacing="0" cellpadding="0">
							<tbody>
								<tr class="table_head">
									<th>ITEM CODE</th>
									<th>P05612U</th>
									<th>P05622U</th>
									<th>P05112U</th>
									<th>P05122U</th>
								</tr>
								<tr>
									<td>RATED WATTAGE</td>
									<td>5 W</td>
									<td>5 W</td>
									<td>5 W</td>
									<td>5 W</td>
								</tr>
								<tr>
									<td>LAMP TYPE</td>
									<td>2V</td>
									<td>2V</td>
									<td>2V</td>
									<td>2V</td>
								</tr>
								<tr>
									<td>CAPSULE TYPE</td>
									<td>T 3</td>
									<td>T 3</td>
									<td>T 3</td>
									<td>T 3</td>
								</tr>
								<tr>
									<td>BASE</td>
									<td>B22D</td>
									<td>ES14</td>
									<td>B22D</td>
									<td>ES14</td>
								</tr>
								<tr>
									<td>RATED VOLTAGE</td>
									<td>220V-240 V</td>
									<td>220V-240 V</td>
									<td>220V-240 V</td>
									<td>220V-240 V</td>
								</tr>
								<tr>
									<td>RATED FREQUENCY</td>
									<td>50 HZ</td>
									<td>50 HZ</td>
									<td>50 HZ</td>
									<td>50 HZ</td>
								</tr>
								<tr>
									<td>CCT</td>
									<td>2700 KELVIN/ <br>WARM YELLOW</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>POWER FACTOR</td>
									<td>0.85</td>
									<td>0.85</td>
									<td>0.85</td>
									<td>0.85</td>
								</tr>
								<tr>
									<td>RATED LUMINOUS FLUX</td>
									<td>220 LUMEN</td>
									<td>220 LUMEN</td>
									<td>225 LUMEN</td>
									<td>225 LUMEN</td>
								</tr>
								<tr>
									<td>MAXIMUM LENGTH (IN MM)</td>
									<td>106.0 MAX</td>
									<td>106.0 MAX</td>
									<td>106.0 MAX</td>
									<td>110.0 MAX</td>
								</tr>
								<tr class="prices">
									<td>MRP (in Rs.)</td>
									<td>150.00</td>
									<td>150.00</td>
									<td>150.00</td>
									<td>150.00</td>
								</tr>
							</tbody>
						</table>
					<?php endif; ?>	
			</div>
		</div>
	</div>
	
	
<?php elseif($node->type == "page"): ?>  <!-- Other nodes--> 
	<div class="content">
    <div class="page_wrapper">
    	<div class="overview_top text_cont">
        <h1><span></span><?php echo $title;?></h1>
        <div class="wrapMid">
					<?php
						if(isset($content['field_image'])) { 
							//print render($content['field_image']);
						}
						echo ($node->body['und'][0]['value']);
					?>
      	</div>
      </div>
    </div>
  </div>
<?php endif; ?>

<script type="text/javascript">

	jQuery(function() {
		
		$("label.error").hide();
		var activeLi=$(".lamps_list li.active").index();
	
		$('.lamps_list > li .lamp_data').click(function() {										
			activeLi = $(this).parent('li').attr('rel');
			activeLiPrice = $('#'+activeLi+'_pl').html();
			$("#mrp_code").html(activeLiPrice);
		});
	
	var k="<?php print $i;?>";
	for(var activeLi=0;activeLi < k;activeLi++) {
		$('.lamps_list > li .lamp_data').click(function(){										
			activeLi = $(this).parent('li').index();
		});
		$( "#submitfrm"+activeLi).click(function() {
			var phone = $("input#mobile1"+activeLi).val();
			var city1 = $("input#city"+activeLi).val();
			var flag1=true;
			var flag2=true;
			var flag3=true;
			if (phone == "" || phone == "Enter Your mobile") {
				$("label#error1"+activeLi).text("Please enter your phone number").show(); //Show error
				flag3=false;
			} else if((phone !== "" && !$.isNumeric(phone)) || phone.length<10 || phone=='' || phone=='0000000000') {
			$("label#error1"+activeLi).text('Please enter valid mobile number').show(); //Show error
				flag1=false;
			}
		
			if ($("select#city"+activeLi).val()=="") {
				$("label#error2"+activeLi).show(); //Show error
				flag2=false;
			}
		
			if(flag1==true && flag3==true)	{
				$("label#error1"+activeLi).hide();
			}
			if(flag2==true) {
				$("label#error2"+activeLi).hide();
			}
		
			if(flag1==true && flag2==true && flag3==true) {
				var data = jQuery("#prdfrm"+activeLi).serialize();
				jQuery.ajax({
					data: data,
					type: "post",
					url: "http://<?php print $_SERVER['HTTP_HOST'] . '/' . request_uri();?>",
					success: function(data){
						$("#mobile1"+activeLi).val("Enter Your mobile");
						$("#city"+activeLi).val("");
						$("#city"+activeLi+" option[value='']").attr('selected', true)
					
						$("#successMsg"+activeLi).show();
					}
				});
			} else {
			  return false;
			}
		});
	
	
	$(window).keydown(function(event){
	if(event.keyCode == 13) {
	event.preventDefault();
	return false;
	}
	});
	

	/*$("input#mobile1").keydown(function(e)
	{
		var key = e.charCode || e.keyCode || 0;
		return (((key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16)));
	});*/

	$("input#mobile1"+activeLi).keydown(function(e)
	{
		var key = e.charCode || e.keyCode || 0;
		var curchr = $("#mobile1"+activeLi).val().length;
		return (((key >= 96 && key <= 105) || (key >= 48 && key <= 57) || (key == 8 || key == 46 || key == 16 || key == 37 || key == 39)) && (curchr <= 9 || (curchr > 9 && (key == 8 || key == 46 || key == 16 || key == 37 || key == 39))));
	});
	} 
	});
	


</script>

