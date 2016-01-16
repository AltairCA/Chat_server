#-------------------------------------------------
#
# Project created by QtCreator 2014-05-27T14:47:53
#
#-------------------------------------------------

QT       += core network sql

QT       -= gui

TARGET = Chat_server
CONFIG   += console
CONFIG   -= app_bundle

TEMPLATE = app


SOURCES += main.cpp \
    myserver.cpp \
    myclient.cpp \
    task2.cpp \
    task10.cpp

HEADERS += \
    myserver.h \
    myclient.h \
    task2.h \
    task10.h

FORMS +=
LIBS += -lws2_32
win32:LIBS += -lsetupapi
