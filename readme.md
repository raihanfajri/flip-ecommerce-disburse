# Recruitment Mini Project Installation 

Change .env-dist according to your local environtment.

Execute these commands on your terminal.

```
cd pathtoproject/flip-ecommerce-disburse
```

## Docker

### Install MYSql

```
docker pull mysql
docker run --name mysql-server -e MYSQL_ROOT_PASSWORD=password --expose=33006 -p 33006:3306 mysql
```

### Create Project Image

```
docker image rm flip-ecommerce-disburse --force
docker build -t flip-ecommerce-disburse .
docker container rm flip-ecommerce-disburse --force 
docker run -d --name flip-ecommerce-disburse -v pathtoproject/flip-ecommerce-disburse/logs/:/var/www/html/logs/ --expose=3005 -p 3005:80 --restart unless-stopped flip-ecommerce-disburse
docker exec flip-ecommerce-disburse cron
```

Open localhost:3005 on your local web browser.
Submit the data that you want to disbursed and click submit.

Refresh the list every minute at minimum to check the updated disburse status.