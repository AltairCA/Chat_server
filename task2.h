#ifndef TASK2_H
#define TASK2_H


#include <QRunnable>
#include <QDebug>
#include <QObject>
#include <QtSql>
class Task2 : public QObject,public QRunnable
{
    Q_OBJECT
public:
    Task2();
    QString to;
    QString splitstring;
    QSqlDatabase *db;

signals:
    void Result(int method,QString Number);
protected:
    void run();
};

#endif // TASK2_H
