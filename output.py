import pymysql
import pandas as pd

# データベースに接続
connection = pymysql.connect(
    host='localhost',
    user='root',
    password='',
    db='gs_db2',
    charset='utf8mb4',
    cursorclass=pymysql.cursors.DictCursor
)

# データを取得
query = "SELECT * FROM gs_an_table2"
cursor = connection.cursor()
cursor.execute(query)
data = cursor.fetchall()

# 取得したデータをDataFrameに変換
df = pd.DataFrame(data)

# Excelファイルに書き込み
df.to_excel("output.xlsx", index=False)

# 接続を閉じる
cursor.close()
connection.close()
