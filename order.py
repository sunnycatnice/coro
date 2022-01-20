#given a txt file as input create an output file with every line ordered in alphabetical order

import sys

input = open(sys.argv[1], "r")
output = open(sys.argv[2], "w")

to_process = input.readlines()
#loop through every line of the input file and sort it
for line in to_process:
    line = line.split()
    line.sort()
    #loop through every word in the line and write it on the output file
    for word in line:
        output.write(word + " ")
    output.write("\n")
