
# Test CRUD TKDN

by Arfan Zarkasi:

Running using docker, you must be have docker engine on your system


## Deployment

To deploy this project run

```bash
  docker compose up -d --build
```

after complete build, do migration database:
```bash
  docker exec -it test-arfan-crud-api sh -c "php artisan migrate"
```

and then You can access 
API via: http://localhost:8080/api and frontend CRUD via http://localhost:8081


## Documentation

[Documentation](https://api.postman.com/collections/5544789-af49420a-6e0d-445c-a4b1-d1e45ec87df5?access_key=PMAT-01GSVX5E5PXCMZK0KBNKSF7MCQ)

