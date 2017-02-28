<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?> the application</h1>

    <p>
        This is similar to a ReadMe File, including instructions and requirements for this application.
    </p>
 
    <p>
        This application concerns the management of persons and members which handle the relevant CRUD operations.
    </p>
    
    <p>
        This application is built using Yii2 Framework. It's an advanced high level MVC approach. Please, visit the official site 
        of <a target="_blank" href='<?=Url::to('http://www.yiiframework.com');?>'>Yii Framework</a> for more information.
    </p>

    <h4>Basic account for authentication (Master Administrator):</h4>
    
    <p>
        The basic credentials for this application are set during the building. It's required to have them as the first time of use. Then when accessing
        the system, the master member (administrator) will be able to create and manage many accounts (with different roles) under the <code>/Members</code> tab.
        The credentials are mentioned below:
    <ul>
        <li><strong>Username</strong>: <code>ounayssi</code></li>
        <li><strong>Password:</strong>: <code>tps001</code></li>
    </ul>
    </p>
    
    <h4>Process:</h4>
    The application includes two roles, administrator (high level) and moderator (without managing members).<br />
    A member cans login by entering the username and password related to his account. An message notification will be appeared
    when an error is occurred (wrong credentials or blocking user).<br />
    <p>When logging in (as an administrator), the member has access to the sections below:</p>
        <ul>
            <li>
                <strong>Manage Persons</strong>: 
                The member has the capability to view (list) all persons already created. Therefore, he is able to add a new person, edit a current one and
                an existing one.
            </li>
            <li>
                <strong>Manage Profile</strong>: 
                The member is able to update his password by accessing to this section. Only the administrators have 
                the permissions to change usernames and emails for a specific member.
            </li>
            <li>
                <strong>About</strong>: 
                The member is able to view the About section, which includes all settings, instructions and requirements 
                for this application (like a guide).
            </li> 
            <li>
                <strong>Manage Members</strong>: 
                The user (administration role) is able to add a new members or edit info for an existing ones.
                The delete action for a member does not exist, alternatively, the administrator is able to deactivate a member 
                by setting the status <code>inactive</code>. Sure, the user can re-activate a member any time.
            </li>   
            <li>
                <strong>Logout</strong>: 
                The member is able to sign out by accessing the logout tab, any time during the process of the activity, 
                and he would be offline.
            </li>             
        </ul>
        When logging in (as a moderator), the member has access to all sections above excepting the members section, which is accessible 
        for the administration role only.
    <p>
        
    </p>
    
    <h4>Application Requirements:</h4>
    
    <ul>
        <li>PHP Version 5.5.x and greater</li>
        <li>Apache or Nginx Web Server</li>
        <li>MySQL Version 5.6.17 and greater</li>
        <li>PDO extension for MySQL must be loaded</li>
        <li>Online web server or local web server, e.g (XAMPP, WAMP, MAMP, LAMP)</li>
    </ul>
    
    <h4>Application Settings:</h4>
        
    <p>
        The application is running without pretty URLs, meaning, no need to enable the rewrite mode and related modules from the web server.
        To enable the pretty URLS, set the relevant parameter to true from the web file in configuration folder: <code>'enablePrettyUrl' => true</code>.
    </p>
    
    <h4>Mail Configuration:</h4>
    
    <p>
        The application uses <strong>swiftmailer</strong> vendor to send emails using SMTP protocol. 
        The SMTP parameters are location inside the <code>params.php</code> in the configuration folder.
        This file contains all parameters required and needed for the application:
        <ul>
            <li><code>adminEmail</code>: The mail support (master), which mails are sending behalf it.</li>
            <li><code>smtp_hostname</code>: The host name value (address) for the SMTP server.</li>
            <li><code>smtp_username</code>: The user name value(access) for the SMTP server.</li>
            <li><code>smtp_password</code>: The password value(security) for the SMTP server.</li>
            <li><code>mail_port</code>: The port number (depends to the encryption) for the SMTP server (25,587, 465, 2525).</li>
            <li><code>mailNotification</code>: Standard message which suppose to be sent to the relevant user when creating a new member.</li>
        </ul>
    </p>
    
    <p>
        The swift mailer configuration part is set for the web configuration file in the configuration folder, by setting the
        <code>transport </code> parameter with the global parameters of the mail configuration.
        The <code>useFileTransport</code> must be set to false in order to send a real mails.
    </p>
    
    <h4>Database Configuration:</h4>
        The database built of this application uses MySQL Driver with PDO extension. The SQL file provided contains three main
        tables:
        <ul>
            <li><code>persons</code>: Represents the Person entity with relationship. Basic Fields are mentioned below:
                <ol>
                    <li><code>first_name</code>: First Name</li>
                    <li><code>last_name</code>: Last Name</li>
                    <li><code>mobile</code>: Mobile Number</li>
                    <li><code>email</code>: Email address</li>
                    <li><code>lang</code>: Language</li>
                    <li><code>date_of_birth</code>: Date of Birth</li>
                </ol>
            </li>
            <li><code>members</code>: Represents the Member entity, users of the application. Basic Fields are mentioned below:
                <ol>
                    <li><code>username</code>: User Name</li>
                    <li><code>email</code>: Email Address of the member</li>
                    <li><code>password_hash</code>: Encrypted Password  of the account</li>
                    <li><code>role</code>: Permission, the system contains two roles, 'Administrator' and 'Moderator'</li>
                    <li><code>active</code>: Status of member (active or blocked)</li>
                </ol>            
            </li>
            <li><code>languages</code>: Represents the language entity, list of languages set in a table rather then make it static. of the application. Basic Fields are mentioned below:
                <ol>
                    <li><code>language</code>: title of language as a string word</li>
                    <li><code>code</code>: Universal ISO 639-2 Code of language</li>
                    <li><code>active</code>: Enable or disable a language</li>
                </ol>              
            </li>
        </ul>
        
        <p>
            There is a relationship between Person and Language. Each Person has a one specific language which is set during the 
            creation of a new member.
        </p>
        
        <p>
            To set the database configuration (host, username and password), access the <code>db.php</code> file from the configuration folder,
            and set the proper parameters required.
        </p>
        
        <h4>Indication for Rest Service API:</h4>
        <p>
            Because we handled the application as a global approach for front end and back end, meaning, we used PHP in both side,
            and because the system requires a member login (authentication) for accessibility, we have to manage a new part 
            for exposing the Person management as a REST Service API, from different domains, by using JWT or an authentication key 
            by the headers request for making requests. Example of REST call for this application:
            <ul>
                <li>
                    <code>/GET</code> /persons: Get list of all persons in the system
                </li>
                <li>
                    <code>/GET</code> /person/{id}: Get info of person that having <code>id={id}</code>
                </li>
                <li>
                    <code>/POST</code> /person/add: Add a new person to the system<br />
                    <p><u>Request Body</u>:</p>
                    <pre><?=(json_encode(array(
                            "first_name"=>"VALUE",
                            "last_name"=>"VALUE",
                            "mobile"=>"VALUE",
                            "email"=>"VALUE",
                            "lang"=>"VALUE",
                            "date_of_birth"=>"VALUE"
                        ),JSON_PRETTY_PRINT))?>
                    </pre>                                   
                </li>
                <li>
                    <code>/POST</code> /person/edit: Update the person with <code>id={id}</code> in request body
                    <p><u>Request Body</u>:</p>
                    <pre><?=(json_encode(array(
                            "id"=>"{id}",
                            "first_name"=>"VALUE",
                            "last_name"=>"VALUE",
                            "mobile"=>"VALUE",
                            "email"=>"VALUE",
                            "lang"=>"VALUE",
                            "date_of_birth"=>"VALUE"
                        ),JSON_PRETTY_PRINT))?>
                    </pre>                    
                </li>
                <li>
                    <code>/POST</code> /person/delete: delete the person with <code>id={id}</code> in request body
                    <p><u>Request Body</u>:</p>
                    <pre><?=(json_encode(array(
                            "id"=>"{id}"
                        ),JSON_PRETTY_PRINT))?>
                    </pre>                    
                </li>
            </ul>
        </p>
</div>
