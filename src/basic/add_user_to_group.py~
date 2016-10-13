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

def run(url,data):
    data = json.dumps(data)
    req = urllib2.urlopen(url, data)
    content = req.read()
    if "OK" in content:
        return True
    else:
        print content
        return False

def add_friend():
    data = {}
    meth = "sns/friend_import?"
    url = set_method(meth)
    user = db.search("select Account_Number,ID from IGEM.Person")
    for i in range(len(user)):
        user[i]["Team_ID"]=db.search("select Team_ID from IGEM.Join_Team where Person_ID=%d;" %user[i]["ID"])[0]["Team_ID"]
    team = db.search("select Team_ID from IGEM.Teams;")
    for i in range(3):
        person = []
        for j in range(len(user)):
            if user[j]["Team_ID"] == team[i]["Team_ID"]:
                person += [ user[j] ]
        for j in person:
            for k in person:
                if j!=k:
                    data = {}
                    while True:
                        url = set_method(meth)
                        data ={
                            "From_Account": "%s" %j["Account_Number"],
                            "AddFriendItem":
                            [
                                {
                                    "To_Account":"%s" %k["Account_Number"],
                                    "GroupName":["Team"],
                                    "AddSource":"AddSource_Type_Server",
                                    "AddTime":1420000001,
                                }
                            ]
                        }
                        print data
                        if run(url, data):
                            break
                        else:
                            print data

def add_user_to_group():
    data = {}
    meth = "group_open_http_svc/add_group_member?"
    url = set_method(meth)
    user = db.search("select Account_Number,ID from IGEM.Person;")
    for i in range(len(user)):
        team_id = db.search("select Team_ID from IGEM.Join_Team where Person_ID = %d;" %user[i]["ID"])[0]["Team_ID"]
        group_id = db.search("select group_id from Chat.groups where team_id = %d;"%team_id)[0]["group_id"]
        data = {
            "GroupId":group_id,
            "MemberList":[
                {
                    "Member_Account":user[i]["Account_Number"]
                }
            ]
        }
        while True:
            url = set_method(meth)
            post_data = json.dumps(data)
            req = urllib2.urlopen(url, post_data)
            content = req.read()
            contents = json.loads(content)
            print content
            if "OK" in content:
                print i
                break
            else:
                print data["MemberList"][0]["Member_Account"]

add_friend()
