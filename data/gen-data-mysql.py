#!/usr/bin/python
import fileinput
import sys
import lib.lorem_ipsum
import MySQLdb

count = 0

db = MySQLdb.connect(user="rest",passwd="rest",db="rest")
c = db.cursor()
c.execute("SET autocommit=0")
for i in range(1, 8000000):
	longString = lib.lorem_ipsum.paragraph()
	c.execute("INSERT INTO rest_data2 (id, short_string, long_string, int_number, true_or_false) VALUES (%s, %s, %s, %s, %s)", (i, lib.lorem_ipsum.words(5, False), longString, len(longString), 1))

	count = count + 1
	if count % 1000 == 0:
		print "Done", count, "rows"

c.execute("SET autocommit=1")
c.execute("COMMIT")
