<?php

function ***MACHINE_NAME***_id_safe($string) {
  if (is_numeric($string{0})) {
    // if the first character is numeric, add 'n' in front
    $string = 'n' . $string;
  }
  return strtolower(preg_replace('/[^a-zA-Z0-9-?]+/', '-', $string));
}

// ---------------------------------------------------------------------------
// Remove redundant CSS
function ***MACHINE_NAME***_css_alter(&$css) {

  //make a list of module css to remove
  $css_to_remove = array();
  //$css_to_remove[] = drupal_get_path('module','system').'/system.base.css';
  $css_to_remove[] = drupal_get_path('module', 'system') . '/system.menus.css';
  $css_to_remove[] = drupal_get_path('module', 'system') . '/system.messages.css';
  $css_to_remove[] = drupal_get_path('module', 'system') . '/system.theme.css';
  $css_to_remove[] = drupal_get_path('module', 'user') . '/user.css';
  $css_to_remove[] = drupal_get_path('module', 'field') . '/theme/field.css)';
  $css_to_remove[] = drupal_get_path('module', 'ctools') . '/css/ctools.css)';

  $css_to_remove[] = drupal_get_path('module', 'node') . '/node.css';
  $css_to_remove[] = drupal_get_path('module', 'views') . '/css/views.css';
  $css_to_remove[] = drupal_get_path('module', 'search') . '/search.css';
  $css_to_remove[] = drupal_get_path('module', 'webform') . '/css/webform.css';
  $css_to_remove[] = drupal_get_path('module', 'field_group') . '/horizontal-tabs/horizontal-tabs.css';
  $css_to_remove[] = drupal_get_path('module', 'date') . '/date_api/date.css';
  // now we can remove the contribs from the array
  foreach ($css_to_remove as $index => $css_file) {
    if(isset($css[$css_file])) {
      unset($css[$css_file]);
    }
  }

}


function ***MACHINE_NAME***_preprocess_html(&$vars) {

  //Stylesheets for IE
  drupal_add_css(
    drupal_get_path('theme', '***MACHINE_NAME***') . '/css/rendered/lte-ie-9.css', 
    array(
      'group' => CSS_THEME,
      'browsers' => array(
        'IE' => 'lte IE 9',
        '!IE' => FALSE
      ),
      'preprocess' => FALSE
    )
  );
  
  drupal_add_css(drupal_get_path('theme', '***MACHINE_NAME***') . '/css/rendered/ie-7.css', 
    array(
      'group' => CSS_THEME,
      'browsers' => array(
        'IE' => 'IE 7',
        '!IE' => FALSE
      ),
      'preprocess' => FALSE
    )
  );

}


function ***MACHINE_NAME***_preprocess_page(&$vars, $hook) {

  if(isset($vars['node']->title)) {

    $element = array(
      '#tag' => 'meta', // The #tag is the html tag - <link />
      '#attributes' => array( // Set up an array of attributes inside the tag
        'property' => 'og:title',
        'content' => $vars['node']->title,
      ),
    );
    drupal_add_html_head($element, 'og_title');
  }

  $status = drupal_get_http_header("status");

  if (isset($vars['node'])) {
    $vars['theme_hook_suggestions'][] = 'page__' . str_replace('_', '__', $vars['node']->type);
  }

  if ($status == "404 Not Found") {
    $vars['theme_hook_suggestions'][] = 'page__404';
  }
  if ($status == "403 Forbidden") {
    $vars['theme_hook_suggestions'][] = 'page__403';
  }

  //Check for admin
  drupal_add_js(drupal_get_path('theme', '***MACHINE_NAME***') . '/js/jquery.tabSlideOut.v1.3.js');
  drupal_add_js(drupal_get_path('theme', '***MACHINE_NAME***') . '/js/edit_sidebar.js');

}

/**
 * Override or insert variables into the node template.
 */
function ***MACHINE_NAME***_preprocess_node(&$variables) {

  $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__' . $variables['view_mode'];
  $variables['classes_array'][] = $variables['view_mode'];
}

/*
 * Implementation of hook_link().
 */
function ***MACHINE_NAME***_link($variables) {
  $variables['options']['html'] = TRUE;
  return '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>' . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>';
}

/*
 * Implementation of hook_menu_local_tasks().
 */
function ***MACHINE_NAME***_menu_local_tasks(&$variables) {
  $output = '';

  if (!empty($variables['primary'])) {
    $variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
    $variables['primary']['#prefix'] .= '<ul id="tab" class="nav nav-tabs">';
    $variables['primary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['primary']);
  }
  if (!empty($variables['secondary'])) {
    $variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
    $variables['secondary']['#prefix'] .= '<ul class="tabs secondary">';
    $variables['secondary']['#suffix'] = '</ul>';
    $output .= drupal_render($variables['secondary']);
  }
  return $output;
}


function ***MACHINE_NAME***_pager_link($variables) {
  if(isset($variables['parameters']['search']) && $variables['parameters']['search'] == '') {
    unset($variables['parameters']['search']);
  }
  if(isset($variables['parameters']['sort_by']) && $variables['parameters']['sort_by'] == '') {
    unset($variables['parameters']['sort_by']);
  }
  $text = $variables['text'];
  $page_new = $variables['page_new'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $attributes = $variables['attributes'];

  $page = isset($_GET['page']) ? $_GET['page'] : '';
  if ($new_page = implode(',', pager_load_array($page_new[$element], $element, explode(',', $page)))) {
    $parameters['page'] = $new_page;
  }

  $query = array();
  if (count($parameters)) {
    $query = drupal_get_query_parameters($parameters, array());
  }
  if ($query_pager = pager_get_query_parameters()) {
    $query = array_merge($query, $query_pager);
  }



  // Set each pager link title
  if (!isset($attributes['title'])) {
    static $titles = NULL;
    if (!isset($titles)) {
      $titles = array(
        t('« first') => t('Go to first page'),
        t('‹ previous') => t('Go to previous page'),
        t('next ›') => t('Go to next page'),
        t('last »') => t('Go to last page'),
      );
    }
    if (isset($titles[$text])) {
      $attributes['title'] = $titles[$text];
    }
    elseif (is_numeric($text)) {
      $attributes['title'] = t('Go to page @number', array('@number' => $text));
    }
  }

  // @todo l() cannot be used here, since it adds an 'active' class based on the
  //   path only (which is always the current path for pager links). Apparently,
  //   none of the pager links is active at any time - but it should still be
  //   possible to use l() here.
  // @see http://drupal.org/node/1410574



  $options = array('query' => $query);
  if(isset($parameters['fragment'])) {
    $options['fragment'] = $parameters['fragment'];
    unset($parameters['fragment']);
    unset($options['query']['fragment']);
  }


  $attributes['href'] = url($_GET['q'], $options);
  return '<a' . drupal_attributes($attributes) . '>' . check_plain($text) . '</a>';
}


/**
 * Implements HOOK_theme().
 */
function ***MACHINE_NAME***_theme(){
  return array(
    'nomarkup' => array (
      'render element' => 'element',
    ),
  );
}

## the nomarkup theme function
function theme_nomarkup($variables) {
  $output = '';
  // Render the items.
  foreach ($variables['items'] as $delta => $item) {
    $output .=  drupal_render($item);
  }
  return $output;
}

/* FORMS IN BOOTSTRAP */



function ***MACHINE_NAME***_textarea($variables) {
  $element = $variables['element'];
  element_set_attributes($element, array('id', 'name', 'cols', 'rows'));
  _form_set_class($element, array('form-textarea'));

  $wrapper_attributes = array(
    'class' => array('form-textarea-wrapper'),
  );

  // Add resizable behavior.
  if (!empty($element['#resizable'])) {
    drupal_add_library('system', 'drupal.textarea');
    $wrapper_attributes['class'][] = 'resizable';
  }

  $output = '<div' . drupal_attributes($wrapper_attributes) . '>';
  $output .= '<textarea' . drupal_attributes($element['#attributes']) . '>' . check_plain($element['#value']) . '</textarea>';
  $output .= '</div>';
  return $output;
}


function ***MACHINE_NAME***_form_element($variables) {
  $element = &$variables['element'];
  $output = '';

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');

    //Add Class radio to radio wrapper
    if($element['#type'] == 'radio') {
      $attributes['class'][] = 'radio';
      $attributes['class'][] = 'inline';
    }
    //Add Class checkbox to checkbox wrapper // Add class inline to checkbox
    elseif($element['#type'] == 'checkbox') {
      $attributes['class'][] = 'checkbox';
    }
    else {
      $attributes['class'][] = 'control-group';
    }
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  if(isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }

  /* Not for radio or Checkbox alas*/
  if(($element['#type'] == 'radio') || ($element['#type'] == 'checkbox')):
    $output .= '<div' . drupal_attributes($attributes) . '>' . "\n";

    // If #title is not set, we don't display any label or required marker.
    if (!isset($element['#title'])) {
      $element['#title_display'] = 'none';
    }
    $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
    $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

    switch ($element['#title_display']) {
      case 'before':
      case 'invisible':
      case 'after':
      case 'attribute':
      case 'none':
      case 'inline' :

        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
        $output .= ' ' . theme('form_element_label', $variables);
        if (!empty($element['#description'])) {
          $output .= ' <span class="help-block">' . $element['#description'] . "</span>";
        }

        break;
    }
    $output .= "</div>\n";

  else:

    $output .= '<div' . drupal_attributes($attributes) . '>' . "\n";

    // If #title is not set, we don't display any label or required marker.
    if (!isset($element['#title'])) {
      $element['#title_display'] = 'none';
    }
    $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
    $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

    switch ($element['#title_display']) {
      case 'before':
      case 'invisible':
      case 'after':
      case 'attribute':
      case 'none':
      case 'inline' :

        $output .= ' ' . theme('form_element_label', $variables);
        $output .= '<div class="controls">';
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
        if (!empty($element['#description'])) {
          $output .= ' <span class="help-block">' . $element['#description'] . "</span>";
        }
        $output .= '</div>';
        break;
    }
    $output .= "</div>\n";
  endif;
  return $output;
}

function ***MACHINE_NAME***_webform_element($variables) {
  $element = &$variables['element'];
  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
    if($element['#type'] != 'radio') {
      $attributes['class'][] = 'control-group';
    }
  }

  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }
  if(isset($element['#parents']) && form_get_error($element)) {
    $attributes['class'][] = 'error';
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
    case 'inline' :

      $output .= ' ' . theme('form_element_label', $variables);
      $output .= '<div class="controls">';
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      if (!empty($element['#description'])) {
        $output .= ' <span class="help-block">' . $element['#description'] . "</span>";
      }
      $output .= '</div>';
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      if($element['#type'] == "markup") {
        $output .= ' ' . $prefix . $element['#webform_component']['value'] . $suffix . "\n";
      }else {
        $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      }
      break;
  }

  $output .= "</div>\n";
  return $output;
}
/*
 * Theme all form labels
 */
function ***MACHINE_NAME***_form_element_label($variables) {
  $element = $variables['element'];
  // This is also used in the installer, pre-database setup.
  $t = get_t();

  // If title and required marker are both empty, output no label.
  if ((!isset($element['#title']) || $element['#title'] === '') && empty($element['#required'])) {
    return '';
  }

  // If the element is required, a required marker is appended to the label.
  $required = !empty($element['#required']) ? theme('form_required_marker', array('element' => $element)) : '';

  $title = filter_xss_admin($element['#title']);

  $attributes = array();

  // Style the label as class option to display inline with the element.

  if($element['#type'] == 'radio' || $element['#type'] == 'checkbox') {
    $extra_class = ' ';
  }
  else {
    $extra_class = ' control-label';
  }
  if ($element['#title_display'] == 'after') {
    $attributes['class'] = 'option' . $extra_class ;
  }
  // Show label only to screen readers to avoid disruption in visual flows.
  elseif ($element['#title_display'] == 'invisible') {
    $attributes['class'] = 'element-invisible' . $extra_class ;
  }

  if (!empty($element['#id'])) {
    $attributes['for'] = $element['#id'];
    $attributes['class'] = $extra_class;
  }
  // The leading whitespace helps visually separate fields from inline labels.
  return ' <label' . drupal_attributes($attributes) . '>' . $t('!title !required', array('!title' => $title, '!required' => $required)) . "</label>\n";
}


function ***MACHINE_NAME***_button($variables) {
  $element = $variables['element'];
  $element['#attributes']['type'] = 'submit';
  element_set_attributes($element, array('id', 'name', 'value'));

  $element['#attributes']['class'][] = 'btn form-' . $element['#button_type'];
  if (!empty($element['#attributes']['disabled'])) {
    $element['#attributes']['class'][] = 'btn form-button-disabled';
  }

  return '<input' . drupal_attributes($element['#attributes']) . ' />';
}



/*
 * Theme Date Popup
 */

function ***MACHINE_NAME***_date_popup($vars) {

  $element = $vars['element'];
  $attributes = !empty($element['#wrapper_attributes']) ? $element['#wrapper_attributes'] : array('class' => array());
  $attributes['class'][] = 'container-inline-date clearfix';
  // If there is no description, the floating date elements need some extra padding below them.
  $wrapper_attributes = array('class' => array('date-padding'));
  if (empty($element['date']['#description'])) {
    $wrapper_attributes['class'][] = 'no-clearfix';
  }

  return '<div ' . drupal_attributes($attributes) .'>' . theme('form_element', $element) . '</div>';
}

/**
 * Theme status messages.
 */
function ***MACHINE_NAME***_status_messages($variables) {

  $display = $variables['display'];
  $output = '';

  $status_heading = array(
    'status' => t('Status message'),
    'error' => t('Error message'),
    'warning' => t('Warning message'),
  );
  foreach (drupal_get_messages($display) as $type => $messages) {

    $output .= "<div class=\"alert-block alert alert-$type\">\n";

    if (!empty($status_heading[$type])) {
      $output .= '<h2 class="element-invisible">' . $status_heading[$type] . "</h2>\n";
    }
    if (count($messages) > 1) {
      $output .= " <ul>\n";
      foreach ($messages as $message) {
        $output .= '  <li>' . $message . "</li>\n";
      }
      $output .= " </ul>\n";
    }
    else {
      $output .= $messages[0];
    }
    $output .= "</div>\n";
  }
  return $output;
}
