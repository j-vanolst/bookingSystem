drop database bookingSystem;
create database if not exists bookingSystem;
use bookingSystem;

-- Table for account logins
create table if not exists User (
	userID int not null primary key auto_increment,
    email varchar(50) not null unique,
    password varchar(200) not null,
    account_created datetime default current_timestamp,
    isSetup bool default false
) engine = InnoDB;

create table if not exists Parent (
	parentID int primary key auto_increment,
    userID int,
    foreign key(userID) references User(userID),
    -- Form Section 1
    address varchar(50),
	homePhone varchar(10),
    school varchar(30),
    email varchar(30),
    doctorName varchar(30),
    doctorPhone varchar(10),
    medicalCenter varchar(30),
    
    -- Form Section 2
    motherName varchar(30),
    motherWorkplace varchar(30),
    motherWorkPhone varchar(10),
    motherMobile varchar(10),
    fatherName varchar(30),
    fatherWorkplace varchar(30),
    fatherWorkPhone varchar(10),
    fatherMobile varchar(10)
    
    -- Form Section 3
    
	) engine = InnoDB;
    
create table if not exists Child (
	childID int primary key auto_increment,
    userID int,
	firstName varchar(20),
    lastName varchar(20),
    birthdate date,
    gender char(1),
    allergies varchar(100),
    foreign key(userID) references User(userID)
	) engine = InnoDB;
    
create table if not exists Booking (
	bookingDate date,
    childID int,
    parentID int,
    foreign key(childID) references Child(childID),
    foreign key(parentID) references Parent(parentID)
	) engine = InnoDB;