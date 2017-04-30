#! /bin/bash

cp -Rvf /home/attilio/Documenti/mrpBackWeb/media/* /var/www/mrpdatabase_ns/media
cp -Rvf /home/attilio/Documenti/mrpBackWeb/text/* /var/www/mrpdatabase_ns/text
cp -Rvf /var/www/mrpdatabase_ns/immagini/no-picture.png /var/www/mrpdatabase_ns/media
chmod ugo+rx /var/www/mrpdatabase_ns/media/*

