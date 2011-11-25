<!-- BEGIN: MAIN -->
<h2>{PHP.L.rightsperuser_title}</h2>

<script type="text/javascript"
	src="{PHP.cfg.plugins_dir}/rightsperuser/js/rightsperuser.js">
</script>

{FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}

<h3>{PHP.L.rightsperuser_rules}</h3>
<table class="cells centerall">
	<tr>
		<td class="coltop">{PHP.L.User}</td>
		<td class="coltop">{PHP.L.Code}</td>
		<td class="coltop">{PHP.L.Item}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_r}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_w}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_1}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_2}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_3}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_4}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_5}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_a}</td>
		<td class="coltop">{PHP.L.Update}</td>
		<td class="coltop">{PHP.L.Delete}</td>
	</tr>
	<!-- BEGIN: RIGHTSPERUSER_ROW -->
	<form action="{RIGHTSPERUSER_ROW_ACTION}" method="POST">
	<tr>
		<td>{RIGHTSPERUSER_ROW_USER}</td>
		<td>{RIGHTSPERUSER_ROW_CODE}</td>
		<td>{RIGHTSPERUSER_ROW_OPTION}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_R}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_W}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_1}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_2}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_3}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_4}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_5}</td>
		<td>{RIGHTSPERUSER_ROW_AUTH_A}</td>
		<td><input type="submit" class="submit" value="{PHP.L.Update}" /></td>
		<td><a href="{RIGHTSPERUSER_ROW_DELETE_URL}" class="button">{PHP.L.Delete}</a></td>
	</tr>
	</form>
	<!-- END: RIGHTSPERUSER_ROW -->
</table>

<p class="paging">
	{RIGHTSPERUSER_PAGENAV_PREV}{RIGHTSPERUSER_PAGENAV_MAIN}{RIGHTSPERUSER_PAGENAV_NEXT}
</p>

<h3>{PHP.L.rightsperuser_add}</h3>
<form action="{RIGHTSPERUSER_ADD_ACTION}" method="POST">
<table class="cells centerall">
	<tr>
		<td class="coltop">{PHP.L.User}</td>
		<td class="coltop">{PHP.L.Code}</td>
		<td class="coltop">{PHP.L.Item}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_r}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_w}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_1}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_2}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_3}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_4}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_5}</td>
		<td class="coltop">{PHP.R.admin_icon_auth_a}</td>
		<td class="coltop">{PHP.L.Add}</td>
	</tr>
	<tr>
		<td>{RIGHTSPERUSER_ADD_USER}</td>
		<td>{RIGHTSPERUSER_ADD_CODE}</td>
		<td>{RIGHTSPERUSER_ADD_OPTION}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_R}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_W}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_1}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_2}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_3}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_4}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_5}</td>
		<td>{RIGHTSPERUSER_ADD_AUTH_A}</td>
		<td><input type="submit" class="submit" value="{PHP.L.Add}" /></td>
	</tr>
</table>
</form>

<!-- END: MAIN -->

<!-- BEGIN: HELP -->
		<p>{PHP.R.admin_icon_auth_r}&nbsp; {PHP.L.Read}</p>
		<p>{PHP.R.admin_icon_auth_w}&nbsp; {PHP.L.Write}</p>
		<p>{PHP.R.admin_icon_auth_1}&nbsp; {PHP.L.Custom} #1</p>
		<p>{PHP.R.admin_icon_auth_2}&nbsp; {PHP.L.Custom} #2</p>
		<p>{PHP.R.admin_icon_auth_3}&nbsp; {PHP.L.Custom} #3</p>
		<p>{PHP.R.admin_icon_auth_4}&nbsp; {PHP.L.Custom} #4</p>
		<p>{PHP.R.admin_icon_auth_5}&nbsp; {PHP.L.Custom} #5</p>
		<p>{PHP.R.admin_icon_auth_a}&nbsp; {PHP.L.Administration}</p>
<!-- END: HELP -->