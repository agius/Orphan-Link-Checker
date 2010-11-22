<?php
require_once 'lib/limonade.php';

function before()
{
  option('env', ENV_DEVELOPMENT);
  layout('layouts/default.html.php');
}

dispatch('/', 'hello');
  function hello()
  {
      return html('olc/index.html.php');
  }
  
dispatch_post('/check', 'check_links');
  function check_links()
  {
      $api_key = $_POST['api_key'] or null;
      $workspace = $_POST['workspace'] or null;
      if($api_key == null || $workspace == null){
        redirect_to('/');
        return;
      }
      $result = file_get_contents("https://$workspace/api_v2/op/GetCurrentPages/read_key/$api_key");
      $result = str_replace('/*-secure-', '', $result);
      $result = str_replace('*/', '', $result);
      $pages = json_decode($result, true);
      return debug(array_keys($pages['pages']));
  }
run();
?>