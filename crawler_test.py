#coding=utf-8
import requests
from bs4 import BeautifulSoup
import lxml
import MySQLdb.cursors
import random

db = MySQLdb.connect(host="localhost", user="far", passwd="far123", db="far",cursorclass=MySQLdb.cursors.DictCursor)
db.set_character_set('utf8')
cursor = db.cursor()
cursor.execute('SET NAMES utf8;')
cursor.execute('SET CHARACTER SET utf8;')
cursor.execute('SET character_set_connection=utf8;')

server_id = random.randrange(1,100)
url = "http://www" + str(server_id) + ".eyny.com/forum.php?mod=forumdisplay&fid=205&filter=author&orderby=dateline"
res = requests.get(url)
soup = BeautifulSoup(res.text,'lxml')
for tbody in soup.find_all('tbody'):
	th = tbody.th
	for title in th.find_all('a',class_='xst'):
		#print title.text
		name = title.text
	for by in tbody.find_all('td',class_='by'):
		#print by.cite.a.text
		admin = by.cite.a.text
		if by.em.span is not None:
			if by.em.span.get('title') is None:
				time = "none"
			else:
				time = by.em.span['title']
	try:
		insert_sql = "INSERT INTO `eyny_movie` (`name`,`admin`,`create_at`) VALUES (%s,%s,%s);"
		val = (name, admin, time)
		result = cursor.execute(insert_sql,val)
	except Error as error:
        	print(error)

db.commit()
print "done"
