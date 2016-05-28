#coding=utf8
import MySQLdb.cursors
import sys
reload(sys)
sys.setdefaultencoding('utf-8')     
db = MySQLdb.connect(host="localhost", user="far", passwd="far123", db="far",cursorclass=MySQLdb.cursors.DictCursor)
cursor = db.cursor() 
cursor.execute('SET NAMES utf8;')
cursor.execute('SET CHARACTER SET utf8;')
cursor.execute('SET character_set_connection=utf8;')

#sql = "SELECT * FROM eyny_movie WHERE name = '[美] 13小時：班加西的秘密士兵 13 Hours BDRip-720P+1080P(MKV@1.1G/2.1G@多免空@簡繁英)(2P)'"
#sql = "SELCET * FROM eyny_movie WHERE name = '為了保護良空載點,開放分享者申請閱讀權限'"
sql = "SELECT * FROM eyny_movie WHERE name = '為了保護良空載點,開放分享者申請閱讀權限'"
#val = ("[美] 13小時：班加西的秘密士兵 13 Hours BDRip-720P+1080P(MKV@1.1G/2.1G@多免空@簡繁英)(2P)")
print sql
cursor.execute(sql)
result = cursor.fetchall()

for row in result:
	print row['name']
