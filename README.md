#View map
install composer packeage
composer require infomap/viewmap

add config/app.php in provider

 Infomap\Viewmap\ViewmapServiceProvider::class,

 also run in terminal

 composuer dump-autoload

then 
php artisan migrate