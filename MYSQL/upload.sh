MYSQL_ROOT="root"
MYSQL_PASS="vasilis1"
mysql -u$MYSQL_ROOT -p$MYSQL_PASS < database.sql
mysql -u$MYSQL_ROOT -p$MYSQL_PASS < triggers.sql
mysql -u$MYSQL_ROOT -p$MYSQL_PASS < insertion.sql

cd views/
mysql -u$MYSQL_ROOT -p$MYSQL_PASS < Details_of_books.sql
mysql -u$MYSQL_ROOT -p$MYSQL_PASS < Members_from_Athens.sql
mysql -u$MYSQL_ROOT -p$MYSQL_PASS 