#ifndef MYCLIENT_H
#define MYCLIENT_H

#include <QObject>
#include <QTcpSocket>
#include <QSslSocket>
#include <QDebug>
#include <QThreadPool>
#include <QTimer>
#include <QtSql>
#include "mytask.h"
#include "task2.h"
#include "task10.h"
#include <QSsl>
#include <QSslKey>
#include <QSslCertificate>
#include <QSslConfiguration>
#include <QSslCipher>
#include <QFile>
#include <QQueue>
class MyClient : public QObject
{
    Q_OBJECT
public:
    explicit MyClient(QObject *parent = 0);
    void SetSocket(int Descriptor, QSqlDatabase *db);
    bool logincheckf(QString name, QString pass);
    void task2();
    void taske10(QString name);







signals:

public slots:
    void connected();
    void disconnected();
    void readyRead();
    void bytesWritten(qint64 bytes);
    void bytesWrittenafter(QString task,int method);
    void TaskResult(int method, QString msg);




    void errorOccured(const QList<QSslError> &error);

    void newmsgchecker();

    void destroysocket();
     void destroytimer();

     void destroytask2();
    void deletecheck();
     void destroydb();



private:
    QTcpSocket *socket;
    //QTcpSocket *socket;
    bool logincheck;
    QString cname;
    QString cpass;
    QString splitstring;
    QTimer *msgchekertimer;
    QTimer *deletetimer;
    bool deletecheckbool;
    QSqlDatabase *db;

    bool task2_check;

    bool msgcheck;
    bool del_timestarted;
    QQueue<int> queue1;
    QQueue<QString> queue2;




};

#endif // MYCLIENT_H
