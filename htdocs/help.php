<?php
//The following three lines provide the variables that incTemplate.php will use to create the page header, menu, and sidebar
$pagetitle="Configuration Help";
$headline="<h1>Configuration Help</h1>";
$top_help_text="";
include ('Hydrogen/pgTemplate.php');

?>


<div id="main" class="w3-main w3-container w3-padding-16" style="margin-left:250px">


<div>
</div>
<?php include 'Hydrogen/elemLogoHeadline.php';  ?>

<h2>Configuring PuTTY</h2>
<p><img src="images/ssh-icon.png">When this icon appears next to a server name, it can be clicked to connect to that server via ssh. Assuming you already have PuTTY on your computer and have configured it to use SSH keys to automatically log you in, these are the steps needed to hand off the "ssh://" URL to PuTTY when you click on it.</p>

<h3>Download KiTTY</h3>
<p>KiTTY is a PuTTY fork with the ability to take SSH URLs on the command line. It can be downloaded from <a href="http://www.9bis.net/kitty/?page=Download">http://www.9bis.net/kitty/?page=Download</a>. Save the kitty.exe file in whatever permanent location you think is best. In the example below, we will use "C:\Program Files\KiTTY\kitty.exe"</p>

<h3>Registry changes</h3>
<p>Download the KiTTY registry file from <a href"http://www.9bis.net/kitty/?file=kitty_ssh_handler.reg"> http://www.9bis.net/kitty/?file=kitty_ssh_handler.reg</a> or save the following into a plain text file. Edit the KiTTY path to match your path if different from the one in this example. Remove any blank lines from the top of the file and any spaces to the left of each line.</p>
<blockquote>
<p>Windows Registry Editor Version 5.00</p>

<p>[HKEY_CLASSES_ROOT\ssh]<br>
@="URL:SSH Protocol"<br>
"EditFlags"=dword:00000002<br>
"FriendlyTypeName"="@ieframe.dll,-907"<br>
"URL Protocol"=""<br>
"BrowserFlags"=dword:00000008</p>

<p>[HKEY_CLASSES_ROOT\ssh\DefaultIcon]<br>
@="C:\\Program Files\\KiTTY\\kitty.exe,0"</p>

<p>[HKEY_CLASSES_ROOT\ssh\shell]<br>
@=""</p>

<p>[HKEY_CLASSES_ROOT\ssh\shell\open]</p>

<p>[HKEY_CLASSES_ROOT\ssh\shell\open\command]<br>
@="\"C:\\Program Files\\KiTTY\\kitty.exe\" %1"</p>
</blockquote>

<p>Once the file has been edited, double-click on it to add the entries to your registry. If Windows complains of it not being a valid reg file, your text editor probably did not save it as an ANSI text file.</p>
<p>Restart your browser. When you click on an ssh link for the first time, you may be prompted to confirm that KiTTY is the handler for ssh links.</p>
<p></p>


<h2>Configuring SQL*Plus</h2>
<p><img src="images/sqlplus.png"></td><td>When this icon appears next to an Oracle database name, it can be clicked to connect to that database via SQL*Plus. The steps for configuring this capability are similar to the steps above, but more extensive depending on how you are accustomed to using SQL*Plus currently. Assuming you have already downloaded and installed an Oracle client and know the path to the SQL*Plus executable, these are the steps to follow.</p>

<h3>Eliminate your dependency on "tnsnames.ora"</h3>

<p>Your Oracle client needs to be able to connect a database when given a host, port and SID even if the database is not in the tnsnames.ora file. Locate "network/admin/sqlnet.ora" in your ORACLE_HOME and make sure it includes "EZCONNECT" in the NAMES.DIRECTORY_PATH. For example, it may include this line: "NAMES.DIRECTORY_PATH= (TNSNAMES, EZCONNECT)".</p>

<h3>Make all your Oracle passwords the same</h3>
<p>If you want to be able to log in automatically, you will need a script that can be passed an Oracle database identifier and can look up the username and password it needs for that database. The easiest way to do that is to use the same password for every database and to change them all before any one of them is due to expire.</p>

<h3>Store all your SQL*Plus scripts in a single directory</h3>
<p>When SQL*Plus starts, you will want to have immediate access to your scripts. The directory path in this example is "C:\Home\sql"</p>

<h3>Create "conn.sql" in your SQL*Plus script directory</h3>
<p>"conn.sql" is a login script which takes the database as a parameter ("&1"). In place of "xy1234/mypassword" below, type your own ID and password.</p>
<blockquote>
<p>set define on<br>
set echo off<br>
connect xy1234/mypassword@&1</p>
</blockquote>

<p>Optionally, you can add other commands or references to other scripts to be executed every time you log in:</p>

<blockquote>

<p>@login<br>
select global_name from global_name;</p>
</blockquote>

<h3>Create a batch file to read the "orcl" URL and hand off to SQL*Plus </h3>
<p>"orcl.bat" takes the URL clicked in the browser, parses it, formats a command window, and hands off the database ID in host:port/SID format to the "conn.sql" script to be run by sqlplus.exe on startup. In this example "orcl.bat"  will be stored in "C:\Home". Edit the text below if your sql script path is different from the one in this example. You can also edit the "cols" and "lines" values to change the size of your command window. For help on choosing window colors, type "color /?" at the Windows command line.</p>

<blockquote>
<p>set arg=%1<br>
set url=%arg:~7%<br>
cd c:\home\sql<br>
color F1<br>
mode con: cols=140 lines=60<br>
Title "SQL*Plus"<br>
sqlplus.exe /nolog @conn %url%</p>
</blockquote>

<h3>Registry changes</h3>
<p>The final step is to tell Windows to hand off any "orcl://" URL to your batch file. Save the following into a plain text file. Edit the "orcl.bat" path to match your path if different from the one in this example. Remove any blank lines from the top of the file and any spaces to the left of each line.</p>
<p></p>
<blockquote>
<p>Windows Registry Editor Version 5.00</p>

<p>[HKEY_CLASSES_ROOT\orcl]<br>
@="URL:orcl Protocol"<br>
"EditFlags"=dword:00000002<br>
"FriendlyTypeName"="@ieframe.dll,-907"<br>
"URL Protocol"=""<br>
"BrowserFlags"=dword:00000008</p>

<p>[HKEY_CLASSES_ROOT\orcl\shell]<br>
@=""</p>

<p>[HKEY_CLASSES_ROOT\orcl\shell\open]</p>

<p>[HKEY_CLASSES_ROOT\orcl\shell\open\command]<br>
@="\"C:\\Home\\orcl.bat\" %1"</p>
</blockquote>
<p>Once the file has been edited, double-click on it to add the entries to your registry. If Windows complains of it not being a valid reg file, your text editor probably did not save it as an ANSI text file.</p>
<p>Restart your browser. When you click on an "orcl://" link for the first time, you may be prompted to confirm that your batch file is the handler for the links.</p>
<p></p>

<p>To enable highlighting of text in the command window for purposes of copying/pasting, see this article: <a href="http://www.winhelponline.com/blog/enable-quick-edit-command-prompt-by-default/">How to Enable Quick Edit Mode in the Command Prompt by Default</a></p>
<p></p>

</div>
<!-- END MAIN -->
<?php
	include 'Hydrogen/elemNavbar.php';
	include "Hydrogen/elemFooter.php";
?>
</body></html>
