# WebProject
Petopia - Thiên đường cho thú cưng - Trang web quản lý thú cưng

Trang web Petopia bao gồm các giao diện sau: Trang chủ, Đăng nhập, Liên hệ, Đăng ký thông tin, Đặt lịch, Đăng ký hồ sơ thú cưng, Quản lý khách hàng, Đánh giá... Mỗi giao diện đều được thiết kế trực quan và dễ sử dụng, nhằm mang lại trải nghiệm tốt nhất cho người dùng.

Petopia cung cấp một giao diện thân thiện và dễ nhìn, giúp bạn dễ dàng tìm kiếm và chọn lựa dịch vụ phù hợp cho thú cưng của mình. Cho dù bạn cần đặt lịch hẹn với bác sĩ thú y, quản lý thông tin sức khỏe của thú cưng hay đơn giản là tìm kiếm các dịch vụ chăm sóc thú cưng, Petopia đều đáp ứng mọi nhu cầu của bạn.

Với Petopia, việc chăm sóc thú cưng chưa bao giờ dễ dàng hơn thế. Hãy để chúng tôi giúp bạn mang lại cuộc sống tốt đẹp nhất cho những người bạn bốn chân thân yêu của mình.

Chức năng trang web:
- Khách hàng (Client web):
  + Đặt lịch hẹn
  + Tìm kiếm thú cưng trên danh sách
  + Đăng kí thông tin khách hàng
  + Đăng kí thông tin thú cưng
  + Đánh giá dịch vụ tại shop
  + Theo dõi tình hình sức khỏe thú cưng
- Nhân viên (Admin web):
  + Quản lí tra cứu thông tin lịch hẹn
  + Tra cứu thông tin khách hàng
  + Tra cứu thông tin thú cưng
  + Có chức năng giúp quản lí thú cưng tại shop
  + Quản lý lịch sử khách hàng
  + Quản lý dịch vụ, phản hồi
  + Có quyền chỉnh sửa thông tin
![image](https://github.com/khanguyen69/WebProject/assets/145459744/1720fbc0-7dc7-4a80-b029-230c555f54f7)

Sơ lược về cách cài đặt và sử dụng:

- Tải xuống và cài đặt:
  
Ta có thể tải xampp ở link sau: https://taimienphi.vn/download-xampp-17727#showlink .
Quá trình cài đặt rất đơn giản và tương tự như cài đặt bất kỳ phần mềm nào khác trên máy tính.

- Chạy XAMPP:
  
Sau khi cài đặt, ta mở bảng điều khiển XAMPP (XAMPP Control Panel) để khởi động hoặc dừng các thành phần như Apache, MySQL, FileZilla, và các dịch vụ khác.
Truy cập localhost:

- Khi Apache đã được khởi động, ta có thể truy cập vào trình duyệt web và nhập "localhost" để xem trang chính của XAMPP. Ta cũng có thể truy cập phpMyAdmin tại "localhost/phpmyadmin" để quản lý cơ sở dữ liệu.
  
Chi tiết về cách sử dụng xampp sau khi cài đặt xong:

Bước 1: Mở phần mềm xampp đã tải về máy tính.

Bước 2: Chọn “Start” ở Apache và MySQL
Sau đó, chờ đến khi hai ứng dụng Apache và MySQL chuyển xanh.

Bước 3: Mở trình duyệt web sau đó nhập địa chỉ https://localhost .
Lúc này, ta sẽ thấy màn hình hiện lên giao diện của Xampp. Điều này chứng tỏ ta đã tạo thành công localhost trên máy tính có địa chỉ là https://localhost. Localhost này được điều hành bởi phần mềm Xampp.
Sau đó, ta có thể sử dụng Localhost như bình thường. Ứng dụng nó trong việc lưu trữ thông tin website.

Bước 4: Trên máy tính, mở ổ C > thư mục xampp> htdocs.

Bước 5: Tạo một thư mục mới. Thư mục này chính là nơi lưu trữ website.

Bước 6: Thêm các file nội dung vào thư mục vừa tạo:

Bước 7: Mở trình duyệt web, truy cập đường dẫn https://localhost/[ten-thu-muc-vua-tao]. Ta sẽ thấy được thư mục đó và các file dữ liệu vừa thêm. Đây chính là cách tải dữ liệu lên trên website. 

Bước 8: Truy cập đường dẫn https://localhost/phpmyadmin/ . Lúc này ta sẽ mở được giao diện quản lý localhost đã tạo bởi Xampp.

Bước 9: Chọn “Database”

Bước 10: Điền thông tin database muốn tạo > Nhấn “Create”. Như vậy, ta đã tạo ra một cơ sở dữ liệu đơn giản trên localhost. Từ đó, có thể điều hành localhost và phát triển website tùy ý.


Câu 1: Có những cách nào để tạo component trong ReactJS

Có 2 cách tạo component trong ReactJS

- Class component: kế thừa React.Component và phải có phương thức render()
  
- Function component.

Chi tiết hơn :

Class Components sử dụng cú pháp lớp của ES6 để tạo các component trong React. Những đặc điểm chính bao gồm:

Kế thừa từ React.Component: Class component phải kế thừa từ React.Component.

Phương thức render(): Mọi class component đều phải có một phương thức render() để trả về các React elements.

State: Class components có thể có state nội bộ, thường được khởi tạo trong constructor.

Lifecycle Methods: Class components có thể sử dụng các phương thức vòng đời của React như:
componentDidMount(): Được gọi sau khi component được render lần đầu.
componentDidUpdate(): Được gọi sau khi component được cập nhật.
componentWillUnmount(): Được gọi ngay trước khi component bị gỡ bỏ khỏi DOM.

Bindings: Thường cần sử dụng .bind(this) hoặc các arrow functions để đảm bảo this trong các phương thức là chính xác.

Class components thường được sử dụng trong các phiên bản cũ của React hoặc khi ta cần các tính năng lifecycle mà functional components không thể cung cấp trước khi hooks được giới thiệu.

Function Components là một cách đơn giản hơn để tạo components. Những đặc điểm chính bao gồm:

Là các hàm JavaScript: Function components chỉ đơn giản là các hàm JavaScript nhận vào props và trả về React elements.

Không có state hay lifecycle methods: Trước khi hooks xuất hiện, function components không có state hoặc các phương thức vòng đời.

Sử dụng hooks để quản lý state và side effects: Với sự xuất hiện của hooks (từ React 16.8), function components có thể quản lý state (useState) và các side effects (useEffect), làm cho chúng mạnh mẽ như class components.

Function components trở nên phổ biến và được khuyến khích sử dụng nhờ vào hooks, vì chúng đơn giản hơn và dễ đọc hơn.

Sự khác biệt chính:

Cú pháp và Độ phức tạp: Class components phức tạp hơn do phải quản lý this và có nhiều cú pháp đặc biệt. Function components đơn giản hơn, chỉ cần một hàm trả về JSX.

State và Lifecycle: Trước hooks, chỉ có class components mới có state và lifecycle methods. Với hooks, function components có thể làm mọi thứ mà class components có thể.

Hiệu suất và Tối ưu hóa: Function components có thể dễ dàng tối ưu hóa hơn với hooks như useMemo và useCallback.

Câu 2: So sánh SSR và CSR trong React, ưu điểm và nhược điểm của mỗi loại

Client-Side Rendering (CSR)

Client-Side Rendering (CSR) là quá trình mà trang web được render hoàn toàn trên trình duyệt của người dùng bằng JavaScript. Trong React, CSR được thực hiện bằng cách sử dụng ReactDOM để render component vào DOM khi trang tải.

Ưu điểm:

Trải nghiệm người dùng tương tác: Sau khi trang được tải, việc chuyển đổi giữa các trang sẽ nhanh chóng và mượt mà do ứng dụng chỉ cần cập nhật DOM thay vì tải lại toàn bộ trang.

Giảm tải cho server: Server chỉ cần gửi một trang HTML ban đầu và tải các tập lệnh JavaScript. Sau đó, mọi xử lý sẽ được thực hiện trên client.

Dễ dàng phát triển và bảo trì: Việc phát triển và gỡ lỗi ứng dụng trở nên đơn giản hơn vì toàn bộ logic đều nằm trên client.

Nhược điểm:

Thời gian tải ban đầu chậm: Ứng dụng cần tải toàn bộ tập lệnh JavaScript trước khi có thể render bất kỳ nội dung nào, dẫn đến thời gian tải ban đầu chậm hơn.

SEO kém: Các công cụ tìm kiếm gặp khó khăn trong việc lập chỉ mục các trang web render bằng JavaScript, dẫn đến SEO không hiệu quả.

Phụ thuộc vào JavaScript: Nếu người dùng tắt JavaScript, trang web sẽ không hoạt động đúng cách.

Server-Side Rendering (SSR)

Server-Side Rendering (SSR) là quá trình mà trang web được render trên server và gửi HTML đã được render sẵn về client. Sau đó, React sẽ "hydrate" nội dung này, thêm các sự kiện và làm cho trang tương tác được.

Ưu điểm:

SEO tốt hơn: SSR cho phép các công cụ tìm kiếm lập chỉ mục nội dung dễ dàng hơn vì HTML đã được render sẵn trước khi gửi về client.

Thời gian tải ban đầu nhanh hơn: Người dùng sẽ thấy nội dung nhanh hơn vì HTML đã được render sẵn, giảm thời gian chờ đợi.

Tương thích tốt hơn: Trang web sẽ hiển thị nội dung cơ bản ngay cả khi người dùng tắt JavaScript.

Nhược điểm:

Tăng tải cho server: Mỗi yêu cầu từ người dùng đòi hỏi server phải render lại trang, dẫn đến tăng tải cho server.

Phức tạp hơn trong việc phát triển: SSR đòi hỏi cấu hình phức tạp hơn và có thể gây khó khăn trong việc quản lý state giữa server và client.

Tương tác ban đầu chậm: Mặc dù nội dung hiển thị nhanh hơn, nhưng sự tương tác có thể chậm hơn do cần thời gian để "hydrate" nội dung.

So sánh tổng quát:

SEO: SSR tốt hơn cho SEO vì nội dung đã được render sẵn.

Thời gian tải ban đầu: SSR thường có thời gian tải ban đầu nhanh hơn so với CSR.

Tương tác sau khi tải: CSR có thể mượt mà hơn sau khi tải xong tập lệnh JavaScript.

Tải cho server: CSR giảm tải cho server hơn so với SSR.

Phát triển và bảo trì: CSR đơn giản hơn cho việc phát triển và bảo trì ứng dụng.

Kết luận:

Lựa chọn giữa SSR và CSR phụ thuộc vào yêu cầu cụ thể của dự án. Nếu cần SEO tốt và thời gian tải ban đầu nhanh, SSR là lựa chọn phù hợp. Ngược lại, nếu ưu tiên trải nghiệm người dùng mượt mà và giảm tải cho server, CSR có thể là lựa chọn tốt hơn. Ngoài ra, ta có thể sử dụng kết hợp cả hai phương pháp (hybrid rendering) để tận dụng ưu điểm của mỗi phương pháp.

Câu 3: ReactJS và React Native có gì khác nhau

React Native là một framework phát triển ứng dụng di động, được xây dựng dựa trên cùng nguyên lý và cú pháp của ReactJS. Tuy nhiên, có một số điểm khác biệt chính giữa React Native và ReactJS: 

1.	Nền tảng đích: ReactJS được sử dụng để phát triển ứng dụng web, trong khi React Native được sử dụng để phát triển ứng dụng di động cho iOS và Android.
   
2.	Rendering Engine: ReactJS sử dụng HTML DOM để render giao diện người dùng, trong khi React Native sử dụng các thành phần native để render giao diện trên thiết bị di động. Điều này có nghĩa là React Native sẽ tạo ra các thành phần UI native thực sự, không phải là HTML, CSS và JavaScript được render trong một WebView như ReactJS.
   
3.	Cách xử lý CSS: Trong ReactJS, bạn sử dụng CSS thông thường để thiết kế giao diện người dùng. Trong React Native, bạn sử dụng một ngôn ngữ gọi là StyleSheet để định dạng giao diện, và nó cung cấp một tập hợp các thành phần UI native mà bạn có thể sử dụng.
   
4.	APIs và tích hợp: React Native cung cấp các API và tích hợp cho phép truy cập các chức năng của thiết bị di động như camera, cảm biến, v.v., trong khi ReactJS thường được sử dụng cho việc xây dựng giao diện trên trình duyệt web.
   
5.	Thư viện và cộng đồng: Mặc dù React Native chia sẻ một số thư viện và cộng đồng với ReactJS, nhưng cũng có những thư viện và tài nguyên cụ thể cho việc phát triển ứng dụng di động.
