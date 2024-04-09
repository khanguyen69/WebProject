create database Web_project 
 go

 use Web_project 
  go
create table account_admin (
 IDaccount char(10) PRIMARY KEY ,
 UserName nvarchar(100) ,
 [PassWord] nvarchar(100) ,
 
 )

create table customer (
 IDCustomer char(10) PRIMARY KEY ,
 Name nvarchar(100) ,
 DateOfBirth date ,
 Diachi nvarchar(200) ,
 PhoneNumber int ,
 email nvarchar(100) 
)

create table pet (
 IDpet char(10) PRIMARY KEY ,
 Pet_type nvarchar(100) ,
 pet_name nvarchar(100) ,
 pet_img VARBINARY(MAX) ,
  IDCustomer char(10) ,
  CONSTRAINT PK_IDCUS Foreign key (IDCustomer) references  customer(IDCustomer)
)
create table services (
  ID_service char(10) PRIMARY KEY ,
  name_service nvarchar(100) ,
  price_service INT ,
  minute_serving INT ,
  point_avg Float 
)
create table booking (
 IDboking char(10) PRIMARY KEY ,
 time_arrival smalldatetime ,
 phone_number int ,
 booking_status nvarchar(100) ,

)
create table history_transaction (
  IDtrans char(10) PRIMARY KEY ,
  IDCustomer char(10) ,
  ID_service char(10)  ,
  IDpet char(10) ,
  time_trans smalldatetime ,
  total_price int ,
  CONSTRAINT PK_idcusto Foreign key (IDCustomer) references  customer(IDCustomer),
  CONSTRAINT PK_idpet Foreign key (IDpet) references  pet(IDpet),
  CONSTRAINT PK_idser Foreign key (ID_service) references  services(ID_service),
)

create table history_feedback (
 IDtrans char(10) ,
  IDCustomer char(10) ,
  ID_service char(10)  ,
  point int ,
   CONSTRAINT PK_idcusto1 Foreign key (IDCustomer) references  customer(IDCustomer),
  CONSTRAINT PK_idtrans Foreign key (IDtrans) references  history_transaction(IDtrans),
  CONSTRAINT PK_idser1 Foreign key (ID_service) references  services(ID_service)
)

ALTER TABLE history_feedback ADD CONSTRAINT CHK_Point CHECK (point IN (1,2,3,4,5));

