<?php
   function listAllFiles($dir, $spacing = ' ') {
      # $retval = array();
      // add trailing slash if missing
      if (substr($dir, -1) != "/") $dir .= "/";

      // open pointer to directory and read list of files
      $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");

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
