<?php

/**
 * @file
 * Contains \Drupal\multiple_selects\Tests\ReferenceTest.
 */

namespace Drupal\multiple_selects\Tests;

/**
 * Tests the the functionality of the Reference widget.
 *
 * @codeCoverageIgnore
 *   Our unit tests do not have to cover the integration tests.
 *
 * @group 'Select or other'
 */
class ListTest extends TestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = ['node', 'options', 'multiple_selects'];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $field_settings = [];
    $widget = 'multiple_selects_list';
    $widgets = ['multiple_selects_select', 'multiple_selects_buttons'];
    $this->prepareTestFields('list_string', $field_settings, $widget, $widgets);
    $user = $this->drupalCreateUser($this->defaultPermissions);
    $this->drupalLogin($user);
  }

  /**
   * Make sure an empty option is present when relevant.
   */
  public function testEmptyOption($empty_option = '') {
    parent::testEmptyOption('My cool new value');
  }

}
