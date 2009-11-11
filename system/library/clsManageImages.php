<?php 
/*%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	Created By: Virendra Sonawane
	Created Date: Monday, June 02, 2008
%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%*/

class clsManageImages{

	// This Function is used for to upload file name
	function upload_image($file,$destfilename,$max_width,$max_height,$maxSize){
		if(!is_uploaded_file($file['tmp_name']))
			return 'NOTEXIT';
		if($file['size'] > $maxSize) 
			return 'LARGESIZE';
		if($file['name']=="")
			return 'NOTEXIT';
		$img_size_array = @getimagesize($file['tmp_name']);
		$img_width	=	$img_size_array[0];
		$img_height	=	$img_size_array[1];
		if($img_width == ""  || $img_height == "" )
			return 'NOTEXIT';
		if($img_width > $max_width  || $img_height > $max_height )
			return 'LARGEDIMENSION';
		if(!copy($file['tmp_name'],$destfilename))
			return 'NOTCOPY';
		return 'DONE';
	}
	// This function is used for to create rand file name
	function createRandFileName($suffix=''){
		$unix_timestamp = strtotime('now'); 
		$rand_no=rand(1000,9999);
		$filename = "tallyzoo_".$suffix.$unix_timestamp.$rand_no;
		return $filename;
	}
	// This Function is used for to get the File extension
	function getFileExtension($filename){
		$temArr			=	explode(".",$filename);
		$extlocation	=	count($temArr) -1 ;
		return $temArr[$extlocation];
	}
	// This function is used for to resize the image
	function imageResize($sourceImg_name,$sourcePath,$destPath,$destImg_name,$dimension){
			$image_source	=	$sourcePath . $sourceImg_name;
			$thumbnail		=	$destPath . $destImg_name;
		if (file_exists($image_source)){
			$img_size_array = getimagesize($image_source);
			//print_r($img_size_array);
			if($img_size_array[0] < $dimension[0] && $img_size_array[1] < $dimension[1]){
				$convert = "convert -geometry ".$img_size_array[0]."x".$img_size_array[1]." ". $image_source . " ". $thumbnail. " ";
			}
			else{
				$convert = "convert -geometry ".$dimension[0]."x".$dimension[1]." ". $image_source . " ". $thumbnail. " ";
			}
			exec($convert);
		}
		return;
	}
	// This function is used for to Delete the File 
	function deleteFile($path){
		if (file_exists($path)){
			@unlink($path);
			return true;
		}
	}
	//This copy image in actual size
	function upload_image_actual($file,$destfilename,$path){
		$destpath = $path .$destfilename;
		if(!@copy($file['tmp_name'],$destpath))
			return false;
		return true;
	}
	//copy image file forom source to destimation
	function copyFile($sourcepath,$destpath){
		if(!@copy($sourcepath,$destpath))
			return false;
		return true;
	}
} // End Class clsManageImages

?>