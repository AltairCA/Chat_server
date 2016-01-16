#ifndef TASK10_H
#define TASK10_H

#include <QFile>
#include <QRunnable>
#include <QDir>
class task10 : public QObject, public QRunnable
{
    Q_OBJECT
public:
    task10();
    QString filename;
protected:
    void run();
};

#endif // TASK10_H
