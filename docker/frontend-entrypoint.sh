#!/usr/bin/env sh
# get the owner of the current directory
dirOwner=$(ls -ld . | awk '{print $3}')
echo "👨 Dir owner: $dirOwner"

echo "⭐️ Install npm packages"
npm install --userconfig="storage/framework/cache/.npmrc"

npm config set cache=/var/www/storage/framework/cache/

echo "⭐️ Change node_modules user"
chown $dirOwner ./node_modules -R

echo "⭐️ Start dev server"
npm run dev
