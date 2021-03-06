<?php
/**
 *
 *            sSSs   .S    S.    .S_sSSs     .S    sSSs
 *           d%%SP  .SS    SS.  .SS~YS%%b   .SS   d%%SP
 *          d%S'    S%S    S%S  S%S   `S%b  S%S  d%S'
 *          S%S     S%S    S%S  S%S    S%S  S%S  S%|
 *          S&S     S%S SSSS%S  S%S    d* S  S&S  S&S
 *          S&S     S&S  SSS&S  S&S   .S* S  S&S  Y&Ss
 *          S&S     S&S    S&S  S&S_sdSSS   S&S  `S&&S
 *          S&S     S&S    S&S  S&S~YSY%b   S&S    `S*S
 *          S*b     S*S    S*S  S*S   `S%b  S*S     l*S
 *          S*S.    S*S    S*S  S*S    S%S  S*S    .S*P
 *           SSSbs  S*S    S*S  S*S    S&S  S*S  sSS*S
 *            YSSP  SSS    S*S  S*S    SSS  S*S  YSS'
 *                         SP   SP          SP
 *                         Y    Y           Y
 *
 *                     R  E  L  O  A  D  E  D
 *
 * (c) 2012 Fetal-Neonatal Neuroimaging & Developmental Science Center
 *                   Boston Children's Hospital
 *
 *              http://childrenshospital.org/FNNDSC/
 *                        dev@babyMRI.org

 */

// prevent direct calls
if(!defined('__CHRIS_ENTRY_POINT__')) die('Invalid access.');

// include the utilities
require_once(dirname(__FILE__).'/controller/_util.inc.php');


// --------------------------------------------------------------------------
//
// GENERAL CONFIGURATION
//
// --------------------------------------------------------------------------

/**
 * The version.
 * It appears at the bottom of the home page.
 */
define('CHRIS_VERSION', '2.9-pre-release');
/**
 * The timezone.
 * It must be defined when we use getTime in php.
 */
define('CHRIS_TIMEZONE', 'America/New_York');
date_default_timezone_set(CHRIS_TIMEZONE);
/**
 * The maintenance mode.
 * If true, the users will not be able to use chris and will be presented the
 * maintenance page.
 */
define('CHRIS_MAINTENANCE', false);
/**
 * The chris' host machine.
 */
#define('CHRIS_HOST', 'chris-tido.tch.harvard.edu');
define('CHRIS_HOST', 'chris-tido');
/**
 * The chris user home directory.
 * We use it to find the chris user .ssh/id_rsa to allow passwordless ssh
 * between 2 instances of ChRIS.
 * We also use it in this configuration file as a base directory for all the
 * directories ChRIS relies on, such as 'src', 'users', 'log', etc.
 */
define('CHRIS_HOME', '/home/chris/');
/**
 * The transfer protocol.
 * We use it to generate the CHRIS_URL.
 * deprecated: Alos used to push a dicom scene to SliceDrop through the api.php.
 */
define('CHRIS_TRANSFER_PROTOCOL', 'https');
/**
 * The ChRIS url.
 * It is being used in several places, for instance when we want to send a curl
 * request to our ChRIS server, from the cluster where the job is running.
 */
#define('CHRIS_URL', CHRIS_TRANSFER_PROTOCOL.'://chris-tido.tch.harvard.edu');
define('CHRIS_URL', 'http://chris-tido');
/**
 * The ChRIS mail suffix.
 * When a user logs in for the first time, we assing him an email address.
 * The email address follows the format: username + CHRIS_MAIL_SUFFIX.
 * We use this address to contact user when a plugin has finished, etc.
 */
// admin email
define('CHRIS_MAIL_SUFFIX', '@tido.childrens.harvard.edu');
/**
 * The plugin email from field.
 * When a plugin finishes, it emails the user that started it.
 * When the user receives the email, this is what appears in the 'from' email
 * field.
 */
define('CHRIS_PLUGIN_EMAIL_FROM', 'plugin@chris-tido.tch.harvard.edu');
/**
 * The ChRIS source location.
 * This is the full name of the directory containing the ChRIS source code.
 * This directory contains the index.php file.
 */
define('CHRIS_SRC', joinPaths('src', 'chrisreloaded'));
/**
 * The ChRIS data location.
 * This is the full name of the directory containing the ChRIS data.
 * This directory contains all the data which has been received through the
 * dicom listener.
 * The contained data is organized by: MRN/STUDY/SERIES
 */
define('CHRIS_DATA', joinPaths(CHRIS_HOME, 'data'));
/**
 * The ChRIS tmp location.
 * This is the full name of the directory containing the ChRIS tmp data.
 * This directory contains the files received by the dicom listener, before
 * before being processed.
 * It also can contain the data sent from a remote ChRIS instance.
 *
 *
 * !!!! IMPORTANT !!!!
 *
 * It must be a LOCAL directory (NOT nfs mounted), to allow chris user to
 * change ownership and mode as root
 *
 */
define('CHRIS_TMP', '/tmp');
/**
 * The ChRIS users location.
 * This is the full name of the directory containing the ChRIS users data.
 * This directory contains all the data generated by the users running plugins.
 * The data is organized by: username/pluginname/feedid
 */
define('CHRIS_USERS', joinPaths(CHRIS_HOME, 'users'));
/**
 * The ChRIS log location.
 * This is the full name of the directory containing the ChRIS log information.
 * It can contain useful debug information.
 * It logs some of the user activity such as, new user creation and received
 * data.
 *
 * NONE OF THIS DATA IS SHARED WITH NSA
 */
define('CHRIS_LOG', joinPaths(CHRIS_HOME, 'log'));
/**
 * The ChRIS root directory name.
 * The name of the directory containing the index.php.
 */
define('CHRIS_WWWROOT', dirname(__FILE__));
/**
 * The model folder.
 * The location of the model folder, relative to the wwwroot directory.
 */
define('CHRIS_MODEL_FOLDER', joinPaths(CHRIS_WWWROOT,'model'));
/**
 * The view folder.
 * The location of the view folder, relative to the wwwroot directory.
 */
define('CHRIS_VIEW_FOLDER', joinPaths(CHRIS_WWWROOT,'view'));
/**
 * The template folder.
 * The location of the template folder, relative to the wwwroot directory.
 */
define('CHRIS_TEMPLATE_FOLDER', joinPaths(CHRIS_VIEW_FOLDER,'template'));
/**
 * The controller folder.
 * The location of the controller folder, relative to the wwwroot directory.
 */
define('CHRIS_CONTROLLER_FOLDER', joinPaths(CHRIS_WWWROOT,'controller'));
/**
 * The location of the library/tools provided by ChRIS, such as the mri_info.
 * Those libs are not used by the plugins but by ChRIS core infrastructure.
 * For instance, mri_info is being used by ChRIS dicom listener to order the
 * incoming files properly.
 */
define('CHRIS_LIB_FOLDER', joinPaths(CHRIS_WWWROOT,'lib'));
/**
 * The plugins folder.
 * The location of the plugins folder, relative to the wwwroot directory.
 */
define('CHRIS_PLUGINS_FOLDER', joinPaths(CHRIS_WWWROOT,'plugins'));
/**
 * The plugins folder.
 * The location of the plugins folder, relative to the file system root directory.
 */
define('CHRIS_PLUGINS_FOLDER_NET', joinPaths(CHRIS_SRC,'plugins'));
/**
 * The plugins folder.
 */
define('CHRIS_PLUGINS_FOLDER_RELATIVE', 'plugins');

// --------------------------------------------------------------------------
//
// DATABASE
//
// --------------------------------------------------------------------------

/**
 * The SQL Host name.
 * This is the name of the machine hosting the ChRIS database.
 */
define('SQL_HOST', 'chris-tido');
/**
 * The SQL Username.
 * This is the name of user we use to interact with the ChRIS database.
 * This user must have privileges on the target database.
 */
define('SQL_USERNAME', 'chris');
/**
 * The SQL User password.
 */
define('SQL_PASSWORD', 'chris1234');
/**
 * The SQL Database.
 * The name of the database which contains all the ChRIS information.
 */
define('SQL_DATABASE', 'chris');


// --------------------------------------------------------------------------
//
// DICOM LISTENER
//
// --------------------------------------------------------------------------

/**
 * The Dicom email to.
 * The list of administrators who should receive an email on incoming data
 * through the dicom listener.
 * It supports multiple users, i.e. 'rudolp@bch,nicolas@hcb,jorge@chb'
 */
define('CHRIS_DICOM_EMAIL_TO', 'rudolph.pienaar@childrens.harvard.edu');
/**
 * The Dicom email from.
 * The name of the database which contains all the ChRIS information.
 */
define('CHRIS_DICOM_EMAIL_FROM', 'dicom@chris-tido.tch.harvard.edu');
/**
 * The destination AETITLE.
 * The remote machine where the data will be pushed after a pacs_pull retrieval.
 */
define('DICOM_DESTINATION_AETITLE', 'FNNDSC-CHRIS');
/**
 * DCMTK binaries.
 * TODO: It should probably be sitting in the CHRIS/LIBS directory, with the
 * mri_convert.
 */
define('DICOM_DCMTK_FINDSCU', '/usr/bin/findscu');
define('DICOM_DCMTK_MOVESCU', '/usr/bin/movescu');
define('DICOM_DCMTK_ECHOSCU', '/usr/bin/echoscu');
/**
 * The ChRIS known scanners.
 * Convenience variable to also email the scanner administrator when something
 * was sent from his scanner.
 */
define('CHRIS_SCANNERS', serialize(array(
"MRC25948" => "borjan.gagoski@childrens.harvard.edu",
"MRWAL2" => "borjan.gagoski@childrens.harvard.edu",
"MR1" => "borjan.gagoski@childrens.harvard.edu")));


// --------------------------------------------------------------------------
//
// REMOTE CHRIS
//
// --------------------------------------------------------------------------

/**
 * The Remote ChRIS instances.
 * Contains all the necessary information to ssh/dicom_push to a remote host.
 * src is relative to the target host.
 * It requires a passwordless ssh connection for the chris user between the
 * remotes in order to work.
 */
define('CHRIS_REMOTES', serialize(array(
"MGH" => serialize(array(
    "sshhost" => "tautona",
    "sshport" => "1148",
    "dicomhost" => "tautona",
    "dicomport" => "10301",
    "src"  => "/home/chris/src/chrisreloaded")),
"BCH" => serialize(array(
    "sshhost" => "localhost",
    "sshport" => "22",
    "dicomhost" => "pretoria",
    "dicomport" => "10401",
    "src"  => "/neuro/users/chris/src/chrisreloaded")),
"MGHPCC" => serialize(array(
    "sshhost" => "chris-mghpcc",
    "sshport" => "22",
    "dicomhost" => "chris-mghpcc",
    "dicomport" => "10401",
    "src"  => "/home/chris/src/chrisreloaded")),
"CRIT" => serialize(array(
    "sshhost" => "chris-crit",
    "sshport" => "22",
    "dicomhost" => "chris-crit",
    "dicomport" => "10401",
    "src"  => "/home/chris/src/chrisreloaded")),
"CHPC" => serialize(array(
    "sshhost" => "chris-chpc",
    "sshport" => "22",
    "dicomhost" => "chris-chpc",
    "dicomport" => "10502",
    "src"  => "/home/chris/src/chrisreloaded"))
)));


// --------------------------------------------------------------------------
//
// USERS CONFIGURATION
//

/**
 * The user configuration directory.
 * This is the name of the directory that contains user specific documentation.
 * This directory is located in CHRIS_USERS/username/CHRIS_USERS_CONFIG_DIR
 */
define('CHRIS_USERS_CONFIG_DIR', 'config');
/**
 * The user configuration file.
 * This is the name of the file containing the user specific configuration.
 * This file is located in the user configuration directory.
 */
define('CHRIS_USERS_CONFIG_FILE', '.chris.conf');
/**
 * The user id rsa file.
 * This is a file generated on log in if it doesn't exist.
 * It allows user to perform passwordless ssh between different machine.
 * It is currently being used in crun (see mri_convert plugin).
 */
define('CHRIS_USERS_CONFIG_SSHKEY', 'id_rsa');


// --------------------------------------------------------------------------
//
// PLUGINS
//
// --------------------------------------------------------------------------

/**
 * The plugins which will run locally.
 * Those plugins will not be run on the cluster.
 * The main use case is if a plugins requires something that the cluster doesn't
 * provide, i.e. php5.
 */
define('CHRIS_RUN_AS_CHRIS_LOCAL', 'pacs_pull,search,pacs_push,chris_push');


// --------------------------------------------------------------------------
//
// CLUSTER
//
// --------------------------------------------------------------------------

/**
 * The cluster head machine.
 * We connect to this machine to schedule jobs on the cluster.
 * This is our *ONLY* way to communicate to the cluster.
 */
#define('CLUSTER_HOST', 'chris-compute');
define('CLUSTER_HOST', 'chris-tido');
/**
* The tunnel port through which we connect to the chris server from the cluster.
* This is by default 22 but if a tunnel is needed and it is set up then change it
* to the actual tunnel port.
 */
#define('CLUSTER_PORT', 22);
define('CLUSTER_PORT', 3333);
/**
 * The cluster type.
 * We specify the cluster type in order for crun to know how to handle the
 * communication.
 * Valid cluster types:
 * crun_hpc_mosix or crun_hpc_lsf or crun_hpc_launchpad or local
 */
define('CLUSTER_TYPE', 'crun_hpc_moc');
/**
 * Set this to true if the cluster shares the file system with the chris server.
 * It will improve performance by exploting the common file system.
 */
define('CLUSTER_SHARED_FS', false);
/**
 * Should dicom files be anonymized before sending them to the cluster?
 * If the answer is no then set this to false which will improve performance by
 * skipping the anonymization step.
 */
define('ANONYMIZE_DICOM', false);
/**
 * The ChRIS location on the cluster.
 * This is the full name of the cluster's directory containing the ChRIS deployment.
 */
define('CLUSTER_CHRIS', CHRIS_HOME);
/**
 * The ChRIS source location in the cluster.
 * This is the full name of the directory containing the ChRIS source code.
 */
define('CLUSTER_CHRIS_SRC', joinPaths(CLUSTER_CHRIS, 'src/chrisreloaded'));

// --------------------------------------------------------------------------
//
// CHRIS ENVIRNOMENT EXTRA SETUP
//
// --------------------------------------------------------------------------

/**
 * Path to be added to the default python path by chris.env.
 * It should be use to add python libraries that might be missing on the cluster.
 * It should only be related to the plugin.py or similar.
 * It shouldn't add any plugin specific library.
 */
 define('CHRIS_ENV_PYTHONPATH', joinPaths(CHRIS_HOME, 'lib', 'py'));


// --------------------------------------------------------------------------
//
// TESTING
//
// --------------------------------------------------------------------------

define('SIMPLETEST_CHRIS', joinPaths(CHRIS_WWWROOT,'testing/simpletest_chris.php'));
define('SIMPLETEST_HTML_CHRIS', joinPaths(CHRIS_WWWROOT,'testing/html_chris.php'));
define('SIMPLETEST_XML_CHRIS', joinPaths(CHRIS_WWWROOT,'testing/xml_chris.php'));
define('SIMPLETEST_SIMPLETEST', joinPaths(CHRIS_WWWROOT,'lib/simpletest/simpletest.php'));
define('SIMPLETEST_AUTORUN', joinPaths(CHRIS_WWWROOT,'lib/simpletest/autorun.php'));

// GOOGLE ANALYTICS
define('ANALYTICS_ACCOUNT', 'UA-39303022-1');

// if CHRIS_DEBUG is defined, print all constants
if(defined('CHRIS_CONFIG_DEBUG')) {
  $all_constants = get_defined_constants(true);
  print_r($all_constants['user']);
}

// setup phpseclib for SSH access
set_include_path(get_include_path() . PATH_SEPARATOR . joinPaths(CHRIS_LIB_FOLDER, 'phpseclib', 'phpseclib'));


// FLAG showing that the config was parsed
define('CHRIS_CONFIG_PARSED', true);


?>

