# InfoApplBulletinBoardBot
A PHP script which periodically checks new message in the bulletin board of informatica.uniurb.it website.



## Setup
The script have to be executed periodically as a cron job or using the Systemd framework (or the one you like the most).

### CronJob setup example
1. First of all you have to download the code into a local directory. We put the code under
        
        /var/www/public/
        
2. Then you need to create a directory to log script errors. We create a public ``log`` directory by typing 

        mkdir log

        chmod 777 log
        
3. Edit the Cron configuration file by typing 
        
        crontab -e
        
4. Finally add the following line 
      	
        */5 * * * * /usr/bin/php /var/www/public/InfoApplBulletinBoardBot/bot.php 2> /var/www/public/InfoApplBulletinBoardBot/log/errors.log
        
   Please note we used absolute paths.
   The cronjob will be executed every 5 minutes (the bot polling period).



