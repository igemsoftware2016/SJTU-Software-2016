#!/usr/bin/python

import DB
import os

db = DB.database()

data = db.search("select Team_Name from Teams;")
"""
for s in data:
    print s["Team_Name"]
    cmd = "mkdir /mydata/Team_Data/" + s["Team_Name"]
    os.system(cmd)
"""
aa = []
with open("select.html" , "w") as tmp_file:
    tmp_file.write("\t\t\t<select>\n")
    for s in data:
        aa += [s["Team_Name"]]
    aa.sort()
    for s in aa:
        tmp_file.write("\t\t\t\t\t<option value =\"%s\">%s</option>\n" %(s,s))
    tmp_file.write("\t\t\t</select>\n")

db.quit_database()
