####################################################################################################
# Backup WoW databases
####################################################################################################
# Current date in YYYYMMDD format
CURDATE=$(date +"%Y%m%d")

# Auth db name
AUTH_DB="%AUTH_DB%"
# World db name
WORLD_DB="%WORLD_DB%"
# Characters db name
CHAR_DB="%CHAR_DB%"
# Control panel db name
CP_DB="%CP_DB%"
# Forum db name
FORUM_DB="%FORUM_DB%"

# mysql user
MYSQL_USER="%USER%"
# mysql password
MYSQL_PASSWORD="%PASSWORD%"

# Root folder with backups
BACKUPS_ROOT="%ROOT%"

function backupDatabase()
{
    echo "Dumping "$2" database..."
    mysqldump -u $MYSQL_USER -p$MYSQL_PASSWORD $1 > $BACKUPS_ROOT"/"$CURDATE"/"$CURDATE"_"$1".sql"
}

# 1. Create folder for current date
if ! [ -d $BACKUPS_ROOT"/"$CURDATE ]; then
    mkdir $BACKUPS_ROOT"/"$CURDATE
fi

# 2. Dump databases
backupDatabase $AUTH_DB "auth"
backupDatabase $WORLD_DB "world"
backupDatabase $CHAR_DB "characters"
backupDatabase $CP_DB "control panel"
backupDatabase $FORUM_DB "forum"

# 3. Create archive
cd $BACKUPS_ROOT
echo "Archiving dumps..."
tar -czvf $CURDATE".tar.gz" $CURDATE"/"

# 4. Remove dumps folder (comment it if you want dumps to stay)
rm -rf $BACKUPS_ROOT"/"$CURDATE
echo "Work is done!"
