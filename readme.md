# Schedule plugin for wordress

A Plugin created by a request from a friend of mine
to easily let people schedule into a prayer chain schedule
on a wordpress website. You can find the plugin in the official store under the name [jih schedular](https://wordpress.org/plugins/jih-schedular/).

Contributions are welcome. On changes i'll role out a new version in the store.

I hope this code helps you create your wordpress plugin.
This repository does not require you to install PHP, Apache or any other php server software. It simply runs on docker. Run `docker-compose up`. Now in localhost you can go through the wordpress installation process and you will already see your plugins in de list of plugins of wordpress. you simply have to activated it.

## Run this project

* Install docker & docker-compose
* Run: `docker-compose up`
* Go through the wordpress installation process on `http://localhost:8080`
* In wp-admin go to plugins.
* Activate this plugin. 

Plugin is now active you can make changes and see the changes happen.

## How to release new version

After downloding the SVN repository. 
* Make sure: You updated version info in readme.txt and php comments in jih-schedular.php (main entry point).
* Overwrite trunk folder in SVN repository
* Create new folder in tags and place a copy of new version here as well