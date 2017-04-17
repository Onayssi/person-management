# person-management
A simple web based application that allow user to manage persons and members.
# Description
This application concerns the management of persons and members which handle the relevant CRUD operations. Built using Yii2 Framework.
###Master account for authentication:
The basic credentials for this application are set during the building. It's required to have them as the first time of use. Then when accessing the system, the master member (administrator) will be able to create and manage many accounts (with different roles) under the /Members tab. The credentials are mentioned below:
- Username: ```ounayssi```
- Password: ```tps001```

# Process
The application includes two roles, administrator (high level) and moderator (without managing members).
A member cans login by entering the username and password related to his account. An message notification will be appeared when an error is occurred (wrong credentials or blocking user).
When logging in (as an administrator), the member has access to the sections below:
- Manage Persons: The member has the capability to view (list) all persons already created. Therefore, he is able to add a new person, edit a current one and an existing one.
- Manage Profile: The member is able to update his password by accessing to this section. Only the administrators have the permissions to change usernames and emails for a specific member.
- About: The member is able to view the About section, which includes all settings, instructions and requirements for this application (like a guide).
- Manage Members: The user (administration role) is able to add a new members or edit info for an existing ones. The delete action for a member does not exist, alternatively, the administrator is able to deactivate a member by setting the status inactive. Sure, the user can re-activate a member any time.
- Logout: The member is able to sign out by accessing the logout tab, any time during the process of the activity, and he would be offline.

When logging in (as a moderator), the member has access to all sections above excepting the members section, which is accessible for the administration role only.
# Application Requirements
- PHP Version 5.5.x and greater
- Apache or Nginx Web Server
- MySQL Version 5.6.17 and greater
- PDO extension for MySQL must be loaded
- Online web server or local web server, e.g (XAMPP, WAMP, MAMP, LAMP)

#Application Settings
The application is running without pretty URLs, meaning, no need to enable the rewrite mode and related modules from the web server. 
To enable the pretty URLS, set the relevant parameter to true from the web file in configuration folder: ```'enablePrettyUrl' => true```.

### Mail Configuration:
The application uses swiftmailer vendor to send emails using SMTP protocol. The SMTP parameters are location inside the params.php in the configuration folder. This file contains all parameters required and needed for the application:
- adminEmail: The mail support (master), which mails are sending behalf it.
- smtp_hostname: The host name value (address) for the SMTP server.
- smtp_username: The user name value(access) for the SMTP server.
- smtp_password: The password value(security) for the SMTP server.
- mail_port: The port number (depends to the encryption) for the SMTP server (25,587, 465, 2525).
- mailNotification: Standard message which suppose to be sent to the relevant user when creating a new member.

The swift mailer configuration part is set for the web configuration file in the configuration folder, by setting the transport parameter with the global parameters of the mail configuration. The ```useFileTransport``` must be set to false in order to send a real mails.
### Database Configuration:
There is a relationship between Person and Language. Each Person has a one specific language which is set during the creation of a new member.

To set the database configuration (host, username and password), access the db.php file from the configuration folder, and set the proper parameters required.

# Copyright
Copyright (c) 2010 - 2017 Mouhamad Ounayssi.<br>
Blog: https://www.mouhamadounayssi.wordpress.com.
