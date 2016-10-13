#!/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = "JieYao"

import DB
import string

with open("person2.txt", "r") as tmp_file:
    data = tmp_file.readlines()

db = DB.database()
i = 0
for tmp in data:
    i += 1
    s = tmp.strip().split("|")
    '''
    cmd =  ("select * from Person where Name=\"%s\" and Account_Number=\"%s\";" %(s[1],s[2]))
    try:
        ll = db.search(cmd)
    except:
        print i,cmd
    if ll:
        continue
    com = ('insert into Person (Name, Account_Number, Identity) values("%s", "%s", "%s");' %(s[1],s[2],s[3]))
    if not db.insert(com):
        print i,com
    '''
    num = db.search("select ID from Person where Account_Number = \"%s\";" % s[2])
    if not db.insert('insert into Join_Team (Team_ID, Person_ID) values(%s, %d);' %(s[0], num[0]['ID'])):
        print sssss
db.quit_database()
