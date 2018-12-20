<?php

/**
 * @file
 * Admin page callbacks for the Contact module.
 */

/**
 * Categories/list tab.
 */
function contact_category_list() {
  $header = array(
    t('Username'),
    t('Mobile1'),
    t('Mobile2'),
    t('City'),
    t('Query Type'),
    t('Subject'),
    t('Query'),
    t('Query Send Date'),
  );
  $rows = array();
  $rows1 = array();

  //print "<pre>";print_r($_REQUEST);print "</pre>";
  
  // Get all the contact categories from the database.
  
	if(isset($_REQUEST['search']) && $_REQUEST['search']=='SEARCH')
	{
		$from=$_REQUEST['from'].' 24:00:00';
		$to=$_REQUEST['to'].' 00:00:00';
		//
		$categories = db_select('contactus', 'c')
		->addTag('translatable')
		->fields('c', array('username', 'mobile1', 'mobile2', 'city', 'requesttype', 'subject', 'query', 'querydate', 'id'))
		->condition('c.querydate', $to, '>=')
		->condition('c.querydate', $from, '<=')
		->orderBy('querydate')
		->execute()
		->fetchAll();
		//->condition('querydate', 'value', $_REQUEST['from'], '<=')
		//->condition('querydate', 'value', $_REQUEST['to'], '>=')
		//->condition('c.querydate', $_REQUEST['to'], '>=')
		//->condition('c.querydate', $_REQUEST['from'], '<=')
		//DATE_FORMAT(field_data_field_from_date.field_from_date_value, '%Y-%m-%d')
	}
	else
	{
		$categories = db_select('contactus', 'c')
		->addTag('translatable')
		->fields('c', array('username', 'mobile1', 'mobile2', 'city', 'requesttype', 'subject', 'query', 'querydate', 'id'))
		->orderBy('querydate')
		->execute()
		->fetchAll();
	}

  // Loop through the categories and add them to the table.
  foreach ($categories as $category) {
    $rows[] = array(
      /*
	  check_plain($category->category),
      check_plain($category->recipients),
      ($category->selected ? t('Yes') : t('No')),
      l(t('Edit'), 'admin/structure/contact/edit/' . $category->cid),
      l(t('Delete'), 'admin/structure/contact/delete/' . $category->cid),
	  */
	  check_plain($category->username),
      check_plain($category->mobile1),
      check_plain($category->mobile2),
      check_plain($category->city),
      ($category->requesttype==1 ? t('Product Information') : t('Service Request')),
	   check_plain($category->subject),
	   $category->query,
	   check_plain($category->querydate)
    );
	$valRow=str_replace('<html><body><table width="100%"; rules="all" style="border:1px solid #3A5896;" cellpadding="10">','',$category->query);
	
	$valRow=str_replace("<tr><td colspan='2'><span class='item_code'>",'',$valRow);
	
	$valRow=str_replace("</span></td></tr><tr><td colspan='2'>",', ',$valRow);
	
	$valRow=str_replace('</td></tr></table></body></html>','',$valRow);
	$valRow=str_replace('Enquiry from',',Enquiry from',$valRow);
	$valRow=str_replace('City:',',City:',$valRow);
	$valRow=str_replace(',,',',',$valRow);
	
	$valRow=strip_tags($valRow);
	$rows1[] = array(
      
	  check_plain($category->username),
      check_plain($category->mobile1),
      check_plain($category->mobile2),
      check_plain($category->city),
      ($category->requesttype==1 ? t('Product Information') : t('Service Request')),
	   check_plain($category->subject),
	   $valRow,
	   check_plain($category->querydate)
    );
	
  }
  $variables['header']=array('Username','Mobile1','Mobile2','City','Query Type','Subject','Query','Query Send Date');
  $variables['rows']=$rows1;
  /*foreach ($variables['rows'] as $value) 
  {
	foreach ($value as $value1) 
	{
		print "<br>".$value1;
		//$output .= implode(",", $value) . "\n";
	}
  }*/
	copyExportCsv($variables);
	
  if (!$rows) {
    $rows[] = array(array(
      'data' => t('No categories available.'),
      'colspan' => 5,
    ));
  }

  $build['category_table'] = array(
    '#theme' => 'table',
    '#header' => $header,
    '#rows' => $rows,
  );
  return $build;
}

/**
 * Form constructor for the category edit form.
 *
 * @param $category
 *   An array describing the category to be edited. May be empty for new
 *   categories. Recognized array keys are:
 *   - category: The name of the category.
 *   - recipients: A comma-separated list of recipients.
 *   - reply: (optional) The body of the auto-reply message.
 *   - weight: The weight of the category.
 *   - selected: Boolean indicating whether the category should be selected by
 *     default.
 *   - cid: The category ID for which the form is to be displayed.
 *
 * @see contact_category_edit_form_validate()
 * @see contact_category_edit_form_submit()
 * @ingroup forms
 */
function contact_category_edit_form($form, &$form_state, array $category = array()) {
  // If this is a new category, add the default values.
  $category += array(
    'category' => '',
    'recipients' => '',
    'reply' => '',
    'weight' => 0,
    'selected' => 0,
    'cid' => NULL,
  );

  $form['category'] = array(
    '#type' => 'textfield',
    '#title' => t('Category'),
    '#maxlength' => 255,
    '#default_value' => $category['category'],
    '#description' => t("Example: 'website feedback' or 'product information'."),
    '#required' => TRUE,
  );
  $form['recipients'] = array(
    '#type' => 'textarea',
    '#title' => t('Recipients'),
    '#default_value' => $category['recipients'],
    '#description' => t("Example: 'webmaster@example.com' or 'sales@example.com,support@example.com' . To specify multiple recipients, separate each e-mail address with a comma."),
    '#required' => TRUE,
  );
  $form['reply'] = array(
    '#type' => 'textarea',
    '#title' => t('Auto-reply'),
    '#default_value' => $category['reply'],
    '#description' => t('Optional auto-reply. Leave empty if you do not want to send the user an auto-reply message.'),
  );
  $form['weight'] = array(
    '#type' => 'weight',
    '#title' => t('Weight'),
    '#default_value' => $category['weight'],
    '#description' => t('When listing categories, those with lighter (smaller) weights get listed before categories with heavier (larger) weights. Categories with equal weights are sorted alphabetically.'),
  );
  $form['selected'] = array(
    '#type' => 'select',
    '#title' => t('Selected'),
    '#options' => array(
      0 => t('No'),
      1 => t('Yes'),
    ),
    '#default_value' => $category['selected'],
    '#description' => t('Set this to <em>Yes</em> if you would like this category to be selected by default.'),
  );
  $form['cid'] = array(
    '#type' => 'value',
    '#value' => $category['cid'],
  );
  $form['actions'] = array('#type' => 'actions');
  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save'),
  );

  return $form;
}

/**
 * Form validation handler for contact_category_edit_form().
 *
 * @see contact_category_edit_form_submit()
 */
function contact_category_edit_form_validate($form, &$form_state) {
  // Validate and each e-mail recipient.
  $recipients = explode(',', $form_state['values']['recipients']);

  // When creating a new contact form, or renaming the category on an existing
  // contact form, make sure that the given category is unique.
  $category = $form_state['values']['category'];
  $query = db_select('contact', 'c')->condition('c.category', $category, '=');
  if (!empty($form_state['values']['cid'])) {
    $query->condition('c.cid', $form_state['values']['cid'], '<>');
  }
  if ($query->countQuery()->execute()->fetchField()) {
    form_set_error('category', t('A contact form with category %category already exists.', array('%category' => $category)));
  }

  foreach ($recipients as &$recipient) {
    $recipient = trim($recipient);
    if (!valid_email_address($recipient)) {
      form_set_error('recipients', t('%recipient is an invalid e-mail address.', array('%recipient' => $recipient)));
    }
  }
  $form_state['values']['recipients'] = implode(',', $recipients);
}

/**
 * Form submission handler for contact_category_edit_form().
 *
 * @see contact_category_edit_form_validate()
 */
function contact_category_edit_form_submit($form, &$form_state) {
  if ($form_state['values']['selected']) {
    // Unselect all other contact categories.
    db_update('contact')
      ->fields(array('selected' => '0'))
      ->execute();
  }

  if (empty($form_state['values']['cid'])) {
    drupal_write_record('contact', $form_state['values']);
  }
  else {
    drupal_write_record('contact', $form_state['values'], array('cid'));
  }

  drupal_set_message(t('Category %category has been saved.', array('%category' => $form_state['values']['category'])));
  watchdog('contact', 'Category %category has been saved.', array('%category' => $form_state['values']['category']), WATCHDOG_NOTICE, l(t('Edit'), 'admin/structure/contact/edit/' . $form_state['values']['cid']));
  $form_state['redirect'] = 'admin/structure/contact';
}

/**
 * Form constructor for the contact category deletion form.
 *
 * @param $contact
 *   Array describing the contact category to be deleted. See the documentation
 *   of contact_category_edit_form() for the recognized keys.
 *
 * @see contact_menu()
 * @see contact_category_delete_form_submit()
 */
function contact_category_delete_form($form, &$form_state, array $contact) {
  $form['contact'] = array(
    '#type' => 'value',
    '#value' => $contact,
  );

  return confirm_form(
    $form,
    t('Are you sure you want to delete %category?', array('%category' => $contact['category'])),
    'admin/structure/contact',
    t('This action cannot be undone.'),
    t('Delete'),
    t('Cancel')
  );
}

/**
 * Form submission handler for contact_category_delete_form().
 */
function contact_category_delete_form_submit($form, &$form_state) {
  $contact = $form['contact']['#value'];

  db_delete('contact')
    ->condition('cid', $contact['cid'])
    ->execute();

  drupal_set_message(t('Category %category has been deleted.', array('%category' => $contact['category'])));
  watchdog('contact', 'Category %category has been deleted.', array('%category' => $contact['category']), WATCHDOG_NOTICE);

  $form_state['redirect'] = 'admin/structure/contact';
}
