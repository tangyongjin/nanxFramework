
#######
clone from gitserver, and deploy local
#######
deploy()
{
echo "clean tmp dirs"

rm -fr /tmp/app_and_js.tgz
rm -fr /tmp/standxgit
mkdir /tmp/standxgit
echo "Clone from git server,only application and js folder"

git archive --format tar --remote git@bitbucket.org:tangyongjin/standx.git HEAD  js application  > /tmp/app_and_js.tgz

echo "unzip to /tmp/standxgit"


tar xvf  /tmp/app_and_js.tgz -C /tmp/standxgit/

echo "Clean  globalvar.js and config.php, database.ph"

rm -fr /tmp/standxgit/js/globalvars.js
rm -fr /tmp/standxgit/application/config/config.php
rm -fr /tmp/standxgit/application/config/database.php

echo "deply to:/var/www/html/nanx_cloud/"$1

cp -rp /tmp/standxgit/application  /var/www/html/nanx_cloud/$1/
cp -rp /tmp/standxgit/js           /var/www/html/nanx_cloud/$1/





}
var="$1"
deply "$var"
