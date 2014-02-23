#!/bin/sh

echo "Enter database configuration: "
read -p "Host     : " host
read -p "Username : " username
read -p "Password : " password
read -p "Schema   : " name

cat <<EOF > "app/config/dbconfig.php"
<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'  => 'Mysql',
        'host'     => '${host}',
        'username' => '${username}',
        'password' => '${password}',
        'name'     => '${name}',
    )
));

EOF

echo "Migrating database.."
phalcon migration run
echo "Done!"
