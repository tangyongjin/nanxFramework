echo "Zip source..."
zip -rq standx.zip .   -x \*.git\*
sudo cp standx.zip  /www3/src_package/standx.zip
sudo rm standx.zip
echo "Create nanx_template from standx..."
mysqldump  --login-path=nanx   standx >standx.sql
sed -i '1i DROP DATABASE IF EXISTS nanx_template;CREATE database `nanx_template` CHARACTER SET utf8 COLLATE utf8_general_ci;use nanx_template;' standx.sql
mysql --login-path=nanx  <standx.sql
sudo rm standx.sql
echo "Done."
