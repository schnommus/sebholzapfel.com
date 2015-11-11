cd .
sudo rm -r -f www_bk
sudo rm -r -f current_nginx_config
cp /etc/nginx/sites-enabled/ghost current_nginx_config
cp /home/schnommus/www www_bk
sudo hg add .
sudo hg commit -u schnommus -m "Backing up website..."
sudo hg push https://schnommus@bitbucket.org/schnommus/sebholzapfel.com
