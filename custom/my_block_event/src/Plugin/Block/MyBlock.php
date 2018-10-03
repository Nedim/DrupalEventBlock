<?php
/**
 * Created by PhpStorm.
 * User: Nedim Trumić
 * Date: 9/30/18
 * Time: 8:38 PM
 */


namespace Drupal\my_block_event\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "my_block_event_block",
 *   admin_label = @Translation("My Event block"),
 * )
 */
class MyBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    $node = \Drupal::routeMatch()->getParameter('node');
    $events = array();
    if($node->getType() == "event") {

      $date = $node->field_event_date->value;
      $diff = \Drupal::service('my_block_event.event_status')->getDiffDays($date);

      $event['title'] = $node->title->value;
      $event['status'] = $diff;
      array_push($events, $event);

    } else {

      $output = "Only for Event Pages.";
    }

    return [
      '#theme' => 'mytemplate',
      '#events' => $events,
      '#cache' => array(
        'max-age' => 0,
      ),
    ];
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['my_block_settings'] = $form_state->getValue('my_block_settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return 0;
  }
}
