#!/bin/bash
ADMIN_OUT=../static/src/card/
for i in `ls ${ADMIN_OUT}`; do \
	for j in `ls ${ADMIN_OUT}/${i}`; do \
		#更改所有js的位置
		if [ "${j}" != "icon.jpg" -a "${j}" != "index.html" ];then \
			rm ${ADMIN_OUT}/${i}/${j}/new_wsmain.js;\
			ln -s ../../../js/new_wsmain.js ${ADMIN_OUT}/${i}/${j}/new_wsmain.js;\
			rm ${ADMIN_OUT}/${i}/${j}/kaniu.gif;\
			ln -s ../../../img/kaniu.gif ${ADMIN_OUT}/${i}/${j}/kaniu.gif;\
		fi \
	done \
done
