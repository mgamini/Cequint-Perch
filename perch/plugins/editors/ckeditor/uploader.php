<?php
# include the API
include('../../../inc/api.php');

// test to see if image folder is writable
$image_folder_writable = is_writable(PERCH_RESFILEPATH);

$file = $_FILES['upload']['name'];
$filesize = $_FILES['upload']['size'];
$funcNum = $_GET['CKEditorFuncNum'];

//if the file is greater than 0, process it into resources
if($filesize > 0) {

	
	if ($image_folder_writable && isset($file)) {
    	$filename = PerchUtil::tidy_file_name($file);
        if (strpos($filename, '.php')!==false) $filename .= '.txt'; // diffuse PHP files
        $target = PERCH_RESFILEPATH.DIRECTORY_SEPARATOR.$filename;
        if (file_exists($target)) {
        	$filename = PerchUtil::tidy_file_name(time().'-'.$filename);
            $target = PERCH_RESFILEPATH.DIRECTORY_SEPARATOR.$filename;
        }
        
        
                                                                    
        move_uploaded_file($_FILES['upload']['tmp_name'], $target);
        
        $urlpath = PERCH_RESPATH.'/'.$filename;
        
        $width = false;
        $height = false;
        $crop = false;
        if(isset($_GET['filetype']) && $_GET['filetype'] == 'image') {
        	
        	if(defined('PERCH_EDITORIMAGE_CROP') && PERCH_EDITORIMAGE_CROP == true) {
        		$crop = true;
        	}
        	
        	
        	
        	if(defined('PERCH_EDITORIMAGE_MAXWIDTH') || defined('PERCH_EDITORIMAGE_MAXHEIGHT')) {
        		if(defined('PERCH_EDITORIMAGE_MAXWIDTH')) {
        			$width = PERCH_EDITORIMAGE_MAXWIDTH;
        		}
        		if(defined('PERCH_EDITORIMAGE_MAXHEIGHT')) {
        			$height = PERCH_EDITORIMAGE_MAXHEIGHT;
        		}
        	}else{
        		//no definitions, default to width.
        		$width = 640;
        	}
        	
        	$PerchImage = new PerchImage();
        	$PerchImage->resize_image($target, $width, $height, $crop, 'ck');
        	
        	$urlpath = $PerchImage->get_resized_filename(PERCH_RESPATH.'/'.$filename,false,false,'ck');
        	
        	
        }
        
		echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$funcNum.',"'.$urlpath.'");</script>';
	} else {
		echo '<p class="message">Upload failed. Is the directory writable?</p>';
	}
} else {
	echo '<p class="message">Upload failed.</p>';
}

?>
