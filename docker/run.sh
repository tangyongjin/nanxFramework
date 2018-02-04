#docker run -t -d --rm  --name test1 -v /ixpdata/webapp/opt/nanx/standx:/var/www/html   -p  8964:80   test1  
docker kill cass.web
docker rm cass.web
docker run -t -d    --name cass.web -v /tang/standx/:/var/www/html  -p  7000:80   cass.web
