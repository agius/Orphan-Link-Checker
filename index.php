<?php
require_once 'lib/limonade.php';

function before()
{
  option('env', ENV_DEVELOPMENT);
  layout('layouts/default.html.php');
}

function get_pb($action, $element = null){
  $api_key = $_POST['api_key'] or null;
  $workspace = $_POST['workspace'] or null;
  if($api_key == null || !preg_match('/(\w+)/', $api_key)){
      throw new Exception("Invalid api key: $api_key");
  }
  if($workspace == null || !preg_match('/([^\s\/]+)\.([^\s\/]+)\.([^\s\/]+)/', $workspace)){
      throw new Exception("Invalid workspace: $workspace");
  }
  $result = file_get_contents("https://$workspace/api_v2/op/$action/user_key/$api_key");
  $result = str_replace('/*-secure-', '', $result);
  $result = str_replace('*/', '', $result);
  $result = json_decode($result, true);
  if(isset($result['error_string']))
      throw new Exception($result['error_string']);
  return $element == null ? $result : $result[$element];
}

dispatch('/', 'hello');
  function hello()
  {
      return html('olc/index.html.php');
  }
  
dispatch_post('/check', 'check_links');
  function check_links()
  {
      try{
          $all_pages = $unlinked_pages = array_keys(get_pb('GetCurrentPages', 'pages'));
          foreach($all_pages as $page){
              $page = 'SideBar';
              $html = get_pb("GetPage/page/$page", 'html');
              $linked_pages = array();
              foreach($unlinked_pages as $unlinked){
                  if(preg_match("/\/w\/page\/$unlinked/", $html)){
                      $linked_pages[] = $unlinked;
                  }
                  $unlinked_pages = array_diff($unlinked_pages, $linked_pages);
              }
          }
          set('unlinked_pages', $unlinked_pages);
          return html('olc/check.html.php');
      }catch(Exception $e){
          $_SESSION['notice'] = $e->getMessage();
          redirect_to('/');
      }
  }
run();
?>