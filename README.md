# DrupalEventBlock
custom block which will be displayed in the sidebar on event pages. 
The block display how many days are left until the event starts.
- I start working on demo project on 30.09.2018 at 20:00
- drupal instaled :
  composer create-project drupal-composer/drupal-project:8.x-dev my_site_name_dir --stability dev --no-interaction
- setup
- database replaced with agiledrop_dev_challenge_8.6.1.sql.tar
- I have some problems with importing database. 
- write .info.yml and MyBlock.php
- install modul and place block in sidebar 
- Creating a service and write a method which gets a date as a parameter and returns a value, which is then used to display correct string in the block.
- rendering events in .html.twig
- disabling cache
- creating repository 
- commiting/pushing code to repository 
