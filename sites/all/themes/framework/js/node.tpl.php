<pre><?php //print_r($node); exit; ?></pre> 

<?php if($node->type == "product" && $view_mode == 'full'): ?>
	<?php
		$nid = $node->nid;
		$title = $node->title;
		$status = $node->status;
		$model = $node->model;
		$price = number_format($node->list_price, 2, '.', '');
		$desc = str_replace('class="MsoNormal"', '', $node->body['und'][0]['value']);
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
		$tech_specs_1 = $node->field_technical_specification_wh['und'][0]['value'];
		$spec_img = file_create_url($node->field_specification_image['und'][0]['uri']);
		$first_tid = '';
		if(!empty($node->field_sub_category)) {
			$parent_tid = $node->field_sub_category['und'][0]['taxonomy_term']->tid;
		}
		
		//echo 'TID '.$tid;
		//exit;
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
				$field_sub_category = $node->field_sub_category;
				//$field_related_products = $node->field_related_products;
				$prod_active = '';
				
/*------------------------------------------------------------------------------------------------------------------------*/

					$sel_prod = '';
					$query = db_select('node', 'n');
					$query->leftJoin('uc_products', 'ucp', 'ucp.nid = n.nid');
					$query->leftJoin('field_data_taxonomy_catalog', 'tc', 'tc.entity_id = n.nid');
					$query->leftJoin('field_data_field_sub_category', 'fsc', 'fsc.entity_id = n.nid');
					$query->leftJoin('field_data_field_color', 'fc', 'fc.entity_id = n.nid');
					$query->leftJoin('field_data_field_no_of_lamps', 'nl', 'nl.entity_id = n.nid');
					$query->leftJoin('taxonomy_term_data', 'td', 'td.tid = nl.field_no_of_lamps_tid');
					$query->fields('n', array('nid', 'title', 'created', 'status'))
				      ->fields('td', array('name'))
							->fields('ucp', array('model'))
							->fields('fc', array('field_color_value'))
							->condition('n.type', array('product'), 'IN')
							->condition('n.status', 1, '=')
							->condition('tc.taxonomy_catalog_tid', $tid, '=');
					if($parent_tid== 22 || $parent_tid== 34 || $parent_tid== 35 || $parent_tid== 32) {
						$query->condition('fsc.field_sub_category_tid', $field_sub_category['und'][0]['tid'], '=');
					} else {
						$query->condition('n.title', $title, '=');
					}
					$query->orderBy('n.nid', DESC )
							  ->groupBy('n.nid');
					$result = $query->execute();
					//foreach($result as $row) {
					//	echo '<pre>';
					//	print_r($row);
					//	
					//	echo '</pre>';
					//}
					//exit;
					$model = '';
					foreach($result as $row) {
						//echo $nid . ' ' . $row->nid . '<br/>';
						if($model != $row->model) {
							$option_val = $row->name .' '. $row->field_color_value;
							if($row->nid == $nid) {
								$sel_prod .= '<option value="'. $option_val. '" selected="selected" rel="n-'.$row->nid.'">'. $option_val .'</option>';
								$prod_active = $option_val;
							} else {
								$sel_prod .= '<option value="'. $option_val. '" rel="n-'.$row->nid.'">'. $option_val .'</option>';	
							}
							$model = $row->model;
						}
					}

/*------------------------------------------------------------------------------------------------------------------------*/
			?>
			<span class="item_code">Item code <?php print $node->model; ?></span>
			<div class="selectBox">
				<div class="selectedvalue"><?php print $prod_active; ?></div>
				<select class="nodeProduct" id="state" name="state"><?php print $sel_prod; ?></select>
			</div>
			
			<?php
				
				
				
				
				
				
				if(empty($field_sub_category) || $tid == 5 || $parent_tid== 22 || $parent_tid== 34) {
					
				} else {
					$sel_prod = '';
					
					$result = taxonomy_get_children($node->field_sub_category['und'][0]['taxonomy_term']->tid, $node->field_sub_category['und'][0]['taxonomy_term']->vid);
					$first = true;
					
					//foreach($result as $row) {
					//	echo '<pre>';
					//	print_r($row);
					//	echo '</pre>';
					//}
					//exit;
					foreach($result as $row) {
						$option_val = $row->name;
						if($first) {
							$sel_prod .= '<option value="'. $option_val. '" selected="selected" rel="'.$parent_tid.'-'.$row->tid.'">'. $option_val .'</option>';
							$prod_active = $option_val;
							$qry = db_query("SELECT n.nid FROM {node} n LEFT JOIN {field_data_field_sub_category} fs ON fs.entity_id = n.nid WHERE fs.field_sub_category_tid =:arg", array(':arg' => $row->tid));
							$roww = $qry->fetchAssoc();
							if(!empty($roww)) {
								$first = false;
								$first_tid = $row->tid;
							}
							
						} else {
							$sel_prod .= '<option value="'. $option_val. '" rel="'.$parent_tid.'-'.$row->tid.'">'. $option_val .'</option>';	
						}
					}
				}
				//foreach($result as $row) {
				//	echo '<pre>';
				//	print_r($row);
				//	echo '</pre>';
				//	exit;
				//}
				$shortdesc = '';
				$word_cnt = str_word_count($desc);
				if($word_cnt > 20) {
					$numwords = 20;
					preg_match("/(\S+\s*){0,$numwords}/", $desc, $regs);
					$shortdesc = trim($regs[0]) .'...';
					$shortdesc = str_replace('<p', '<p class="shortDesc"',trim($regs[0]) .'...');
					$desc = str_replace('<p', '<p class="fullDesc dnone"', $desc);
				}
				
			?>
			
			
			<div class="lmpInfolhs">
				<?php print $shortdesc . $desc; ?>
				<?php if($word_cnt > 20): ?>
					<a class="readMore" href="javascript:;">Read More</a>
				<?php endif; ?>
				<p class="mrp">MRP: <span class="rupees">` </span><?php print $price; ?></p>
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
				<li><a href="javascript:;" class="singleLine">Technical <br> Specs</a></li>
			</ul>
			<div class="tabContent">
				<ul>
					<li>Material<br><?php print $material; ?></li>
					<li>Color<br><?php print $color; ?></li>
					<li>Installation<br><?php print $installation; ?></li>
					<?php if($tid == 5): ?>
						<li>Dimensions<br><?php print $node->field_dimensions['und'][0]['value']; ?></li>
					<?php endif; ?>
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
				<p class="title">Check availability, price!</p>
				<div class="formWrap">
					<div class="fieldWrap">
						<input name="mobile" type="text" onblur="clearText(this)" onfocus="clearText(this)" value="Enter Your Mobile" class="inputWrap mobileNo" maxlength="10">
						<div class="mobErr dnone">Please enter your mobile number</div>
					</div>
					
					<div class="selectBox">
						<div class="selectedvalue frmSelectedVal">Select State</div>
						<select id="state" name="state">
							<option class="primero" value="Select State">Select State</option>
							<?php 
								$vid = taxonomy_vocabulary_machine_name_load("store_location")->vid;
								$terms = taxonomy_get_tree($vid,$parent=0, $max_depth=2);
								$selected = "";
								$options = '';
								foreach($terms as $term){
									$selected = "";
									$options .= '<option value="'.$term->name.'"'.$selected.'>'.$term->name.'</option>';
								}
								print $options;
							?>
						</select>
					</div>
					<div class="cityErr dnone" id="error2">Please select city.</div>
					<div class="formBtns">
						<input name="" type="button" value="Have us call you" class="prodFormSubmit">
					</div>
					<p class="thankYouMsg dnone">We'll get back to you shortly.</p>
					
				</div>
			</div>
			<!-- 				Tech Specs and Related Products 				-->
			<?php
				
			?>
			
			
			
			
			<div class="tabContent">
				
				<?php if(empty($field_sub_category) || $tid == 5 || $parent_tid== 22 || $parent_tid == 24 || $parent_tid== 34): ?>
					<?php if(empty($product->field_related_products)):?>
						<p class="title">The Specifications</p>
						<?php if(!empty($node->field_specification_image)): ?>
							<div class="imgBox"><img src="<?php print $spec_img; ?>" alt=""></div>
						<?php endif; ?>
						<?php print str_replace('<ul', '<ul class="specifications"',$tech_specs); ?>
						<?php print str_replace('<ul', '<ul class="specifications"',$tech_specs_1); ?>
					<?php endif; ?>
				<?php else: ?>  <!-- Led Lights -->
					
					<div class="selectBox">
						<div class="selectedvalue"><?php print $prod_active; ?></div>
						<select class="nodeProductTab" id="state" name="state"><?php print $sel_prod; ?></select>
					</div>
					<?php
						$item_code = '';
						$sell_price = '';
						$type_of_lamp = '';
						$no_of_lamp = '';
						$fitting_cap = '';
						$operating_voltage = '';
						$rated_voltage = '';
						$frequency = '';
						$rated_wattage.= '';
						$total_wattage = '';
						$cct = '';
						$luminous_flux = '';
						$rated_wattage = '';
						$no_of_leds = '';
						$wattage = '';
						$dimming = '';
						$remote_control = '';
						$base = '';
						$current = '';
						$life = '';
						$capsule_tpye = '';
						$power_factor = '';
						$rated_luminous_flux = '';
						$max_length = '';
					//echo 'TID: '.$parent_tid; exit;
					if($parent_tid == 35) {  // LED strip
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_wattage', 'frw', 'frw.entity_id = n.nid');
						$query->leftJoin('field_data_field_operating_voltage', 'fov', 'fov.entity_id = n.nid');
						$query->leftJoin('field_data_field_cct', 'cct', 'cct.entity_id = n.nid');
						$query->leftJoin('field_data_field_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_no_of_leds', 'fnl', 'fnl.entity_id = n.nid');
						$query->leftJoin('field_data_field_wattage', 'fw', 'fw.entity_id = n.nid');
						$query->leftJoin('field_data_field_dimming', 'fd', 'fd.entity_id = n.nid');
						$query->leftJoin('field_data_field_remote_control', 'frc', 'frc.entity_id = n.nid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('frw', array('field_rated_wattage_value'))
									->fields('fov', array('field_operating_voltage_value'))
									->fields('cct', array('field_cct_value'))
									->fields('ff', array('field_frequency_value'))
									->fields('fnl', array('field_no_of_leds_value'))
									->fields('fw', array('field_wattage_value'))
									->fields('fd', array('field_dimming_value'))
									->fields('frc', array('field_remote_control_value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$rated_wattage .= '<td>'.$row->field_rated_wattage_value.'</td>';
							$operating_voltage .= '<td>'.$row->field_operating_voltage_value.'</td>';
							if($row->field_cct_value == '') {
								$cct .= '<td>&nbsp;</td>';
							} else {
								$cct .= '<td>'.$row->field_cct_value.'</td>';
							}
							$frequency .= '<td>'.$row->field_frequency_value.'</td>';
							$no_of_leds .= '<td>'.$row->field_no_of_leds_value.'</td>';
							$wattage .= '<td>'.$row->field_wattage_value.'</td>';
							$dimming .= '<td>'.$row->field_dimming_value.'</td>';
							if($row->field_remote_control_value == 1) {
								$remote_control .= '<td>Yes</td>';	
							} else {
								$remote_control .= '<td>NA</td>';	
							}
							
						}
						
					} elseif($parent_tid == 27) { // LED Lamps
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_type_of_lamp', 'tol', 'tol.entity_id = n.nid');
						$query->leftJoin('field_data_field_base', 'b', 'b.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_voltage', 'frv', 'frv.entity_id = n.nid');
						$query->leftJoin('field_data_field_operating_voltage', 'fov', 'fov.entity_id = n.nid');
						$query->leftJoin('field_data_field_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_wattage', 'fw', 'fw.entity_id = n.nid');
						$query->leftJoin('field_revision_field_current', 'c', 'c.entity_id = n.nid');
						$query->leftJoin('field_revision_field_luminous_flux', 'lf', 'lf.entity_id = n.nid');
						$query->leftJoin('field_data_field_cct', 'cct', 'cct.entity_id = n.nid');
						$query->leftJoin('field_revision_field_life', 'l', 'l.entity_id = n.nid');
						$query->leftJoin('field_data_field_dimming', 'fd', 'fd.entity_id = n.nid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('tol', array('field_type_of_lamp_value'))
									->fields('b', array('field_base_value'))
									->fields('frv', array('field_rated_voltage_value'))
									->fields('fov', array('field_operating_voltage_value'))
									->fields('ff', array('field_frequency_value'))
									->fields('fw', array('field_wattage_value'))
									->fields('c', array('field_current_value'))
									->fields('lf', array('field_luminous_flux_value'))
									->fields('cct', array('field_cct_value'))
									->fields('l', array('field_life_value'))
									->fields('fd', array('field_dimming_value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();						
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$type_of_lamp .= '<td>'.$row->field_type_of_lamp_value.'</td>';
							$base .= '<td>'.$row->field_base_value.'</td>';
							$rated_voltage .= '<td>'.$row->field_rated_voltage_value.'</td>';
							$operating_voltage .= '<td>'.$row->field_operating_voltage_value.'</td>';
							$frequency .= '<td>'.$row->field_frequency_value.'</td>';
							$wattage .= '<td>'.$row->field_wattage_value.'</td>';
							$current .= '<td>'.$row->field_current_value.'</td>';
							$luminous_flux .= '<td>'.$row->field_luminous_flux_value.'</td>';
							$cct .= '<td>'.$row->field_cct_value.'</td>';
							$life .= '<td>'.$row->field_life_value.'</td>';
							$dimming .= '<td>'.$row->field_dimming_value.'</td>';
						}
					} elseif($parent_tid == 32 || $parent_tid == 33) {
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_type_of_lamp', 'tol', 'tol.entity_id = n.nid');
						$query->leftJoin('field_data_field_no_of_lamps', 'nol', 'nol.entity_id = n.nid');
						$query->leftJoin('field_revision_field_fitting_cap', 'ffc', 'ffc.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_voltage', 'frv', 'frv.entity_id = n.nid');
						$query->leftJoin('field_data_field_operating_voltage', 'fov', 'fov.entity_id = n.nid');
						$query->leftJoin('field_data_field_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_wattage', 'frw', 'frw.entity_id = n.nid');
						$query->leftJoin('field_revision_field_total_wattage', 'tw', 'tw.entity_id = n.nid');
						$query->leftJoin('field_data_field_cct', 'cct', 'cct.entity_id = n.nid');
						$query->leftJoin('field_revision_field_luminous_flux', 'lf', 'lf.entity_id = n.nid');
						$query->leftJoin('taxonomy_term_data', 'ttd', 'ttd.tid = nol.field_no_of_lamps_tid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('tol', array('field_type_of_lamp_value'))
									->fields('ttd', array('name'))
									->fields('ffc', array('field_fitting_cap_value'))
									->fields('frv', array('field_rated_voltage_value'))
									->fields('fov', array('field_operating_voltage_value'))
									->fields('ff', array('field_frequency_value'))
									->fields('frw', array('field_rated_wattage_value'))
									->fields('tw', array('field_total_wattage_value'))
									->fields('cct', array('field_cct_value'))
									->fields('lf', array('field_luminous_flux_value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();						
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$type_of_lamp .= '<td>'.$row->field_type_of_lamp_value.'</td>';
							$no_of_lamp .= '<td>'.$row->name.'</td>';
							$fitting_cap .= '<td>'.$row->field_fitting_cap_value.'</td>';
							$operating_voltage .= '<td>'.$row->field_operating_voltage_value.'</td>';
							$rated_voltage .= '<td>'.$row->field_rated_voltage_value.'</td>';
							$frequency .= '<td>'.$row->field_frequency_value.'</td>';
							$rated_wattage .= '<td>'.$row->field_rated_wattage_value.'</td>';
							$total_wattage .= '<td>'.$row->field_total_wattage_value.'</td>';
							$cct .= '<td>'.$row->field_cct_value.'</td>';
							$luminous_flux .= '<td>'.$row->field_luminous_flux_value.'</td>';
						}
					} elseif($parent_tid == 31) {
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_type_of_lamp', 'tol', 'tol.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_voltage', 'frv', 'frv.entity_id = n.nid');
						$query->leftJoin('field_data_field_operating_voltage', 'fov', 'fov.entity_id = n.nid');
						$query->leftJoin('field_data_field_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_wattage', 'frw', 'frw.entity_id = n.nid');
						$query->leftJoin('field_revision_field_total_wattage', 'tw', 'tw.entity_id = n.nid');
						$query->leftJoin('field_data_field_cct', 'cct', 'cct.entity_id = n.nid');
						$query->leftJoin('field_revision_field_luminous_flux', 'lf', 'lf.entity_id = n.nid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('tol', array('field_type_of_lamp_value'))
									->fields('frv', array('field_rated_voltage_value'))
									->fields('fov', array('field_operating_voltage_value'))
									->fields('ff', array('field_frequency_value'))
									->fields('frw', array('field_rated_wattage_value'))
									->fields('tw', array('field_total_wattage_value'))
									->fields('cct', array('field_cct_value'))
									->fields('lf', array('field_luminous_flux_value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();						
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$type_of_lamp .= '<td>'.$row->field_type_of_lamp_value.'</td>';
							$operating_voltage .= '<td>'.$row->field_operating_voltage_value.'</td>';
							$rated_voltage .= '<td>'.$row->field_rated_voltage_value.'</td>';
							$frequency .= '<td>'.$row->field_frequency_value.'</td>';
							$rated_wattage .= '<td>'.$row->field_rated_wattage_value.'</td>';
							if($total_wattage == '') {
								$total_wattage .= '<td>&nbsp;</td>';
							} else {
								$total_wattage .= '<td>'.$row->field_total_wattage_value.'</td>';
							}
							
							$cct .= '<td>'.$row->field_cct_value.'</td>';
							$luminous_flux .= '<td>'.$row->field_luminous_flux_value.'</td>';
						}
					} elseif($parent_tid == 30) {
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_type_of_lamp', 'tol', 'tol.entity_id = n.nid');
						$query->leftJoin('field_data_field_no_of_lamps', 'nol', 'nol.entity_id = n.nid');
						$query->leftJoin('field_revision_field_fitting_cap', 'ffc', 'ffc.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_voltage', 'frv', 'frv.entity_id = n.nid');
						$query->leftJoin('field_data_field_operating_voltage', 'fov', 'fov.entity_id = n.nid');
						$query->leftJoin('field_data_field_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_wattage', 'frw', 'frw.entity_id = n.nid');
						$query->leftJoin('field_revision_field_total_wattage', 'tw', 'tw.entity_id = n.nid');
						$query->leftJoin('taxonomy_term_data', 'ttd', 'ttd.tid = nol.field_no_of_lamps_tid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('tol', array('field_type_of_lamp_value'))
									->fields('ttd', array('name'))
									->fields('ffc', array('field_fitting_cap_value'))
									->fields('frv', array('field_rated_voltage_value'))
									->fields('fov', array('field_operating_voltage_value'))
									->fields('ff', array('field_frequency_value'))
									->fields('frw', array('field_rated_wattage_value'))
									->fields('tw', array('field_total_wattage_value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();
						//foreach($result as $row) {
						//	echo '<pre>';
						//	print_r($row);
						//	echo '</pre>';
						//	
						//}	exit;		
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$type_of_lamp .= '<td>'.$row->field_type_of_lamp_value.'</td>';
							if($no_of_lamp == '') {
								$no_of_lamp .= '<td>&nbsp;</td>';
							} else {
								$no_of_lamp .= '<td>'.$row->name.'</td>';
							}
							
							$fitting_cap .= '<td>'.$row->field_fitting_cap_value.'</td>';
							$operating_voltage .= '<td>'.$row->field_operating_voltage_value.'</td>';
							$rated_voltage .= '<td>'.$row->field_rated_voltage_value.'</td>';
							$frequency .= '<td>'.$row->field_frequency_value.'</td>';
							$rated_wattage .= '<td>'.$row->field_rated_wattage_value.'</td>';
							$total_wattage .= '<td>'.$row->field_total_wattage_value.'</td>';
						}
						
					} elseif($parent_tid == 28) {
						$query = db_select('node', 'n');
						$query->leftJoin('uc_products', 'uc', 'uc.nid = n.nid');
						$query->leftJoin('field_data_field_sub_category', 'sc', 'sc.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_wattage', 'frw', 'frw.entity_id = n.nid');
						$query->leftJoin('field_data_field_type_of_lamp', 'tol', 'tol.entity_id = n.nid');
						$query->leftJoin('field_data_field_capsule_type', 'ct', 'ct.entity_id = n.nid');
						$query->leftJoin('field_data_field_base', 'b', 'b.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_voltage', 'frv', 'frv.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_frequency', 'ff', 'ff.entity_id = n.nid');
						$query->leftJoin('field_data_field_cct', 'cct', 'cct.entity_id = n.nid');
						$query->leftJoin('field_data_field_power_factor ', 'pf', 'pf.entity_id = n.nid');
						$query->leftJoin('field_data_field_rated_luminous_flux', 'rlf', 'rlf.entity_id = n.nid');
						$query->leftJoin('field_data_field_maximum_length_in_mm_', 'mm', 'mm.entity_id = n.nid');
						$query->fields('n', array('nid', 'title', 'status', 'created'))
									->fields('uc', array('model', 'sell_price'))
									->fields('sc', array('field_sub_category_tid'))
									->fields('frw', array('field_rated_wattage_value'))
									->fields('tol', array('field_type_of_lamp_value'))
									->fields('ct', array('field_capsule_type_value'))
									->fields('b', array('field_base_value'))
									->fields('frv', array('field_rated_voltage_value'))
									->fields('ff', array('field_rated_frequency_value'))
									->fields('cct', array('field_cct_value'))
									->fields('pf', array('field_power_factor_value'))
									->fields('rlf', array('field_rated_luminous_flux_value'))
									->fields('mm', array('field_maximum_length_in_mm__value'))
									->condition('n.status', 1, '=')
									->condition('sc.field_sub_category_tid', $first_tid, '=')
									->groupBy('n.nid')
									->orderBy('n.created', 'DESC');
						$result = $query->execute();
						foreach($result as $row) {
							$item_code .= '<th>'.$row->model.'</th>';
							$sell_price .= '<td>'.number_format($row->sell_price, 2, '.', '').'</td>';
							$rated_wattage .= '<td>'.$row->field_capsule_type_value.'</td>';
							$type_of_lamp .= '<td>'.$row->field_type_of_lamp_value.'</td>';
							$capsule_tpye .= '<td>'.$row->field_capsule_type_value.'</td>';
							$base .= '<td>'.$row->field_base_value.'</td>';
							$rated_voltage .= '<td>'.$row->field_rated_voltage_value.'</td>';
							$frequency .= '<td>'.$row->field_rated_frequency_value.'</td>';
							$cct .= '<td>'.$row->field_cct_value.'</td>';
							$power_factor .= '<td>'.$row->field_power_factor_value.'</td>';
							$rated_luminous_flux .= '<td>'.$row->field_rated_luminous_flux_value.'</td>';
							$max_length .= '<td>'.$row->field_maximum_length_in_mm__value.'</td>';
						}
					} 
					//echo $item_code;
					//exit;
					?>
					
					

					
					<table class="responsive" width="100%" border="0" cellspacing="0" cellpadding="0">
						<tbody>
							<?php if($parent_tid == 35): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>RATED WATTAGE</td><?php print $rated_wattage; ?></tr>
								<tr><td>OPERATING VOLTAGE</td><?php print $operating_voltage; ?></tr>
								<tr><td>CCT</td><?php print $cct; ?></tr>
								<tr><td>FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>NO OF LEDS</td><?php print $no_of_leds; ?></tr>
								<tr><td>WATTAGE</td><?php print $wattage; ?></tr>
								<tr><td>DIMMING</td><?php print $dimming; ?></tr>
								<tr><td>Remote Control</td><?php print $remote_control; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php elseif($parent_tid == 32 || $parent_tid == 33): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>TYPE OF LAMP</td><?php print $type_of_lamp; ?></tr>
								<tr><td>NO OF LAMP</td><?php print $no_of_lamp; ?></tr>
								<tr><td>FITTING/CAP</td><?php print $fitting_cap; ?></tr>
								<tr><td>RATED VOLTAGE</td><?php print $rated_voltage; ?></tr>
								<tr><td>OPERATING VOLTAGE</td><?php print $operating_voltage; ?></tr>
								<tr><td>FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>RATED WATTAGE</td><?php print $rated_wattage; ?></tr>
								<tr><td>TOTAL WATTAGE</td><?php print $total_wattage; ?></tr>
								<tr><td>CCT</td><?php print $cct; ?></tr>								
								<tr><td>LUMINOUS FLUX</td><?php print $luminous_flux; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php elseif($parent_tid == 27): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>TYPE OF LAMP</td><?php print $type_of_lamp; ?></tr>
								<tr><td>BASE</td><?php print $base; ?></tr>
								<tr><td>RATED VOLTAGE</td><?php print $rated_voltage; ?></tr>
								<tr><td>OPERATING VOLTAGE</td><?php print $operating_voltage; ?></tr>
								<tr><td>FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>WATTAGE</td><?php print $wattage; ?></tr>
								<tr><td>CURRENT</td><?php print $current; ?></tr>			
								<tr><td>LUMINOUS FLUX</td><?php print $luminous_flux; ?></tr>
								<tr><td>CCT</td><?php print $cct; ?></tr>
								<tr><td>LIFE</td><?php print $life; ?></tr>
								<tr><td>DIMMING</td><?php print $dimming; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php elseif($parent_tid == 31): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>TYPE OF LAMP</td><?php print $type_of_lamp; ?></tr>
								<tr><td>RATED VOLTAGE</td><?php print $rated_voltage; ?></tr>
								<tr><td>OPERATING VOLTAGE</td><?php print $operating_voltage; ?></tr>
								<tr><td>FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>RATED WATTAGE</td><?php print $rated_wattage; ?></tr>
								<tr><td>TOTAL WATTAGE</td><?php print $total_wattage; ?></tr>
								<tr><td>CCT</td><?php print $cct; ?></tr>			
								<tr><td>LUMINOUS FLUX</td><?php print $luminous_flux; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php elseif($parent_tid == 30): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>TYPE OF LAMP</td><?php print $type_of_lamp; ?></tr>
								<tr><td>NO OF LAMP</td><?php print $no_of_lamp; ?></tr>
								<tr><td>FITTING/CAP</td><?php print $fitting_cap; ?></tr>
								<tr><td>RATED VOLTAGE</td><?php print $rated_voltage; ?></tr>
								<tr><td>OPERATING VOLTAGE</td><?php print $operating_voltage; ?></tr>
								<tr><td>FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>RATED WATTAGE</td><?php print $rated_wattage; ?></tr>
								<tr><td>TOTAL WATTAGE</td><?php print $total_wattage; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php elseif($parent_tid == 28): ?>
								<tr class="table_head"><th>ITEM CODE</th><?php print $item_code; ?></tr>
								<tr><td>RATED WATTAGE</td><?php print $rated_wattage; ?></tr>
								<tr><td>LAMP TYPE </td><?php print $type_of_lamp; ?></tr>
								<tr><td>CAPSULE TYPE</td><?php print $capsule_tpye; ?></tr>
								<tr><td>BASE</td><?php print $base; ?></tr>
								<tr><td>RATED VOLTAGE</td><?php print $rated_voltage; ?></tr>
								<tr><td>RATED FREQUENCY</td><?php print $frequency; ?></tr>
								<tr><td>CCT</td><?php print $cct; ?></tr>
								<tr><td>POWER FACTOR</td><?php print $power_factor; ?></tr>
								<tr><td>RATED LUMINOUS FLUX</td><?php print $rated_luminous_flux; ?></tr>
								<tr><td>MAXIMUM LENGTH (IN MM)</td><?php print $max_length; ?></tr>
								<tr class="prices"><td>MRP (in Rs.)</td><?php print $sell_price; ?></tr>
							<?php endif; ?>
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


