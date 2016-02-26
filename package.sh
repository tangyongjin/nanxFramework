echo "Zip source..."
zip -rq standx.zip .   -x \*.git\*

echo "copy standx.zip to  /var/www/html/nanx_web/src_package/standx.zip.."
sudo cp standx.zip  /var/www/html/nanx_web/src_package/standx.zip
echo "rm standx.zip from this dir"
sudo rm standx.zip
