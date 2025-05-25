drop database if exists hrm;

create database hrm;

use hrm;

-- Tạo bảng clients
CREATE TABLE IF NOT EXISTS clients (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fullName VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    isMute BOOLEAN DEFAULT FALSE,
    avatarUrl VARCHAR(255),
    isActive BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Nguyen Van A', '$2b$12$6xmtzoaFRg8vbTxMEpZnVOfgiLyEDUSswuehPZxO0mH3nwFriVHRm', 'a.nguyen@example.com', FALSE, 'url_avatar_a.jpg', TRUE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Tran Thi B', '$2b$12$.KPeHWFLAEdJdFBZBVP4pexgluTP9VcvW2CkjtiMC3eEQ1wui77hS', 'b.tran@example.com', TRUE, 'url_avatar_b.png', TRUE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Le Minh C', '$2b$12$RAN630EQ48vJeh.jfBSPfecgApI8Dot8ck/b6apNICCdywaS0GYpy', 'c.le@example.com', FALSE, NULL, FALSE);
INSERT INTO clients (fullName, password, email, isMute, avatarUrl, isActive) VALUES ('Pham Hoang D', '$2b$12$MAkBcLQSpQEX1rAVwchIaeNpzejUbdl6AZvAIOSbWF8bqoEcAhok6', 'd.pham@example.com', FALSE, 'url_avatar_d.gif', TRUE);

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

-- Tạo bảng comments
CREATE TABLE IF NOT EXISTS comments (
    id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    clientId BIGINT NOT NULL,
    content TEXT NOT NULL,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    like_count INT DEFAULT 0,
    commentId BIGINT,
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (commentId) REFERENCES comments(id) ON DELETE CASCADE
);

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

-- Tạo bảng comment_news
CREATE TABLE IF NOT EXISTS comment_news (
	newsId BIGINT NOT NULL,
	commentId BIGINT NOT NULL,
	PRIMARY KEY (newsId, commentId),
	FOREIGN KEY (newsId) REFERENCES news(id) ON DELETE CASCADE,
	FOREIGN KEY (commentId) REFERENCES comments(id) on delete cascade
);

-- Tạo bảng save_news
CREATE TABLE IF NOT EXISTS save_news (
    clientId BIGINT NOT NULL,
    newsId BIGINT NOT NULL,
    PRIMARY KEY (clientId, newsId),
    FOREIGN KEY (clientId) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (newsId) REFERENCES news(id) on delete cascade
);
