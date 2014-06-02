#!/bin/sh

echo "Enter database configuration: "
read -p "Host     : " host
read -p "Username : " username
read -p "Password : " password
read -p "Schema   : " dbname

cat <<EOF > "backend/app/config/dbconfig.php"
<?php

return new \Phalcon\Config(array(
    "database" => array(
        "adapter"  => "Mysql",
        "host"     => "${host}",
        "username" => "${username}",
        "password" => "${password}",
        "dbname"   => "${dbname}",
    )
));
EOF

echo "Which address will your API have?"
read -p "Development : " development_host
read -p "Production  : " production_host

cat <<EOF > "frontend/config/api.js"
module.exports = {
    "development": {
        host: "${development_host}"
    },
    "production": {
        host: "${production_host}"
    }
};
EOF

echo "Done!"
