<?php

include_once(MODEL_PATH . "UserModel.php");

class CoreController
{
  static function getModel()
  {
    return new UserModel();
  }
}