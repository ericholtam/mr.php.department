#!/bin/bash

# department_manifest controller
CTL="${BASEURL}index.php?/module/department/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/department.sh" -o "${MUNKIPATH}preflight.d/department.sh"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/department.sh"

	# Set preference to include this file in the preflight check
	setreportpref "department" "${CACHEPATH}department.txt"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/department.sh"

	# Signal that we had an error
	ERR=1
fi
