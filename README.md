# php-lxd-dns
This PHP script allows you to run a DNS server to resolve your LXD container 
host names to their IP addresses. This is not possible out of the box because 
the dns server provided by LXD *dnsmasq* is not able to resolve IPv6 adresses properly.

## Usage
This project uses [composer](https://getcomposer.org/doc/00-intro.md) for dependency 
management. With Debian/Ubuntu, you can get composer by executing `apt install composer`.

To run the dns server, use the following commands: 
```
git clone THIS_REPO_URL
composer install
./build.sh
 
sudo php php-lxd-dns.phar
```

Now the project is packaged into one `.phar` file, 
which you can copy anywhere you want.

*Hint: When you are in the project directory, you can also just run `sudo php index.php`.*