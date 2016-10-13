#!/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = 'JieYao'

import DB
import string

with open("information.txt", "r") as tmp_file:
    data = tmp_file.readlines()

x = "\"" 
y = "\\\""
xx = "\'" 
yy = "\\\'"
for i in range(len(data)):
    data[i] = data[i].strip().lower()
db = DB.database()

for i in range(len(data)):
    now = data[i].split("|")
    db.insert("insert into Projects (Title,Abstract) values(\"%s\",\"%s\");" %(now[4].strip().lower(), now[5].strip().lower()))
    ids = db.search("select * from Projects where Title = \"%s\";" % now[4].strip().lower())
    db.insert("update Teams set Project_ID = %d where Team_Name = \"%s\";" %(ids[0]["Project_ID"], now[0]))

