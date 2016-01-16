#include "task3.h"

Task3::Task3()
{
}
void Task3::run(){
    try{
    this->db = new  QSqlDatabase(*db);
    if(this->db->isOpen()){

    }else{
        this->db->open();
    }
    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "SELECT * FROM `friend_table` WHERE (`f_name`='"+this->to+"' or `name`='"+this->to+"') and `name_accept`='"+"1"+"'";
    qry.exec(query_1);
    while (qry.next())
       {

         emit Result(3, qry.value(0).toString()+this->splitstring+qry.value(1).toString()+this->splitstring , qry.value(0).toString() ,qry.value(0).toString(),qry.value(0).toString() );

       }
    delete this->db;
    }catch(...){

    }
}
