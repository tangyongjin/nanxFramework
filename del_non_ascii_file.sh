ls -1 -R -i | grep -a "[^A-Za-z0-9_.':@ /-]" | while read f; do inode=$(echo "$f" | cut -d ' ' -f 1); find -inum "$inode" -delete; done
