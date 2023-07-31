# DV Pay API

DV Pay API is a free and open-source cryptocurrency payment processor which allows you to accept cryptocurrency without fees or intermediaries.

<p align="center">
<img src="https://ibb.co/0QcrtDt/dv_logo.png" alt="payment-form" border="0">
</p>

## 🎨 Features

* Direct, peer-to-peer cryptocurrency payments
* No transaction fees (other than the network fee)
* No fees, middleman or KYC
* Non-custodial (complete control over the private key)
* Enhanced privacy & security
* Self-hosted
* Share your instance with friends (multi-tenant)
* Invoice management and Payment requests


## 💵 Support currency
- [x] Bitcoin 
- [x] USDT (TRC20) 
- [ ] ETH  
- [ ] USDT (ERC20)

## ⚙️ Requirements

* PHP ^8.1
* MySQL Percona 8.0+ 
* Redis
* Nginx

## 👨‍💻 Using Technology

Based on laravel framework with any popular laravel package 

## 🚀 How to install project:

### Manual installation with docker


```shell
    1. clone project
    2. cp .env.example .env
       cp .env.testing.example .env.testing
    3. docker network create merchant_backend_network
    4. docker-compose up -d
    5. docker-compose exec app composer install --ignore-platform-reqs
    6. docker-compose exec app php artisan key:generate
    7. docker-compose exec app php artisan migrate --seed
    8. docker-compose exec app php artisan cache:currency:rate
    9. docker-compose exec app php artisan processing:init
   10. docker-compose exec app php register:processing:owner
   11. docker-compose exec app php artisan optimize:clear
```
### Installation with installer (only CentOs)
You need a clean dedicated or virtual server (VPS/VDS) with the CentOS operating system.

There is no need to install a database or a webserver. The installation script will do it by itself.

Run the installation script as root user.

Before installation, you will need a processing service. You can install the processing on your server, or use ours (then specify its IP address during installation).

The installation will also require a domain name. Register it before starting the installation.

1. git clone git@github.com:RadgRabbi/dv-backend.git
2. cd ./dv-backend
3. ./init.sh

Or using command
```shell
bash <(curl -Ls https://raw.githubusercontent.com/RadgRabbi/dv-backend/master/init.sh)
```
