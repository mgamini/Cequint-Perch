<script type="text/javascript" src="PERCH_LOGINPATH/plugins/editors/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="PERCH_LOGINPATH/plugins/editors/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" charset="utf-8">
    
$(function() {
	var config = {
		filebrowserUploadUrl : 'PERCH_LOGINPATH/plugins/editors/ckeditor/uploader.php',
		filebrowserImageUploadUrl : 'PERCH_LOGINPATH/plugins/editors/ckeditor/uploader.php?filetype=image'
	}
	$('textarea.ckeditor').ckeditor(config);
});
</script>
<style type="text/css">
    html body .cke_skin_kama {
        width: 450px;
        float: left;
    }
</style>