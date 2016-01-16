#include "task2.h"

Task2::Task2()
{
}

void Task2::run(){
    try{
   // qDebug() <<"Task Start";

    this->db = new  QSqlDatabase(*db);
    if(this->db->isOpen()){

    }else{
        this->db->open();
    }
    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "SELECT * FROM `msg_store` WHERE `to_name`='"+to+"' and `deliverd`='0' order by `date`, `time`";
    qry.exec(query_1);
    while (qry.next())
       {
         emit Result(1, "a"+this->splitstring+"a"+this->splitstring);
        break;

       }
    //qDebug()<<"Task Done";
    //emit Result(1,"Task Result = "+QString::number(num)+splitstring+"Altair"+splitstring);
    // emit Result(1,msg+splitstring+"Altair"+splitstring);
    //emit Result(1,"Task Result = "+QString::number(num)+splitstring+"waat"+splitstring);
    delete this->db;
    }catch(...){

    }

}
