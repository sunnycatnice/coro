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

		//non so perchè non funziona sul server ok localhost
		// echo "<script type=\"text/javascript\" src=\"search.js?ver=107\"></script>";
		// echo "<script type=\"text/javascript\" src=\"/data/vhosts/coralesantalessandro.com/httpdocs/search.js?ver=107\"></script>";

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

// print_table(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/reserved")));
// print_table_2(create_right_index(read_files("/data/vhosts/coralesantalessandro.com/httpdocs/reserved/table2")));
print_table(create_right_index(read_files("/Users/daniele/coro/tests")));
print_table_2(create_right_index(read_files("/Users/daniele/coro/tests")));