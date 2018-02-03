#! /bin/bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH
#=================================================================#
#   System Required:  CentOS 6,7, Debian, Ubuntu                  #
#   Description: One click Install ShadowsocksR Server and BBR    #
#   Thanks: @breakwa11 <https://twitter.com/breakwa11>            #
#   Thanks: @Teddysun <i@teddysun.com>                            #
#   Thanks: @91yun  https://www.91yun.org/archives/2079           #
#   Improved by Suiyuanjian                                       #
#=================================================================#

red='\033[0;31m'
green='\033[0;32m'
yellow='\033[0;33m'
plain='\033[0m'


#Current folder
cur_dir=`pwd`
# Get public IP address
IP=$(ip addr | egrep -o '[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}' | egrep -v "^192\.168|^172\.1[6-9]\.|^172\.2[0-9]\.|^172\.3[0-2]\.|^10\.|^127\.|^255\.|^0\." | head -n 1)
if [[ "$IP" = "" ]]; then
    IP=$(wget -qO- -t1 -T2 ipv4.icanhazip.com)
fi


running_in_docker() {
    if [[ ! $(cat /proc/1/sched | head -n 1 | grep init) ]]; then {
        echo in docker
    } else {
        echo not in docker
    } 
    fi
}





get_char(){
        SAVEDSTTY=`stty -g`
        stty -echo
        stty cbreak
        dd if=/dev/tty bs=1 count=1 2> /dev/null
        stty -raw
        stty echo
        stty $SAVEDSTTY
}
    

get_server_ip(){
    ip route get 1 | awk '{print $NF;exit}'
}


# Pre-installation settings
function collect_arguments(){

	clear
    # appid
    echo "And now please input AppID  for NANX:"
    read -p "(Default AppID: nanx):" appid
    [ -z "$appid" ] && appid="nanx"
    echo
    echo "---------------------------"
    echo "AppID = $appid"
    echo "---------------------------"
    echo
    


    #Serverip
    echo "And now please input Serverip  for NANX:"
    read -p "(Default Serverip: `get_server_ip`):" Serverip
    [ -z "$Serverip" ] && Serverip=`get_server_ip`
    echo
    echo "---------------------------"
    echo "Serverip = $Serverip"
    echo "---------------------------"
    echo
    

    # Set port
   
    while true
    do
        echo -e "Please input port for NANX [1-65535]:"
        read -p "(Default port: 80):" dockerport
        [ -z "$dockerport" ] && dockerport="80"
        expr $dockerport + 0 &>/dev/null
        if [ $? -eq 0 ]; then
            if [ $dockerport -ge 1 ] && [ $dockerport -le 65535 ]; then
                echo
                echo "---------------------------"
                echo "port = $dockerport"
                echo "---------------------------"
                echo
                break
            else
                echo "Input error! Please input correct number."
            fi
        else
            echo "Input error! Please input correct number."
        fi
    done
   

#   mysql host172.18.0.3
    echo "And now please input mysql host address(in container view):"
    read -p "(Default mysqlhost: 172.18.0.3):" mysqlhost
    [ -z "$mysqlhost" ] && mysqlhost="172.18.0.3"
    echo
    echo "---------------------------"
    echo "mysqlhost = $mysqlhost"
    echo "---------------------------"
    echo
    


#   mysql user
    echo "And now please input mysql user :"
    read -p "(Default mysqluser: root):" mysqluser
    [ -z "$mysqluser" ] && mysqluser="root"
    echo
    echo "---------------------------"
    echo "mysqluser = $mysqluser"
    echo "---------------------------"
    echo
#   mysql dbpassword
    echo "And now please input password for user $mysqluser:"
    read -p "(Default dbpassword: root):" dbpassword
    [ -z "$dbpassword" ] && dbpassword="root"
    echo
    echo "---------------------------"
    echo "dbpassword = $dbpassword"
    echo "---------------------------"
    echo
    
    

#   database
    echo "And now please input mysql database :"
    read -p "( Default database: test:):" database
    [ -z "$database" ] && database="db_test"
    echo
    echo "---------------------------"
    echo "database = $database"
    echo "---------------------------"
    echo

    echo
    echo "Press any key to start...or Press Ctrl+C to cancel"
    char=`get_char`

    cd $cur_dir
}





function modify_global_js()
{
    echo $appid
    echo $dockerport
    echo $Serverip:$dockerport
    
    sed -ie s/^APP_PREFIX=.*/APP_PREFIX=\'$appid\'/  js/globalvars.js
    sed -ie s/^BASE_URL=.*/BASE_URL=\'http:\\/\\/$Serverip:$dockerport\\/\'/  js/globalvars.js && more js/globalvars.js

    cp application/config/database.php.bak application/config/database.php

    sed -i "s/hostname_to_change/${mysqlhost}/g"   application/config/database.php
    sed -i "s/username_to_change/${mysqluser}/g"   application/config/database.php
    sed -i "s/password_to_change/${dbpassword}/g"   application/config/database.php
    sed -i "s/database_to_change/${database}/g"   application/config/database.php

    cp application/config/config.php.bak application/config/config.php
    sed -i "s/eidfolder_to_change/${appid}/g"   application/config/config.php
     

    
     

       
}

# Install ShadowsocksR
function install_shadowsocks(){
    collect_arguments
    modify_global_js
}


install_shadowsocks



