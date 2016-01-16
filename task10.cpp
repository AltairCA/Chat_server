#include "task10.h"

task10::task10()
{
}
 void task10::run(){
     try{
     QDir dir;
     dir.remove(this->filename);
     }catch(...){

     }
 }
