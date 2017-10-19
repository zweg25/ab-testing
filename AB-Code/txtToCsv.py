# Purpose: converts mylog txt files to csv
# File Locations: have "mylog" and this python file on your desktop
# Instructions: Go to your Terminal/Powershell and navigate to Desktop. 
# Run the python file with the following command: "python txtToCsv.py"
# Output: A csv file called "cleanLogs.csv" will be created on your Desktop

import csv

with open('mylog', 'r') as inputF, open('cleanLogs.csv', 'w') as outputF:
	w = csv.writer(outputF)
	for line in inputF:
		row = line.split(" ")
		w.writerow(row)

