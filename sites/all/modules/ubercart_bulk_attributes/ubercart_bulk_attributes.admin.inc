<?php

function ubercart_bulk_attributes_bulk_options_form($form, &$form_state, $attribute) {
  $form['header'] = array(
    '#markup' => t("The following form allows you to create a lot of attribute options at once. Specifically when the options have a number on it."),
    );

  $form['example'] = array(
    '#title' => t("Example"),
    '#type' => 'item',
    '#markup' => "<ul><li>Add 2 wishes</li><li>Add 5 wishes</li><li>Add 8 wishes</li><li>Add 11 wishes</li><li>Add 14 wishes</li></ul>",
    );

  $form['name_prefix'] = array(
    '#title' => t("Name prefix"),
    '#type' => 'textfield',
    '#description' => t("In the previous example, this would be <strong>Add </strong>, including the space after <em>Add</em>."),
    );

  $form['name_suffix'] = array(
    '#title' => t("Name suffix"),
    '#type' => 'textfield',
    '#description' => t("In the previous example, this would be <strong> wishes</strong>, including the space before <em>wishes</em>."),
    );

  $form['first_option'] = array(
    '#title' => t("First option"),
    '#type' => 'textfield',
    '#required' => TRUE,
    '#element_validate' => array('element_validate_integer'),
    '#description' => t("In the previous example, this would be <strong>2</strong>."),
    );

  $form['last_option'] = array(
    '#title' => t("Last option"),
    '#type' => 'textfield',
    '#required' => TRUE,
    '#element_validate' => array('element_validate_integer'),
    '#description' => t("In the previous example, this would be <strong>14</strong>."),
    );

  $form['options_step'] = array(
    '#title' => t("Options step"),
    '#type' => 'textfield',
    '#default_value' => 1,
    '#required' => TRUE,
    '#element_validate' => array('element_validate_integer_positive'),
    '#description' => t("In the previous example, this would be <strong>3</strong>, because each option is greater than the previous one by <em>3</em>."),
    );

  $form['sort'] = array(
    '#title' => t("Sort"),
    '#type' => 'radios',
    '#options' => array(
      1 => t("Normal") . ': 1, 2, 3...',
      -1 => t("Reverse") . ': 3, 2, 1...',
      ),
    '#required' => TRUE,
    );

  $form['weight'] = array(
    '#title' => t("Weight"),
    '#type' => 'radios',
    '#options' => array(
      'before' => t("Add the options <strong>before</strong> the rest of the options on this attribute"),
      'after' => t("Add the options <strong>after</strong> the rest of the options on this attribute"),
      'option' => t("Use the option value as its weight. Use this option if you need to mix this attributes with existing ones."),
      ),
    '#required' => TRUE,
    );

  $options_products = ubercart_bulk_attributes_get_products_options();

  $form['products'] = array(
    '#title' => t("Products"),
    '#type' => 'select',
    '#multiple' => TRUE,
    '#options' => $options_products,
    '#description' => t("The options will be added to the selected nodes. This is the only way to automatically add this options to "),
    );

  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t("Create bulk options"),
    );

  return $form;
}

function ubercart_bulk_attributes_bulk_options_form_validate($form, &$form_state) {
  if ($form_state['values']['last_option'] < $form_state['values']['first_option']) {
    form_set_error('last_option', t("%last_option must be equal or greater than %first_option", array('%last_option' => t("Last option"), '%first_option' => t("First option"))));
  }
}

function ubercart_bulk_attributes_bulk_options_form_submit($form, &$form_state) {
  $attribute = $form_state['build_info']['args'][0];

  if (empty($attribute)) {
    drupal_access_denied();
  }

  $direction = $form_state['values']['sort'];

  $weight = $form_state['values']['weight'];

  $limit = _ubercart_bulk_attributes_get_limit($form_state);

  foreach ($form_state['values']['products'] as $nid) {
    db_merge('uc_product_attributes')
    ->key(array('nid' => $nid, 'aid' => $attribute->aid))
    ->fields(array(
      'nid' => $nid,
      'aid' => $attribute->aid,
      'label' => $attribute->label,
      'ordering' => $attribute->ordering,
      'required' => $attribute->required,
      'display' => $attribute->display,
      ))
    ->execute();
  }

  $options_created = 0;

  for ($i = $form_state['values']['first_option']; $i <= $form_state['values']['last_option']; $i += $form_state['values']['options_step']) {
    $name = check_plain($form_state['values']['name_prefix']) . $i . check_plain($form_state['values']['name_suffix']);
    $option = (object) array(
      'aid' => $attribute->aid,
      'name' => $name,
      'ordering' => $limit + ($direction * $i),
      );

    drupal_write_record('uc_attribute_options', $option);
    $options_created++;

    foreach ($form_state['values']['products'] as $nid) {
      $product_option = (object) array(
        'nid' => $nid,
        'oid' => $option->oid,
        'ordering' => $option->ordering,
        );
      drupal_write_record('uc_product_options', $product_option);
    }
  }
  $products_used = count($form_state['values']['products']);

  $message = format_plural($options_created, '1 option added to attribute %attribute', '@count options added to attribute %attribute', array('%attribute' => $attribute->name));
  $message .= ' ' . format_plural($products_used, 'and assigned to 1 product.', 'and assigned to @count products.');

  drupal_set_message($message);

}

function ubercart_bulk_attributes_get_products_options() {
  $products = array();

  $product_types = uc_product_uc_product_types();

  $query = db_select('node', 'n');
  $query->fields('n', array('nid'));
  $query->condition('status', 1);
  $query->condition('type', $product_types, 'IN');
  $query->orderBy('title');

  $result = $query->execute();

  foreach ($result as $row) {
    $node = node_load($row->nid);
    $products[$node->nid] = check_plain($node->title);
  }

  return $products;
}

function _ubercart_bulk_attributes_get_limit($form_state) {
  $limit = 0;

  if ($form_state['values']['weight'] == 'option') {
    return $limit;
  }

  $offset = max(abs($form_state['values']['first_option']), abs($form_state['values']['last_option'])) + 1;

  $query = db_select('uc_attribute_options', 'uao');
  $query->fields('uao');
  $query->condition('aid', $form_state['build_info']['args'][0]->aid);
  if ($form_state['values']['weight'] == 'before') {
    $query->orderBy('ordering', 'ASC');
    $offset *= -1;
  }
  else {
    $query->orderBy('ordering', 'DESC');
  }
  $query->range(0, 1);

  $results = $query->execute();

  if ($row = $results->fetchObject()) {
    $limit = $row->ordering;
  }

  return $limit + $offset;
}
