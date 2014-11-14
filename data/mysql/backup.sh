#!/bin/sh
ADDRESS=/home/fish/Project/FishMoney/data/mysql/
DATABASE=FishMoney

#add data
DATE=`date "+%Y-%m-%d_%T"`
/usr/bin/mysqldump -uroot -p1 ${DATABASE} > ${ADDRESS}/${DATABASE}/$DATE

#del data
LASTSAVEDATE=`date -d last-month "+%Y-%m-%d_%T"`
for f in `ls ${ADDRESS}/${DATABASE} | xargs echo`
	do
	if [ "${f}" \< "$LASTSAVEDATE" ];then
		rm ${ADDRESS}/${DATABASE}/${f}
	fi
done
