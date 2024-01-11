<?php

namespace App\Helpers;

class SessionHelpers
{
  public function setSession($key, $data)
  {
    $session = session();
    $sessionData = [];
    if ($session->get('sessionData')) {
      $sessionData = $session->get('sessionData');
    }
    $sessionData = array_merge($sessionData, [$key => $data]);
    $session->set('sessionData', $sessionData);
  }

  public function getSession()
  {
    $session = session();
    return $session->get('sessionData');
  }

  public function removeSession($list)
  {
    foreach ($list as $key) {
      $session = session();
      $sessionData =  $session->get('sessionData');
      unset($sessionData[$key]);
      $session->set('sessionData', $sessionData);
    }
  }

  public function deleteSession()
  {
    $session = session();
    $session->remove('sessionData');
  }
}
