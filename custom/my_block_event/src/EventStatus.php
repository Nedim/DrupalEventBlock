<?php
/**
 * Created by PhpStorm.
 * User: Nedim Trumić
 * Date: 10/3/18
 * Time: 1:51 PM
 */

namespace Drupal\my_block_event;

class EventStatus
{
  public function getDiffDays($date1){

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
}
