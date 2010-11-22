<?php
require_once 'lib/limonade.php';

function before()
{
  layout('layouts/default.html.php');
}

dispatch('/', 'hello');
  function hello()
  {
      return html('olc/index.html.php');
  }
run();
?>