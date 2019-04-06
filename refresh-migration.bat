@echo off
echo Refreshing Migration
cd "%~dp0"
php artisan migrate:refresh --seed