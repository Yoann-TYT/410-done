# 410-done

## Step 1: No cache
```shell
git checkout step-1-with-no-cache
docker-compose up --build --force-recreate
```

## Step 2: Cache on Redis
```shell
git checkout step-2-with-cache-on-redis
docker-compose up --build --force-recreate
```

## Step 3: Using Reverse Proxy
```shell
git checkout step-3-with-reverse-proxy
docker-compose up --build --force-recreate
```