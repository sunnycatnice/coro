<?php

// header('Content-Type:text/plain');

//constants to define better what is called what
define("FILE_PATH", 0);
define("FILE_NAME", 1);
define("PRINTABLE_FILE", 0);
define("SKIPPABLE_FILE", -1);
define("SITE_URL", "http://www.coralesantalessandro.com/");

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

//function get_file_number to extract the number of the file from its name
//it should return the first numbers befre the character '-'
function get_file_number($file_name)
{
	$file_number = "";
	settype($file_number, "integer");
	$i = 0;
	//scroll through the file name as long as the character is a number
	while(is_numeric($file_name[$i]))
	{
		if ($i == 0)
		{
			$file_number = $file_name[$i];
		}
		else
		{
			$file_number = $file_number . $file_name[$i];
		}
		$i++;
	}
	return $file_number;
}
//function folderisright that checks if the folder is right
//the folder is right if its name starts with a number followed by a "-"
//it returns 0 if the folder is right
//it returns 1 if the folder is wrong
function folderisright($key)
{
	//loop through the folder name as long as the character is a number
	//if none of the characters is a number, return 1
	//if there is at least one number, check if the number is followed by a "-"
	//if not, return 1
	//if the folder is right, return 0
	$i = 0;
	while(is_numeric($key[$i]))
	{
		$i++;
	}
	if ($i == 0)
	{
		return 1;
	}
	else
	{
		if ($key[$i] != "-")
			return 1;
		else
			return 0;
	}
}

//fileisright function that checks if the name of the file is correct
//a correct file name is a file that starts with a number followed by a "-"
//return 0 if the file name is correct
//return -1 if the file name starts with a number, followed by a "-" and contains the world "skip"
//return 1 if the file name is incorrect
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
	$str2 = "/data/vhosts/coralesantalessandro.com/httpdocs/";
	return(str_replace($str2,"", $str));
}

function check_youtube_video($filename)
{
	if (preg_match("/watch/", $filename))
		return 1;
	return 0;
}

//function check_2_files($file_name, $file_number, $key, $file_array)
//if the current file number is equal to the next one, it means that the file is a duplicate, then the function returns 0
//if the current file number is not equal to the next one, it means that the file is not a duplicate, then the function returns 1
function check_2_files($file_array, $key)
{
	$file_number = get_file_number($file_array[$key][FILE_NAME]);
	$next_file_number = get_file_number($file_array[$key + 1][FILE_NAME]);
	//execute the if only if $key is even
	if ($key % 2 == 0)
	{
		if ($file_number == $next_file_number)
			return 0;
		else
			return 1;
	}
	else
		return 1;
}

function check_single_video($filename)
{
	if (preg_match("/watch/", $filename))
	{
		$youtube_link = "http://www.youtube.com/";
		$youtube_link = $youtube_link . substr($filename, 2, -4);
		//put an html title to that video
		$youtube_link = $youtube_link;
		//using this solution up to put it there is the file up/down the video with function check_if_other_files_for_ytvideo
		echo '<td><a href=' . $youtube_link . ">" . $filename.'" target="_blank"></td>';
		return 1;
	}
	return 0;
}

function print_yt_status2($value, $key, $youtube_link)
{
	echo '<td><a href=' . $youtube_link . ">" . $value[$key + 1][FILE_NAME].'" target="_blank">'.'</a>'.' -';
	echo '<br> <a href="'.SITE_URL.fixpath($value[$key][FILE_PATH])."/".$value[$key][FILE_NAME].'" target="_blank">'.substr($value[$key][FILE_NAME],2).'</a></td>';
}

function print_yt_status3($value, $key, $youtube_link)
{
	echo '<td><a href=' . $youtube_link . ">" . $value[$key][FILE_NAME].'" target="_blank">'.'</a>'.' -';
	echo '<br> <a href="'.SITE_URL.fixpath($value[$key+1][FILE_PATH])."/".$value[$key+1][FILE_NAME].'" target="_blank">'.substr($value[$key+1][FILE_NAME],2).'</a></td>';
}

function generate_yt_link($filename)
{
	$youtube_link = "http://www.youtube.com/";
	$youtube_link = $youtube_link . substr($filename, 2, -4);
	//BISOGNA FARE EVENTUALMENTE 2 CAZZO DI LINK DIVERSI SE NO NON FUNZIONA. MADONNA.
	//FINITO QUESTO BASTA.
	$youtube_link = $youtube_link;
	return $youtube_link;
}

//the status variable is used to check if it's nessessary to print the td tag
function print_youtube_video($value, $key, $status)
{
	$yt_link1 = 0;
	$yt_link2 = 0;
	//using this solution up to put it there is the file up/down the video with function check_if_other_files_for_ytvideo
	//finire questa maledetta funzione, per dindirindina
	if ($status == 4)
	{
		$yt_link1 = generate_yt_link($value, $key);
		$yt_link2 = generate_yt_link($value, $key + 1);
		echo '<td><a href=' . $yt_link1 . ">" . $value[$key][FILE_NAME] .'" target="_blank">'.'</a>'.' -';
		echo '<br> <a href=' . $yt_link2 . ">" . $value[$key + 1][FILE_NAME].'" target="_blank"></td>';
	}
	if ($status == 3)
	{
		$yt_link1 = generate_yt_link($value, $key);
		print_yt_status3($value, $key, $$yt_link1);
	}
	if ($status == 2)
	{
		$yt_link2 = generate_yt_link($value, $key + 1);
		print_yt_status2($value, $key, $yt_link2);
	}
	if ($status == 1)
	{
		echo '<td class="ui-helper-center"><a href="'.SITE_URL.fixpath($value[$key][FILE_PATH])."/".$value[$key][FILE_NAME].'" target="_blank">'.substr($value[$key][FILE_NAME],2).'</a>'.' -';
		echo '<br> <a href="'.SITE_URL.fixpath($value[$key+1][FILE_PATH])."/".$value[$key+1][FILE_NAME].'" target="_blank">'.substr($value[$key+1][FILE_NAME],2).'</a></td>';
	}
}

//it returns 4 if both of the files ARE yt videos
//it returns 3 if the first file is a yt video and the second is NOT
//it returns 2 if the first file is NOT a yt video and the second is
//it returns 1 if both of the files ARE NOT yt videos
function check_if_other_files_for_ytvideo($value, $key)
{
	if (check_youtube_video($value[$key][FILE_NAME]) == 1)
	{
		if (check_youtube_video($value[$key + 1][FILE_NAME]) == 1)
			return 4;
		else
			return 3;
	}
	elseif (check_youtube_video($value[$key+1][FILE_NAME]) == 1)
	{
		if (check_youtube_video($value[$key][FILE_NAME]) == 0)
			return 2;
	}
	elseif (check_youtube_video($value[$key][FILE_NAME]) == 0)
	{
		if (check_youtube_video($value[$key + 1][FILE_NAME]) == 0)
			return 1;
	}
}

function make_youtube_videos($value, $key)
{
	$n_ytvideo = check_if_other_files_for_ytvideo($value, $key);
	if ($n_ytvideo == 4)
		print_youtube_video($value, $key, $n_ytvideo);
	if ($n_ytvideo == 3)
		print_youtube_video($value, $key, $n_ytvideo);
	if ($n_ytvideo == 2)
		print_youtube_video($value, $key, $n_ytvideo);
	if ($n_ytvideo == 1)
		print_youtube_video($value, $key, $n_ytvideo);
}

function print_single_file($value, $key, $file, $isprinted)
{
	if ($isprinted == 0 || $isprinted == 1)
	{
		if(fileisright($file->file_name) == PRINTABLE_FILE)
		{
			if (check_single_video($file->file_name) == 0 && $found == 0)
				echo '<td class="ui-helper-center"><a href="'.SITE_URL.fixpath($file->file_path)."/".$file->file_name.'" target="_blank">'.substr($file->file_name,2).'</a></td>';
		}
		elseif(fileisright($file->file_name) == SKIPPABLE_FILE)
			echo '<td></td>';
	}
	else
	{
		//non entra qua quando casi 2 e 3 per yt video.
		//if the filename of the current file is equal to the filename of $isprinted, then do not print the file
		if ($file->file_name != $isprinted)
		{
			if (check_single_video($file->file_name) == 0)
			{
				if(fileisright($file->file_name) == PRINTABLE_FILE)
					echo '<td class="ui-helper-center"><a href="'.SITE_URL.fixpath($file->file_path)."/".$file->file_name.'" target="_blank">'.substr($file->file_name,2).'</a></td>';
				elseif(fileisright($file->file_name) == SKIPPABLE_FILE)
					echo '<td class="ui-helper-center"></td>';
			}
		}
	}
}

function print_2_files($file, $value, $key)
{
	if(fileisright($file->file_name) == PRINTABLE_FILE || fileisright($value[$key + 1][FILE_NAME]) == PRINTABLE_FILE)
	{
		make_youtube_videos($value, $key);
		return $value[$key+1][FILE_NAME];
	}
	elseif(fileisright($file->file_name) == SKIPPABLE_FILE)
		echo '<td></td>';
	return 1;
}

//function to get how long is the number of the folder
function get_first_4_element_length($key)
{
	$count = 1;
	for ($i = 0; $i < 4; $i++)
	{
		if (is_numeric(substr($key, $i, 1)))
			$count++;
	}
	return $count;
}

//function to get the name of the file or the folder
function get_name($key)
{
	$name = "";
	$i = 0;
	while(is_numeric(substr($key, $i, 1)) || substr($key, $i, 1) == "-")
		$i++;
	$name = substr($key, $i);
	return $name;
}

//functon create_right_indexed($array)
//it returns the same array sorted by the first numbers found in the folder name
function create_right_index($array)
{
	//sort the multi-dimensional array by the first numbers appearing in the folder name
	array_multisort(array_map('get_file_number', array_keys($array)), SORT_ASC, $array);
	return $array;
}

function check_prev_number($filename, $prev_number)
{
	$number = get_file_number($filename);
	if ($number == $prev_number)
		return 1;
	else
		return 0;
}

//function to count the right files in a column
//given the array of files in a folder and the column to analize...
//it returns the number of files in the current column ($count)
function count_right_files_in_column($array, $column)
{
	$count = 0;
	foreach ($array as $key => $value)
	{
		// echo "[ " . $value[FILE_NAME]."] ";
		$current_col_num = get_file_number($value[FILE_NAME]);

		if($column == $current_col_num)
		{
			if (check_prev_number($value[FILE_NAME], $current_col_num) == 1
			&& fileisright($value[FILE_NAME]) == PRINTABLE_FILE)
			{
				$count++;
				$current_col_num = get_file_number($value[FILE_NAME]);
			}
			else
				break;
		}
		// echo "count:$count      ";
		// echo "current_col_num:$current_col_num      ";
	}
	// echo "FINE COUNT_RIGHT_FILES_IN_COLUMN\n";
	// echo "count:$count      ";
	return $count;
}

//function to print $n_of_times files in a column
//given the array of files in a folder and the column to analize...
//it prints using the function print_single_file the $n_of_times files in the current column
function print_x_files_in_column($array, $column, $n_of_times)
{
	$i = 0;
	// echo $n_of_times;
	foreach($array as $key => $value)
	{
		$file = new filedata();
		init_filedata($file, $value);
		if ($i == 0)
			$current_col_num = get_file_number($value[FILE_NAME]);
		if($column == $current_col_num)
		{
			// echo "[ " . $value[FILE_NAME]."] ";
			// echo check_youtube_video($file->file_name);
			if (check_prev_number($value[FILE_NAME], $current_col_num) == 1
			&& fileisright($value[FILE_NAME]) == PRINTABLE_FILE
			|| check_youtube_video($value[$key][FILE_NAME]) == 1)
			{
				if ($i == 0)
					echo '<td class="ui-helper-center">';
				if (check_youtube_video($file->file_name) == 1)
				{
					$yt_link = generate_yt_link($file->file_name);
					echo '<a href=' . $yt_link . ">" . $file->file_name .'</a>'.' -';
				}
				else
					echo '<a href="'.SITE_URL.fixpath($file->file_path)."/".$file->file_name.'" target="_blank">'.substr($file->file_name,2).'</a> - <br>';
				if ($i == $n_of_times - 1)
					echo '</td>';
				$i++;
				// echo "i:$i      ";
				$current_col_num = get_file_number($value[FILE_NAME]);
			}
			else
				break;
		}
	}
}

#function to print in a table the output of the function read_files
#the first array depth is the name of the folder
#the second array depth is an array containing the path and the name of the file
#print on the rows the name of the folder (first array depth)
#print on the columns the name of the files (third array depth first index)
#every file is clickable and will open the file in a new window
function print_table($array){
	echo '<table id="myTable1">'; 
	echo "<input type='text' id='myInput1' onkeyup='myFunction(1)' placeholder=' Cerca un brano...' title='Type in a name'>";?>	
<style>

thead, tbody, tr, td, th { display: block; }

/*
.qt-the-content table td, .qt-the-content table th {
	border: none !important;
	text-align: right;
}
*/

#myInput1 {
  background-image: url('http://coralesantalessandro.com/reserved/utils/search.svg'); /* Add a search icon to input */
  background-position: 10px 15px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

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

table td {
	padding: .625em;
	text-align: center;
}

tr:after {
	content: ' ';
	display: block;
	visibility: hidden;
	clear: both;
}

thead th {
	height: 50px;
	/*text-align: left;*/
}

tbody {
	height: 600px;
	overflow-y: auto;
}

thead {
	/* fallback */
}


tbody td, thead th {
	width: 13.8%;
	float: left;
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

	/*aria-label has no advantage, 
	**it won't be read inside a table
	*/
	content: attr(aria-label);
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
<caption>Brani in audio e spartito</caption>
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
		if (folderisright($key) == 0)
		{
			echo '<tr>';
			$isprinted = 1;
			$i = 1;
			$folder_name = get_name($key);
			echo '<td>'.$folder_name.'</td>';
		
			foreach($value as $key2 => $folder_and_file)
			{
				$num_of_files = count_right_files_in_column($value, $i);
				// echo "n_of_files:$num_of_files ";
				// echo "i:$i ";
				// if ($num_of_files >= 3)
					print_x_files_in_column($value, $i, $num_of_files);
				// else
				// {
				// 	if (check_2_files($value, $key2) == 0)
				// 		$isprinted = print_2_files($file, $value, $key2);
				// 	else
				// 		print_single_file($value, $key2, $file, $isprinted);
				// }
				$i++;
			}
			echo '</tr>';
		}
	}
	echo '</table>';
?>
</tr>
</tbody>
<?php
}

//function that counts the number of files in the folder
function count_files($array)
{
	$count = 0;
	foreach($array as $key => $value)
	{
		if (folderisright($key) == 0)
		{
			$count += count($value);
		}
	}
	return $count;
}

#function create_right_index2($array) to create another html dynamic table
#it takes as input the array returned by read_files
#it prints the table with the name of the folder on the first column
#end every other column with a link to the file
function print_table_2($array)
{
	echo '<br>';
	echo '<table id="myTable2">'; 
	echo "<input type='text' id='myInput2' onkeyup='myFunction(2)' placeholder=' Cerca un brano...' title='Type in a name'>"; ?>
	<style>
	
	thead, tbody, tr, td, th { display: block; }
	
	/*
	.qt-the-content table td, .qt-the-content table th {
		border: none !important;
		text-align: right;
	}
	*/

	#myInput2 {
	background-image: url('http://coralesantalessandro.com/reserved/utils/search.svg'); /* Add a search icon to input */
	background-position: 10px 15px; /* Position the search icon */
	background-repeat: no-repeat; /* Do not repeat the icon image */
	width: 100%; /* Full-width */
	font-size: 16px; /* Increase font-size */
	padding: 12px 20px 12px 40px; /* Add some padding */
	border: 1px solid #ddd; /* Add a grey border */
	margin-bottom: 12px; /* Add some space below the input */
  	} 
	
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
	
	table td {
		padding: .625em;
		text-align: center;
	}
	
	tr:after {
		content: ' ';
		display: block;
		visibility: hidden;
		clear: both;
	}
	
	thead th {
		height: 50px;
		/*text-align: left;*/
	}
	
	tbody {
		height: 600px;
		overflow-y: auto;
	}
	
	thead {
		/* fallback */
	}
	
	
	tbody td, thead th {
		width: 13.8%;
		float: left;
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
	
		/*aria-label has no advantage, 
		**it won't be read inside a table
		*/
		content: attr(aria-label);
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
	<caption>LA RISURREZIONE di G. Zelioli</caption>
	<thead>
		<tr>
		<th scope="col">Titolo</th>
		<th scope="col">Soprani</th>
		<th scope="col">Contralti</th>
		<th scope="col">Tenori</th>
		<th scope="col">Bassi</th>
		</tr>
	</thead>
	<tbody>
		<tr>
	<?php
		foreach($array as $key => $value)
		{
			if (folderisright($key) == 0)
			{
				echo '<tr>';
				$isprinted = 0;
				$folder_name = get_name($key);
				echo '<td>'.$folder_name.'</td>';
				//
				foreach($value as $key2 => $folder_and_file)
				{
					$file = new filedata();
					init_filedata($file, $folder_and_file);
					if (check_2_files($value, $key2) == 0)
						$isprinted = print_2_files($file, $value, $key2);
					else
						print_single_file($value, $key2, $file, $isprinted);
				}
				echo '</tr>';
			}
		}
		echo '</table>'; 
		
		echo "<script type = 'text/javascript'>
		function myFunction(id) {
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById('myInput'+id);
		  filter = input.value.toUpperCase();
		  table = document.getElementById('myTable'+id);
		  tr = table.getElementsByTagName('tr');
		  for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName('td')[0];
			if (td) {
			  txtValue = td.textContent || td.innerText;
			  if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = '';
			  } else {
				tr[i].style.display = 'none';
			  }
			}       
		  }
		}
		</script>";
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
				if ($ext == "mp3" || $ext == "pdf" || $ext == "txt" || $ext == "JPG")
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
//print_r(read_files("/Users/dmangola/Desktop/coro/tests"));
//$right_indexed = create_right_index(read_files("C:\\Users\\danie\\Desktop\\The BIG project\\coro\\tests"));
//print_r($right_indexed);
// print_table(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/reserved")));
print_table(create_right_index(read_files("/Users/daniele/coro/tests")));
//print_table_2(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/reserved/table2")));
//print_table(read_files("/Users/dmangola/Desktop/coro/index.php"));