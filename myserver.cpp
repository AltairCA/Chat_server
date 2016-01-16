#include "myserver.h"

MyServer::MyServer(QObject *parent) :
    QTcpServer(parent)
{

}

void MyServer::StartServer(){

/*
    db = new QSqlDatabase(QSqlDatabase::addDatabase("QMYSQL"));

    db->setHostName("127.0.0.1");
    db->setPort(3306);
    db->setUserName("chat");
    db->setPassword("chat");
    db->setDatabaseName("chat");
    db->setConnectOptions("MYSQL_OPT_RECONNECT=true");
*/
    db = new QSqlDatabase(QSqlDatabase::addDatabase("QSQLITE"));
    //db->setDatabaseName(QCoreApplication::applicationDirPath()+"//msgs.db");
    db->setDatabaseName("/var/www/chat/public_html/build/msgs.db");
    db->setDatabaseName("C:/xampp/htdocs/chat/public_html/build/msgs.db");
    //db->setDatabaseName("msgs.db");
    db->setConnectOptions("QSQLITE_ENABLE_SHARED_CACHE=1;");
    db->setConnectOptions("QSQLITE_BUSY_TIMEOUT=10000000");
    //bool chek = db.open();
    if(db->open()){
        if(listen(QHostAddress::Any,1234)){
            qDebug()<<"server Started";
        }else{
            qDebug()<<"server not Started";
        }
    }else{
        qDebug()<<"server not Started";
    }
}

void MyServer::incomingConnection(qintptr handle){


    MyClient *client = new MyClient(this);

    client->SetSocket(handle,db);
    connect(client,SIGNAL(destroyed()),this,SLOT(print()));



}
void MyServer::print(){
    qDebug()<<"cllent object removed";
}
