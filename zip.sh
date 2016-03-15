echo "Zip source..."
zip -rq standx.zip .   -x \*.git\*
sudo cp standx.zip  /var/www/html/nanx_web/src_package/standx.zip
sudo rm standx.zip
echo "Create nanx_template from standx..."
mysqldump  -uroot -pdongman    cloud_standx >standx.sql
sed -i '1i DROP DATABASE IF EXISTS nanx_template;CREATE database `nanx_template` CHARACTER SET utf8 COLLATE utf8_general_ci;use nanx_template;' standx.sql
mysql  -uroot   -pdongman  <standx.sql
sudo rm standx.sql
echo "Done."
