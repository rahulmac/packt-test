## Installation steps
- after cloning the project follow below steps
- create .env file from .env.example file
- go to project directory or folder
- run *composer install* to install packages and libraries
- generate key using *php artisan key:generate* command
- run *npm install* to install node required pacakges
- after npm install - run command *npm run dev* to generate mix files 
- after that start laravel server using *php artisan serve command* or we can create virtual host file as well
- Below parameters are needed to declare 
    MIX_PACKET_API=https://api.packt.com/api/v1/
    MIX_API_TOKEN=rrd0wATTLPfAHX9pqbqT4XUIx729VZI21w0iuWG1
    MIX_APP_URL= this needs to be the url of laravel project
    
    
## pending items
- need to work on pagiantion design fixes
