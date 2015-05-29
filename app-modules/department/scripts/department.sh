#!/bin/sh

# Department information

# Skip manual check
if [ "$1" = 'manualcheck' ]; then
	echo 'Manual check: skipping'
	exit 0
fi

# Create cache dir if it does not exist
DIR=$(dirname $0)
mkdir -p "$DIR/cache"
department_manfiest_file="$DIR/cache/department.txt"

#### Department Manifest Information ####

if [ ! -d /Library/Managed\ Installs/manifests ]; then
	echo "No manifest directory: exiting"
	exit 0
else
	cd /Library/Managed\ Installs/manifests/
	department_info=$(ls department*)
	if [ -z $department_info ]; then
		echo "Status = No Department" > "$department_manfiest_file"
		exit 0
	fi
fi 

echo "Department = $department_info" > "$department_manfiest_file"

exit 0
