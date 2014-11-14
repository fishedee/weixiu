#创建数据库
drop database weixiu;
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

#创建类目表
create table t_category(
	categoryId integer not null auto_increment,	
	userId integer not null,
	name char(32) not null,
	remark char(32) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( categoryId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建记账表
create table t_account(
	accountId integer not null auto_increment,
	userId integer not null,
	name char(32) not null,
	money integer not null,
	remark char(128) not null,
	categoryId integer not null,
	type integer not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( accountId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建人物表
create table t_people(
	peopleId integer not null auto_increment,
	userId integer not null,
	name char(32) not null,
	sex integer not null,
	birthday date not null,
	remark char(128) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( peopleId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建人物联系方式表
create table t_people_contact(
	peopleContactId integer not null auto_increment,
	peopleId integer not null,
	name char(32) not null,
	value char(128) not null,
	remark char(128) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( peopleContactId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建人物关系表
create table t_people_relation(
	peopleRelationId integer not null auto_increment,
	firstPeopleId integer not null,
	secondPeopleId integer not null,
	relation char(32) not null,
	remark char(128) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( peopleRelationId )
)engine=innodb default charset=utf8 auto_increment = 10001;

#创建人物事件表
create table t_people_event(
	peopleEventId integer not null auto_increment,
	peopleId integer not null,
	name char(32) not null,
	remark char(128) not null,
	state integer not null,
	createTime datetime not null,
	modifyTime datetime not null, 
	primary key( peopleEventId )
)engine=innodb default charset=utf8 auto_increment = 10001;

insert into t_user(name,password,type,state,createTime,modifyTime) values
("fish",SHA1("123"),0,0,now(),now());

insert into t_category(userId,name,state,createTime,modifyTime) values
(10001,"日常收支",0,now(),now()),
(10001,"衣着服装",0,now(),now()),
(10001,"理财投资",0,now(),now()),
(10001,"薪酬工资",0,now(),now());

insert into t_people(peopleId,userId,name,sex,birthday,remark,state,createTime,modifyTime) values
(10001,10001,"我",0,"19901101","",0,now(),now()),
(10002,10001,"黎健桓",0,"19651101","爸爸",0,now(),now()),
(10003,10001,"陈燕明",1,"19671102","妈妈",0,now(),now());

insert into t_people_contact(peopleContactId,peopleId,name,value,remark,state,createTime,modifyTime) values
(10001,10001,"QQ","306766045","",0,now(),now()),
(10002,10001,"email","306766045@qq.com","",0,now(),now());

insert into t_people_relation(peopleRelationId,firstPeopleId,secondPeopleId,relation,remark,state,createTime,modifyTime) values
(10001,10001,10002,"亲人","",0,now(),now()),
(10002,10001,10003,"亲人","",0,now(),now());

select * from t_user;
select * from t_category;
select * from t_account;
select * from t_people;
select * from t_people_contact;
select * from t_people_relation;
