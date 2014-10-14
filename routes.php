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



/**
 *  Place particular routes before generic ones. 
 *  Routes resolving to any http method will be processed after particular method ones.
 */

\Core\Routes::add('/^\/welcome(?:\/(.*?))*$/i', 'home', 'welcome', \Core\Routes::ANY);

\Core\Routes::add('/^\/$/i', 'home', 'welcome', \Core\Routes::ANY);

\Core\Routes::add('/^\/address\/(?:([0-9]*?)(:?\.(json))?)$/i', 'task2', 'address', \Core\Routes::GET);

\Core\Routes::add('/^\/addresses(:?\.(json))?$/i', 'task2', 'addresses', \Core\Routes::GET);
//\Core\Routes::add('/^\/addresses(?:\/)*$/i', 'task2', 'addresses', \Core\Routes::GET);


\Core\Routes::add('/^\/t3\/address(?:\/([0-9]*?))?\/form(:?\.(json))?$/i', 'task3', 'form', \Core\Routes::GET);
\Core\Routes::add('/^\/t3\/address(?:\/([0-9]*?)(:?\.(json)))*$/i', 'task3', 'index', \Core\Routes::GET);

