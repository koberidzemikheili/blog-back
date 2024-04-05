
# Blog back

git clone https://github.com/koberidzemikheili/blog-back.git

cd blog-back

composer install

cp .env.example .env

now setup mysql connection in .env file

php artisan migrate --seed

if you want to run tests use (php artisan test --testsuite=Unit) but after tests are done write (php artisan db:seed)

php artisan serve

There are 3 users 1 admin and 2 editors initially created from seeder

Credentials:

Admin: email:
admin@example.com password: password

editor: email:
editor@example.com password: password

editor: email:
secondeditor@example.com password: password

normal users can be created through registration form 
