# Setting up Yii PHP with Vagrant - up and and running in 5 minutes  

This repository aims to have a simple vagrant project with yii 1.16 and all the tools necessary ready in a few minutes.

### Step 1

clone this repository and cd to the directory created.

### Step 2 (optional)

Edit 'Vagrantfile' and 'local-script.sh' to change the configuration if you need to change the project name and/or the ip address.

### Step 3

run the command:

	vagrant up

### Step 4

Edit `/etc/hosts` file, add:

    192.168.22.11 yii.local.com

### Final Step

open your browser and navigate to yii.local.com
to view the frontend of your application.


#Docs

## Components

- EWebUser.php
	user access management

- Util.php
	some utility functions to provide email and dbimport support

## Extensions

- giix
  advanced code generation   

- yii-mail
	advanced email library

- dumpdb

- EAjaxUpload
	Uploading files using ajax

## User Management

User registration flow already enabled with the following actions:

	/user/register
	/user/login
	/user/forgotpassword
	/profile/changePassword

Profile page, profile update etc ( /profile )

## MySQL

MySQL installed with user `root` password `root` @localhost


## MailCatcher

MailCatcher @ http://192.168.22.11:1080

MailCatcher settings:

    SMTP host: localhost
    SMTP port: 1025


## Credits

Thanks to [Lorenzo Ferrara](https://github.com/lorenzoferrarajr) for showing me the powerful Vagrant.
