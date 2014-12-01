#!/bin/sh
sudo apt-get install imagemagick -y
sudo crontab -l > /tmp/crontab.bak
sudo echo "50 * * * * /home/fish/Project/weixiu/data/mysql/backup.sh > /dev/null 2>&1" >> /tmp/crontab.bak
sudo crontab /tmp/crontab.bak
sudo crontab -l
