create database if not exists bookingSystem;
use bookingSystem;

create table if not exists Parent (
	parentID int primary key auto_increment,
    
    -- Form Section 1
    address varchar(50),
	homePhone varchar(10),
    school varchar(30),
    email varchar(30),
    doctor varchar(30),
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
    parentID int,
	firstName varchar(20),
    lastName varchar(20),
    birthday date,
    gender char(1),
    allergies varchar(100),
    foreign key(parentID) references Parent(parentID)
	) engine = InnoDB;
    
create table if not exists Booking (
	bookingDate date,
    childID int,
    parentID int,
    foreign key(childID) references Child(childID),
    foreign key(parentID) references Parent(parentID)
	) engine = InnoDB;