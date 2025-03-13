<tr>
  <th></th>
  <td>или</td>
</tr>
<tr>
  <th>Сервер</th>
  <td>
    <select name="auth[custom_server]">
      <option value="" selected>-- Не выбрано --</option>
      <?php foreach ($servers as $name => $config) { ?>
        <option value="<?= htmlspecialchars($name) ?>"><?= htmlspecialchars($name) ?></option>
      <?php } ?>
    </select>
  </td>
</tr>

