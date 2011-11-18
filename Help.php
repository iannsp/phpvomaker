<?php
namespace VoMaker;
/**
 * @author iann
 *
 *
 */
class Help {

    public function help()
    {
    return <<<EOT
    To use the vomaker you need inform some parameters in command line, like above
    phpvomaker [cmd] --dsn [dsn] --login [login] --password  [options]
    --dsn: at this time you just can use mysql dsn's
    --login: you database login
    --password:you databaase password
    [cmd] : listtable|create|help
    --table : the table list
    --template : templatename
    action:you can request for
    listtable     :  list all tables in you database for support your choice to generate vo.
    create        :  create the Vo's
     help         :  show this or a especific help if use help [cmd]
    phpvomaker --help
    phpvomaker --help listtable\n
    examples:
    create vo of table tags with BlueSeed Template into actual directory
    ./appvomaker.php create --dsn 'mysql:host=127.0.0.1;dbname=test' --user root --password mysql --output ./ --tables tags --template blueseed
    create Vo of All Tables in database using template 'vo' basic 
    ./appvomaker.php create --dsn 'mysql:host=127.0.0.1;dbname=test' --user root --password mysql --output ./ --tables ALLTABLES --template vo
    create vo of table tags and tags2 with BlueSeed Template into actual directory
    ./appvomaker.php create --dsn 'mysql:host=127.0.0.1;dbname=test' --user root --password mysql --output ./ --tables tags,tags2 --template blueseed
    create vo to all tables  with vo basic Template into actual directory
    ./appvomaker.php create --dsn 'mysql:host=127.0.0.1;dbname=test' --user root --password mysql --output ./ --tables ALLTABLES --template vo
    create vo to all tables  with default Template(vo basic) into actual directory
    ./appvomaker.php create --dsn 'mysql:host=127.0.0.1;dbname=test' --user root --password mysql --output ./ --tables ALLTABLES
EOT;
    }

    private function tabledefinition()
    {
        return <<<EOT
            You can define your table as:
            ALLTABLE     : use this when you like to make reference to all tables in DB
            table1        : You can define just one table, by name
            table1,table2,table3 : or can define a list of tables.\n
EOT;
    }
    public function listtable()
    {
        return <<<EOT
        List all tables in database.
        used as:
        phpvomaker listtable --dsn [dsn] --login [login] --password \n
EOT;
    }
    public function create()
    {
        return <<<EOT
        create Vo's to tables tables in database.\n
        used as:
        phpvomaker create --dsn [dsn] --login [login] --password [password] --tables [tables]\n
EOT;
}

}
