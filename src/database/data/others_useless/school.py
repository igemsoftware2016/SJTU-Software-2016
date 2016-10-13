#!/usr/bin/python
# -*- coding: utf-8 -*-
# __author__ = "JieYao"

import DB
import os
import string

teamname = []
school = []
kind = []
track = []
title = []
abstract = []
primarypi = []
secondpi = []
instructor = []

db = DB.database()
with open("information.txt", "r") as tmp_file:
    data = tmp_file.readlines()
info = []
for s in data:
    s = s.rstrip().split("|")
    info += [s]
now = 1
with open("Schools.txt", "w") as tmp_file:
    for i in range(len(info)):
        if not info[i]:
            continue
        if info[i][1] == "NULL":
            continue
        data = db.search("select * from Schools where School_Name = \"%s\";" % info[i][1])
        if data:
            continue
        data = db.search("select Teams.Area_ID from Teams where Teams.Team_Name = \"%s\";" % info[i][0])
        if not data:
            print info[i][0]
            continue
        db.insert('insert into Schools values(%d,"%s",%d);' %(now,info[i][1].strip(),data[0]["Area_ID"]))
        tmp_file.write("%d|%s|%d\n" %(now, info[i][1].strip(), data[0]["Area_ID"]))
        now += 1
db.quit_database()

        
