# Sử dụng image PHP 7.4-fpm làm base image
FROM php:7.4-fpm

# Cập nhật danh sách package và cài đặt các dependencies cần thiết
# git: Dùng để clone repository hoặc quản lý version control
# curl: Dùng để tải file từ URL
# libpng-dev: Thư viện hỗ trợ xử lý ảnh PNG
# libonig-dev: Thư viện hỗ trợ regular expressions cho mbstring
# libxml2-dev: Thư viện hỗ trợ xử lý XML
# zip, unzip: Dùng để nén và giải nén file
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Cài đặt Composer (trình quản lý dependency cho PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt các PHP extensions cần thiết cho Laravel hoặc các ứng dụng PHP khác
# pdo_mysql: PHP Data Objects extension cho MySQL
# mbstring: Hỗ trợ xử lý chuỗi multi-byte (ví dụ: UTF-8)
RUN docker-php-ext-install pdo_mysql mbstring

# Thiết lập thư mục làm việc bên trong container
WORKDIR /app

# Sao chép file composer.json (và composer.lock nếu có) vào thư mục làm việc
# Điều này giúp tận dụng Docker cache. Nếu composer.json không thay đổi, bước RUN composer install sẽ không chạy lại.
COPY composer.json ./

# Cài đặt các dependencies của dự án PHP bằng Composer
# --no-scripts: Không chạy các script được định nghĩa trong composer.json (ví dụ: post-install-cmd)
RUN composer install --no-scripts

# Sao chép toàn bộ mã nguồn của ứng dụng vào thư mục làm việc
COPY . .

# Chạy lệnh để khởi động ứng dụng Laravel (hoặc ứng dụng PHP tương tự)
# php artisan serve: Lệnh mặc định để chạy development server của Laravel
# --host=0.0.0.0: Cho phép server lắng nghe request từ bất kỳ IP nào (quan trọng khi chạy trong Docker)
# --port=80: Chỉ định port mà server sẽ chạy (port 80 là port HTTP mặc định)
CMD php artisan serve --host=0.0.0.0 --port=80
