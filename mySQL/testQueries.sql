use bookingSystem;
select * from user;
select * from parent;
select address, homePhone, school, email, doctorName, doctorPhone, medicalCenter,
    motherName, motherWorkplace, motherWorkPhone, motherMobile, fatherName, fatherWorkplace, fatherWorkPhone, fatherMobile
    from Parent where userID = "1";
UPDATE Parent Set
    address = 2,
    homePhone = 2,
    school = 2,
    email = 2,
    doctorName = 2,
    doctorPhone = 2,
    medicalCenter = 2,
    motherName = 2,
    motherWorkplace = 2,
    motherWorkPhone = 2,
    motherMobile = 2,
    fatherName = 2,
    fatherWorkplace = 2,
    fatherWorkPhone = 2,
    fatherMobile = 2
    WHERE userID = 1;