#!/bin/bash

# Setting the backup directory
backup_dir="/var/www/html/backup"

# Create a directory for storing backups if it doesn't exist
mkdir -p "$backup_dir"

# Set the current date as part of the snapshot name
current_date=$(date +%Y-%m-%d)
# Create snapshot name with the date
snapshot_name="snapshot-$(date +%Y-%m-%d-%H-%M-%S)"

# Create the snapshot using the instance, snapshot name and zone it's located
gcloud compute disks snapshot instance-20240325-042636 --snapshot-names="$snapshot_name" --zone us-central1-c

# Check if the snapshot was created successfully
if [ $? -eq 0 ]; then
    echo "Snapshot created successfully: $snapshot_name"
else
    echo "Failed to create snapshot"
    exit 1
fi

