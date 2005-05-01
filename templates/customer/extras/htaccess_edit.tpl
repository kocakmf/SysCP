$header
    <form method="post" action="$filename">
     <input type="hidden" name="s" value="$s">
     <input type="hidden" name="page" value="$page">
     <input type="hidden" name="action" value="$action">
     <input type="hidden" name="id" value="$id">
     <table cellpadding="3" cellspacing="1" border="0" align="center" class="maintable">
      <tr>
       <td colspan="2" class="title">{$lng['extras']['pathoptions_edit']}</td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['panel']['path']}:</b></td>
       <td class="maintable" nowrap>{$result['path']}</td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['extras']['directory_browsing']}:</b></td>
       <td class="maintable">$options_indexes</td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['extras']['errordocument404path']}:</b><br />{$lng['panel']['emptyfordefault']}</td>
       <td class="maintable"><input type="text" name="error404path" value="{$result['error404path']}" maxlength="50"></td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['extras']['errordocument403path']}:</b><br />{$lng['panel']['emptyfordefault']}</td>
       <td class="maintable"><input type="text" name="error403path" value="{$result['error403path']}"  maxlength="50"></td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['extras']['errordocument500path']}:</b><br />{$lng['panel']['emptyfordefault']}</td>
       <td class="maintable"><input type="text" name="error500path" value="{$result['error500path']}"  maxlength="50"></td>
      </tr>
      <tr>
       <td class="maintable"><b>{$lng['extras']['errordocument401path']}:</b><br />{$lng['panel']['emptyfordefault']}</td>
       <td class="maintable"><input type="text" name="error401path" value="{$result['error401path']}"  maxlength="50"></td>
      </tr>
      <tr>
       <td class="maintable" colspan="2" align="right"><input type="hidden" name="send" value="send"><input type="submit" value="{$lng['extras']['pathoptions_edit']}"></td>
      </tr>
     </table>
    </form>
$footer