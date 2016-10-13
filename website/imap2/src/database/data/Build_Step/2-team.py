#!/usr/bin/python

import string
import DB

db = DB.database()
with open("2016__team_list__2016-08-17.csv", "r") as tmp_file:
    data = tmp_file.readlines()
for s in data:
    now = s.strip().lower().split(",")
    try:
        area_id = db.search("select Area_ID from Areas where Region=\"%s\" and Country=\"%s\";" %( now[2],now[3]));
    except:
        print now[2],now[3]
    if not db.insert("insert into Teams(Team_ID,Team_Name,Member_Num,Area_ID,Year,Status,Track) values(%s,\"%s\",%s,%d,%d,\"%s\",\"%s\");" %(now[0],now[1],now[6],area_id[0]["Area_ID"],2016,now[7],now[4])):
        print "insert into Teams(Team_ID,Team_Name,Member_Num,Area_ID,Year,Status,Track) values(%s,\"%s\",%s,%d,%d,\"%s\",\"%s\");" %(now[0],now[1],now[6],area_id[0]["Area_ID"],2016,now[7],now[4])

db.quit_database()
