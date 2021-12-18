<?php

header('Content-Type:text/plain');

function fixpath($str)
{
  $str2 = "/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/";
  return(str_replace($str2,"", $str));
}

#function to print in a table the output of the function read_files
#the first array depth is the name of the folder
#the second array depth is an array containing the path and the name of the file
#print on the rows the name of the folder (first array depth)
#print on the columns the name of the files (third array depth first index)
#every file is clickable and will open the file in a new window
function print_table($array){
  echo '<table>'; ?>
  <style>
  table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
  }

  table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
  }

  table tr {
    background-color: black;
    border: 1px solid #ddd;
    padding: .35em;
  }

  table th,
  table td {
    padding: .625em;
    text-align: center;
  }

  table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
  }

  @media screen and (max-width: 600px) {
    table {
      border: 0;
    }

    table caption {
      font-size: 1.3em;
    }
    
    table thead {
      border: none;
      clip: rect(0 0 0 0);
      height: 1px;
      margin: -1px;
      overflow: hidden;
      padding: 0;
      position: absolute;
      width: 1px;
    }
    
    table tr {
      border-bottom: 3px solid #ddd;
      display: block;
      margin-bottom: .625em;
    }
    
    table td {
      border-bottom: 1px solid #ddd;
      display: block;
      font-size: .8em;
      text-align: right;
    }
    
    table td::before {
      /*
      * aria-label has no advantage, it won't be read inside a table
      content: attr(aria-label);
      */
      content: attr(data-label);
      float: left;
      font-weight: bold;
      text-transform: uppercase;
    }
    
    table td:last-child {
      border-bottom: 0;
    }
  }
  </style>
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">Tipologia 1</th>
      <th scope="col">Tipologia 2</th>
      <th scope="col">Spartito</th>
      <th scope="col">Ascolta</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <?php
  foreach($array as $key => $value){
    echo '<tr>';
    echo '<td>'.$key.'</td>';
    foreach($value as $key2 => $folder_and_file){
      //if in the filename is present the world "skip", it will leave the column empty
      //else it will echo '<td><a href="http://www.coralesantalessandro.com/wordpress/'.fixpath($folder_and_file[0])."/".$folder_and_file[1].'" target="_blank">'.$folder_and_file[1].'</a></td>';
      if(strpos($folder_and_file[1], "skip") !== false){
        echo '<td></td>';
      }
      else{
        echo '<td><a href="http://www.coralesantalessandro.com/wordpress/'.fixpath($folder_and_file[0])."/".$folder_and_file[1].'" target="_blank">'.$folder_and_file[1].'</a></td>';
      }
    }
    echo '</tr>';
  }
  echo '</table>'; ?>
    </tr>
  </tbody>
  <?php
}

#php function that reads the files from the directory passed to it
#it should be recursive, so it will return the files in subdirectories
#it creates an array of arrays, where the first array is the directory, and the second is the file
#it will only return mp3 and PDF files
function read_files($dir) {
	$files = array();
	$dir_array = array();
	$dir_array = scandir($dir);
	foreach ($dir_array as $key => $value) {
		if ($value != "." && $value != "..") 
    {
			if (is_dir($dir . "/" . $value)) 
      {
				$files[$value] = read_files($dir . "/" . $value);
			} 
      else 
      {
        $ext = pathinfo($value, PATHINFO_EXTENSION);
				if ($ext == "mp3" || $ext == "pdf" || $ext == "txt") 
        {
          #check if $value has number into it
          if(preg_match('/\-\d/', $value))
          {
            $sametipe[] = array($value);
          }
          else
          {
            $files[] = array($dir, $value, $sametipe);
				  }
        }
			}
		}
	}
	return $files;
}

#print the array of arrays returned by the function get_files
#print_r(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/reserved"));
print_table(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/reserved"));