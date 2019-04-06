@echo off
cd "%~dp0"
echo Running Redis
start cmd /k Redis\Windows\Redis-x64-3.2.100\redis-server.exe
echo Running Node Server
start cmd /k node server.js