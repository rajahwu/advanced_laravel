composer create-project laravel/laravel:^11.0 mygym
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
npm install
npm run dev