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


$CONFIG['path'] = __DIR__;


include_once($CONFIG['path'].'/config.php');

if(file_exists($CONFIG['path'].'/config_overide/config.php')){
	include_once($CONFIG['path'].'/config_overide/config.php');
}

ini_set('display_errors', (bool) $CONFIG['debug']);

include_once($CONFIG['path'].'/core/autoload.php');

$cli = (isset($cli)? $cli : false);

$application = new \Core\Application;

$application->start($cli);