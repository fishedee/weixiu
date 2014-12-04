#创建数据库
drop database if exists weixiu;
create database weixiu;
use weixiu;

#创建用户表
create table t_user(
	userId integer not null auto_increment,
	name char(32) not null,
	password char(48) not null,
	type integer not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( userId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建模板表
create table t_template(
	templateId integer not null auto_increment,
	name char(32) not null,
	url char(127) not null,
	remark char(127) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( templateId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建文章表
create table t_article(
	articleId integer not null auto_increment,
	title char(32) not null,
	sound varchar(1024) not null,
	templateId integer not null,
	remark char(127) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( articleId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建文章内容表
create table t_article_content(
	articleContentId integer not null auto_increment,
	articleId integer not null,
	type integer not null,
	data text not null,
	weight integer not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( articleContentId )
)engine=innodb default charset=utf8 auto_increment = 10001;

insert into t_user(userId,name,password,type,state,createTime,modifyTime) values
(10001,"fish",SHA1("123"),0,0,now(),now());

insert into t_template(templateId,name,url,remark,state,createTime,modifyTime) values
(10001,"记录与青春有关的日子","/card/1001/index.html","",0,now(),now()),
(10002,"男与女","/card/1064/index.html","",0,now(),now()),
(10003,"夜幕降临","/card/1089/index.html","",0,now(),now()),
(10004,"秋天铁轨","/card/1090/index.html","",0,now(),now()),
(10005,"秋天朦脓","/card/1411/index.html","",0,now(),now());

insert into t_article(articleId,templateId,title,remark,state,createTime,modifyTime) values
(10001,10001,"文章1","",0,now(),now()),
(10002,10002,"文章2","",0,now(),now()),
(10003,10003,"文章3","",0,now(),now()),
(10004,10004,"文章4","",0,now(),now()),
(10005,10005,"文章5","",0,now(),now());

insert into t_article_content(articleContentId,articleId,data,type,weight,state,createTime,modifyTime) values
(10001,10001,"文章1",0,1,0,now(),now()),
(10002,10001,"文章2",0,2,0,now(),now()),
(10003,10002,"文章3",0,2,0,now(),now()),
(10004,10002,"文章4",0,1,0,now(),now());

select * from t_user;
select * from t_template;
select * from t_article;
select * from t_article_content;
