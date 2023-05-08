docker-compose up -d --build

make init

http://localhost:8888

POST /api/push

GET /sensor/read/{ip} ip={IPv4 | IPv6}

GET /average/day/{day:\d+} day=int

GET /average/sensor/{ip} ip={IPv4 | IPv6 | UUID}

wget --no-check-certificate --quiet \
--method POST \
--timeout=0 \
--header 'Content-Type: text/plain' \
--body-data '{
"reading": {
"sensor_uuid": "cae3fbcc-b5fb-4dc9-af60-8b7096e76675",
"temperature": "12.34"
}
}' \
'localhost:8888/api/push'