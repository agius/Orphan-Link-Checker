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
  if($api_key == null){
      throw new Exception('invalid api key');
  }
  if($workspace == null){
      throw new Exception('invalid workspace');
  }
  $result = file_get_contents("https://$workspace/api_v2/op/$action/read_key/$api_key");
  $result = str_replace('/*-secure-', '', $result);
  $result = str_replace('*/', '', $result);
  $result = json_decode($result, true);
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
  }
run();
?>