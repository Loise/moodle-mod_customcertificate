<?php

/**
 * Language strings for the customcertificate module
 *
 * @package    mod
 * @subpackage customcertificate
 * @copyright  Carlos Alexandre S. da Fonseca <carlos.alexandre@outlook.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


//-----
$string['modulename'] = 'Custom Certificate';
$string['modulenameplural'] = 'Custom Certificates';
$string['pluginname'] = 'Custom Certificate';
$string['viewcertificateviews'] = 'View {$a} issued certificates';
$string['summaryofattempts'] = 'Summary of Previously Received Certificates';
$string['issued'] = 'Issued';
$string['coursegrade'] = 'Course Grade';
$string['getcertificate'] = 'Get your certificate';
$string['awardedto'] = 'Awarded To';
$string['receiveddate'] = 'Date Received';
$string['grade'] = 'Grade';
$string['code'] = 'Code';
$string['report'] = 'Report';
$string['hours'] = 'hours';
$string['keywords'] = 'certificate, course, pdf, moodle';
$string['pluginadministration'] = 'Certificate administration';
$string['awarded'] = 'Awarded';
$string['deletissuedcertificates'] = 'Delete issued certificates';
$string['nocertificatesissued'] = 'There are no certificates that have been issued';

//Form
$string['certificatename'] = 'Certificate Name';
$string['certificateimage'] = 'Certificate Image File';
$string['userphoto'] = 'Certificate User Photo File';
$string['certificatetext'] = 'Certificate Text';
$string['certificatetextx'] = 'Certificate Text Horizontal Position';
$string['certificatetexty'] = 'Certificate Text Vertical Position';
$string['introcertificatetext'] = 'Introduction Certificate Text';
$string['introcertificatetextx'] = 'Introduction Certificate Text Horizontal Position';
$string['introcertificatetexty'] = 'Introduction Certificate Text Vertical Position';
$string['conclucertificatetext'] = 'Conclusion Certificate Text';
$string['conclucertificatetextx'] = 'Conclusion Certificate Text Horizontal Position';
$string['conclucertificatetexty'] = 'Conclusion Certificate Text Vertical Position';
$string['height'] = 'Certificate Height';
$string['width'] = 'Certificate Width';
$string['coursehours'] = 'Hours in course';
$string['coursename'] = 'Alternative Course Name';
$string['intro'] = 'Introduction';
$string['printoutcome'] = 'Print Outcome';
$string['printdate'] = 'Print Date';

////Date options
$string['issueddate'] = 'Date Issued';
$string['completiondate'] = 'Course Completion';
$string['datefmt'] = 'Date Format';

////Date format options
$string['userdateformat'] = 'User\'s Language Date Format';

$string['printgrade'] = 'Print Grade';
$string['gradefmt'] = 'Grade Format';
////Grade format options
$string['gradeletter'] = 'Letter Grade';
$string['gradepercent'] = 'Percentage Grade';
$string['gradepoints'] = 'Points Grade';
$string['coursetimereq'] = 'Required minutes in course';
$string['addphoto'] = 'Add photo to certificate';
$string['addphotox'] = 'User photo Horizontal Position';
$string['addphotoy'] = 'User photo Vertical Position';
$string['addphotowidth'] = 'User photo width';
$string['addphotoheight'] = 'User photo height';



////Form options help text

$string['certificatename_help'] = 'Certificate Name';
$string['certificatetext_help'] = 'This is the text that will be used in the certificate back, some special words will be replaced with variables such as course name, student\'s name, grade ...
These are:

{USERNAME} -> Full user name
{COURSENAME} -> Full course name (or a Defined alternate course name)
{GRADE} -> Formated Grade
{DATE} -> Formated Date
{OUTCOME} -> Outcomes
{HOURS} -> Defined hours in course
{TEACHERS} -> Teachers List
{IDNUMBER} -> User id number
{FIRSTNAME} -> User first name        
{LASTNAME} -> User last name        
{EMAIL} -> User e-mail        
{ICQ} -> User ICQ        
{SKYPE} -> User Skype        
{YAHOO} -> User yahoo messenger        
{AIM} -> User AIM        
{MSN} -> User MSN        
{PHONE1} -> User 1° Phone Number        
{PHONE2} -> User 2° Phone Number        
{INSTITUTION} -> User institution        
{DEPARTMENT} -> User department        
{ADDRESS} -> User address
{CITY} -> User city
{COUNTRY} -> User country
{URL} -> User Home-page
{PROFILE_xxxx} -> User custom profile fields

In order to use custom profiles fields you must use "PORFILE_" prefix, for example: you has created a custom profile with shortname of "birthday," so the text mark used on certificate must be {PROFILE_BIRTHDAY} 
The text can use basic html, basic fonts, tables,  but avoid any position definition';
$string['introcertificatetext_help'] = 'This is the text that will be used in the certificate back, some special words will be replaced with variables such as course name, student\'s name, grade';
$string['conclucertificatetext_help'] = 'This is the text that will be used in the certificate back, some special words will be replaced with variables such as course name, student\'s name, grade';
$string['textposition'] = 'Certificate Text Position';
$string['textposition_help'] = 'These are the XY coordinates (in millimeters) of the certificate text';
$string['size'] = 'Certificate Size';
$string['size_help'] = 'These are the Width and Height size (in millimeters) of the certificate, Default size is A4 Landscape';
$string['coursehours_help'] = 'Hours in course';
$string['coursename_help'] = 'Alternative Course Name';
$string['userphoto_help'] = 'This is the picture that will be used like the user photo in the certificate';
$string['certificateimage_help'] = 'This is the picture that will be used in the certificate';

$string['printoutcome_help'] = 'You can choose any course outcome to print the name of the outcome and the user\'s received outcome on the certificate.  An example might be: Assignment Outcome: Proficient.';
$string['printdate_help'] = 'This is the date that will be printed, if a print date is selected. If the course completion date is selected but the student has not completed the course, the date received will be printed. You can also choose to print the date based on when an activity was graded. If a certificate is issued before that activity is graded, the date received will be printed.';
$string['datefmt_help'] = 'Enter a valid PHP date format pattern (http://www.php.net/manual/en/function.strftime.php). Or, leave it empty to use the format of the user\'s chosen language.';
$string['printgrade_help'] = 'You can choose any available course grade items from the gradebook to print the user\'s grade received for that item on the certificate.  The grade items are listed in the order in which they appear in the gradebook. Choose the format of the grade below.';
$string['gradefmt_help'] = 'There are three available formats if you choose to print a grade on the certificate:

Percentage Grade: Prints the grade as a percentage.
Points Grade: Prints the point value of the grade.
Letter Grade: Prints the percentage grade as a letter.';

$string['coursetimereq_help'] = 'Enter here the minimum amount of time, in minutes, that a student must be logged into the course before they will be able to receive the certificate.';
$string['addphoto_help'] = 'If you choose this option, students are forced to upload their photo to get their certificate.';

$string['designoptions'] = 'Design Options';


//Admin settings page
$string['defaultwidth'] = 'Default Width';
$string['defaultheight'] = 'Default Height';
$string['defaultcertificatetextx'] = 'Default Hotizontal Text Position';
$string['defaultcertificatetexty'] = 'Default Vertical Text Position';
$string['defaultintrocertificatetextx'] = 'Default Introduction Hotizontal Text Position';
$string['defaultintrocertificatetexty'] = 'Default Introduction Vertical Text Position';
$string['defaultconclucertificatetextx'] = 'Default Conclusion Hotizontal Text Position';
$string['defaultconclucertificatetexty'] = 'Default Conclusion Vertical Text Position';

$string['defaultaddphotox'] = 'Default Hotizontal User Photo Position';
$string['defaultaddphotoy'] = 'Default Vertical User Photo Position';
$string['defaultaddphotowidth'] = 'Default User photo width';
$string['defaultaddphotoheight'] = 'Default User photo height';

$string['link'] = 'this link';

//Erros
$string['filenotfound'] = 'File not Found: {$a}';
$string['invalidcode'] = 'Invalid certificate code';
$string['cantdeleteissue'] = 'Error removing issued certificates';


//Verify certificate page
$string['certificateverification'] = 'Certificate Verification';

//Adding photo certificate page
$string['certificateaddphoto'] = 'Add your identify photo';
$string['unknowchar'] = 'The name of your file contains special characters, thank you to fix that and try again.';
$string['emailvalidationphotosubject'] = '[Moodle] A user need a validation of photo !';
$string['emailvalidationphotolink'] = 'You can validate the users photos here : ';
$string['emailvalidationphotolinkhtml'] = 'You can validate the users photos at ';

//Pending certificate page
$string['pendingcertificate'] = 'Pending the validation';
$string['pending'] = 'Your picture is being validated, please wait.';

//Save certificate page
$string['savecertificate'] = 'Get an archive';
$string['archivefinished'] = 'The archive is completed, you can get it at ';
$string['archiveerror'] = 'There are an error in the creation of the archive, please retry antoher time';

//Validation certificate page
$string['validationcertificate'] = 'Validation of user\'s photo';
$string['emailvalidatedphotosubject'] = '[Moodle] Your photo is validated !';
$string['emailvalidatedphotolink'] = 'You can get your certificate at this link: ';
$string['emailvalidatedphotolink'] = 'You can get your certificate at ';
$string['refresh'] = 'Please refresh the page for anoher validation.';
$string['photovalidated'] = 'These photo are validated: ';
$string['permissiondenied'] = 'You don\'t have the permission for access at this page.';

//Menu
$string['validationlink'] = 'Validation pictures of students';
$string['verificationlink'] = 'Verification of certificate';
$string['archivelink'] = 'Archive';

//Settings
$string['certlifetime'] = 'Keep issued certificates for: (in Months)';
$string['certlifetime_help'] = 'This specifies the length of time you want to keep issued certificates. Issed certificates that are older than this age are automatically deleted.';
$string['neverdeleteoption'] = 'Never delete';

$string['variablesoptions'] = 'Others Options';
$string['getcertificate'] = 'Get Certificate';
$string['verifycertificate'] = 'Verify Certificate';



$string['customcertificate'] = 'Verification for custom certificate code';
$string['customcertificate:addinstance'] = 'Add a custom certificate instance';
$string['customcertificate:manage'] = 'Manage a custom certificate instance';
$string['customcertificate:printteacher'] = 'Be listed as a teacher on the custom certificate if the print teacher setting is on';
$string['customcertificate:student'] = 'Retrieve a custom certificate';
$string['customcertificate:view'] = 'View a custom certificate';

