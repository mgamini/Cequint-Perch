$(document).ready(function(){

	$('textarea.markitup.textile:not(.markItUpEditor)').markItUp(textileSettings);
	$('textarea.markitup.markdown:not(.markItUpEditor)').markItUp(markdownSettings);
	$('textarea.markitup.html:not(.markItUpEditor)').markItUp(htmlSettings);
	
});