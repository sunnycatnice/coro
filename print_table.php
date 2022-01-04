<?php

header('Content-Type:text/plain');

//constants to define better what is called what
define("FILE_PATH", 0);
define("FILE_NAME", 1);
define("PRINTABLE_FILE", 0);
define("SKIPPABLE_FILE", -1);
define("SITE_URL", "http://www.coralesantalessandro.com/wordpress/");

//class structure to store datas from every file of the current directory
class filedata
{
	public $file_path;
	public $file_name;
	public $file_number;
}

//initialize the array to store the data of the files of the current directory
function init_filedata($file, $folder_and_file)
{
	$file->file_path = $folder_and_file[FILE_PATH];
	$file->file_name = $folder_and_file[FILE_NAME];
}

//function folderisright that checks if the folder is right
//the folder is right if its name starts with a number followed by a "-"
//it returns 0 if the folder is right
//it returns 1 if the folder is wrong
function folderisright($key)
{
	if (preg_match("/^[0-9]+-/", $key))
		return 0;
	else
		return 1;
}

//fileisright function that checks if the name of the file is correct
//a correct file name is a file that starts with a number followed by a "-"
//return 0 if the file name is correct
//return -1 if the file name starts with a number, followed by a "-" and contains the world "skip"
//return 1 if the file name is incorrec
function fileisright($file)
{
	if (preg_match("/skip/", $file))
		return -1;
	$first_2_chars = substr($file, 0, 2);
	if (preg_match("/^[0-9]+-/", $first_2_chars))
		return 0;
	return 1;
}

function fixpath($str)
{
	$str2 = "/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/";
	return(str_replace($str2,"", $str));
}

//function check_2_files
//if there is present a file containing its first 2 characters equal to the first 2 characters of another file in the same folder
//the function returns 0 if there are at least 2 files with the same first 2 characters
//it returns 1 if there are less than 2 files with the same first 2 characters
function check_2_files($filename, $files)
{
	$first_2_chars = substr($filename, 0, 2);
	$count = 0;
	foreach ($files as $file)
	{
		if (substr($file[FILE_NAME], 0, 2) == $first_2_chars)
			$count++;
	}
	if ($count >= 2)
		return 0;
	else
		return 1;
}

function print_single_file($file)
{
	if(fileisright($file->file_name) == PRINTABLE_FILE)
		echo '<td><a href="'.SITE_URL.fixpath($file->file_path)."/".$file->file_name.'" target="_blank">'.substr($file->file_name,2).'</a></td>';
	elseif(fileisright($file->file_name) == SKIPPABLE_FILE)
		echo '<td></td>';
}

function print_2_files($file, $value, $key)
{
	if(fileisright($file->file_name) == PRINTABLE_FILE)
	{
		echo '<td><a href="'.SITE_URL.fixpath($value[$key][FILE_PATH])."/".$value[$key][FILE_NAME].'" target="_blank">'.substr($value[$key][FILE_NAME],2).'</a>';
		echo ' - <a href="'.SITE_URL.fixpath($value[$key+1][FILE_PATH])."/".$value[$key+1][FILE_NAME].'" target="_blank">'.substr($value[$key+1][FILE_NAME],2).'</a></td>';
	}
	elseif(fileisright($file->file_name) == SKIPPABLE_FILE)
		echo '<td></td>';
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
	<th scope="col">Titolo</th>
	<th scope="col">Soprani</th>
	<th scope="col">Contralti</th>
	<th scope="col">Tenori</th>
	<th scope="col">Bassi</th>
	<th scope="col">Spartito</th>
	<th scope="col">Ascolta</th>
	</tr>
</thead>
<tbody>
	<tr>
	<?php
		foreach($array as $key => $value)
		{
			echo '<tr>';
			if (folderisright($key) == 0)
			{
				//new variable to store the name of the folder without the number
				$folder_name = substr($key, 2);
				echo '<td>'.$folder_name.'</td>';
				foreach($value as $key2 => $folder_and_file)
				{
					$file = new filedata();
					init_filedata($file, $folder_and_file);
					//if there is present a file containing its first 2 characters equal to the first 2 characters of another file in the same folder
					//then use the function print_2_files
					if (check_2_files($file->file_name, $value) == 0)
					{
						//use the function print_2_files only for odd keys
						if ($key2 % 2 == 0)
							print_2_files($file, $value, $key2);
					}
					else
						print_single_file($file);
				}
			}
			echo '</tr>';
		}
		echo '</table>';
	?>
	</tr>
</tbody>
<?php
}

#php function that reads the files from the directory passed to it
#it should be recursive, so it will return the files in subdirectories
#it creates an array of arrays, where the first array is the directory, and the second is the file
#it will only return mp3 and PDF files
function read_files($dir)
{
	$files = array();
	$dir_array = array();
	$i = 2;
	$dir_array = scandir($dir);
	foreach ($dir_array as $key => $value)
	{
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
						$files[$i] = array($dir, $value);
				}
				$i++;
			}
		}
	}
	return $files;
}

#print the array of arrays returned by the function get_files
#print_r(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/reserved"));
print_table(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/wordpress/reserved"));
?>