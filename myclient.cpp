#include "myclient.h"

#ifdef Q_OS_WIN32
#include <winsock2.h>
#include <ws2tcpip.h>
#include "mstcpip.h"
#endif

#ifdef Q_OS_LINUX
#include <sys/socket.h>
#include <netinet/in.h>
#include <netinet/tcp.h>
#endif

#define LOCALCERTIFICATE_FILE "D:/users/Qt/Private/cert/server.crt"
#define PRIVATEKEY_FILE "D:/users/Qt/Private/cert/key/server.key"
//#define HTTPDIR "/var/www/chat/public_html/server/upload/"
#define HTTPDIR "C:/xampp/htdocs/chat/public_html/server/upload/"

MyClient::MyClient(QObject *parent) :
    QObject(parent)
{
    QThreadPool::globalInstance()->setMaxThreadCount(2);
}


void MyClient::SetSocket(int Descriptor, QSqlDatabase *db1){

   qDebug("QMyServer::incomingConnection(%d)", Descriptor);
     del_timestarted = false;
    //socket = new QTcpSocket(this);
    this->socket = new QTcpSocket(this);

    msgcheck = false;



    connect(this->socket,SIGNAL(connected()),this,SLOT(connected()));
    connect(this->socket,SIGNAL(disconnected()),this,SLOT(disconnected()));

    connect(this->socket,SIGNAL(readyRead()),this,SLOT(readyRead()));
    connect(this->socket,SIGNAL(bytesWritten(qint64)),this,SLOT(bytesWritten(qint64)),Qt::QueuedConnection);
    //connect(this->socket,SIGNAL(destroyed()),this,SLOT(destroysocket()));

   // connect(this->socket, SIGNAL(sslErrors(const QList<QSslError> &)),this, SLOT(errorOccured(const QList<QSslError> &)));


    if (!this->socket->setSocketDescriptor(Descriptor)) {
          qWarning("couldn't set socket descriptor");

          this->socket->close();
          //delete socket;
    }else{

      // this->socket->setCiphers("!SSLv2:ECDHE-RSA-AES128-SHA256:AES128-GCM-SHA256:RC4:HIGH:!MD5:!aNULL:!EDH");
      //  this->socket->setProtocol(QSsl::TlsV1SslV3);
      //  this->socket->setPrivateKey(PRIVATEKEY_FILE);
     //   this->socket->setLocalCertificate(LOCALCERTIFICATE_FILE);

        this->socket->setSocketOption(QAbstractSocket::KeepAliveOption,true);
      //  this->socket->startServerEncryption();

    }


    this->msgchekertimer = new QTimer(this);
    this->deletetimer = new QTimer(this);
     connect(this->deletetimer,SIGNAL(timeout()),this,SLOT(deletecheck()));
   // connect(this->msgchekertimer,SIGNAL(timeout()),this,SLOT(newmsgchecker()));
   // connect(this->msgchekertimer,SIGNAL(destroyed()),this,SLOT(destroytimer()));
    this->db = new  QSqlDatabase(*db1);

    //connect this timer timeout signal to the new msg checking slot, stop and start timer in the TaskResult function (SLOT)
    this->logincheck = false;
    deletecheckbool = true;
    this->splitstring = ",,,,";



    if(!(this->db->open())){
        this->socket->close();
    }


    qDebug()<<"Client Connected";
    if(this->socket->isOpen()){
        qDebug()<<"socket open";
    }else{
        qDebug()<<"socket close";
    }

    this->task2_check = true;



}
 void MyClient::deletecheck(){
        if(deletecheckbool){
            deletecheckbool = false;
        }else{

                this->deletetimer->stop();
                this->msgchekertimer->stop();
                disconnect(deletetimer,0,0,0);
                disconnect(msgchekertimer,0,0,0);
                //disconnect(this,0,0,0);
                disconnect(this->socket,0,0,0);
                 destroydb();
                delete socket;
                delete  msgchekertimer;
                delete deletetimer;

                //db->close();

                this->deleteLater();



        }
 }

void MyClient::destroysocket(){
    qDebug()<<"Socket destroyed";
}
 void MyClient::destroytimer(){
      qDebug()<<"timer destroyed";
 }

 void MyClient::destroytask2(){
     this->task2_check = true;
 }

 void  MyClient::destroydb(){

        db->close();
     delete this->db;
     qDebug()<<"db destroyed";

 }

void MyClient::connected(){
    qDebug()<<"Client Connected event";
}

void MyClient::disconnected(){

    if(this->db->isOpen()){

    }else{
        this->db->open();
    }

    QSqlQuery qry(*db);
    QString query_1;
    query_1 = "DELETE FROM `online_user` WHERE `name`='"+this->cname+"'";
    qry.exec(query_1);

    qDebug()<<"Client disconnected";
    this->socket->close();
    this->msgchekertimer->stop();

    if(this->socket->isOpen()){
        qDebug()<<"socket open";
    }else{
        qDebug()<<"socket close";
    }

    if(!del_timestarted){
        deletetimer->start(30000);
        del_timestarted = true;
    }


}

void MyClient::readyRead(){
    QStringList list;

    QString temp=this->socket->readAll();
    qDebug()<<temp;

    try{
        list = temp.split(this->splitstring);

    }catch(...){

    }


if(list.length()>=3&&(list.length()%3-1==0)){
    if(!this->logincheck){
        if(!logincheckf(list[1],list[2])){
             QByteArray Buffer;
             Buffer.append("0"+this->splitstring+"Login Fail"+this->splitstring+"waat"+this->splitstring);
             this->socket->write(Buffer);
             this->socket->close();

        }else{
            this->logincheck=true;
            QByteArray Buffer;
            Buffer.append("0"+this->splitstring+"Login Successful!"+this->splitstring+"waat"+this->splitstring);
            this->socket->write(Buffer);
            //this->msgchekertimer->start(10000);
            if(this->db->isOpen()){

            }else{
                this->db->open();
            }
            QSqlQuery qry1(*db);
            QString query;
            query = "SELECT count(*) FROM `online_user` WHERE `name`='"+this->cname+"'";
            qry1.exec(query);
            qry1.first();
            if(qry1.value(0)==0){
                QSqlQuery qry(*db);
                QString query_1;
                query_1 = "INSERT INTO `online_user`( `name`) VALUES ('"+this->cname+"')";
                qry.exec(query_1);
            }
        }
    }else{
        for(int x=0;(list.length()/3)>x;x++){
            if(list[0+x*3]=="10"){
                taske10(list[1+x*3]);
            }
        }
    }
}else{
   this->socket->close();


}



}

void MyClient::bytesWritten(qint64 bytes){

    //QByteArray data= QByteArray::number(bytes);
    //qDebug()<<QString::number(bytes,64).toUtf8();

}
void MyClient::bytesWrittenafter(QString task,int method){

   // qDebug()<<"Bytes Written done";
}


void MyClient::TaskResult(int method, QString msg){

    if(this->socket->isOpen()&&this->socket->state() == QAbstractSocket::ConnectedState &&deletecheckbool){


        this->msgchekertimer->stop();
        QByteArray Buffer;
        Buffer.append(QString::number(method)+this->splitstring+msg);
        this->socket->write(Buffer);
        socket->flush();

       // this->msgchekertimer->start(4000);

    }else{
        //this->socket->close();
    }

}
/***********************************************************************************************************/


bool MyClient::logincheckf(QString name, QString pass){
    if(!this->logincheck){
        //Connect to Database and check for the user
        if(this->db->isOpen()){

        }else{
            this->db->open();
        }
        if(this->db->open()){
            QSqlQuery qry(*this->db);
            QString query_1 = "select * from user_main where name='" + name + "' and pass='" + pass + "' and code='-1';";
            if(qry.exec(query_1)){
                while(qry.next()){
                    this->cname = name;
                    this->cpass = pass;
                    return true;
                }
            }
        }
        return false;


    }
    return false;

}

void MyClient::task2(){
    try{
        if(!this->task2_check){
            return;
        }
        this->task2_check = false;
        Task2 *mytask2 = new Task2();
        mytask2->setAutoDelete(true);
        mytask2->to = this->cname;
        mytask2->splitstring = this->splitstring;
        mytask2->db = this->db;
        connect(mytask2,SIGNAL(Result(int,QString)),this,SLOT(TaskResult(int,QString)),Qt::QueuedConnection);
        //connect(mytask2,SIGNAL(destroyed()),this,SLOT(destroytask2()));
        //connect(mytask,SIGNAL(Result(int)),this,SLOT(TaskResult(int)),Qt::QueuedConnection);
        QThreadPool::globalInstance()->start(mytask2);
    }catch(...){

    }


}

void MyClient::taske10(QString name){
    try{
            task10 *mytask10 = new task10();
            mytask10->setAutoDelete(true);

            mytask10->filename = HTTPDIR+name;

            //connect(mytask10,SIGNAL(destroyed()),this,SLOT(destroytask()));
             QThreadPool::globalInstance()->start(mytask10);
        }catch(...){

        }
}

/****************************************************************************************************************************/

void MyClient::errorOccured(const QList<QSslError> &error)
{
// simply ignore the errors
// it should be very careful when ignoring errors
    //this->socket->ignoreSslErrors();
}

void MyClient::newmsgchecker(){
   /* if(msgcheck){

    }else{
        msgcheck = true;
        return;
    }
    */
    if(this->socket->state() != QAbstractSocket::ConnectedState){
        this->socket->close();
    }else{
       // qDebug()<<"msg checker";
        this->task2();
    }

}
