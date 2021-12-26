INSERT INTO 
Doctors (DNo, DName, Dob, Age, Gender, Addrs, Zip, Phone, Mail, Password) 
VALUES 
(0, "JohnDoe", "01/01/01",23, "M", "122 Street St", "11111", "7777777777", "johndoe@email.com", "123password");


INSERT INTO 
OManagers (ONo, OName, Dob, Age, Gender, Addrs, Zip, Phone, Mail, Password) 
VALUES 
(0, "JackDoe", "01/01/01",23, "M", "123 Avenue Ave", "11111", "7777777777", "jackdoe@email.com", "123password");

INSERT INTO 
Patients (PNo, PName, Dob, Age, Gender, Addrs, Zip, Phone, Mail, DNo, Password) 
VALUES 
(-1, "JackDoe", "01/01/01",23, "M", "123 Avenue Ave", "11111", "7777777777", "jackdoe@email.com", 0, "123Pass");

INSERT INTO
Rooms (RNo, PNo)
VALUES (1,-1);

INSERT INTO
Rooms (RNo, PNo)
VALUES (2,-1);

INSERT INTO
Rooms (RNo, PNo)
VALUES (3,-1);

INSERT INTO
Rooms (RNo, PNo)
VALUES (4,-1);

INSERT INTO
Rooms (RNo, PNo)
VALUES (5,-1);

INSERT INTO
Rooms (RNo, PNo)
VALUES (6,-1);