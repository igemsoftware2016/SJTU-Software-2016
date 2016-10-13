#!/usr/bin/python

import DB
import string

db = DB.database()
with open("information.txt", "r") as tmp_file:
    data = tmp_file.readlines()
for i in range(len(data)):
    data[i] = data[i].strip().lower().replace("\'","\\\'").replace("\"","\\\"")

name = set({})

for i in data:
    now = i.split("|")
    area_id = db.search("select * from Teams where Team_Name = \"%s\";" % now[0])
    if now[1] not in name:
        db.insert("insert into Schools (School_Name,Area_ID) values(\"%s\",%d);" %(now[1],area_id[0]["Area_ID"]))
        name.add(now[1])
    ids = db.search("select * from Schools where School_Name = \"%s\";" % now[1])
    db.insert("update Teams set School_ID=%d where Team_Name = \"%s\";" %(ids[0]["School_ID"],now[0]))
    
db.quit_database()
