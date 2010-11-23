<h2>Orphan Pages:</h2>
<ul>
  <?php foreach($unlinked_pages as $page){ ?>
    <li><a href='<?= "https://{$_POST['workspace']}/w/page/$page" ?>' target='_blank'><?= $page ?></a></li>
  <?php } ?>
</ul>
<p>
  <a href="/">Back</a>
</p>