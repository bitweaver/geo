{strip}
	<div class="row">
		{formlabel label="latitude" for="geo[lat]"}
		{forminput}
			<input type="text" name="geo[lat]" id="geo_lat" value="{if $gContent}{$gContent->mInfo.lat}{else if $serviceHash}{$serviceHash.lat}{/if}" />			
		{/forminput}
	</div>

	<div class="row">
		{formlabel label="longetitude" for="geo[lng]"}
		{forminput}
			<input type="text" name="geo[lng]" id="geo_lng" value="{if $gContent}{$gContent->mInfo.lng}{else if $serviceHash}{$serviceHash.lng}{/if}" />
		{formhelp note="Location Data"}
		{/forminput}
	</div>
{/strip}
