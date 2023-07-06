import pandas as pd
from sqlalchemy import create_engine

# エクセルファイルを読み込む
excel_file = 'output.xlsx'
df = pd.read_excel(excel_file, sheet_name='Sheet1')

# データを加工するなどの操作が必要な場合はここで行う

# データベースに接続
engine = create_engine('mysql://root:@localhost/gs_db2?unix_socket=/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock')

# データをデータベースに書き込む
df.to_sql('gs_an_ta', con=engine, if_exists='append', index=False)
