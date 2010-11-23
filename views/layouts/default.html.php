<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Orphaned Link Checker</title>
  <link rel="stylesheet" type="text/css" href="/public/stylesheets/reset.css" />
  <link rel="stylesheet" type="text/css" href="/public/stylesheets/olc.css" />
</head>
<body>
  <h1>Orphaned Link Checker</h1>
  <?php if(isset($_SESSION['notice'])){ ?>
      <div id="notice"><?= $_SESSION['notice'] ?></div>
      <?php unset($_SESSION['notice']) ?>
  <?php } ?>
  <div id="content">
    <?= $content ?>
  </div>
</body>
</html>