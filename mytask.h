#ifndef MYTASK_H
#define MYTASK_H

#include <QRunnable>
#include <QDebug>
#include <QObject>
#include <QtSql>
#include <QDate>
#include<QTime>
class MyTask : public QObject, public QRunnable
{
    Q_OBJECT
public:
    MyTask();

    QString msg;
    QString from;
    QString to;
    QString splitstring;
    QSqlDatabase *db;
signals:
    void Result(int method,QString Number,QString Date,QString time,QString from);
protected:
    void run();



};

#endif // MYTASK_H
