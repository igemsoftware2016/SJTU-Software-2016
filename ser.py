import web  
import cgi
import DB
from web import form as form  

cgi.maxlen = 10 * 1024 * 1024

db = DB.database()

urls = (  
    '/homepage*', 'homepage',
    '/login.html' , 'login',
    '/map.html' , 'map',
    '/africa.html', 'africa',
    '/asia.html' , 'asia',
    '/europe.html', 'europe',
    '/norAmer.html', 'norAmer',
    '/souAmer.html', 'souAmer',
    '/austr.html', 'austr',
    '/chat.html', 'chat',
    '/index.html', 'index',
    '/upload.html', 'upload'
)  
render = web.template.render('templates')  

class upload():
    def GET(self):
        web.header("Content-Type","text/html; charset=utf-8")
        tmp_cookie = web.cookies().get("teamfile")
        if tmp_cookie:
            return render.upload()
        else:
            return render.login()
    def POST(self):
        try:
            x = web.input(myfile={})
        except:
            return "File is too Bigger!"
        filedir = '/mydata/Team_Data/' + web.input()["Team_Name"] + "/"
        if 'myfile' in x:
            filepath=x.myfile.filename.replace('\\','/')
            filename=filepath.split('/')[-1]
            fout = open(filedir +'/'+ filename,'w')
            fout.write(x.myfile.file.read())
            fout.close()
        raise web.seeother('/upload.html')


class homepage():
    def GET(self):
        return render.homepage()

class login():
    def GET(self):
        web.header("Content-Type","text/html; charset=utf-8")
        tmp_cookie = web.cookies().get("teamfile")
        if tmp_cookie:
            return render.upload()
        else:
            return render.login()
    def POST(self):
        xx = web.input()["user"]
        yy = web.input()["pwd"]
        real_yy = db.search("select * from Teamfile_Manager where Account = \"%s\";" % str(xx))
        if (real_yy) and (real_yy[0]["Password"] == yy):
            web.setcookie("teamfile",eval(yy),600)
            raise web.seeother('./upload.html')
        else:
            raise web.seeother('./login.html')

class map():
    def GET(self):
        return render.map()

class africa():
    def GET(self):
        return render.africa()

class asia():
    def GET(self):
        return render.asia()

class europe():
    def GET(self):
        return render.europe()

class souAmer():
    def GET(self):
        return render.souAmer()

class norAmer():
    def GET(self):
        return render.norAmer()

class austr():
    def GET(self):
        return render.austr()

class chat():
    def GET(self):
        return render.chat()

class index:  
    def GET(self):  
        return render.index()  

class add:  
    def POST(self):       
        print web.input()['title1']  
        print web.data()  
        raise web.seeother('/')  
          
if __name__ == "__main__":  
    app = web.application(urls, globals())  
    app.run() 
    db.quit_database()
