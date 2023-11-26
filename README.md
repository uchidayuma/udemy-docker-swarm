
## AWS CLIのインストール
### Windows(WSL2)
- sudo apt install unzip
- curl "https://awscli.amazonaws.com/awscli-exe-linux-x86_64.zip" -o "awscliv2.zip"
- unzip awscliv2.zip
- sudo ./aws/install
- aws --version

### Mac
- /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
- brew reinstall awscli
-  (echo; echo 'eval "$(/opt/homebrew/bin/brew shellenv)"') >> /Users/uchidayuma/.zprofile
- eval "$(/opt/homebrew/bin/brew shellenv)"
- aws --version

## 共通）Swarmクラスターの準備
### swarmuserのインラインポリシー
```
{
	"Version": "2012-10-17",
	"Statement": [
		{
			"Sid": "GetAuthorizationToken",
			"Effect": "Allow",
			"Action": "ecr:GetAuthorizationToken",
			"Resource": "*"
		},
		{
			"Sid": "PushPull",
			"Effect": "Allow",
			"Action": [
				"ecr:BatchGetImage",
                "ecr:BatchCheckLayerAvailability",
                "ecr:CompleteLayerUpload",
                "ecr:GetDownloadUrlForLayer",
                "ecr:InitiateLayerUpload",
                "ecr:PutImage",
                "ecr:UploadLayerPart"
			],
			"Resource": "*"
		}
	]
}
```
- aws configure list-profiles
- aws configure --profile swarmuser

### Mac)EC2にSSH接続
- mv udemy-swarm-node.pem .ssh
- ssh -i ~/.ssh/udemy-swarm-node.pem ec2-user@IPアドレス

### Dockerのインストール

1. sudo yum -y install docker
2. sudo systemctl start docker
3. sudo systemctl enable docker
4. sudo usermod -aG docker $USER
5. exit
6. 再度SSH
7. docker swarm init

## シングルクラスターの構築
### Dockerfile
```
FROM php:8.2-apache

WORKDIR /var/www
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install pdo_mysql mysqli zip opcache mbstring xml exif pcntl bcmath
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . /var/www/
COPY simple-swarm/sites-available /etc/apache2/sites-available
COPY simple-swarm/cacert.pem /etc/ssl/cert.pem
COPY .env.production .env

ENV COMPOSER_ALLOW_SUPERUSER 1
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --no-suggest
RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www
RUN a2enmod rewrite

EXPOSE 80
```

### 000-default.conf
```
<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/public

    <Directory /var/www/public>
        AllowOverride All
        Require all granted
        Options -Indexes
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### .dockerignore
```
storage/logs/*
bootstrap/cache/*
```
