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
    isMute BOOLEAN DEFAULT FALSE,
    avatarUrl TEXT,
    isActive BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Nguyen Van A', '$2b$12$6xmtzoaFRg8vbTxMEpZnVOfgiLyEDUSswuehPZxO0mH3nwFriVHRm', 'a.nguyen@example.com', FALSE, null, TRUE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Tran Thi B', '$2b$12$.KPeHWFLAEdJdFBZBVP4pexgluTP9VcvW2CkjtiMC3eEQ1wui77hS', 'b.tran@example.com', TRUE, 'url_avatar_b.png', TRUE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Le Minh C', '$2b$12$RAN630EQ48vJeh.jfBSPfecgApI8Dot8ck/b6apNICCdywaS0GYpy', 'c.le@example.com', FALSE, NULL, FALSE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Pham Hoang D', '$2b$12$MAkBcLQSpQEX1rAVwchIaeNpzejUbdl6AZvAIOSbWF8bqoEcAhok6', 'd.pham@example.com', FALSE, 'url_avatar_d.gif', TRUE);
INSERT INTO clients (fullName, password, email, isMute, isActive) VALUES ('Trang Xuan', '123456', 'trangxuan@gmail.com', FALSE, TRUE);

-- Tạo bảng managers
CREATE TABLE IF NOT EXISTS managers (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL CHECK (role IN('admin', 'editor')),
    email VARCHAR(255) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO managers (fullName, password, role,email) VALUES ('Trang Xuân', '$2b$12$4.FthDpDH0mmetIANiges.7vk59.gW2DNMzjJmrEkToPMQNI7c8Tq', 'admin', 'trang@gmail.com');
INSERT INTO managers (fullName, password, role,email) VALUES ('Phạm Vân Anh', '$2b$12$k2qIfnDDFEunC6kWQOmq1OYsKQbF6cIrCmsy/NspM3rWHLpneOt1G', 'editor', 'vananh@gmail.com');
INSERT INTO managers (fullName, password, role,email) VALUES ('Thảo Nhi', '$2b$12$70fqwwm6c.2i2qDeLI.XZO6CiKRyKZ5yZb9rEurGbf3jI3qWpQG5q', 'editor', 'thaonhi@gmail.com');

-- Tạo bảng label
CREATE TABLE IF NOT EXISTS labels (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(255) NOT NULL
);

-- Tạo bảng News
CREATE TABLE IF NOT EXISTS news (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    managerId BIGINT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    tag VARCHAR(255),
    content TEXT,
    thumbNailUrl VARCHAR(255),
    isHot BOOLEAN DEFAULT FALSE,
    labelId INT,
    FOREIGN KEY (managerId) REFERENCES managers(id),
    FOREIGN KEY (labelId) REFERENCES labels(id)
);
INSERT INTO news (title, managerId, date, tag, content, thumbNailUrl, isHot, status, labelId) VALUES
                                                                                                  ('Tech Conference 2025 Highlights', 1, '2025-05-20 10:00:00', 'Technology', 'Detailed summary of the major announcements and discussions from the annual tech conference. Keynotes included advancements in AI and quantum computing.', 'https://placehold.co/300x200/A7C7E7/333333?text=Tech+Conf', TRUE, 'publish', 1),
                                                                                                  ('Global Economic Outlook Q3', 2, '2025-05-21 11:30:00', 'Economy', 'An in-depth analysis of the global economic trends for the third quarter. Experts predict steady growth despite regional challenges.', 'https://placehold.co/300x200/B2D8B2/333333?text=Economy+Q3', FALSE, 'publish', 2),
                                                                                                  ('New Environmental Policies Announced', 3, '2025-05-22 14:15:00', 'Environment', 'The government has unveiled a new set of policies aimed at reducing carbon emissions and promoting renewable energy sources.', 'https://placehold.co/300x200/FFDAB9/333333?text=Eco+Policy', TRUE, 'draft', 3),
                                                                                                  ('Healthcare Advances in Gene Therapy', 4, '2025-05-23 09:00:00', 'Health', 'Recent breakthroughs in gene therapy offer new hope for treating previously incurable genetic disorders. Clinical trials show promising results.', 'https://placehold.co/300x200/E6E6FA/333333?text=Gene+Therapy', FALSE, 'publish', 4),
                                                                                                  ('Upcoming Arts Festival Preview', 1, '2025-05-24 16:45:00', 'Arts', 'A sneak peek into the upcoming international arts festival, featuring renowned artists and diverse cultural performances. This article is still under review.', 'https://placehold.co/300x200/FFFACD/333333?text=Arts+Fest', TRUE, 'draft', 5),
                                                                                                  ('Sports Championship Finals Recap', 2, '2025-05-25 18:00:00', 'Sports', 'A thrilling recap of the national sports championship finals, including highlights, player interviews, and expert commentary.', 'https://placehold.co/300x200/F0E68C/333333?text=Sports+Finals', TRUE, 'publish', 1),
                                                                                                  ('DIY Home Improvement Trends', 3, '2025-05-26 13:20:00', 'Lifestyle', 'Discover the latest trends in DIY home improvement, with tips and tricks for easy and affordable upgrades to your living space.', 'https://placehold.co/300x200/D8BFD8/333333?text=DIY+Home', FALSE, 'publish', 2),
                                                                                                  ('Travel Guide: Summer Destinations', 4, '2025-05-27 10:50:00', 'Travel', 'Explore the top summer travel destinations for 2025. This guide covers everything from exotic beaches to mountain retreats. Awaiting final approval.', 'https://placehold.co/300x200/ADD8E6/333333?text=Summer+Travel', FALSE, 'draft', 3),
                                                                                                  ('Startup Success Stories of the Year', 1, NOW() - INTERVAL 1 DAY, 'Business', 'Inspiring stories from the most successful startups of the past year, highlighting their journeys and innovations.', 'https://placehold.co/300x200/98FB98/333333?text=Startups', TRUE, 'publish', 4),
                                                                                                  ('Culinary Delights: New Recipes to Try', 2, NOW(), 'Food', 'A collection of exciting new recipes from top chefs around the world. Perfect for home cooks looking to spice up their meals.', 'https://placehold.co/300x200/FFB6C1/333333?text=New+Recipes', FALSE, 'publish', 5);
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
    reason VARCHAR(255) NOT NULL CHECK (reason IN('spam', 'harassment', 'inappropriate_content')),
    content TEXT,
    clientId BIGINT NOT NULL,
    commentId BIGINT NOT NULL,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (commentId) REFERENCES comments(id) ON DELETE CASCADE
);
-- Assuming 'clients' table has ids 1, 2, 3, 4
-- Assuming 'comments' table has ids 1, 2, 3, ..., 20 (based on previous sample data for comments)

-- Sample Data for 'reports' table


INSERT INTO reports (reason, content, clientId, commentId, created_at) VALUES
-- Report for commentId = 3 (Reply to comment 2 on newsId = 1)
('spam', 'The link provided looks suspicious and might be spam.', 1, 3, '2025-05-20 14:00:00'),

-- Report for commentId = 9 (Reply to comment 8 on newsId = 3)
('harassment', 'This user is being aggressive in their replies.', 2, 9, '2025-05-22 18:00:00'),

-- Report for commentId = 10 (Comment on newsId = 4)
('inappropriate_content', 'The language used in this comment is not suitable for the platform.', 3, 10, '2025-05-23 11:00:00'),

-- Report for commentId = 1 (Comment on newsId = 1)
('spam', 'This comment seems like a generic advertisement.', 4, 1, '2025-05-21 10:00:00'),

-- Report for commentId = 14 (Reply to comment 13 on newsId = 6)
('harassment', 'User is repeatedly targeting another user in the sports discussion.', 1, 14, '2025-05-25 21:00:00'),

-- Report for commentId = 5 (Comment on newsId = 2)
('inappropriate_content', NULL, 2, 5, '2025-05-21 15:30:00'), -- No specific content, just the reason

-- Report for commentId = 18 (Comment on newsId = 10)
('spam', 'This looks like a bot comment trying to promote something unrelated.', 3, 18, NOW() - INTERVAL 2 HOUR),

-- Report for commentId = 7 (Comment on newsId = 3)
('inappropriate_content', 'The comment contains offensive terms.', 4, 7, '2025-05-22 17:30:00'),

-- Report for commentId = 12 (Comment on newsId = 5)
('harassment', 'The user is making personal attacks.', 1, 12, '2025-05-24 19:00:00'),

-- Report for commentId = 20 (Reply to comment 19 on newsId = 10)
('spam', NULL, 2, 20, NOW() - INTERVAL 15 MINUTE);



-- Tạo bảng save_news
CREATE TABLE IF NOT EXISTS save_news (
    clientId BIGINT NOT NULL,
    newsId BIGINT NOT NULL,
    PRIMARY KEY (clientId, newsId),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (newsId) REFERENCES news(id) on delete cascade
);

-- Tạo bảng nearest_news
CREATE TABLE IF NOT EXISTS nearest_news (
    clientId BIGINT NOT NULL,
    newsId BIGINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (clientId, newsId),
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (newsId) REFERENCES news(id) on delete cascade
);

-- Tạo bảng notifications
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    clientId BIGINT NOT NULL,
    replierId BIGINT NOT NULL,
    newsURL TEXT NOT NULL,
    content TEXT NOT NULL,
    isRead BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (clientId) REFERENCES clients(id) on DELETE CASCADE,
    FOREIGN KEY (replierId) REFERENCES clients(id)
);

INSERT INTO notifications (id, clientId, replierId, newsURL, content) VALUES ('1', '1', '2', 'example.com', 'like');
INSERT INTO notifications (id, clientId, replierId, newsURL, content) VALUES ('2', '1', '3', 'example.com', 'comment');
