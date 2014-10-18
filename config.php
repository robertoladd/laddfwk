<?

//    Copyright (C) 2014  Roberto Ladd 
//    https://github.com/robertoladd/laddfwk
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.


$CONFIG['debug']=false;

$CONFIG['error_logging']='both';//available email, file or both values. Leave empty for no logging.

$CONFIG['error_logging_email']='testfwkerror@yopmail.com';//email used for error notifications. Only used when error_logging is email or both.

$CONFIG['from_email'] = 'laddfwk <laddfwk@localhost>';//From address used for sending system emails.

$CONFIG['wwwroot']='http://localhost';//without ending slash

$CONFIG['db_driver']='mysql';

$CONFIG['db_driver_config']=array(
    'username' => 'root',
    'password' => 'root',
    'host' => 'localhost',
    'port' => '3306',
    'database' => 'laddfwk',
);
