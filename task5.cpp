#include "task5.h"

task5::task5()
{

}

void task5::run()
{
    try{
    this->db = new  QSqlDatabase(*db);
    if(this->db->isOpen()){

    }else{
        this->db->open();
    }
    QSqlQuery qry(*this->db);
    QString query_1;
    query_1 = "SELECT count(*) FROM `friend_table` WHERE (`f_name`='"+this->friend_name+"' and `name`='"+this->client_name+"') or (`f_name`='"+this->client_name+"' and `name`='"+this->friend_name+"')";

     qry.exec(query_1);
     qry.first();
    if(qry.value(0)==0 && (this->friend_name!=this->client_name)){
        qry.clear();
        QString de = "at here "+this->friend_name;

        query_1 = "SELECT count(*) FROM `user_main` WHERE `name` ='"+this->friend_name+"";
        qry.exec(query_1);
        qry.first();
        if(qry.value(0)!=0){

            query_1 = "INSERT INTO `friend_table`(`f_name`, `name`, `name_accept`) VALUES ('"+this->friend_name+"','"+this->client_name+"','0')";
            qry.exec(query_1);
        }

    }

     delete this->db;
    }catch(...){

    }

}
