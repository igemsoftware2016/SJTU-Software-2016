import urllib
import urllib2
import json
import string
import sys
import DB
import random

global bases,method,para,db

db = DB.database()
print db.insert("use Chat;")

def set_method(meth):
    global bases,method,para
    bases = "https://console.tim.qq.com/v4/"
    method = meth
    #method = "im_open_login_svc/multiaccount_import?"
    para = "usersig=eJw9j8lOwzAARH*l8rUIvCR2yo2wlIDb1OpC4WJZtdOaKAuJQxfEv0NSpdd50sybH7Dg82u12RRN7qQ7lgbcDgAEV4MOfJuqtkXeZhgiH2Ho9ajWqVRlaXULkQchRCRgwQXbbQsmj*-3kXjgKhZ8SddMxYvEL55uRuPn5s19YZzN3Fz7WRMNRRpmq62IdnfTSLP6xdjpx*mwGk6KkH*SpBa7cBSwExsv9-wYmz1ev*K0n7Pa5M4m1lTtqtKZzXvUSUrlJKk61z53NjNnd*ZRRD16eW0Opa2MVIk71xHkE-p-EPz*Acf0WGQ_&apn=1&identifier=admin&sdkappid=1400013878&random=%d&contenttype=json" % random.randint(0,65536)
    return bases+method+para

def add_user():
    global bases,method,para,db
    data = {}
    meth = "im_open_login_svc/multiaccount_import?"
    url = set_method(meth)
    user = db.search("select Account_Number from IGEM.Person;")
    """
    data["Accounts"] = ["\'MartinD"]
    url = set_method(meth)
    post_data = json.dumps(data)
    req = urllib2.urlopen(url, post_data)
    content = req.read()
    print content
    """
    for i in range(len(user)):
        data["Accounts"] = [user[i]["Account_Number"].strip()]
        while True:
            url = set_method(meth)
            post_data = json.dumps(data)
            req = urllib2.urlopen(url, post_data)
            content = req.read()
            if  "OK" in content:
                print i
                break
            else:
                print data["Accounts"]

def add_group(files):
    global bases,method,para,db
    data = {}
    data["Type"] = "Public"
    meth = "group_open_http_svc/create_group?"
    url = set_method(meth)
    groups = []
    ids = []
    with open(files, "r") as tmp_file:
        ddd = tmp_file.readlines()
    for aa in ddd:
        groups += [aa.strip().split()[1]] 
        ids += [eval(aa.strip().split()[0])]
    """
    data["Name"] = "gaston_day"
    url = set_method(meth)
    post_data = json.dumps(data)  
    req = urllib2.urlopen(url, post_data)
    contents = req.read() 
    print contents
    """
    for i in range(len(groups)):
        data["Name"] = groups[i].strip()
        while True:
            url = set_method(meth)
            post_data = json.dumps(data)
            req = urllib2.urlopen(url, post_data)
            contents = req.read()
            content = json.loads(contents)
            if "OK" in contents:
                if db.insert("insert into groups (group_id, group_name, team_id) values(\"%s\",\"%s\",%d);" %(content["GroupId"], groups[i].strip(), ids[i])):
                    break
                else:
                    print groups[i].strip()
                    break
   

#add_group("add_group.txt")
#add_user()
