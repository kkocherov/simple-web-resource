docker build -t pomidorki-php -f Dockerfile.php .
docker build -t pomidorki-nginx -f Dockerfile.nginx .

docker run -it -p 8080:80 --network pomidorki-network --name pomidorki-nginx --rm  pomidorki-nginx:latest
docker run -it  --network pomidorki-network --name pomidorki-php --rm  pomidorki-php:latest