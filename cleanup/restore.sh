####################################################################################################
# Restore data
####################################################################################################
# 1. Check that all required parameters where passed to script
# Script accepts two arguments: 
# 1) Date of recovery (YYYYMMDD)
# 2) Recovery mask:
#    1: auth db
#    2: world db
#    4: characters db
#    8: control panel db
#   16: forum db
if [ $# -lt 2 ] ; then
    echo "Usage: ./restore.sh RESTORE_DATE RESTORE_MASK"
    exit 0
fi

# Restore date (YYYYMMDD)
RESTORE_DATE=$1

# Auth db name
AUTH_DB="%AUTH_DB%"
RESTORED_AUTH_DB=$AUTH_DB"_"$RESTORE_DATE

# World db name
WORLD_DB="%WORLD_DB%"
RESTORED_WORLD_DB=$WORLD_DB"_"$RESTORE_DATE

# Characters db name
CHAR_DB="%CHAR_DB%"
RESTORED_CHAR_DB=$CHAR_DB"_"$RESTORE_DATE

# Control panel db name
CP_DB="%CP_DB%"
RESTORED_CP_DB=$CP_DB"_"$RESTORE_DATE

# Forum db name
FORUM_DB="%FORUM_DB%"
RESTORED_FORUM_DB=$FORUM_DB"_"$RESTORE_DATE

# mysql user
MYSQL_USER="%USER%"
# mysql password
MYSQL_PASSWORD="%PASSWORD%"

# Root folder with backups
BACKUPS_ROOT="%ROOT%"
RESTORE_DIR=$BACKUPS_ROOT"/restore"

function restoreDatabase() {
    if [ -a $RESTORE_DIR"/"$RESTORE_DATE"/"$RESTORE_DATE"_"$1".sql" ]; then
        echo "Restoring "$3" database from "$RESTORE_DATE"_"$1".sql..."
        mysql -u $MYSQL_USER -p$MYSQL_PASSWORD $2 < $RESTORE_DIR"/"$RESTORE_DATE"/"$RESTORE_DATE"_"$1".sql"
    else
        echo $RESTORE_DATE"_"$1".sql does not exist. Skipping "$3" database restoration."
    fi
}

# 2. Check if archive for given date exists in backup folder
if ! [ -a $BACKUPS_ROOT"/"$RESTORE_DATE".tar.gz" ]; then
    echo "Specified archive "$RESTORE_DATE".tar.gz does not exist!"
    exit 0
fi

# 3. Create folder into which restored backups will be extracted
if ! [ -d $RESTORE_DIR ]; then
    mkdir $RESTORE_DIR
fi

# 4. Extract archive
echo "Extracting dumps from archive..."
tar -C $RESTORE_DIR -xzvf $BACKUPS_ROOT"/"$RESTORE_DATE".tar.gz"

# 5. Restore dumps
if [ $(( $2 & 1 )) == 1 ]; then
    restoreDatabase $AUTH_DB $RESTORED_AUTH_DB "auth"
fi
if [ $(( $2 & 2 )) == 2 ]; then
    restoreDatabase $WORLD_DB $RESTORED_WORLD_DB "world"
fi
if [ $(( $2 & 4 )) == 4 ]; then
    restoreDatabase $CHAR_DB $RESTORED_CHAR_DB "characters"
fi
if [ $(( $2 & 8 )) == 8 ]; then
    restoreDatabase $CP_DB $RESTORED_CP_DB "control panel"
fi
if [ $(( $2 & 16 )) == 16 ]; then
    restoreDatabase $FORUM_DB $RESTORED_FORUM_DB "forum"
fi

# 6. Remove dumps
rm -rf $RESTORE_DIR"/"$RESTORE_DATE
echo "Work is done!"
