<form action="<?= url_for('check'); ?>" method="post">
  <label for="key">User Key:</label><br />
  <input name="api_key" type="text" size="35" placeholder="abc123" /><br />
  <label for="workspace">Workspace:</label><br />
  <input name="workspace" type="text" size="35" placeholder="my-workspace.pbworks.com" /><br />
  <input type="submit" value="Check" />
</form>