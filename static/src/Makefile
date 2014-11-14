OUT = ../public
COPY_FILE = view css js font img
GENERATE_FILE = $(OUT)/view
.PHONY:all copyfile generatefile $(COPY_FILE)
all:
	-rm $(OUT) -rf
	mkdir $(OUT)
	cp /home/fish/Project/FishStrap/css/* css/ -r
	cp /home/fish/Project/FishStrap/js/* js/ -r
	cp /home/fish/Project/FishStrap/font/* font/ -r
	cp /home/fish/Project/FishStrap/img/* img/ -r
	$(MAKE) copyfile
	$(MAKE) generatefile
generatefile:
	php index.php > $(OUT)/index.html
	php login.php > $(OUT)/login.html
	for i in `ls $(GENERATE_FILE)`; do \
		for j in `ls $(GENERATE_FILE)/$$i`; do \
			if [ "$$i" != "common" -a "$$i" != "Makefile" ];then \
			php $(GENERATE_FILE)/$$i/$$j > $(GENERATE_FILE)/$$i/$${j%.php}.html; \
			rm $(GENERATE_FILE)/$$i/$$j; \
			fi \
		done \
	done
	echo generatefile success!
copyfile:$(COPY_FILE)
	echo copyfile success!
$(COPY_FILE):
	cp $@  $(patsubst %,$(OUT)/%,$@) -r

