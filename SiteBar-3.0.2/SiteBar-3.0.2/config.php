<?
/******************************************************************************
 *  SiteBar 3 - The Bookmark Server for Personal and Team Use.                *
 *  Copyright (C) 2003  Ondrej Brablc <sitebar@brablc.com>                    *
 *                                                                            *
 *  This program is free software; you can redistribute it and/or modify      *
 *  it under the terms of the GNU General Public License as published by      *
 *  the Free Software Foundation; either version 2 of the License, or         *
 *  (at your option) any later version.                                       *
 *                                                                            *
 *  This program is distributed in the hope that it will be useful,           *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 *  GNU General Public License for more details.                              *
 *                                                                            *
 *  You should have received a copy of the GNU General Public License         *
 *  along with this program; if not, write to the Free Software               *
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 ******************************************************************************/

require_once('./inc/errorhandler.inc.php');
require_once('./inc/database.inc.php');

class Configuration extends ErrorHandler
{
    var $file;
    var $base = 'config.inc.php';
    var $config;
    var $command;
    var $message;
    var $db;

    var $host = 'localhost';
    var $name = 'sitebar';
    var $user = 'root';
    var $pass;
    var $pass2;

    function Configuration()
    {
        $this->file = './inc/'.$this->base;

        if (file_exists($this->file))
        {
            $this->checkStructure();
            return;
        }

        if (isset($_REQUEST['command']))
        {
            $this->command = $_REQUEST['command'];
            $this->host = $_REQUEST['host'];
            $this->name = $_REQUEST['name'];
            $this->user = $_REQUEST['username'];
            $this->pass = $_REQUEST['password'];
            $this->pass2 = $_REQUEST['repeat'];

            $this->config = <<<__END
<?

\$SITEBAR = array
(
    'db' => array
    (
        'host'      =>  '{$this->host}',
        'username'  =>  '{$this->user}',
        'password'  =>  '{$this->pass}',
        'name'      =>  '{$this->name}',
    ),
);

?>
__END;
        }

        if ($this->command)
        {
            if ($this->checkParams() && $this->command!='Check Settings')
            {
                $shortname = str_replace(' ','',$this->command);
                $execute = 'command' . $shortname;
                $this->$execute();
            }
        }

        $this->writeConfig();
    }

    function checkParams()
    {
        if ($this->pass && $this->pass !== $this->pass2)
        {
            $this->error('Password incorrectly retyped!');
            return false;
        }

        $connection = Database::connect($this->host, $this->user, $this->pass);

        if (!$connection)
        {
            $this->error(Database::getErrorText());
            return false;
        }
        else if (!Database::hasDB($this->name))
        {
            if ($this->command!="Create Database")
            {
                $this->error(Database::getErrorText());
                return false;
            }
        }
        else if ($this->command=="Create Database")
        {
            $this->error("Database already exists!");
            return false;
        }

        return true;
    }

    function commandCreateDatabase()
    {
        if (!Database::createDB($this->name))
        {
            $this->error(Database::getErrorText());
        }
        else
        {
            $this->message = 'Database created.';
        }
    }

    function commandWriteToFile()
    {
        $fp = @fopen($this->file,'wb');
        if (!$fp)
        {
            $this->error("Cannot open file " . $this->file .
                ". Does your HTTP server have write " .
                "access to inc directory?");
            return;
        }
        fwrite($fp, $this->config);
        fclose($fp);
        header('Location: config.php');
    }

    function commandDownloadSettings()
    {
        header('Content-type: application/octet-stream');
        header('Content-disposition: attachment; filename="'.$this->base.'"');
        header('Content-transfer-encoding: binary');
        header('Content-length: ' . strlen($this->config));
        echo $this->config;
    }

    function commandPreviewSettings()
    {
        header('Content-type: text/plain');
        header('Content-length: ' . strlen($this->config));
        echo $this->config;
    }

    function writePage()
    {
        require_once('./inc/page.inc.php');
        Page::head('DB Configuration', 'config');
?>
<h2>DB Configuration</h2>
<?
        if (!$this->hasErrors())
        {
            if ($this->command=='Check Settings')
            {
                $this->message = 'Connection parameters are OK!';
            }
            if ($this->message)
            {
?>
<div class='message'>
    <?=$this->message?>
</div>
<?
            }
        }
        else
        {
?>
<div class='error'>
<?
            $this->writeErrors(false);
?>
</div>
<?
        }
    }

    function writeConfig()
    {
        $this->writePage();

?>
<form action='config.php' method='POST'>
<table>
<tr><th>Host Name</th></tr>
<tr><td><input name='host' value='<?=$this->host?>'></tr>
<tr><th>Username</th></tr>
<tr><td><input name='username' value='<?=$this->user?>'></tr>
<tr><th>Password</th></tr>
<tr><td><input type='password' name='password' value='<?=$this->pass?>'></tr>
<tr><th>Repeat Password</th></tr>
<tr><td><input  type='password' name='repeat' value='<?=$this->pass2?>'></tr>
<tr><th>Database Name</th></tr>
<tr><td><input name='name' value='<?=$this->name?>'></tr>
</table>

<p>
<input type='submit' name='command' value='Check Settings'>
<input type='submit' name='command' value='Create Database'>
Use any of the following to create file config.php and place
it to your inc subdirectory of your SiteBar installation.
<input type='submit' name='command' value='Write To File'>
<input type='submit' name='command' value='Download Settings'>
<input type='submit' name='command' value='Preview Settings'>
</form>
<?
        Page::foot();
    }

    function checkStructure()
    {
        $this->db = new Database();
        if ($this->db->connection)
        {
            $release = "";

            if ($this->db->hasTable('sitebar_config'))
            {
                $rset = $this->db->select(null, 'sitebar_config');
                $config = $this->db->fetchRecord($rset);
                $release = $config['release'];

                // Small fix for CVS releases
                if ($release == "3.0pre")  $release = "3.0pre1";
                if ($release == "3.0pre2") $release = "3.0pre1";
                if ($release == "3.0b")    $release = "3.0pre1";
            }

            if ($this->db->currentRelease() != $release)
            {
                if (isset($_REQUEST['command']))
                {
                    $this->command = $_REQUEST['command'];
                }

                switch ($this->command)
                {
                    case "Upgrade":
                        $this->upgrade($release);
                        exit;

                    case "Install":
                        $this->install();
                        exit;
                }

                if ($release)
                {
                    $this->message =
                        "Please upgrade your database from release " .$release . ".";
                    $this->writePage();
?>
<p>
<form action='config.php' method='POST'>
<input type='submit' name='command' value='Upgrade'>
<input type='submit' name='command' value='Reload'>
</form>
<?
                }
                else
                {
                    $this->message = "Your database does not contain SiteBar tables.";
                    $this->writePage();
?>
<p>
<form action='config.php' method='POST'>
<input type='submit' name='command' value='Install'>
<input type='submit' name='command' value='Reload'>
</form>
<?
                }
            }
            else
            {
                header("Location: sitebar.php");
            }
        }
        else
        {
            $this->error("Your configuration file ".$this->file." is incorrect or the ".
                "database server is currently down! <p>" .
                "Please fix it or delete and run configuration again.");

            $this->writePage();
?>
<p>
<form action='config.php' method='POST'>
<input type='submit' name='command' value='Check Settings'>
</form>
<?
        }

    }

    function upgrade($from)
    {
        $file = sprintf("sql/upgrade_%s.sql", $from);

        if (!file_exists($file))
        {
            $this->error("I do not know how to upgrade from release $from!");
            $this->error("Try manual reconciliation!");
            $this->writePage();
?>
<p>
<form action='config.php' method='POST'>
<input type='submit' name='command' value='Reload'>
</form>
<?
        }
        else
        {
            $this->loadSQL($file);
        }
    }

    function install()
    {
        $this->loadSQL("sql/install.sql");
    }

    function loadSQL($filename)
    {
        if (!($fp=fopen($filename,"r")))
        {
            $this->error("Cannot open file ".$filename."!");
            return;
        }

        $sql = '';

        while (!feof($fp))
        {
            $line = rtrim(fgets($fp,4096));
            $size = strlen($line);

            if ($size>0 && $line{$size-1}==';')
            {
                $line = substr($line,0,$size-1);
                $sql .= ' ' . $line;
                if (!$this->db->raw($sql))
                {
                    $this->error($this->db->getErrorText().' ['.$sql.']');
                }
                $sql = '';
            }
            else
            {
                $sql .= ' ' . $line;
            }
        }
        fclose( $fp);

        if ($this->hasErrors())
        {
            $this->writePage();
?>
<p>
<form action='config.php' method='POST'>
<input type='submit' name='command' value='Reload'>
</form>
<?
        }
        else
        {
            header('Location: sitebar.php');
        }
    }
}

$config = new Configuration();
