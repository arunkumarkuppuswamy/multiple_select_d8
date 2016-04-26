<?php
/**
 * @file
 * Contains \Drupal\multiple_selects\Plugin\Field\FieldWidget\ListWidget.
 */

namespace Drupal\multiple_selects\Plugin\Field\FieldWidget;

use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'multiple_selects_list' widget.
 *
 * @FieldWidget(
 *   id = "multiple_selects_list",
 *   label = @Translation("Multiple Selects"),
 *   field_types = {
 *     "list_integer",
 *     "list_float",
 *     "list_string"
 *   },
 *   multiple_values = TRUE
 * )
 */
class ListWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  protected function getOptions(FieldableEntityInterface $entity = NULL) {
    $options = [];

    if ($entity) {
      $options = $this->fieldDefinition
        ->getFieldStorageDefinition()
        ->getOptionsProvider($this->getColumn(), $entity)
        ->getSettableOptions(\Drupal::currentUser());
    }

    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    
    $options = $this->getOptions($items->getEntity());
    $selected = $this->getSelectedOptions($items);

    // If required and there is one single option, preselect it.
    if ($this->required && count($options) == 1) {
      reset($options);
      $selected = array(key($options));
    }

    if ($this->multiple) {
      $element += array(
        '#type' => 'checkboxes',
        '#default_value' => $selected,
        '#options' => $options,
      );
    }
    else {
      $element += array(
        '#type' => 'radios',
        // Radio buttons need a scalar value. Take the first default value, or
        // default to NULL so that the form element is properly recognized as
        // not having a default value.
        '#default_value' => $selected ? reset($selected) : NULL,
        '#options' => $options,
      );
    }
dpm($element);  
    
    return $element;
  }
  
  /**
   * Collects the options for a field.
   */
  public function _multiple_selects_get_options($field, $instance, $properties, $entity_type, $entity) {
    
    if ($properties['empty_option']) {
      $label = theme('multiple_selects_none', array('instance' => $instance, 'option' => $properties['empty_option']));
      $options = array('_none' => $label) + $options;
    }
  
    return $options;
  }
}
