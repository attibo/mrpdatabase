#! /bin/bash
rm -f mrpdatabase_ns.tar
rm -vf /var/www/mrpdatabase_ns/media/*
tar -cvf mrpdatabase_ns.tar *
cp mrpdatabase_ns.tar /media/attilio/D83B-E963/mrpMysql
