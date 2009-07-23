<?php
// $Id: fivestarextra.admin.inc,v 1.3 2008/10/27 12:34:28 likeless Exp $

/**
 * @file
 * Admin pages and functions for fivestarextra
 *
 */


/**
 * Admin settings form, mainly cannibalised from fivestar_form_alter,
 * with a few important modifications.
 */
function fivestarextra_comments_admin_form(&$form_state) {
////////////////hemanth-baryons/////////////////////////
  $value = db_result(db_query('select count(*) from category'));
  //echo $value;exit();
  $form['fivestar_stars1'] = array(
    '#type' => 'select',
    '#title' => t('Number of Categories'),
    '#options' => drupal_map_assoc(range(1, 10)),
    '#default_value' =>$value,// variable_get('fivestarextra_stars1_comment', 5),
    '#weight' => -4,
  );

  for ($n = 1; $n <= 10; $n++) {
    $default_labels = db_result(db_query('select category from {category} where category_id=%d',$n));
    $form['fivestar1_label_'. $n] = array(
      '#type' => 'textfield',
      '#title' => 'Category_'.$n,
      '#default_value' =>$default_labels,//isset($labels[$n]) ? $labels[$n] : $default_labels[$n],
      '#prefix' => '<div id="fivestar1-label-'. $n .'" class="fivestar1-label">',
      '#suffix' => '</div>',
      '#size' => 30,
    );
  }
  /////////////////////////////
  $form['fivestar'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fivestar Comments Rating'),
    '#description' => t('This is for rating comments, as in whether a particular comment is good or bad. For writing reviews of nodes, including comments, see the module Fivestar Comments.'),
    '#theme' => 'fivestar_node_type_form',
    '#attributes' => array('id' => 'fivestar-node-type-form'),
  );

  $form['fivestar']['fivestar'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Fivestar rating on comments'),
    '#default_value' => variable_get('fivestarextra_enable_comment', 0),
    '#return_value' => 1,
    '#weight' => -5,
  );

  $form['fivestar']['fivestar_stars'] = array(
    '#type' => 'select',
    '#title' => t('Number of stars'),
    '#options' => drupal_map_assoc(range(1, 10)),
    '#default_value' => variable_get('fivestarextra_stars_comment', 5),
    '#weight' => -4,
  );


  $form['fivestar']['labels'] = array(
    '#type' => 'fieldset',
    '#title' => t('Star Labels'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('These star labels appear as the link title when javascript is enabled as well as the select list options when javascript is disabled.'),
  );

  $form['fivestar']['labels']['fivestar_labels_enable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display labels on mouse over'),
    '#default_value' => variable_get('fivestarextra_labels_enable_comment', 1),
    '#return_value' => 1,
    '#weight' => -5,
    '#description' => t('When enabled, the star labels will dynamically appear underneath the stars as the user hovers over each star to provide a more descriptive qualitative meaning for each star value.'),
  );

  // Create the Mouseover text forms for each of the rating options
  // This form depends on the number of stars, and these extra textfields will be hidden with javascript
  $star_count = variable_get('fivestarextra_stars_comment', 5);
  $labels = variable_get('fivestarextra_labels_comment', array());
  for ($n = 0; $n <= 10; $n++) {
    if ($star_count == 5 && $n <= 5) {
      // If the default 5 stars are chosen, then use these five default label values.
      $default_labels = array('Cancel rating', 'Poor', 'Okay', 'Good', 'Great', 'Awesome');
    }
    elseif ($n == 0) {
      $default_labels[$n] = 'Cancel rating';
    }
    else {
      $default_labels[$n] = 'Give it @star/@count';
    }
    $form['fivestar']['labels']['fivestar_label_'. $n] = array(
      '#type' => 'textfield',
      '#title' => $n > 0 ? t('Star @star label', array('@star' => $n)) : t('Cancel label'),
      '#default_value' => isset($labels[$n]) ? $labels[$n] : $default_labels[$n],
      '#prefix' => '<div id="fivestar-label-'. $n .'" class="fivestar-label">',
      '#suffix' => '</div>',
      '#size' => 30,
    );
  }

  $form['fivestar']['direct'] = array(
    '#type' => 'fieldset',
    '#title' => t('Direct rating widget'),
    '#collapsible' => FALSE,
    '#description' => t('These settings allow you to display a rating widget to your users while they are viewing content of this type. Rating will immediately register a vote for that piece of content.'),
    '#weight' => 2,
  );

  $form['fivestar']['direct']['fivestar_style'] = array(
    '#type' => 'select',
    '#title' => t('Star display style'),
    '#default_value' => variable_get('fivestarextra_style_comment', 'average'),
    '#options' => array(
      'average' => t('Display average vote value'),
      'user'    => t('Display user vote value'),
      'smart'   => t('User vote if available, average otherwise'),
      'dual'    => t('Both user and average vote'),
    ),
  );

  $form['fivestar']['direct']['fivestar_text'] = array(
    '#type' => 'select',
    '#title' => t('Text display style'),
    '#default_value' => variable_get('fivestarextra_text_comment', 'dual'),
    '#options' => array(
      'none'    => t('Display no text beneath stars'),
      'average' => t('Current average in text'),
      'user'    => t('User current vote in text'),
      'smart'   => t('User vote if available, average otherwise'),
      'dual'    => t('Both user and average vote'),
    ),
  );

  $form['fivestar']['direct']['fivestar_title'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show widget title'),
    '#default_value' => variable_get('fivestarextra_title_comment', 1),
    '#return_value' => 1,
  );

  $form['fivestar']['direct']['fivestar_feedback'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable feedback during vote saving and deletion'),
    '#default_value' => variable_get('fivestarextra_feedback_comment', 1),
    '#return_value' => 1
  );

  $form['fivestar']['direct']['fivestar_unvote'] = array(
    '#type' => 'checkbox',
    '#title' => t('Allow users to undo their votes'),
    '#default_value' => variable_get('fivestarextra_unvote_comment', 0),
    '#return_value' => 1,
  );

 $form['fivestar']['direct']['fivestar_position'] = array(
    '#type' => 'select',
    '#title' => t('Display mode'),
    '#default_value' => variable_get('fivestarextra_position_comment', 'below'),
    '#options' => array(
      'above' => t('Clickable widget above comment body'),
      'below' => t('Clickable widget below comment body'),
      'hidden' => t('<Hidden>'),
    ),
  );

  $form['fivestar']['direct']['fivestar_direct_preview'] = array(
    '#type' => 'item',
    '#title' => t('Direct rating widget preview'),
    '#value' => theme(
      'fivestar_preview',
      $form['fivestar']['direct']['fivestar_style']['#default_value'],
      $form['fivestar']['direct']['fivestar_text']['#default_value'],
      $form['fivestar']['fivestar_stars']['#default_value'],
      $form['fivestar']['direct']['fivestar_unvote']['#default_value'],
      $form['fivestar']['direct']['fivestar_title']['#default_value'] ? NULL : FALSE,
      $form['fivestar']['labels']['fivestar_labels_enable']['#default_value'],
      variable_get('fivestarextra_labels_comment', array())
    ),
  );
  if (!$form['fivestar']['fivestar']['#default_value']) {
    $form['fivestar']['direct']['fivestar_direct_preview']['#value'] = theme('fivestar_preview_wrapper', '');
  }
  else {
    $form['fivestar']['direct']['fivestar_direct_preview']['#value'] = theme('fivestar_preview_wrapper', $form['fivestar']['direct']['fivestar_direct_preview']['#value']);
  }
  
  $form['fivestar']['nodetypes'] = array(
    '#type' => 'fieldset',
    '#title' => t('Restrict By Node Type'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('Leave this section alone to allow rating of all comments. Enable it if you want to allow comments to be rated only on particular types of node.'),
    '#weight' => 5,
  );
  
  $form['fivestar']['nodetypes']['fivestar_noderestrict_enable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Restrict By Node Type'),
    '#default_value' => variable_get('fivestarextra_noderestrict_enable_comment', 0),
    '#return_value' => 1,
    '#prefix' => theme('fivestarextra_noderestrict_enable_comment',''),
    '#weight' => -5,
  );
  
  $nodetypes = node_get_types('names');
  $form['fivestar']['nodetypes']['fivestar_noderestrict_nodetypes'] = array(
    '#type' => 'checkboxes',
    '#title' => t('Enable Comment Rating on These Node Types'),
    '#default_value' => variable_get('fivestarextra_noderestrict_nodetypes', array_keys($nodetypes)),
    '#options' => $nodetypes,
    '#attributes' => array('class' => 'fivestarextra_noderestrict_nodetypes'),
    '#weight' => 0,
  );
  
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
    '#weight' => 45,
  );
  
  $form['#submit'][] = 'fivestarextra_comments_admin_form_submit';
  return $form;
}

/**
 * Admin settings form submit function. It simply saves the variables.
 */
function fivestarextra_comments_admin_form_submit($form, &$form_state) {
  variable_set('fivestarextra_enable_comment',$form_state['values']['fivestar']);
//  print_r($form_state['values']);exit();
  $variables = array('stars','labels_enable','style','text','title','unvote','feedback','position','noderestrict_enable');
  foreach ($variables as $variable) {
    variable_set('fivestarextra_'.$variable .'_comment',$form_state['values']['fivestar_'.$variable]);
  }
  
  //Merge node types into an array
  $nodetypes = array();
  foreach ($form_state['values']['fivestar_noderestrict_nodetypes'] as $type => $value) {
    if ($value) {
      $nodetypes[] = $type;
    }
  }
  variable_set('fivestarextra_noderestrict_nodetypes',$nodetypes);
  
  // Merge labels into a single variable.
  $labels = array();
  for ($n = 0; $n <= 10; $n++) {
    $labels[] = $form_state['values']['fivestar_label_'. $n];
    variable_del('fivestarextra_label_'. $n .'_comment');
  }
  variable_del('fivestar_labels_comment');
  if ($form_state['values']['fivestar_labels_enable']) {
    variable_set('fivestarextra_labels_comment', $labels);
  }
  //hemanth-baryons
  $result = db_result(db_query('select count(*) from {category}'));
  for($j=$result;$j>$form_state['values']['fivestar_stars1'];$j--){
  db_query('delete from {category} where category_id=%d',$j);
  }
  for($i=1;$i<=$form_state['values']['fivestar_stars1'];$i++){
  	
	   $result = db_result(db_query('select count(*) from {category} where category_id=%d',$i));
	   if($result){
		db_query('update {category} set category="%s" where category_id=%d',$form_state['values']['fivestar1_label_'.$i],$i);
	   }
	   else{
	     	db_query('insert into {category} values(%d,"%s")',$i,$form_state['values']['fivestar1_label_'.$i]);
	    } 	
  }
};


/**
 * Theme the checkbox for the node type part of the admin form. This adds a tiny javascript file.
 */
function theme_fivestarextra_noderestrict_enable_comment($element) {
  drupal_add_js(drupal_get_path('module', 'fivestarextra') .'/fivestarextra-admin.js');
  return '';
}


/**
 * Admin settings form, mainly cannibalised from fivestar_form_alter,
 * with a few important modifications.
 */
function fivestarextra_users_admin_form(&$form_state) {

  $form['fivestar'] = array(
    '#type' => 'fieldset',
    '#title' => t('Fivestar users Rating'),
    '#description' => t('This is for rating users, as in whether a particular user is good or bad. For writing reviews of nodes, including users, see the module Fivestar users.'),
    '#theme' => 'fivestar_node_type_form',
    '#attributes' => array('id' => 'fivestar-node-type-form'),
  );

  $form['fivestar']['fivestar'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable Fivestar rating on users'),
    '#default_value' => variable_get('fivestarextra_enable_user', 0),
    '#return_value' => 1,
    '#weight' => -5,
  );

  $form['fivestar']['fivestar_stars'] = array(
    '#type' => 'select',
    '#title' => t('Number of stars'),
    '#options' => drupal_map_assoc(range(1, 10)),
    '#default_value' => variable_get('fivestarextra_stars_user', 5),
    '#weight' => -4,
  );


  $form['fivestar']['labels'] = array(
    '#type' => 'fieldset',
    '#title' => t('Star Labels'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
    '#description' => t('These star labels appear as the link title when javascript is enabled as well as the select list options when javascript is disabled.'),
  );

  $form['fivestar']['labels']['fivestar_labels_enable'] = array(
    '#type' => 'checkbox',
    '#title' => t('Display labels on mouse over'),
    '#default_value' => variable_get('fivestarextra_labels_enable_user', 1),
    '#return_value' => 1,
    '#weight' => -5,
    '#description' => t('When enabled, the star labels will dynamically appear underneath the stars as the user hovers over each star to provide a more descriptive qualitative meaning for each star value.'),
  );

  // Create the Mouseover text forms for each of the rating options
  // This form depends on the number of stars, and these extra textfields will be hidden with javascript
  $star_count = variable_get('fivestarextra_stars_user', 5);
  $labels = variable_get('fivestarextra_labels_user', array());
  for ($n = 0; $n <= 10; $n++) {
    if ($star_count == 5 && $n <= 5) {
      // If the default 5 stars are chosen, then use these five default label values.
      $default_labels = array('Cancel rating', 'Poor', 'Okay', 'Good', 'Great', 'Awesome');
    }
    elseif ($n == 0) {
      $default_labels[$n] = 'Cancel rating';
    }
    else {
      $default_labels[$n] = 'Give it @star/@count';
    }
    $form['fivestar']['labels']['fivestar_label_'. $n] = array(
      '#type' => 'textfield',
      '#title' => $n > 0 ? t('Star @star label', array('@star' => $n)) : t('Cancel label'),
      '#default_value' => isset($labels[$n]) ? $labels[$n] : $default_labels[$n],
      '#prefix' => '<div id="fivestar-label-'. $n .'" class="fivestar-label">',
      '#suffix' => '</div>',
      '#size' => 30,
    );
  }

  $form['fivestar']['direct'] = array(
    '#type' => 'fieldset',
    '#title' => t('Direct rating widget'),
    '#collapsible' => FALSE,
    '#description' => t('These settings allow you to display a rating widget to your users while they are viewing content of this type. Rating will immediately register a vote for that piece of content.'),
    '#weight' => 2,
  );

  $form['fivestar']['direct']['fivestar_style'] = array(
    '#type' => 'select',
    '#title' => t('Star display style'),
    '#default_value' => variable_get('fivestarextra_style_user', 'average'),
    '#options' => array(
      'average' => t('Display average vote value'),
      'user'    => t('Display user vote value'),
      'smart'   => t('User vote if available, average otherwise'),
      'dual'    => t('Both user and average vote'),
    ),
  );

  $form['fivestar']['direct']['fivestar_text'] = array(
    '#type' => 'select',
    '#title' => t('Text display style'),
    '#default_value' => variable_get('fivestarextra_text_user', 'dual'),
    '#options' => array(
      'none'    => t('Display no text beneath stars'),
      'average' => t('Current average in text'),
      'user'    => t('User current vote in text'),
      'smart'   => t('User vote if available, average otherwise'),
      'dual'    => t('Both user and average vote'),
    ),
  );

  $form['fivestar']['direct']['fivestar_title'] = array(
    '#type' => 'checkbox',
    '#title' => t('Show widget title'),
    '#default_value' => variable_get('fivestarextra_title_user', 1),
    '#return_value' => 1,
  );

  $form['fivestar']['direct']['fivestar_feedback'] = array(
    '#type' => 'checkbox',
    '#title' => t('Enable feedback during vote saving and deletion'),
    '#default_value' => variable_get('fivestarextra_feedback_user', 1),
    '#return_value' => 1
  );

  $form['fivestar']['direct']['fivestar_unvote'] = array(
    '#type' => 'checkbox',
    '#title' => t('Allow users to undo their votes'),
    '#default_value' => variable_get('fivestarextra_unvote_user', 0),
    '#return_value' => 1,
  );
  
 $weightoptions = array('hidden' => t('<Hidden>'));
 foreach (range(-100,100) as $weight) {
   $weightoptions[$weight] = $weight;
 }
 
 $form['fivestar']['direct']['fivestar_position'] = array(
    '#type' => 'select',
    '#title' => t('Weight'),
    '#description' => t('Determines the position of the voting widget on the user page. Higher values are lower down.'),
    '#default_value' => variable_get('fivestarextra_position_user', '100'),
    '#options' => $weightoptions,
  );

  $form['fivestar']['direct']['fivestar_direct_preview'] = array(
    '#type' => 'item',
    '#title' => t('Direct rating widget preview'),
    '#value' => theme(
      'fivestar_preview',
      $form['fivestar']['direct']['fivestar_style']['#default_value'],
      $form['fivestar']['direct']['fivestar_text']['#default_value'],
      $form['fivestar']['fivestar_stars']['#default_value'],
      $form['fivestar']['direct']['fivestar_unvote']['#default_value'],
      $form['fivestar']['direct']['fivestar_title']['#default_value'] ? NULL : FALSE,
      $form['fivestar']['labels']['fivestar_labels_enable']['#default_value'],
      variable_get('fivestarextra_labels_user', array())
    ),
  );
  if (!$form['fivestar']['fivestar']['#default_value']) {
    $form['fivestar']['direct']['fivestar_direct_preview']['#value'] = theme('fivestar_preview_wrapper', '');
  }
  else {
    $form['fivestar']['direct']['fivestar_direct_preview']['#value'] = theme('fivestar_preview_wrapper', $form['fivestar']['direct']['fivestar_direct_preview']['#value']);
  }
  
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Submit'),
    '#weight' => 45,
  );
  
  $form['#submit'][] = 'fivestarextra_users_admin_form_submit';
  return $form;
}
  

/**
 * Admin settings form submit function. It simply saves the variables.
 */
function fivestarextra_users_admin_form_submit($form, &$form_state) {
  
  variable_set('fivestarextra_enable_user',$form_state['values']['fivestar']);
  
  $variables = array('stars','labels_enable','style','text','title','unvote','feedback','position');
  foreach ($variables as $variable) {
    variable_set('fivestarextra_'.$variable .'_user',$form_state['values']['fivestar_'.$variable]);
  }
  
  // Merge labels into a single variable.
  $labels = array();
  for ($n = 0; $n <= 10; $n++) {
    $labels[] = $form_state['values']['fivestar_label_'. $n];
    variable_del('fivestarextra_label_'. $n .'_user');
  }
  variable_del('fivestar_labels_user');
  if ($form_state['values']['fivestar_labels_enable']) {
    variable_set('fivestarextra_labels_user', $labels);
  }
};

