# custom_script

This is custom remedy for tracking virus/worm like http://security.stackexchange.com/questions/86094/what-does-this-malicious-php-script-do#_=_

This script is not 100% accurate. But still the list of files can be found out using. 
The files are to be check before deleting the file. 


===================================
Logic behid the script
===================================

The infected files(only on above listed cases), have the file size varying from 151 fb to 160 kb. 
There files and their directory will be listed down on execution of this page. 
THE FILES ARE TO BE CHECKED BEFORE DELETION. 
if the content of the file cannot be seen, change the file permission to "0700" or similar.

==================================
Script 
==================================

Save the scipt in a php page and execute on server. 

The files with file size 151kb will be listed down. Most of there files will be affected. 




<?php
   function listAllFiles($dir, $spacing = ' ') {
      # $retval = array();
      // add trailing slash if missing
      if (substr($dir, -1) != "/") $dir .= "/";

      // open pointer to directory and read list of files
      $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");

      echo '<pre>';
      while (false !== ($entry = $d->read())) {
         if ($entry[0] == ".") continue;

         $strong = false;
         if(filesize($dir.$entry) > 15000) {
            if(filesize($dir.$entry) < 16000) {
               $strong = true;
            }
         }
         # $strong = ((filesize($dir.$entry) > 1500) and (filesize($dir.$entry) < 16000))? true:false;

         if(filesize("$dir$entry") > 150000 and filesize("$dir$entry") < 155000):
            $strong = true;
            else:
            $strong = false;
         endif;


         if(($strong)) {
            echo ($strong)?'<strong style="color: #555">':'';
            echo $spacing . $entry;
            echo (is_dir("$dir$entry") ? '/' : ' - <small>' . getPower(filesize("$dir$entry")) . '</small>') . '<br />';
            # var_dump(is_dir("$dir$entry"));
            echo ($strong)?'</strong>':'';
         }

         if( is_dir("$dir$entry") ){
            listAllFiles("$dir$entry",
               substr($spacing, 0, -1) . '/' . $entry . '/');
         }
      }
      echo '</pre>';
      return true;
   }

   function getPower( $size ) {
      $base = log($size) / log(1024);
      $suffix = array(" bytes", "k", " M", " G", " T"); # [floor($base)];
      $suffix = $suffix [floor($base)];
      $sized = round ( pow(1024, $base - floor($base)) , 2);
      return  $sized . $suffix;
   }

   listAllFiles( getcwd() );
?>
