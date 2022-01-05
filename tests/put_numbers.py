#python program that given a txt file, it returns another file with the numbers in front of every new line

import sys #import sys module
#open file
f = open(sys.argv[1], "r")
#open file to write
f2 = open(sys.argv[2], "w")
#read file
lines = f.readlines()
#init skipper counter
skipped = 0
#write file
for i in range(len(lines)):
	#if there is an empty line, leave it
	if lines[i] == "\n":
		f2.write(lines[i])
		skipped += 1
	else:
		number = i+1-skipped
		#if there is a line, write the number and the line
		f2.write(str(number) + "-" + lines[i])
#close file
f.close()