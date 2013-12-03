Websms
======

Application for sending sms messages

<h3>Installation:</h3>

Update dependencies: 

<code>php composer.phar update</code>

Create database:

<code>php app/console doctrine:database:create</code>

Update database:

<code>php app/console doctrine:schema:update --force</code>

Ensure permissions for logs and cache:

<code>chmod 777 app/cache/ -R</code>

<code>chmod 777 app/logs/ -R</code>
