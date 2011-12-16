#!/bin/bash
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 664 {} \;
find .git -type d -exec chmod 700 {} \;
find .git -type f -exec chmod 600 {} \;
chmod -R o+w images
chmod 755 .htaccess
chmod 600 .gitignore
