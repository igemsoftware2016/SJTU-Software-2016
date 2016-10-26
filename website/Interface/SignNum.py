#! /usr/bin/python
# coding:utf-8

import sys
import OpenSSL
import base64
import zlib
import json
import time
import DB

ecdsa_pri_key = """
-----BEGIN EC PARAMETERS-----
BgUrgQQACg==
-----END EC PARAMETERS-----
-----BEGIN PRIVATE KEY-----
MIGEAgEAMBAGByqGSM49AgEGBSuBBAAKBG0wawIBAQQgJCgTJfXLp4Z4D3kjF+ry
RKYxpLSJnSuWTBbw57EURM2hRANCAAR1YMuciBiJzw+O82W1jTkZd4Lj3pDHYd7b
6KUqnY1vz2HnkQosRGT0iMN4qwooI7D/dnQ2LF19jd6UIrn0+lRR
-----END PRIVATE KEY-----
"""

def list_all_curves():
    list = OpenSSL.crypto.get_elliptic_curves()
    for element in list:
        print element

def get_secp256k1():
    print OpenSSL.crypto.get_elliptic_curve('secp256k1');


def base64_encode_url(data):
    base64_data = base64.b64encode(data)
    base64_data = base64_data.replace('+', '*')
    base64_data = base64_data.replace('/', '-')
    base64_data = base64_data.replace('=', '_')
    return base64_data

def base64_decode_url(base64_data):
    base64_data = base64_data.replace('*', '+')
    base64_data = base64_data.replace('-', '/')
    base64_data = base64_data.replace('_', '=')
    raw_data = base64.b64decode(base64_data)
    return raw_data

class TLSSigAPI:
    """"""    
    __acctype = 0
    __identifier = ""
    __appid3rd = ""
    __sdkappid = 0
    __version = 20151204
    __expire = 3600*24*365       # 默认一个月，需要调整请自行修改
    __pri_key = ""
    __pub_key = ""
    _err_msg = "ok"

    def __get_pri_key(self):
        return OpenSSL.crypto.load_privatekey(OpenSSL.crypto.FILETYPE_PEM, self.__pri_key);

    def __init__(self, sdkappid, pri_key):
        self.__sdkappid = sdkappid
        self.__pri_key = pri_key

    def __create_dict(self):
        m = {}
        m["TLS.account_type"] = "%d" % self.__acctype
        m["TLS.identifier"] = "%s" % self.__identifier
        m["TLS.appid_at_3rd"] = "%s" % self.__appid3rd
        m["TLS.sdk_appid"] = "%d" % self.__sdkappid
        m["TLS.expire_after"] = "%d" % self.__expire
        m["TLS.version"] = "%d" % self.__version
        m["TLS.time"] = "%d" % time.time()
        return m

    def __encode_to_fix_str(self, m):
        fix_str = "TLS.appid_at_3rd:"+m["TLS.appid_at_3rd"]+"\n" \
                  +"TLS.account_type:"+m["TLS.account_type"]+"\n" \
                  +"TLS.identifier:"+m["TLS.identifier"]+"\n" \
                  +"TLS.sdk_appid:"+m["TLS.sdk_appid"]+"\n" \
                  +"TLS.time:"+m["TLS.time"]+"\n" \
                  +"TLS.expire_after:"+m["TLS.expire_after"]+"\n"
        return fix_str

    def tls_gen_sig(self, identifier):
        self.__identifier = identifier

        m = self.__create_dict()
        fix_str = self.__encode_to_fix_str(m)
        pk_loaded = self.__get_pri_key()
        sig_field = OpenSSL.crypto.sign(pk_loaded, fix_str, "sha256");
        sig_field_base64 = base64.b64encode(sig_field)
        m["TLS.sig"] = sig_field_base64
        json_str = json.dumps(m)
        sig_cmpressed = zlib.compress(json_str)
        base64_sig = base64_encode_url(sig_cmpressed)
        return base64_sig 

def calc(accounts):
    db = DB.database()
    print accounts
    person_id = "NULL"
    team_id = 0
    team_name = "NULL"
    try:
        person_id = db.search("select ID from Person where Account_Number=\"%s\";" %accounts)[0]["ID"]
    except:
        pass
    try:
        team_id = db.search("select Team_ID from Join_Team where Person_ID=%d;" %person_id)[0]["Team_ID"]
    except:
        pass
    try:
        team_name = db.search("select Team_Name from Teams where Team_ID=%d;" %team_id)[0]["Team_Name"]
    except:
        pass
    db.quit_database()
    api = TLSSigAPI(1400013878, ecdsa_pri_key)
    sig = api.tls_gen_sig(accounts)
    print sig
    d = dict()
    d["username"] = accounts
    d["password"] = sig
    d["team_id"] = str(team_id)
    d["team_name"] = team_name
    result = json.dumps(d)
    files = open(accounts+".json","w")
    files.write("[")
    files.write(result)
    files.write("]")
    files.close()


if __name__ == "__main__":
    calc(sys.argv[1])
