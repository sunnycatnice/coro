import os

#function to make a list of every file in every subdirectory of the path
#the function takes the path of the directory as an argument
#the function returns a list of every file in every subdirectory of the path
#the function returns an array of arrays, in one array there are 2 elements: the file and the path of the file
#it returns every file in every subdirectory of the path associated with the path of the directory
def list_files(path):
	list_files = []
	for subdir, dirs, files in os.walk(path):
		for file in files:
			list_files.append([file, subdir])
	return list_files

#function to search for the name of the current file in the whole list of files
#the function takes the name of the current file and the whole list of files as arguments
#the function returns the number of times the name of the current file appears in the whole list of files
def search_file(name_file, list_files):
	count = 0
	for file in list_files:
		if name_file == file[0]:
			count += 1
	return count

#function to create a txt file with the name of the files and the path associated with them
#the function takes the path of the directory and the path of a txt file as an argument
#the function writes on a txt file the following information:
#divide the txt file in two parts:
#the first part contains only the file that appear once in every subdirectory of the path
#the second part contains the file that appear more than once in every subdirectory of the path
#after writing a file.some_extension, print a "," and after that print the path of the file, then a new line
#the first part is recognized by the printing of the sentence "files that appear once in every subdirectory"
#the second part is recognized by the printing of the sentence "files that appear more than once in every subdirectory"
#the function returns nothing, because it writes on a txt file
def make_files(path, path_txt_file):
	#open the txt file
	text = open(path_txt_file, "w")
	print (path)
	#write on the txt file the sentence "files that appear once in every subdirectory"
	text.write("Files that appear once in every subdirectory\n\n")
	files = list_files(path)
	#now print in the first part of the txt file
	#the file that appear once in every subdirectory of the path
	#for every file in every subdirectory of the path
	for file in files:
		#search for the name of the current file in the whole list of files
		count = search_file(file[0], files)
		#if the name of the current file appears only once in every subdirectory of the path
		if count == 1:
			#print the name of the current file and the path of the file
			text.write(file[0] + "," + file[1] + "\n")
	#write on the txt file the sentence "files that appear more than once in every subdirectory"
	text.write("\nFiles that appear more than once in every subdirectory\n\n")
	#now print in the second part of the txt file
	#the file that appear more than once in every subdirectory of the path
	#for every file in every subdirectory of the path
	for file in files:
		#search for the name of the current file in the whole list of files
		count = search_file(file[0], files)
		#if the name of the current file appears more than once in every subdirectory of the path
		if count > 1:
			#print the name of the current file and the path of the file
			text.write(file[0] + "," + file[1] + "\n")
	#close the txt file
	text.close()

make_files("/Users/dmangola/Downloads/folder3", "/Users/dmangola/Desktop/coro/files.txt")