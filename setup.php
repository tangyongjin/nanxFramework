deploy()
{


echo "modify global.js"



sed -ie s/^APP_PREFIX=.*/APP_PREFIX=\'$1\'/  js/globalvars.js
sed -ie s/^BASE_URL=.*/BASE_URL=\'http:\\/\\/$2:$3\'/  js/globalvars.js 
more js/globalvars.js




echo "deply to:/var/www/html/nanx_cloud/"$1 $2


}



if [ ! -n "$1" ] ;then
    echo "specify appprefix  host and  port"
else
  var1="$1"
  var2="$2"
  var3="$3"
  deploy  "$var1"  "$var2" "$var3"
fi




