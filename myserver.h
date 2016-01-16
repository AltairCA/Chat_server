#ifndef MYSERVER_H
#define MYSERVER_H


#include <QTcpServer>
#include <QTcpSocket>
#include <QAbstractSocket>
#include "myclient.h"
#include <QtSql>
#include <QSsl>
#include <QSslKey>
#include <QSslCertificate>
class MyServer : public QTcpServer
{
    Q_OBJECT
public:
    explicit MyServer(QObject *parent = 0);
    void StartServer();

protected:
    void incomingConnection(qintptr handle);

signals:

private:
   QSqlDatabase *db;



public slots:
   void print();

};

#endif // MYSERVER_H
