## Start Up and set up docker via command line

- Copy the .env.example to .env

- docker-compose up
- docker-compose exec php php artisan key:generate
- docker-compose exec php php artisan optimize
- docker-compose exec php composer install
- docker-compose exec php composer dump-autoload
- docker-compose exec php php artisan db:seed
- docker-compose exec front-end npm install
- docker-compose exec front-end npm run build

## Remove file (if exist)

- In the public folder directory, delete the file name 'Hot' (it appears whenever 'npm run dev' is runned and messes up the vite css and js imported files)

## Browser url

- Access the webpage using 127.0.0.1 as the URL in the browser and the page will default to the customer dashboard
- You will be able to add, edit, delete, and load customer data.
