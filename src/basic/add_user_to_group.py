import urllib
import urllib2
import json
import string
import sys
import DB
import random

global bases,method,para,db

db = DB.database()

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

def calcs(url, data):
    try:
        ans = urllib2.urlopen(url, data)
    except:
        return calcs(url, data)
    return ans

def del_friend():
    data = {}
    meth = "sns/friend_delete_all?"
    url = set_method(meth)
    user = db.search("select Account_Number from IGEM.Person")
    for i in range(len(user)):
        data = {}
        print i
        data["From_Account"] = user[i]["Account_Number"]
        while not run(url, data):
            pass
            

def add_friend():
    data = {}
    meth = "sns/friend_import?"
    url = set_method(meth)
    user = db.search("select Account_Number,ID from IGEM.Person")
    for i in range(len(user)):
        user[i]["Team_ID"]=db.search("select Team_ID from IGEM.Join_Team where Person_ID=%d;" %user[i]["ID"])
        if (user[i]["Team_ID"]):
            user[i]["Team_ID"] = user[i]["Team_ID"][0]["Team_ID"]
        user[i]["Team_Name"]=db.search("select Team_Name from IGEM.Teams where Team_ID=%d;" %user[i]["Team_ID"])[0]["Team_Name"]
        user[i]["Name"]=db.search("select Name from IGEM.Person where ID=%d;" %user[i]["ID"])[0]["Name"]
    data = {}
    data["From_Account"] = ""
    for i in range(len(user)):
        print i,user[i]["Account_Number"]
        data["From_Account"] = user[i]["Account_Number"]
        #calc own team member
        base = []
        for j in range(len(user)):
            if (user[i]["Team_Name"]==user[j]["Team_Name"])and(i!=j):
                tmp = {}
                tmp["To_Account"] = user[j]["Account_Number"]
                tmp["GroupName"] = [user[j]["Team_Name"]]
                tmp["AddSource"] = "AddSource_Type_Server"
                tmp["Remark"] = user[j]["Name"]
                base += [ tmp ]
        data["AddFriendItem"] = base
        use_data = json.dumps(data)
        req = calcs(url, use_data)
        content = req.read()
        content = json.loads(content)
        while content["ErrorCode"]==60008:
            req = calcs(url, use_data)
            content = req.read() 
            content = json.loads(content)
        try:
            for j in range(len(content["ResultItem"])):
                if content["ResultItem"][j]["ResultCode"]==0:
                    continue
                else:
                    print i,user[i]["Account_Number"]
                    print content["ResultItem"][j]
        except:
            print content
        
def add_user_to_group():
    data = {}
    meth = "group_open_http_svc/add_group_member?"
    url = set_method(meth)
    user = db.search("select Account_Number,ID from IGEM.Person;")
    for i in range(4000,len(user)):
        #team_id = db.search("select Team_ID from IGEM.Join_Team where Person_ID = %d;" %user[i]["ID"])[0]["Team_ID"]
        #group_id = db.search("select group_id from Chat.groups where team_id = %d;"%team_id)[0]["group_id"]
        #group_id = "@TGS#2GPDAXFE6" #IGEMer 
        #group_id = "@TGS#2ZGTGXFEA" #IGEMer2
        group_id = "@TGS#2WFXBXFE2" #IGEMer3
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

add_user_to_group()
#del_friend()
#add_friend()
