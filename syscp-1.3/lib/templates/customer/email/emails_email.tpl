     <tr>
      <td class="maintable">{$row['email_full']}</td>
      <td class="maintable">{$row['destination']}</td>
      <td class="maintable"><if $row['popaccountid'] != 0>{$lng['panel']['yes']}</if><if $row['popaccountid'] == 0>{$lng['panel']['no']}</if></td>
      <td class="maintable"><if $row['iscatchall'] != 0>{$lng['panel']['yes']}</if><if $row['iscatchall'] == 0>{$lng['panel']['no']}</if></td>
      <td class="maintable"><a href="{$config->get('env.filename')}?page={$config->get('env.page')}&action=edit&id={$row['id']}&s={$config->get('env.s')}">{$lng['panel']['edit']}</a></td>
      <td class="maintable"><a href="{$config->get('env.filename')}?page={$config->get('env.page')}&action=delete&id={$row['id']}&s={$config->get('env.s')}">{$lng['panel']['delete']}</a></td>
     </tr>

