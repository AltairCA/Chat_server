#include "mytask.h"

MyTask::MyTask()
{
}


void MyTask::run(){
    try{
   // qDebug() <<"Task Start";
    this->db = new  QSqlDatabase(*db);


    if(this->db->isOpen()){

    }else{
        this->db->open();
    }


    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "INSERT INTO `msg_store`(`date`, `time`, `from_name`, `to_name`, `msg`) VALUES ( '"+QDate::currentDate().toString(Qt::TextDate)+"','"+QTime::currentTime().toString(Qt::TextDate)+"','"+from+"','"+to+"','"+msg+"')";
    qry.exec(query_1);
   // qDebug()<<"Task Done";
    //emit Result(1,"Task Result = "+QString::number(num)+splitstring+"Altair2"+splitstring);
    //emit Result(1,msg+splitstring+"Altair2"+splitstring);
    //emit Result(1,"Task Result = "+QString::number(num)+splitstring+"waat"+splitstring);
    //emit Result(1,"Task Result = "+QString::number(num));
    delete this->db;
    }catch(...){

    }

}

