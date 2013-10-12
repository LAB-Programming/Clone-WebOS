Clone-WebOS for pcDuino
===========


##Description:

###Introduction

   Today, we live in a world dominated by cloud computing where most of the things we do are done on
   someone else's servers, and the desktop as we knew it no longer exists. The only issue problem running
   everything over the web is that you don't know where your data is or who has it! Despite this, it is
   still convinient to run a OS over the web and run every thing on a think client, so you don't need
   a powerfull computer. Clone-WebOS is a trade off of between a Cloud based OS and a Localy hosted OS
   in that every things is run though one server but it is run localy on your network and if you were
   to get another computer it does not need to powerful; it can be a thin client that connects to the
   server that runs Clone-WebOS. Another limiting thing about Cloud OS's is that you can not realy do
   what you want with them such as write code, modify the OS itself, however with Clone WebOS, your OS
   is run localy, so you can do any thing that you what with your server, and the software is open sorce.
   This version of Clone WebOS comes with special features for use on a <a href="http://www.pcduino.com/">pcDuino</a>
   
###How the OS works

   Clone WebOS is basically a website. To run, it needs a LAMP server (*L*inux, *A*pache, *M*ySQL, *P*HP) on the server. 
   It can work with any client with a modern web browser and an internet connection. The main technologies used 
   in Clone WebOS are:
   
   - php
   - javascript
   - jquery
   - html
   - css
 
   You interact with the OS just like you would a web site. The way Clone WebOS is designed, each app is a webpage, and
   there is a dynamically-generated webpage that links all of the apps together and deals with authenticating logins
   and stuff like that.  

##Writing Apps

###Introduction

   In Clone WebOS every app is it's own seporite web app. you can write you web app in php javascript or it could 
   even be just a html file. you can get data about the user via a session varuable (in php) so you can make
   dinamic apps that are diffrent for each user. 
   
###How to add an app to the system
   
   An app, in Clone WebOS, is a web page.  To add an app to the system, you put the icon in home/bin/icons, and put
   the rest of the files in the app's folder in the bin folder. Then, you have to add the app to the apps array in 
   the apps.xml file. The entry for an app should look somewhat like this:
      
      <app>
         <displayName>My Fancy New App!</displayName>
         <name>my-fancy-app</name>
         <url>appfolder/app.filetype</url>
         <icon>icons/app_icon.png</icon>
      </app>
   


