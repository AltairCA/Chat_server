#ifndef TASK9_H
#define TASK9_H
#include <QObject>
#include <QDebug>
#include <QObject>
#include <QtSql>

class task9 : public QObject,public QRunnable
{
    Q_OBJECT
public:
    task9();
    QString splitstring;
    QSqlDatabase *db;
    QString friend_name;
    QString client_name;
protected:
    void run();
signals:
    void Result(int method,QString Number,QString Date,QString time,QString from);
};

#endif // TASK9_H
