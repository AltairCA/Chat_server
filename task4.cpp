#include "task4.h"

task4::task4()
{

}

void task4::run()
{
    try{
    this->db = new  QSqlDatabase(*db);
    if(this->db->isOpen()){

    }else{
        this->db->open();
    }
    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "SELECT `name` FROM `user_main` WHERE `name` LIKE '%"+this->word+"%' and `name` <> '"+this->to+"' and (`name` not in (SELECT `name` FROM `friend_table` WHERE `f_name`='"+to+"')  and `name` not in  (SELECT `f_name` FROM `friend_table` WHERE `name`='"+to+"'))" ;
    qry.exec(query_1);
    int count=0;
    while (qry.next() && count<20)
       {
            count++;

             emit Result(4, qry.value(0).toString()+this->splitstring+"waat"+this->splitstring , "" ,"","");

       }
    delete this->db;
    }catch(...){

    }
}

