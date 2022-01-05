#shell script that execute put_numbers.py and execute mkdir command to create directories in this directory

#take the output of put_numbers.py and create directories
function create_dirs {
	while read line; do
		mkdir "$line"
	done < out.txt
}

#execute put_numbers.py and create directories
python3 put_numbers.py in.txt out.txt
create_dirs