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

    $nids = \Drupal::entityQuery('node')->condition('type','event')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);

    $events = array();
    foreach ($nodes as $node){

      $date = $node->field_event_date->value;

      $diff = $this->getDiffDays($date);

      $event['title'] = $node->title->value;
      $event['status'] = $diff;

      array_push($events, $event);
    }

    return [
      '#theme' => 'mytemplate',
      '#events' => $events,
      '#cache' => array(
        'max-age' => 0,
      ),
    ];
  }


  protected function getDiffDays($date1){

    $from=date_create(date('Y-m-d'));
    $date = date('Y-m-d', strtotime($date1));

    $to = date_create($date);

    $diff=date_diff($to,$from);

    $message="";

    if($diff->format('%R') == '-'){
      $message = "Days left to event start:".$diff->format('%a');
    }elseif ($diff->format('%a') == 0){
      $message = "This event is happening today!";
    }else{
      $message = "The event has ended.";
    }

    return $message;
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
