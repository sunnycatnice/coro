<?php

// header('Content-Type:text/plain');

require_once('table_lib.php');

#function to print in a table the output of the function read_files
#the first array depth is the name of the folder
#the second array depth is an array containing the path and the name of the file
#print on the rows the name of the folder (first array depth)
#print on the columns the name of the files (third array depth first index)
#every file is clickable and will open the file in a new window
function print_table($array){
	echo '<table id="myTable1">'; 
	echo "<input type='text' id='myInput1' onkeyup='myFunction(1)' placeholder=' Cerca un brano...' title='Type in a name'>";	

	//include main.css
	echo '<link rel="stylesheet" type="text/css" href="https://coralesantalessandro.com/lib_areariservata/CSS/main.css">';

	?>
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
				print_x_files_in_column($value, $i, $num_of_files);
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

#function create_right_index2($array) to create another html dynamic table
#it takes as input the array returned by read_files
#it prints the table with the name of the folder on the first column
#end every other column with a link to the file
function print_table_2($array)
{
	echo '<br>';
	echo '<table id="myTable2">'; 
	echo "<input type='text' id='myInput2' onkeyup='myFunction(2)' placeholder=' Cerca un brano...' title='Type in a name'>";

	// <!-- <link rel="stylesheet" href="http://coralesantalessandro.com/lib_areariservata/CSS/main.css" type="text/css"> -->
	echo '<link rel="stylesheet" type="text/css" href="https://coralesantalessandro.com/lib_areariservata/CSS/main.css">';

	?>
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
				$i = 1;
				$folder_name = get_name($key);
				echo '<td>'.$folder_name.'</td>';
				foreach($value as $key2 => $folder_and_file)
				{
					$num_of_files = count_right_files_in_column($value, $i);
					print_x_files_in_column($value, $i, $num_of_files);
					$i++;
				}
				echo '</tr>';
			}
		}
		echo '</table>';

		echo "<script type=\"text/javascript\" src=\"https://coralesantalessandro.com/search.js?ver=107\"></script>";
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

print_table(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpsdocs/reserved")));
print_table_2(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpsdocs/reserved/table2")));
// print_table(create_right_index(read_files("/Users/daniele/coro/tests")));
// print_table_2(create_right_index(read_files("/Users/daniele/coro/tests")));