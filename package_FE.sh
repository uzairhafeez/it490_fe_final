echo "FE Bundle"
	DIR=/home/uzair/FE
        cp -a $DIR* /home/uzair/frontEnd/tmp/
        tar -czvf frontendPackage.tgz -C /home/uzair/frontEnd/tmp/FE .
        echo "New Package: `ls | grep frontendPackage`"

	echo "tar -xf $HOME/Desktop/frontendPackage.tgz -C /home/uzair/Desktop/Unzip/" >> deploy.sh
	# cd /home/uzair/Desktop/Unzip/
	
	# echo "mv 000-default.conf.back /etc/apache2/sites-available/" >> deploy.sh
	# echo "mv default-ssl.conf /etc/apache2/sites-available/" >> deploy.sh
	# echo "mv default.conf /etc/apache2/sites-enabled/" >> deploy.sh
	# echo "mv /home/uzair/Desktop/Unzip/. /var/www/html/" >> deploy.sh                                         
	
        rm -r /home/uzair/frontEnd/tmp/FE
        echo Success

	echo "Bundle is ready to deploy"
