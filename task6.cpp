#include "task6.h"

task6::task6()
{

}

void task6::run(){
    try{
    this->db = new  QSqlDatabase(*db);
    if(this->db->isOpen()){

    }else{
        this->db->open();
    }
    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "SELECT `name` FROM `friend_table` WHERE (`f_name`='"+this->client_name+"') and `name_accept`='"+"0"+"'";
    qry.exec(query_1);
    while (qry.next())
       {
         emit Result(6, qry.value(0).toString()+this->splitstring+"waat"+this->splitstring , "" ,"","" );

       }
    delete this->db;
    }catch(...){

    }

}

