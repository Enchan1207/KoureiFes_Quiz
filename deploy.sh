#!/bin/bash
#
# デプロイ後に実行されるスクリプト
#
PHP=`which php`
CONSOLE="bin/console"

# キャッシュクリア
$PHP $CONSOLE cache:clear

# スキーマ更新
$PHP $CONSOLE d:s:u --force

# パズル初期化
yes | $PHP $CONSOLE puzzle:init

# パズル追加

echo -e "puzzle_1\n2\n2\n3,0,1,2\n#DC143C,#00008B,#FFD700,#228B22\n[ 4  3  9 ]\n" | $PHP $CONSOLE puzzle:add

echo -e "puzzle_2\n3\n3\n7,5,0,2,1,6,4,3,8\n#444,#444,#444,#444,#444,#444,#444,#444,#444\n[ 5  6  0 ]\n" | $PHP $CONSOLE puzzle:add
