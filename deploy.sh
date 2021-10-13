#
# デプロイ後に実行されるスクリプト
#

# キャッシュクリア
/usr/local/bin/php bin/console cache:clear

# パズル追加

echo "2\n2\n3,0,1,2\n#DC143C,#00008B,#FFD700,#228B22\n[ 1  2  3 ]\n" | /usr/local/bin/php bin/console puzzle:add

echo "3\n3\n2,4,3,7,6,1,5,0,8\n#444,#444,#444,#444,#444,#444,#444,#444,#444\n[ 1  2  3 ]\n" | /usr/local/bin/php bin/console puzzle:add
