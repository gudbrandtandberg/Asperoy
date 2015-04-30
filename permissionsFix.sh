#!/bin/bash
sudo chown -R $USER:ladmin www/
sudo chown -R $USER:ladmin model/
sudo chown $USER:ladmin *.log
chmod og+w model/*.xml
chmod og+w model/*.json
chmod g+w *.log
chmod -R g+w www/
