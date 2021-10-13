#
# デプロイ後に実行されるスクリプト
#
PHP=`which php`
CONSOLE="bin/console"

# キャッシュクリア
$PHP $CONSOLE cache:clear

# パズル初期化
yes | $PHP $CONSOLE puzzle:init

# パズル追加

echo -e "2\n2\n3,0,1,2\n#DC143C,#00008B,#FFD700,#228B22\n[ 1  2  3 ]\n" | $PHP $CONSOLE puzzle:add

echo -e "3\n3\n2,4,3,7,6,1,5,0,8\n#444,#444,#444,#444,#444,#444,#444,#444,#444\n[ 1  2  3 ]\n" | $PHP $CONSOLE puzzle:add
