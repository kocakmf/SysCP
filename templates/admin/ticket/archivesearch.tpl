$header
	<form action="$filename?s=$s&amp;page=$page" method="post">
		<input type="hidden" name="token" value="{$userinfo['formtoken']}" />
		<input type="hidden" name="send" value="send" />
		<table cellpadding="5" cellspacing="0" border="0" align="center" class="maintable">
			<tr>
				<td class="maintitle_search_left"><b><img src="images/title.gif" alt="" />&nbsp;{$lng['ticket']['archivesearch']}</b></td>
        <td class="maintitle_search_right" colspan="5">&nbsp;</td>
			</tr>
      <if 0 < $tickets_count >
			<tr>
				<td class="field_display_border_left">{$lng['ticket']['archivedtime']}</td>
				<td class="field_display">{$lng['ticket']['ticket_answers']}</td>
				<td class="field_display">{$lng['ticket']['subject']}</td>
				<td class="field_display">{$lng['ticket']['lastreplier']}</td>
				<td class="field_display">{$lng['ticket']['priority']}</td>
        <td class="field_display_search">&nbsp;</td>
			</tr>
			$tickets
      </if>
      <if $tickets_count < 1 >
        <tr><td class="field_display_border_left" colspan="5">{$lng['ticket']['noresults']}<br />{$query}</td></tr>
      </if>
		</table>
	</form>
	<br />
	<br />
$footer