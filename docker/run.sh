#docker run -t -d --rm  --name test1 -v /ixpdata/webapp/opt/nanx/standx:/var/www/html   -p  8964:80   test1  
docker kill test1
docker rm test1
docker run -t -d --rm  --name test1 -v /ixpdata/webapp/opt/nanx/standx:/var/www/html  -p  8964:80   test1  
