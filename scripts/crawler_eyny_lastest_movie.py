#coding=utf8
import MySQLdb.cursors
import sys
reload(sys)
sys.setdefaultencoding('utf-8')
import requests
from bs4 import BeautifulSoup
import lxml
import random
import json
import datetime
import time

with open('../config/config.json') as data_file:
    config = json.load(data_file)

db = MySQLdb.connect(host=config['db_host'], user=config['db_user'], passwd=config['db_password'], db=config['selected_db'],cursorclass=MySQLdb.cursors.DictCursor)
db.set_character_set('utf8')
cursor = db.cursor()
cursor.execute('SET NAMES utf8;')
cursor.execute('SET CHARACTER SET utf8;')
cursor.execute('SET character_set_connection=utf8;')

print datetime.datetime.now()
#print time.time()
now = time.time()
server_id = random.randrange(100,90000)
url = "http://www" + str(server_id) + ".eyny.com/forum.php?mod=forumdisplay&fid=205&filter=author&orderby=dateline"
res = requests.get(url)
soup = BeautifulSoup(res.text,'lxml')
for tbody in soup.find_all('tbody'):
	th = tbody.th
	for title in th.find_all('a',class_='xst'):
		print title.text
		name = title.text
		url = "http://www" + str(server_id) + ".eyny.com/" + title['href']
	for by in tbody.find_all('td',class_='by'):
		#print by.cite.a.text
		admin = by.cite.a.text
		if by.em.span is not None:
			time = by.em.span

	check_sql = "SELECT * FROM `eyny_movie` WHERE `name` = '{0}'".format(name)
	result = cursor.execute(check_sql)
	if result == 0 :
		insert_sql = "INSERT INTO `eyny_movie` (`name`,`admin`,`create_at`,`url`, `created_at`) VALUES (%s,%s,%s,%s,%s);"
		val = (name, admin, time, url, now)
		result = cursor.execute(insert_sql,val)
		print result
db.commit()
