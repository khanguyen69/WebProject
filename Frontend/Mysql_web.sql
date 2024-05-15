create database pettopia ;
use pettopia ;
CREATE TABLE account_admin (
    IDaccount INT AUTO_INCREMENT PRIMARY KEY,
    UserName NVARCHAR(100) NOT NULL,
    Pass_Word NVARCHAR(100) NOT NULL,
    UNIQUE (IDaccount)
) CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
INSERT INTO account_admin (UserName, Pass_Word) VALUES
('admin1', 'password1'),
('admin2', 'password2'),
('admin3', 'password3');

create table customer (
 IDCustomer int AUTO_INCREMENT  PRIMARY KEY ,
 Name_customer nvarchar(100) not null ,
 DateOfBirth date not null,
 Diachi nvarchar(200) not null ,
 PhoneNumber int not null ,
 email nvarchar(100) not null ,
 UNIQUE (PhoneNumber,email,IDCustomer) 
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO customer (Name_customer, DateOfBirth, Diachi, PhoneNumber, email) VALUES
('John Doe', '1990-05-15', '123 Main Street, City, Country', 123456789, 'john@example.com'),
('Jane Smith', '1985-10-20', '456 Elm Street, City, Country', 987654321, 'jane@example.com'),
('Alice Johnson', '1995-03-25', '789 Oak Street, City, Country', 987123456, 'alice@example.com');



create table pet (
 IDpet int AUTO_INCREMENT PRIMARY KEY ,
 Pet_type nvarchar(100) ,
 pet_name nvarchar(100) ,
 pet_img nvarchar(100) ,
 PhoneNumber_owner int ,
 IDCustomer int ,
 CONSTRAINT PK_IDCUS Foreign key (IDCustomer) references  customer(IDCustomer)
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO pet (Pet_type, pet_name, pet_img, PhoneNumber_owner, IDCustomer) VALUES
('Dog', 'Buddy', 'dog.jpg', 123456789, (SELECT IDCustomer FROM customer WHERE PhoneNumber = 123456789)),
('Cat', 'Whiskers', 'cat.jpg', 987654321, (SELECT IDCustomer FROM customer WHERE PhoneNumber = 987654321)),
('Bird', 'Polly', 'bird.jpg', 987123456, (SELECT IDCustomer FROM customer WHERE PhoneNumber = 987123456));


create table services (
  ID_service int AUTO_INCREMENT  PRIMARY KEY ,
  name_service nvarchar(100) not null,
  price_service INT not null ,
  minute_serving INT not null,
  point_avg Float 
) CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO services (name_service, price_service, minute_serving, point_avg) VALUES
('Thường', 200000, 30, 4.5),
('Cao cấp', 800000, 45, 4.2),
('Chuyên Nghiệp', 1000000, 60, 4.8);

create table booking (
 IDboking int AUTO_INCREMENT   PRIMARY KEY ,
 time_arrival datetime ,
 phone_number int ,
 booking_status nvarchar(100) ,
 check(booking_status in ('Đã đến', 'Đợi' , 'Hủy'))
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci; 

INSERT INTO booking (time_arrival, phone_number, booking_status) VALUES
('2024-04-01 09:00:00', 123456789, 'Đã đến'),
('2024-04-01 10:30:00', 987654321, 'Đợi'),
('2024-04-02 11:00:00', 987123456, 'Hủy');

create table history_transaction (
  IDtrans int AUTO_INCREMENT PRIMARY KEY ,
  IDCustomer INT ,
  ID_service INT  ,
  IDpet INT ,
  time_trans DATETIME ,
  total_price int ,
  CONSTRAINT PK_idcusto Foreign key (IDCustomer) references  customer(IDCustomer),
  CONSTRAINT PK_idpet Foreign key (IDpet) references  pet(IDpet),
  CONSTRAINT PK_idser Foreign key (ID_service) references  services(ID_service)
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci; 

INSERT INTO history_transaction (IDCustomer, ID_service, IDpet, time_trans, total_price)
VALUES
    (1, 1, 1, '2024-04-01 09:00:00', 200000),
    (2, 2, 2, '2024-04-02 10:30:00', 800000),
    (3, 3, 3, '2024-04-03 11:00:00', 1000000);
    
create table history_feedback (
  IDtrans int ,
  IDCustomer int ,
  ID_service int ,
  point_feedback int ,
  comment_feedback nvarchar(1000) ,
  Primary key(IDtrans,IDCustomer,ID_service),
  CONSTRAINT PK_idcusto1 Foreign key (IDCustomer) references  customer(IDCustomer),
  CONSTRAINT PK_idtrans Foreign key (IDtrans) references  history_transaction(IDtrans),
  CONSTRAINT PK_idser1 Foreign key (ID_service) references  services(ID_service)
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
ALTER TABLE history_feedback ADD CONSTRAINT CHK_Point CHECK (point_feedback IN (1,2,3,4,5)); 

INSERT INTO history_feedback (IDtrans, IDCustomer, ID_service, point_feedback, comment_feedback)
SELECT ht.IDtrans, ht.IDCustomer, ht.ID_service, 5, 'Excellent experience!'
FROM history_transaction ht
JOIN customer c ON ht.IDCustomer = c.IDCustomer
JOIN services s ON ht.ID_service = s.ID_service
WHERE c.Name_customer = 'John Doe';

INSERT INTO history_feedback (IDtrans, IDCustomer, ID_service, point_feedback, comment_feedback)
SELECT ht.IDtrans, ht.IDCustomer, ht.ID_service, 4, 'Good service overall.'
FROM history_transaction ht
JOIN customer c ON ht.IDCustomer = c.IDCustomer
JOIN services s ON ht.ID_service = s.ID_service
WHERE c.Name_customer = 'Jane Smith';

INSERT INTO history_feedback (IDtrans, IDCustomer, ID_service, point_feedback, comment_feedback)
SELECT ht.IDtrans, ht.IDCustomer, ht.ID_service, 3, 'Average experience.'
FROM history_transaction ht
JOIN customer c ON ht.IDCustomer = c.IDCustomer
JOIN services s ON ht.ID_service = s.ID_service
WHERE c.Name_customer = 'Alice Johnson';

select c.name_customer,s.name_service, ht.point_feedback , ht.comment_feedback 
from history_feedback ht 
JOIN customer c ON ht.IDCustomer = c.IDCustomer
JOIN services s ON ht.ID_service = s.ID_service ; 
/* 
câu truy vấn tên khách hàng và tên dịch vụ đánh giá 
g) table Thú cưng đang sử dụng dịch vụ tại shop
mã lịch sử ( khóa chính )
thời gian đến
mã thú cưng
tên thú cưng
tình trạng sức khỏe( tốt, khá, ổn, không tốt ) ( cho phép nhân viên thay đổi )
mã dịch vụ ( cần hiển thị ra tên dịch vụ trên giao diện)
ghi chú ( nếu có cho phép nhân viên ghi chú thêm các trường hợp đặc biệt)
mã khách hàng
tình trạng: đã xong hoặc đang tại shop ( khi nhân viên tra các thú cưng đang tại shop chỉ hiển thị các thú cưng đang tại shop, với tính năng này nhân viên sẽ có quyền cập nhật trạng thái của thú cưng là xong hay đang tại shop

*/ 
create table pet_pending (
 IDcome int auto_increment Primary key ,
 time_coming datetime ,
 IDpet int ,
 healt_status char(10) ,
 ID_service int ,
 note nvarchar(100) ,
 IDCustomer int ,
 work_status char(20) ,
 CONSTRAINT PK_idcusto2 Foreign key (IDCustomer) references  customer(IDCustomer),
 CONSTRAINT PK_idser2 Foreign key (ID_service) references  services(ID_service),
 CONSTRAINT PK_pet Foreign key (IDpet) references  pet(IDpet),
 check ( healt_status in ('Tốt', 'Ổn' ,'Không tốt')),
 check ( work_status in ('Đã xong', 'Đang tại shop' ))
)CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci; 

INSERT INTO pet_pending (time_coming, IDpet, healt_status, ID_service, note, IDCustomer, work_status)
VALUES
    ('2024-04-01 09:00:00', 1, 'Tốt', 1, 'Need grooming', 1, 'Đang tại shop'),
    ('2024-04-02 10:30:00', 2, 'Ổn', 2, 'Routine checkup', 2, 'Đã xong'),
    ('2024-04-03 11:00:00', 3, 'Không tốt', 3, 'Emergency treatment', 3, 'Đang tại shop');
 
 select*from pet_pending ;
























