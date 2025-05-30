    drop database if exists hrm;

    create database hrm;

    use hrm;

-- Tạo bảng clients
CREATE TABLE IF NOT EXISTS clients (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    bio TEXT(255),
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    isMute INT DEFAULT 5,
    avatarUrl TEXT default 'https://placehold.co/96x96/CCCCCC/333333?text=U',
    isActive BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO clients (fullName, password, email, isActive) VALUES ('Nguyen Van A', '$2b$12$6xmtzoaFRg8vbTxMEpZnVOfgiLyEDUSswuehPZxO0mH3nwFriVHRm', 'a.nguyen@example.com', TRUE);
INSERT INTO clients (fullName, password, email, isActive) VALUES ('Tran Thi B', '$2b$12$.KPeHWFLAEdJdFBZBVP4pexgluTP9VcvW2CkjtiMC3eEQ1wui77hS', 'b.tran@example.com', TRUE);
INSERT INTO clients (fullName, password, email, isActive) VALUES ('Le Minh C', '$2b$12$RAN630EQ48vJeh.jfBSPfecgApI8Dot8ck/b6apNICCdywaS0GYpy', 'c.le@example.com', FALSE);
INSERT INTO clients (fullName, password, email, isActive) VALUES ('Pham Hoang D', '$2b$12$MAkBcLQSpQEX1rAVwchIaeNpzejUbdl6AZvAIOSbWF8bqoEcAhok6', 'd.pham@example.com', TRUE);
INSERT INTO clients (fullName, password, email, isActive) VALUES ('Trang Xuan', '123456', 'trangxuan@gmail.com', TRUE);

    -- Tạo bảng managers
    CREATE TABLE IF NOT EXISTS managers (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        fullName VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    );

    INSERT INTO managers (fullName, password, email) VALUES ('Trang Xuân', '$2b$12$4.FthDpDH0mmetIANiges.7vk59.gW2DNMzjJmrEkToPMQNI7c8Tq', 'trang@gmail.com');
    INSERT INTO managers (fullName, password, email) VALUES ('Phạm Vân Anh', '$2b$12$k2qIfnDDFEunC6kWQOmq1OYsKQbF6cIrCmsy/NspM3rWHLpneOt1G', 'vananh@gmail.com');
    INSERT INTO managers (fullName, password, email) VALUES ('Thảo Nhi', '$2b$12$70fqwwm6c.2i2qDeLI.XZO6CiKRyKZ5yZb9rEurGbf3jI3qWpQG5q', 'thaonhi@gmail.com');
    INSERT INTO managers (fullName, password,email) VALUES ('Chau', '$2y$10$9qIC/5I3PnlaCq9EkRdOIeCjiFV37owCPUisIT7VLLdkIdRCexR0u', 'chau@gmail.com');
    -- Tạo bảng label
    CREATE TABLE IF NOT EXISTS labels (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        type VARCHAR(255) NOT NULL
    );
    INSERT INTO labels (type) VALUES ('Tin nóng');
    INSERT INTO labels (type) VALUES ('Đời sống');
    INSERT INTO labels (type) VALUES ('Thể thao');
    INSERT INTO labels (type) VALUES ('Khoa học - Công nghệ');
    INSERT INTO labels (type) VALUES ('Sức khoẻ');
    INSERT INTO labels (type) VALUES ('Giải trí');
    INSERT INTO labels (type) VALUES ('Kinh doanh');


    -- Tạo bảng News
    CREATE TABLE IF NOT EXISTS news (
                                        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                        title VARCHAR(255) NOT NULL,
                                        managerId BIGINT NOT NULL,
                                        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                                        views BIGINT default 0,
                                        content TEXT,
                                        status VARCHAR(255) NOT NULL CHECK( status IN('draft','publish')),
                                        thumbNailUrl VARCHAR(255),
                                        isHot BOOLEAN DEFAULT FALSE,
                                        labelId INT NOT NULL,
                                        FOREIGN KEY (managerId) REFERENCES managers(id),
                                        FOREIGN KEY (labelId) REFERENCES labels(id)
    );
    INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Hướng dẫn tự làm vườn rau sạch tại nhà cho người mới bắt đầu',
    1,
    '<p>Trong bối cảnh thực phẩm an toàn đang là mối quan tâm hàng đầu, việc tự trồng rau sạch tại nhà ngày càng trở nên phổ biến. Bài viết này sẽ hướng dẫn chi tiết từng bước để bạn có thể bắt đầu khu vườn nhỏ của riêng mình ngay cả khi không có kinh nghiệm.</p><h2>1. Chuẩn bị dụng cụ và vị trí</h2><p>Đầu tiên, bạn cần chuẩn bị chậu, đất trồng, hạt giống, và dụng cụ làm vườn cơ bản. Chọn vị trí có đủ ánh sáng mặt trời (ít nhất 6 tiếng/ngày) như ban công, sân thượng hoặc cửa sổ.</p><h2>2. Chọn loại rau dễ trồng</h2><p>Đối với người mới bắt đầu, nên chọn các loại rau dễ sống và phát triển nhanh như xà lách, rau muống, cải ngọt, húng quế. Chúng không yêu cầu kỹ thuật chăm sóc quá phức tạp.</p><h2>3. Gieo hạt và chăm sóc</h2><p>Gieo hạt theo hướng dẫn trên bao bì, đảm bảo độ sâu và khoảng cách phù hợp. Tưới nước đều đặn mỗi ngày vào sáng sớm hoặc chiều mát. Thường xuyên kiểm tra sâu bệnh và có biện pháp xử lý kịp thời.</p><p>Hãy kiên nhẫn và tận hưởng thành quả của mình!</p><img src=\"https://placehold.co/600x400/008000/FFFFFF?text=Vuon+Rau+Sach\" alt=\"Vườn rau sạch tại nhà\">',
    'https://placehold.co/400x250/008000/FFFFFF?text=Vuon+Rau+Sach', -- Placeholder URL dựa trên tiêu đề
    FALSE,
    'publish',
    1
	);
    INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Ra mắt điện thoại gập màn hình kép: Cuộc cách mạng mới hay chỉ là trào lưu?',
    2,
    '<p>Sau nhiều tháng rò rỉ thông tin, <strong>điện thoại gập màn hình kép</strong> đầu tiên của hãng X đã chính thức trình làng vào tối qua tại sự kiện công nghệ toàn cầu.</p><p>Thiết bị này hứa hẹn mang đến trải nghiệm đa nhiệm vượt trội với khả năng mở rộng không gian hiển thị. Tuy nhiên, liệu đây có phải là một cuộc cách mạng thực sự hay chỉ là một trào lưu nhất thời của ngành công nghiệp di động?</p><p>Thiết kế đột phá của sản phẩm cho phép người dùng chuyển đổi linh hoạt giữa chế độ điện thoại thông thường và máy tính bảng mini, phục vụ tốt cho cả công việc và giải trí. Máy được trang bị chip xử lý thế hệ mới nhất, camera AI cải tiến và dung lượng pin ấn tượng.</p><h3>Điểm nhấn công nghệ</h3><ul><li>Màn hình AMOLED dẻo, kích thước 7.8 inch khi mở ra.</li><li>Chipset XYZ siêu mạnh, tối ưu cho đa nhiệm.</li><li>Hệ thống camera kép 50MP với công nghệ chống rung quang học.</li><li>Pin 5000mAh hỗ trợ sạc nhanh 65W.</li></ul><p>Giá bán dự kiến của sản phẩm sẽ được công bố vào tuần tới. Các chuyên gia nhận định rằng, thành công của mẫu điện thoại này sẽ phụ thuộc lớn vào trải nghiệm người dùng thực tế và giá thành cạnh tranh.</p><img src=\"https://placehold.co/600x400/FF0000/FFFFFF?text=Dien+Thoai+Gap\" alt=\"Điện thoại gập màn hình kép\">',
    'https://placehold.co/400x250/FF0000/FFFFFF?text=Dien+Thoai+Gap', -- Placeholder URL dựa trên tiêu đề
    TRUE,
    'publish',
    3
	);
    INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Báo cáo tài chính quý 1/2025: Kinh tế toàn cầu có dấu hiệu phục hồi?',
    3,
    '<p>Theo báo cáo tài chính mới nhất từ Quỹ Tiền tệ Quốc tế (IMF), nền kinh tế toàn cầu đang cho thấy những dấu hiệu phục hồi tích cực trong quý 1 năm 2025, vượt qua nhiều dự báo tiêu cực trước đó.</p><p>Các số liệu cho thấy sự tăng trưởng mạnh mẽ ở một số khu vực trọng điểm, đặc biệt là các thị trường mới nổi. Hoạt động sản xuất và tiêu dùng đều có xu hướng tăng trở lại, dù vẫn còn những thách thức nhất định.</p><p>Tuy nhiên, IMF cũng cảnh báo về những rủi ro tiềm ẩn như lạm phát dai dẳng và căng thẳng địa chính trị có thể ảnh hưởng đến đà phục hồi này.</p><blockquote>\"Sự phục hồi là đáng khích lệ, nhưng chúng ta cần cảnh giác và tiếp tục thực hiện các chính sách hợp lý để đảm bảo sự ổn định bền vững.\" - Đại diện IMF.</blockquote><p>Các chuyên gia kinh tế khuyến nghị các chính phủ và ngân hàng trung ương cần tiếp tục phối hợp chặt chẽ để đối phó với những biến động của thị trường và duy trì niềm tin của nhà đầu tư.</p>',
    'https://placehold.co/400x250/0000FF/FFFFFF?text=Bao+Cao+Tai+Chinh', -- Placeholder URL dựa trên tiêu đề
    TRUE,
    'publish',
    3
	);
    INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    '10 mẹo tiết kiệm năng lượng hiệu quả cho gia đình bạn',
    1,
    '<p>Tiết kiệm năng lượng không chỉ giúp giảm hóa đơn tiền điện mà còn góp phần bảo vệ môi trường. Dưới đây là 10 mẹo đơn giản bạn có thể áp dụng ngay tại nhà để tối ưu hóa việc sử dụng năng lượng.</p><h2>1. Tắt thiết bị khi không sử dụng</h2><p>Đừng để các thiết bị điện tử ở chế độ chờ. Rút phích cắm hoặc sử dụng ổ cắm có công tắc để ngắt hoàn toàn nguồn điện.</p><h2>2. Tận dụng ánh sáng tự nhiên</h2><p>Mở rèm cửa và cửa sổ để ánh sáng mặt trời chiếu vào nhà, giảm nhu cầu sử dụng đèn chiếu sáng ban ngày.</p><h3>Các mẹo khác:</h3><ul><li>Sử dụng bóng đèn LED.</li><li>Vệ sinh điều hòa định kỳ.</li><li>Trồng cây xanh xung quanh nhà để giảm nhiệt độ.</li></ul><p>Thực hiện những thay đổi nhỏ này có thể mang lại hiệu quả đáng kể cho ngôi nhà của bạn.</p>',
    'https://placehold.co/400x250/87CEEB/FFFFFF?text=Tiet+Kiem+Nang+Luong', -- Placeholder cho "Đời sống"
    FALSE,
    'publish',
    '1' -- labelId: Đời sống
	);
    INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'World Cup 2026: Những thay đổi lớn và kỳ vọng từ người hâm mộ',
    2,
    '<p>World Cup 2026 hứa hẹn sẽ là một giải đấu lịch sử với nhiều thay đổi về thể thức và số lượng đội tham dự. Lần đầu tiên, 48 đội tuyển sẽ tranh tài tại 3 quốc gia chủ nhà: Mỹ, Canada và Mexico.</p><p>Sự mở rộng này được kỳ vọng sẽ mang lại cơ hội cho nhiều nền bóng đá hơn, đồng thời tăng tính cạnh tranh và kịch tính của giải đấu.</p><h2>Điểm mới nổi bật:</h2><ul><li>Số đội tham dự tăng từ 32 lên 48.</li><li>Số trận đấu tăng đáng kể.</li><li>Giải đấu sẽ được tổ chức tại nhiều thành phố trên khắp ba quốc gia.</li></ul><p>Người hâm mộ trên toàn thế giới đang rất mong chờ những màn trình diễn đỉnh cao và các bất ngờ đến từ các đội bóng mới.</p>',
    'https://placehold.co/400x250/228B22/FFFFFF?text=World+Cup+2026', -- Placeholder cho "Thể thao"
    TRUE,
    'publish',
    '2' -- labelId: Thể thao
);

-- News Article 6: Khám phá Sao Hỏa
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'NASA công bố dữ liệu mới về tiềm năng sự sống trên Sao Hỏa',
    3,
    '<p>Cơ quan Hàng không và Vũ trụ Mỹ (NASA) vừa công bố những dữ liệu mới từ tàu thăm dò Perseverance, mang lại hy vọng về khả năng tồn tại sự sống trong quá khứ trên Sao Hỏa.</p><p>Các mẫu vật đá được thu thập cho thấy dấu vết của nước lỏng và các hợp chất hữu cơ, là những yếu tố cần thiết cho sự phát triển của sự sống.</p><h2>Phát hiện quan trọng:</h2><ul><li>Bằng chứng về nước lỏng cổ đại.</li><li>Phát hiện các phân tử hữu cơ phức tạp.</li><li>Các nhà khoa học đang phân tích sâu hơn các mẫu vật này.</li></ul><p>Những khám phá này mở ra một chương mới trong hành trình tìm kiếm sự sống ngoài Trái Đất và thúc đẩy các sứ mệnh thám hiểm Sao Hỏa trong tương lai.</p>',
    'https://placehold.co/400x250/800080/FFFFFF?text=Sao+Hoa', -- Placeholder cho "Khoa học - Công nghệ"
    TRUE,
    'publish',
    '3' -- labelId: Khoa học - Công nghệ
);

-- News Article 7: Lợi ích của yoga
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Yoga cho người mới bắt đầu: 5 tư thế đơn giản cải thiện sức khỏe',
    1,
    '<p>Yoga là bộ môn tuyệt vời giúp cải thiện cả sức khỏe thể chất lẫn tinh thần. Nếu bạn là người mới bắt đầu, đừng lo lắng! Dưới đây là 5 tư thế yoga đơn giản nhưng vô cùng hiệu quả mà bạn có thể thực hiện ngay tại nhà.</p><h2>Các tư thế cơ bản:</h2><ol><li>Tư thế Ngọn núi (Tadasana): Giúp cải thiện tư thế và sự cân bằng.</li><li>Tư thế Chó úp mặt (Adho Mukha Svanasana): Kéo dãn toàn thân, giảm căng thẳng.</li><li>Tư thế Cây (Vrksasana): Tăng cường sự tập trung và cân bằng.</li><li>Tư thế Xác chết (Savasana): Thư giãn sâu, giảm căng thẳng.</li></ol><p>Hãy bắt đầu hành trình yoga của bạn để cảm nhận sự thay đổi tích cực trong cơ thể và tâm trí.</p>',
    'https://placehold.co/400x250/FF6347/FFFFFF?text=Yoga+Suc+Khoe', -- Placeholder cho "Sức khoẻ"
    FALSE,
    'publish',
    '4' -- labelId: Sức khoẻ
);

-- News Article 8: Phim bom tấn
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Top 5 bộ phim bom tấn đáng xem nhất mùa hè 2025',
    2,
    '<p>Mùa hè luôn là thời điểm bùng nổ của các siêu phẩm điện ảnh. Năm 2025 cũng không ngoại lệ với hàng loạt bộ phim bom tấn hứa hẹn sẽ làm mưa làm gió tại các phòng vé.</p><p>Từ những cuộc phiêu lưu giả tưởng đến các trận chiến hành động nghẹt thở, khán giả sẽ có vô vàn lựa chọn để giải trí.</p><h2>Danh sách phim:</h2><ul><li>\"Người Khổng Lồ\" - Phần tiếp theo của series hành động nổi tiếng.</li><li>\"Hành Tinh Bí Ẩn\" - Phim khoa học viễn tưởng với kỹ xảo đỉnh cao.</li><li>\"Cuộc Đua Tử Thần\" - Phim đua xe đầy kịch tính.</li></ul><p>Hãy chuẩn bị bắp rang bơ và tận hưởng những giờ phút giải trí tuyệt vời tại rạp chiếu phim!</p>',
    'https://placehold.co/400x250/8A2BE2/FFFFFF?text=Phim+Bom+Tan', -- Placeholder cho "Giải trí"
    TRUE,
    'publish',
    '5' -- labelId: Giải trí
);

-- News Article 9: Khởi nghiệp
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Khởi nghiệp 2025: Những xu hướng đáng chú ý và cơ hội cho nhà đầu tư',
    1,
    '<p>Năm 2025 chứng kiến sự phát triển mạnh mẽ của nhiều mô hình khởi nghiệp mới, đặc biệt trong lĩnh vực công nghệ xanh, AI và chuỗi cung ứng bền vững. Đây là những xu hướng đang thu hút sự quan tâm lớn từ các nhà đầu tư.</p><p>Các startup tập trung vào giải quyết vấn đề xã hội và môi trường đang có lợi thế cạnh tranh, cũng như những công ty ứng dụng AI để tối ưu hóa quy trình kinh doanh.</p><h2>Xu hướng chính:</h2><ul><li>Công nghệ xanh và năng lượng tái tạo.</li><li>Ứng dụng trí tuệ nhân tạo trong mọi lĩnh vực.</li><li>Phát triển các mô hình kinh doanh tuần hoàn.</li></ul><p>Thị trường khởi nghiệp đang sôi động hơn bao giờ hết, mở ra nhiều cơ hội cho những ý tưởng đột phá và tầm nhìn dài hạn.</p>',
    'https://placehold.co/400x250/DAA520/FFFFFF?text=Khoi+Nghiep+2025', -- Placeholder cho "Kinh doanh"
    TRUE,
    'publish',
    '6' -- labelId: Kinh doanh
);

-- News Article 10: Du lịch bền vững
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Xu hướng du lịch bền vững lên ngôi: Khám phá những điểm đến thân thiện môi trường',
    2,
    '<p>Du lịch bền vững đang trở thành lựa chọn hàng đầu của nhiều du khách hiện đại, không chỉ mang lại trải nghiệm đáng nhớ mà còn góp phần bảo vệ thiên nhiên và văn hóa địa phương. Xu hướng này tập trung vào việc giảm thiểu tác động tiêu cực và tối đa hóa lợi ích cho cộng đồng.</p><h2>Điểm đến nổi bật:</h2><ul><li><strong>Ecotourism ở Vườn Quốc gia:</strong> Trải nghiệm thiên nhiên hoang dã mà không làm ảnh hưởng đến hệ sinh thái.</li><li><strong>Du lịch cộng đồng:</strong> Tìm hiểu văn hóa bản địa, hỗ trợ kinh tế địa phương.</li><li><strong>Khu nghỉ dưỡng thân thiện môi trường:</strong> Sử dụng năng lượng tái tạo, giảm thiểu rác thải.</li></ul><p>Hãy cùng khám phá những điểm đến tuyệt vời, nơi bạn có thể vừa tận hưởng chuyến đi, vừa đóng góp cho một tương lai xanh hơn.</p>',
    'https://placehold.co/400x250/32CD32/FFFFFF?text=Du+Lich+Ben+Vung', -- Placeholder cho "Đời sống"
    FALSE,
    'publish',
    '1' -- labelId: Đời sống
);

-- News Article 11: Olympic 2028
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Olympic 2028: Los Angeles sẵn sàng cho kỳ đại hội thể thao hoành tráng',
    3,
    '<p>Los Angeles đang gấp rút chuẩn bị cho kỳ Thế vận hội mùa hè 2028, hứa hẹn một đại hội thể thao đầy ấn tượng với công nghệ tiên tiến và các cơ sở vật chất đẳng cấp thế giới. Thành phố này đã có kinh nghiệm tổ chức Olympic hai lần trước đó vào năm 1932 và 1984.</p><h2>Những điểm nhấn:</h2><ul><li>Sử dụng lại các địa điểm thi đấu hiện có để giảm chi phí và tác động môi trường.</li><li>Tích hợp công nghệ mới vào trải nghiệm khán giả và vận động viên.</li><li>Tập trung vào tính bền vững và di sản lâu dài cho thành phố.</li></ul><p>Các vận động viên và người hâm mộ trên toàn thế giới đang mong chờ một kỳ Olympic đáng nhớ tại thành phố của những thiên thần.</p>',
    'https://placehold.co/400x250/4682B4/FFFFFF?text=Olympic+LA+2028', -- Placeholder cho "Thể thao"
    TRUE,
    'publish',
    '2' -- labelId: Thể thao
);

-- News Article 12: Trí tuệ nhân tạo
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'AI và tương lai việc làm: Thách thức và cơ hội cho người lao động',
    4,
    '<p>Trí tuệ nhân tạo (AI) đang định hình lại thị trường lao động toàn cầu với tốc độ chóng mặt. Mặc dù AI có thể tự động hóa nhiều công việc lặp đi lặp lại, nó cũng mở ra những cơ hội mới cho các ngành nghề đòi hỏi sự sáng tạo và tương tác con người.</p><h2>Tác động của AI:</h2><ul><li><strong>Thay đổi kỹ năng cần thiết:</strong> Tập trung vào kỹ năng mềm, tư duy phản biện và khả năng học hỏi.</li><li><strong>Phát sinh ngành nghề mới:</strong> Kỹ sư AI, chuyên gia đạo đức AI, quản lý dữ liệu.</li><li><strong>Tăng năng suất:</strong> AI giúp tự động hóa tác vụ, giải phóng thời gian cho công việc phức tạp hơn.</li></ul><p>Để thích nghi với tương lai, người lao động cần không ngừng học hỏi và phát triển các kỹ năng mà AI không thể thay thế.</p>',
    'https://placehold.co/400x250/B0C4DE/FFFFFF?text=AI+Va+Viec+Lam', -- Placeholder cho "Khoa học - Công nghệ"
    TRUE,
    'publish',
    '3' -- labelId: Khoa học - Công nghệ
);

-- News Article 13: Sức khỏe tinh thần
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Bí quyết giữ gìn sức khỏe tinh thần trong cuộc sống hiện đại đầy áp lực',
    4,
    '<p>Trong bối cảnh cuộc sống hiện đại đầy áp lực, việc chăm sóc sức khỏe tinh thần trở nên quan trọng hơn bao giờ hết. Stress, lo âu và trầm cảm là những vấn đề phổ biến cần được quan tâm đúng mức.</p><h2>Bí quyết đơn giản:</h2><ol><li><strong>Thiền và chánh niệm:</strong> Dành 10-15 phút mỗi ngày để tĩnh tâm và tập trung vào hơi thở.</li><li><strong>Tập thể dục đều đặn:</strong> Hoạt động thể chất giúp giải phóng endorphin, cải thiện tâm trạng.</li><li><strong>Kết nối xã hội:</strong> Dành thời gian cho bạn bè và gia đình, chia sẻ cảm xúc.</li><li><strong>Ngủ đủ giấc:</strong> Giấc ngủ chất lượng là yếu tố then chốt để phục hồi năng lượng tinh thần.</li></ol><p>Hãy ưu tiên sức khỏe tinh thần của bạn như ưu tiên sức khỏe thể chất để có một cuộc sống trọn vẹn và hạnh phúc hơn.</p>',
    'https://placehold.co/400x250/98FB98/FFFFFF?text=Suc+Khoe+Tinh+Than', -- Placeholder cho "Sức khoẻ"
    FALSE,
    'publish',
    '4' -- labelId: Sức khoẻ
);

-- News Article 14: Lễ hội âm nhạc
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Các lễ hội âm nhạc quốc tế không thể bỏ lỡ trong năm 2025',
    3,
    '<p>Năm 2025 hứa hẹn sẽ là một năm bùng nổ của các lễ hội âm nhạc trên toàn thế giới, mang đến những trải nghiệm âm nhạc đỉnh cao và không khí cuồng nhiệt. Từ rock, pop đến EDM, có vô số lựa chọn cho mọi tín đồ âm nhạc.</p><h2>Điểm danh lễ hội:</h2><ul><li><strong>Glastonbury (Anh):</strong> Lễ hội huyền thoại với đa dạng thể loại và nghệ sĩ hàng đầu.</li><li><strong>Tomorrowland (Bỉ):</strong> Thiên đường của âm nhạc điện tử, với sân khấu hoành tráng.</li><li><strong>Coachella (Mỹ):</strong> Sự kiện văn hóa kết hợp âm nhạc, nghệ thuật và thời trang.</li></ul><p>Hãy lên kế hoạch và chuẩn bị cho những chuyến đi âm nhạc đáng nhớ nhất trong năm!</p>',
    'https://placehold.co/400x250/BA55D3/FFFFFF?text=Le+Hoi+Am+Nhac', -- Placeholder cho "Giải trí"
    TRUE,
    'publish',
    '5' -- labelId: Giải trí
);

-- News Article 15: Thị trường chứng khoán
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Phân tích thị trường chứng khoán quý 2/2025: Những ngành nào sẽ dẫn đầu?',
    1,
    '<p>Quý 2 năm 2025 được dự báo sẽ mang đến nhiều biến động và cơ hội cho thị trường chứng khoán. Các nhà phân tích đang tập trung vào những ngành có tiềm năng tăng trưởng mạnh mẽ trong bối cảnh kinh tế toàn cầu đang dần ổn định.</p><h2>Ngành tiềm năng:</h2><ul><li><strong>Công nghệ thông tin:</strong> Với sự phát triển của AI và điện toán đám mây.</li><li><strong>Năng lượng tái tạo:</strong> Đầu tư vào các giải pháp xanh ngày càng tăng.</li><li><strong>Dược phẩm và chăm sóc sức khỏe:</strong> Nhu cầu y tế luôn ổn định và tăng trưởng.</li></ul><p>Việc đầu tư thông minh và theo dõi sát sao diễn biến thị trường là chìa khóa để đạt được lợi nhuận trong giai đoạn này.</p>',
    'https://placehold.co/400x250/CD853F/FFFFFF?text=Chung+Khoan+Quy2', -- Placeholder cho "Kinh doanh"
    TRUE,
    'publish',
    '6' -- labelId: Kinh doanh
);
-- News Article 16: Ẩm thực đường phố
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Khám phá ẩm thực đường phố: Những món ăn không thể bỏ lỡ khi du lịch',
    4,
    '<p>Ẩm thực đường phố luôn là một phần không thể thiếu trong trải nghiệm du lịch, mang đến hương vị độc đáo và cái nhìn chân thực về văn hóa địa phương. Từ những xe đẩy nhỏ bé đến các quán ăn vỉa hè sầm uất, mỗi món ăn đều kể một câu chuyện riêng.</p><h2>Điểm danh món ngon:</h2><ul><li><strong>Phở (Việt Nam):</strong> Món ăn quốc hồn quốc túy với hương vị đậm đà.</li><li><strong>Taco (Mexico):</strong> Sự kết hợp hoàn hảo của thịt, rau và gia vị.</li><li><strong>Currywurst (Đức):</strong> Xúc xích nướng sốt cà ri, món ăn nhanh đặc trưng.</li></ul><p>Hãy dũng cảm thử những món mới và để vị giác dẫn lối bạn khám phá thế giới!</p>',
    'https://placehold.co/400x250/FFD700/000000?text=Am+Thuc+Duong+Pho', -- Placeholder cho "Đời sống"
    FALSE,
    'publish',
    '1' -- labelId: Đời sống
);

-- News Article 17: E-Sports
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'E-Sports bùng nổ: Cơ hội nghề nghiệp mới cho giới trẻ đam mê game',
    2,
    '<p>E-Sports (Thể thao điện tử) không còn là một sân chơi đơn thuần mà đã trở thành một ngành công nghiệp tỷ đô, mở ra vô vàn cơ hội nghề nghiệp hấp dẫn cho những người trẻ có niềm đam mê mãnh liệt với game. Từ vận động viên chuyên nghiệp đến bình luận viên, huấn luyện viên, hay quản lý đội tuyển, E-Sports đang tạo ra một hệ sinh thái việc làm đa dạng.</p><h2>Các vai trò chính:</h2><ul><li><strong>Tuyển thủ chuyên nghiệp:</strong> Cạnh tranh ở các giải đấu lớn.</li><li><strong>Streamer/Content Creator:</strong> Tạo nội dung game thu hút khán giả.</li><li><strong>Phân tích viên:</strong> Cung cấp cái nhìn chuyên sâu về chiến thuật.</li></ul><p>Nếu bạn có tài năng và quyết tâm, E-Sports có thể là con đường sự nghiệp đầy hứa hẹn.</p>',
    'https://placehold.co/400x250/5F9EA0/FFFFFF?text=E-Sports+Nghe+Nghiep', -- Placeholder cho "Thể thao"
    TRUE,
    'publish',
    '2' -- labelId: Thể thao
);

-- News Article 18: Công nghệ sinh học
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Đột phá trong công nghệ sinh học: Hy vọng mới cho y học và nông nghiệp',
    1,
    '<p>Những tiến bộ vượt bậc trong công nghệ sinh học đang mở ra kỷ nguyên mới cho y học và nông nghiệp, mang lại giải pháp cho nhiều thách thức toàn cầu. Từ việc phát triển vắc-xin thế hệ mới đến tạo ra cây trồng chống chịu bệnh tật, công nghệ sinh học đang thay đổi cuộc sống của chúng ta.</p><h2>Ứng dụng nổi bật:</h2><ul><li><strong>Y học cá thể hóa:</strong> Điều trị dựa trên đặc điểm di truyền của từng bệnh nhân.</li><li><strong>Nông nghiệp bền vững:</strong> Cây trồng biến đổi gen giúp tăng năng suất và giảm sử dụng hóa chất.</li><li><strong>Sản xuất dược phẩm:</strong> Tạo ra thuốc men hiệu quả hơn với chi phí thấp hơn.</li></ul><p>Công nghệ sinh học hứa hẹn một tương lai nơi con người có thể sống khỏe mạnh hơn và giải quyết vấn đề an ninh lương thực.</p>',
    'https://placehold.co/400x250/6A5ACD/FFFFFF?text=Cong+Nghe+Sinh+Hoc', -- Placeholder cho "Khoa học - Công nghệ"
    TRUE,
    'publish',
    '3' -- labelId: Khoa học - Công nghệ
);

-- News Article 19: Chế độ ăn uống
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Chế độ ăn uống Địa Trung Hải: Bí quyết sống thọ và khỏe mạnh',
    2,
    '<p>Chế độ ăn Địa Trung Hải từ lâu đã được công nhận là một trong những kiểu ăn uống lành mạnh nhất thế giới, góp phần vào tuổi thọ cao và giảm nguy cơ mắc các bệnh mãn tính. Chế độ này nhấn mạnh vào thực phẩm tươi sống, nguyên hạt và chất béo lành mạnh.</p><h2>Các nguyên tắc chính:</h2><ul><li><strong>Rau củ quả và ngũ cốc nguyên hạt:</strong> Chiếm phần lớn bữa ăn.</li><li><strong>Dầu ô liu nguyên chất:</strong> Nguồn chất béo chính.</li><li><strong>Cá và hải sản:</strong> Tiêu thụ thường xuyên.</li><li><strong>Thịt gia cầm, trứng:</strong> Tiêu thụ vừa phải.</li><li><strong>Thịt đỏ, đồ ngọt:</strong> Tiêu thụ hạn chế.</li></ul><p>Áp dụng chế độ ăn này không chỉ giúp bạn có sức khỏe tốt mà còn mang lại niềm vui từ những bữa ăn ngon miệng.</p>',
    'https://placehold.co/400x250/90EE90/000000?text=An+Dia+Trung+Hai', -- Placeholder cho "Sức khoẻ"
    FALSE,
    'publish',
    '4' -- labelId: Sức khoẻ
);

-- News Article 20: Sách bán chạy
INSERT INTO News (title, managerId, content, thumbNailUrl, isHot, status, labelId) VALUES (
    'Top 5 cuốn sách phi hư cấu bán chạy nhất năm 2025 bạn không thể bỏ lỡ',
    4,
    '<p>Năm 2025 chứng kiến sự lên ngôi của nhiều cuốn sách phi hư cấu đột phá, mang đến kiến thức sâu sắc và những góc nhìn mới mẻ về cuộc sống, khoa học và kinh doanh. Đây là những tác phẩm giúp độc giả phát triển bản thân và hiểu rõ hơn về thế giới xung quanh.</p><h2>Sách nổi bật:</h2><ul><li><strong>\"Tư Duy Sáng Tạo Trong Kỷ Nguyên AI\":</strong> Hướng dẫn cách phát huy trí óc trong thời đại công nghệ.</li><li><strong>\"Bí Mật Của Hạnh Phúc Bền Vững\":</strong> Khám phá khoa học đằng sau sự hài lòng trong cuộc sống.</li><li><strong>\"Lịch Sử Ngắn Gọn Về Tương Lai\":</strong> Cái nhìn về những gì đang chờ đợi nhân loại.</li></ul><p>Hãy dành thời gian đắm mình vào những trang sách này để mở rộng tầm hiểu biết của bạn.</p>',
    'https://placehold.co/400x250/DDA0DD/FFFFFF?text=Sach+Hay+2025', -- Placeholder cho "Giải trí"
    TRUE,
    'publish',
    '5' -- labelId: Giải trí
);

    
   -- Tạo bảng comments
    CREATE TABLE IF NOT EXISTS comments (
        id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        clientId BIGINT NOT NULL,
        content TEXT NOT NULL,
        date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        like_count INT DEFAULT 0,
        commentId BIGINT,
        newsId BIGINT NOT NULL,
        FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
        FOREIGN KEY (commentId) REFERENCES comments(id) ON DELETE CASCADE,
        FOREIGN KEY (newsId) REFERENCES news(id) ON DELETE CASCADE
    );
    -- Giả sử bảng 'clients' có các id 1, 2, 3, 4
    -- Giả sử bảng 'news' có các id 1, 2, 3, ..., 10 (dựa trên dữ liệu mẫu trước đó)

    -- Dữ liệu mẫu cho bảng 'comments'
    INSERT INTO comments (clientId, content, date, like_count, commentId, newsId) VALUES
    -- Bình luận cho newsId = 1 (Tech Conference 2025 Highlights)
    (1, 'Great summary of the tech conference! I was particularly interested in the AI advancements.', '2025-05-20 12:00:00', 15, NULL, 1),
    (2, 'Does anyone have more details on the quantum computing talks?', '2025-05-20 12:30:00', 8, NULL, 1),
    (3, 'Reply to comment 2: I found a link to the slides here: [link_to_slides.com]', '2025-05-20 13:00:00', 5, 2, 1), -- Giả sử bình luận có id 2 tồn tại cho newsId 1
    (4, 'This was a fantastic event. Looking forward to next year.', '2025-05-21 09:00:00', 12, NULL, 1),

    -- Bình luận cho newsId = 2 (Global Economic Outlook Q3)
    (4, 'Interesting analysis. The regional challenges part is concerning.', '2025-05-21 14:00:00', 7, NULL, 2), -- clientId cập nhật từ 5 thành 4
    (1, 'I agree, the outlook seems cautiously optimistic.', '2025-05-21 14:30:00', 9, NULL, 2),

    -- Bình luận cho newsId = 3 (New Environmental Policies Announced)
    (2, 'These new policies are a step in the right direction!', '2025-05-22 16:00:00', 22, NULL, 3),
    (3, 'I hope they are implemented effectively. Enforcement will be key.', '2025-05-22 16:45:00', 18, NULL, 3),
    (1, 'Reply to comment 8: Absolutely, without proper enforcement, these policies won\'t mean much.', '2025-05-22 17:00:00', 6, 8, 3), -- Giả sử bình luận có id 8 tồn tại cho newsId 3

    -- Bình luận cho newsId = 4 (Healthcare Advances in Gene Therapy)
    (4, 'Incredible news for genetic disorders! This is life-changing.', '2025-05-23 10:00:00', 30, NULL, 4),
    (1, 'What is the timeline for these therapies to become widely available?', '2025-05-23 10:30:00', 11, NULL, 4), -- clientId cập nhật từ 5 thành 1

    -- Bình luận cho newsId = 5 (Upcoming Arts Festival Preview)
    (1, 'Can\'t wait for the arts festival! The lineup looks amazing.', '2025-05-24 18:00:00', 19, NULL, 5),

    -- Bình luận cho newsId = 6 (Sports Championship Finals Recap)
    (2, 'What a game! The highlights were epic.', '2025-05-25 20:00:00', 25, NULL, 6),
    (3, 'Reply to comment 13: That last goal was unbelievable!', '2025-05-25 20:15:00', 10, 13, 6), -- Giả sử bình luận có id 13 tồn tại cho newsId 6

    -- Bình luận cho newsId = 7 (DIY Home Improvement Trends)
    (4, 'Thanks for the DIY tips! I\'m planning a weekend project now.', '2025-05-26 15:00:00', 14, NULL, 7),

    -- Bình luận cho newsId = 8 (Travel Guide: Summer Destinations)
    (2, 'The summer destinations guide is just what I needed. So many great ideas!', '2025-05-27 12:00:00', 17, NULL, 8), -- clientId cập nhật từ 5 thành 2

    -- Bình luận cho newsId = 9 (Startup Success Stories of the Year)
    (1, 'Very inspiring stories. It shows what dedication can achieve.', '2025-05-27 10:00:00', 20, NULL, 9),

    -- Bình luận cho newsId = 10 (Culinary Delights: New Recipes to Try)
    (2, 'The new recipes look delicious! I\'m trying the pasta one tonight.', NOW(), 23, NULL, 10),
    (3, 'Any recommendations for a good dessert recipe from the list?', NOW() - INTERVAL 1 HOUR, 9, NULL, 10),
    (4, 'Reply to comment 19: The chocolate lava cake is a must-try!', NOW() - INTERVAL 30 MINUTE, 7, 19, 10); -- Giả sử bình luận có id 19 tồn tại cho newsId 10

-- Tạo bảng reports
CREATE TABLE IF NOT EXISTS reports (
                                       id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                       reason VARCHAR(255) NOT NULL CHECK (reason IN('Tin rác', 'Quấy rối', 'Nội dung không phù hợp','Khác')),
    content TEXT,
    clientId BIGINT NOT NULL,
    commentId BIGINT NOT NULL,
    created_at TIMESTAMP default current_timestamp,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (commentId) REFERENCES comments(id) ON DELETE CASCADE
    );
    -- Assuming 'clients' table has ids 1, 2, 3, 4
    -- Assuming 'comments' table has ids 1, 2, 3, ..., 20 (based on previous sample data for comments)

    -- Sample Data for 'reports' table


INSERT INTO reports (reason, content, clientId, commentId, created_at) VALUES
                                                                           ('Tin rác', 'The link provided looks suspicious and might be spam.', 1, 3, NOW()),
                                                                           ('Quấy rối', 'This user is being aggressive in their replies.', 2, 9, NOW()),
                                                                           ('Nội dung không phù hợp', 'The language used in this comment is not suitable for the platform.', 3, 10, NOW()),
                                                                           ('Tin rác', 'This comment seems like a generic advertisement.', 4, 1, NOW()),
                                                                           ('Quấy rối', 'User is repeatedly targeting another user in the sports discussion.', 1, 14, NOW()),
                                                                           ('Nội dung không phù hợp', NULL, 2, 5, NOW()),
                                                                           ('Tin rác', 'This looks like a bot comment trying to promote something unrelated.', 3, 18, NOW()),
                                                                           ('Nội dung không phù hợp', 'The comment contains offensive terms.', 4, 7, NOW()),
                                                                           ('Quấy rối', 'The user is making personal attacks.', 1, 12, NOW()),
                                                                           ('Khác', NULL, 2, 20, NOW());




-- Tạo bảng save_news
CREATE TABLE IF NOT EXISTS save_news (
	id INT primary key auto_increment,
    clientId BIGINT NOT NULL,
    newsId BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (newsId) REFERENCES news(id) on delete cascade
);

INSERT INTO save_news (clientId, newsId) VALUES ('1', '1');
INSERT INTO save_news (clientId, newsId) VALUES ('1', '2');
INSERT INTO save_news (clientId, newsId) VALUES ('1', '3');


-- Tạo bảng nearest_news
CREATE TABLE IF NOT EXISTS nearest_news (	
	id INT primary key auto_increment,
    clientId BIGINT NOT NULL,
    newsId BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (newsId) REFERENCES news(id) on delete cascade
);

-- Tạo bảng notifications
CREATE TABLE notifications (
                               id INT PRIMARY KEY AUTO_INCREMENT,
                               clientId BIGINT NOT NULL,
                               replierId BIGINT NOT NULL,
                               newsId BIGINT NOT NULL,
                               content TEXT NOT NULL,
                               isRead BOOLEAN DEFAULT FALSE,
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               FOREIGN KEY (clientId) REFERENCES clients(id) on DELETE CASCADE,
                               FOREIGN KEY (newsId) REFERENCES news(id) on DELETE CASCADE,
                               FOREIGN KEY (replierId) REFERENCES clients(id)
);

INSERT INTO notifications (id, clientId, replierId, newsId, content) VALUES ('1', '1', '2', 1, 'like');
INSERT INTO notifications (id, clientId, replierId, newsId, content) VALUES ('2', '1', '3', 2, 'comment');
